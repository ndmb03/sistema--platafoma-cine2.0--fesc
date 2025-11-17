<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarteleraController extends Controller
{
    /**
     * Muestra la cartelera actual: Películas con funciones programadas a futuro.
     */
    public function index()
    {
        // 1. Obtener los IDs de las películas que tienen funciones a futuro
        $peliculasIdsConFunciones = Funcion::where('horario', '>', Carbon::now())
                                         ->pluck('pelicula_id')
                                         ->unique()
                                         ->toArray();

        // 2. Obtener las películas activas que tienen funciones programadas
        $peliculas = Pelicula::whereIn('id', $peliculasIdsConFunciones)
                             ->where('is_active', true)
                             ->orderBy('titulo')
                             ->get();
        
        // Retorna la vista principal de la cartelera
        return view('cartelera.index', compact('peliculas'));
    }

    /**
     * Muestra todas las funciones disponibles para una película específica.
     */
    public function showFunctions(Pelicula $pelicula)
    {
        // Obtener solo las funciones futuras para esta película, ordenadas por horario
        $funciones = $pelicula->funciones()
                              ->with('sala') // Cargar la sala relacionada
                              ->where('horario', '>', Carbon::now())
                              ->orderBy('horario')
                              ->get();

        // Retorna la vista de horarios para la película
        return view('cartelera.show_functions', compact('pelicula', 'funciones'));
    }

    /**
     * Muestra la vista de selección de asientos para una función específica.
     * * MODIFICACIÓN: La vista ahora apunta a 'venta.asientos'.
     */
    public function selectSeats(Funcion $funcion)
    {
        // Cargar las relaciones necesarias (Película y Sala)
        $funcion->load('pelicula', 'sala');

        // Retorna la vista de selección de asientos
        return view('venta.asientos', compact('funcion'));
    }
}