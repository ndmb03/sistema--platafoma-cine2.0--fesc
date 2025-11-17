<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * Muestra una lista de todas las películas (R - Read).
     */
    public function index()
    {
        // Obtiene todas las películas, ordenadas por título
        $peliculas = Pelicula::orderBy('titulo')->get(); 
        
        // Retorna la vista de índice con la lista de películas
        return view('modulo_peliculas.index', compact('peliculas'));
    }

    /**
     * Muestra el formulario para crear una nueva película (C - Create).
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        return view('modulo_peliculas.create');
    }

    /**
     * Almacena una nueva película en la base de datos (C - Create).
     */
    public function store(Request $request)
    {
        // 1. Validación de datos de entrada
        $request->validate([
            'titulo' => 'required|string|max:150|unique:peliculas,titulo',
            'genero' => 'required|string|max:50',
            'duracion' => 'required|integer|min:1',
            'clasificacion' => 'required|string|max:10',
            'foto_url' => 'nullable|url', // Asume que la foto_url es una URL externa por ahora
        ]);

        // 2. Creación del registro
        Pelicula::create($request->all());

        // 3. Redirección con mensaje de éxito
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una película (U - Update).
     */
    public function edit(Pelicula $pelicula)
    {
        // Retorna la vista de edición con los datos de la película
        return view('modulo_peliculas.edit', compact('pelicula'));
    }

    /**
     * Actualiza una película específica en la base de datos (U - Update).
     */
    public function update(Request $request, Pelicula $pelicula)
    {
        // 1. Validación de datos (exceptuando el título de la película actual)
        $request->validate([
            'titulo' => 'required|string|max:150|unique:peliculas,titulo,' . $pelicula->id,
            'genero' => 'required|string|max:50',
            'duracion' => 'required|integer|min:1',
            'clasificacion' => 'required|string|max:10',
            'foto_url' => 'nullable|url',
        ]);

        // 2. Actualización del registro
        $pelicula->update($request->all());

        // 3. Redirección con mensaje de éxito
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película actualizada exitosamente.');
    }

    /**
     * Elimina una película de la base de datos (D - Delete).
     */
    public function destroy(Pelicula $pelicula)
    {
        // 1. Eliminación del registro
        $pelicula->delete();

        // 2. Redirección con mensaje de éxito
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película eliminada correctamente.');
    }
}