<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalaController extends Controller
{
    /**
     * Muestra una lista de todas las salas (R - Read).
     */
    public function index()
    {
        // Obtiene todas las salas, ordenadas por número
        $salas = Sala::orderBy('numero')->get(); 
        
        // Retorna la vista de índice
        return view('modulo_salas.index', compact('salas'));
    }

    /**
     * Muestra el formulario para crear una nueva sala (C - Create).
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        // Se define una lista de tipos disponibles para el formulario
        $tipos_sala = ['2D', '3D', 'VIP'];
        return view('modulo_salas.create', compact('tipos_sala'));
    }

    /**
     * Almacena una nueva sala en la base de datos (C - Create).
     */
    public function store(Request $request)
    {
        // 1. Validación de datos de entrada
        $request->validate([
            'numero' => 'required|integer|min:1|unique:salas,numero',
            'capacidad' => 'required|integer|min:10|max:500', // Capacidad mínima y máxima razonable
            'tipo' => ['required', Rule::in(['2D', '3D', 'VIP'])],
        ]);

        // 2. Creación del registro
        Sala::create($request->all());

        // 3. Redirección con mensaje de éxito
        return redirect()->route('salas.index')
                         ->with('success', 'Sala número ' . $request->numero . ' creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una sala (U - Update).
     */
    public function edit(Sala $sala)
    {
        // Se define una lista de tipos disponibles para el formulario
        $tipos_sala = ['2D', '3D', 'VIP'];
        // Retorna la vista de edición con los datos de la sala
        return view('modulo_salas.edit', compact('sala', 'tipos_sala'));
    }

    /**
     * Actualiza una sala específica en la base de datos (U - Update).
     */
    public function update(Request $request, Sala $sala)
    {
        // 1. Validación de datos (el número debe ser único, excluyendo el de la sala actual)
        $request->validate([
            'numero' => ['required', 'integer', 'min:1', Rule::unique('salas')->ignore($sala->id)],
            'capacidad' => 'required|integer|min:10|max:500',
            'tipo' => ['required', Rule::in(['2D', '3D', 'VIP'])],
        ]);

        // 2. Actualización del registro
        $sala->update($request->all());

        // 3. Redirección con mensaje de éxito
        return redirect()->route('salas.index')
                         ->with('success', 'Sala número ' . $sala->numero . ' actualizada exitosamente.');
    }

    /**
     * Elimina una sala de la base de datos (D - Delete).
     */
    public function destroy(Sala $sala)
    {
        // TODO: Agregar verificación para asegurar que la sala no tenga funciones activas programadas.
        
        // 1. Eliminación del registro
        $sala->delete();

        // 2. Redirección con mensaje de éxito
        return redirect()->route('salas.index')
                         ->with('success', 'Sala número ' . $sala->numero . ' eliminada correctamente.');
    }
}