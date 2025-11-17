<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class FuncionController extends Controller
{
    /**
     * Muestra una lista de todas las funciones (R - Read).
     */
    public function index()
    {
        // Obtiene todas las funciones cargando de forma "eager" las relaciones Pelicula y Sala para evitar N+1
        $funciones = Funcion::with(['pelicula', 'sala'])
                            ->orderBy('horario', 'desc')
                            ->get(); 
        
        // Retorna la vista de índice
        return view('modulo_funciones.index', compact('funciones'));
    }

    /**
     * Muestra el formulario para crear una nueva función (C - Create).
     */
    public function create()
    {
        // Se necesitan listas de Películas y Salas para los dropdowns del formulario
        $peliculas = Pelicula::where('is_active', true)->orderBy('titulo')->pluck('titulo', 'id');
        $salas = Sala::where('is_active', true)->orderBy('numero')->get();

        return view('modulo_funciones.create', compact('peliculas', 'salas'));
    }

    /**
     * Almacena una nueva función en la base de datos (C - Create).
     */
    public function store(Request $request)
    {
        // 1. Validación inicial de datos
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'sala_id' => 'required|exists:salas,id',
            'horario' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            'precio_base' => 'required|numeric|min:1.00',
        ]);

        // 2. Validación de colisión de horario (Lógica de Negocio)
        $this->checkCollision($request);

        // 3. Creación del registro
        Funcion::create($request->all());

        // 4. Redirección con mensaje de éxito
        return redirect()->route('funciones.index')
                         ->with('success', 'Función programada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una función (U - Update).
     */
    public function edit(Funcion $funcion)
    {
        // Se necesitan listas de Películas y Salas para los dropdowns
        $peliculas = Pelicula::where('is_active', true)->orderBy('titulo')->pluck('titulo', 'id');
        $salas = Sala::where('is_active', true)->orderBy('numero')->get();

        // Retorna la vista de edición con los datos
        return view('modulo_funciones.edit', compact('funcion', 'peliculas', 'salas'));
    }

    /**
     * Actualiza una función específica en la base de datos (U - Update).
     */
    public function update(Request $request, Funcion $funcion)
    {
        // 1. Validación inicial de datos
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'sala_id' => 'required|exists:salas,id',
            'horario' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            'precio_base' => 'required|numeric|min:1.00',
        ]);

        // 2. Validación de colisión de horario, excluyendo la función actual
        $this->checkCollision($request, $funcion->id);

        // 3. Actualización del registro
        $funcion->update($request->all());

        // 4. Redirección con mensaje de éxito
        return redirect()->route('funciones.index')
                         ->with('success', 'Función actualizada exitosamente.');
    }

    /**
     * Elimina una función de la base de datos (D - Delete).
     */
    public function destroy(Funcion $funcion)
    {
        // TODO: Verificar si ya hay boletos vendidos. Si los hay, quizás solo desactivar (is_active=false) en lugar de eliminar.

        $funcion->delete();

        return redirect()->route('funciones.index')
                         ->with('success', 'Función eliminada correctamente.');
    }

    /**
     * Verifica si una nueva función colisiona con una función existente en la misma sala.
     * La colisión se basa en el horario de inicio y la duración de la película.
     * @throws ValidationException
     */
    protected function checkCollision(Request $request, $ignoreId = null)
    {
        $salaId = $request->sala_id;
        $horarioInicio = Carbon::parse($request->horario);

        // Obtener la duración de la película para calcular el tiempo de fin
        $pelicula = Pelicula::find($request->pelicula_id);
        if (!$pelicula) {
             throw ValidationException::withMessages(['pelicula_id' => 'La película seleccionada no existe.']);
        }

        // Se agrega un buffer de 15 minutos para limpieza entre funciones
        $duracionFuncion = $pelicula->duracion + 15; 
        $horarioFin = $horarioInicio->copy()->addMinutes($duracionFuncion);

        // Buscar funciones que se solapen en la misma sala
        $query = Funcion::where('sala_id', $salaId)
            // La función existente empieza antes de que termine la nueva función
            ->where('horario', '<', $horarioFin->format('Y-m-d H:i:s')); 
            
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $funcionesExistentes = $query->with('pelicula')->get();

        foreach ($funcionesExistentes as $funcionExistente) {
            $duracionExistente = $funcionExistente->pelicula->duracion + 15;
            $finExistente = Carbon::parse($funcionExistente->horario)->addMinutes($duracionExistente);

            // Verificar solapamiento: la nueva función empieza antes de que termine la función existente
            if ($horarioInicio->lessThan($finExistente)) {
                 throw ValidationException::withMessages([
                    'horario' => "La Sala {$salaId} ya tiene una función programada ({$funcionExistente->pelicula->titulo}) que colisiona en este horario. Finaliza a las {$finExistente->format('H:i')}."
                 ]);
            }
        }
    }
}