@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Detalles de la Función
        </h1>
        
        <!-- Botón para editar (asumiendo que tienes una ruta 'funciones.edit') -->
        <a href="{{ route('funciones.edit', $funcion->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-150">
            Editar Función
        </a>
    </div>

    <!-- Tarjeta Principal de la Función -->
    <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-indigo-500">
        
        <!-- Sección de Metadatos de la Función -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 border-b pb-6">
            
            <!-- Fecha de la Función -->
            <div class="p-4 bg-gray-50 rounded-lg text-center shadow-inner">
                <p class="text-sm font-medium text-indigo-600">Fecha</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">
                    {{ \Carbon\Carbon::parse($funcion->fecha)->isoFormat('D MMMM') }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($funcion->fecha)->isoFormat('YYYY') }}
                </p>
            </div>

            <!-- Hora de Inicio -->
            <div class="p-4 bg-gray-50 rounded-lg text-center shadow-inner">
                <p class="text-sm font-medium text-indigo-600">Hora de Inicio</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">
                    {{ \Carbon\Carbon::parse($funcion->hora)->format('H:i') }}
                </p>
            </div>

            <!-- Sala de Proyección -->
            <div class="p-4 bg-gray-50 rounded-lg text-center shadow-inner">
                <p class="text-sm font-medium text-indigo-600">En Sala</p>
                <!-- Asume que el modelo Funcion tiene una relación 'sala' -->
                <p class="text-2xl font-extrabold text-gray-900 mt-1 hover:text-indigo-600 transition">
                    <a href="{{ route('salas.show', $funcion->sala->id) }}">
                        {{ $funcion->sala->nombre }}
                    </a>
                </p>
                <p class="text-sm text-gray-500">
                    Capacidad: {{ $funcion->sala->capacidad }} asientos
                </p>
            </div>
        </div>

        <!-- Sección de Detalles de la Película -->
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Película en Proyección</h3>
            
            <div class="flex flex-col md:flex-row gap-6 p-4 border rounded-xl bg-indigo-50">
                
                <!-- Detalles de la Película -->
                <div class="flex-grow">
                    <!-- Asume que el modelo Funcion tiene una relación 'pelicula' -->
                    <h4 class="text-3xl font-extrabold text-gray-900 mb-2">
                        <a href="{{ route('peliculas.show', $funcion->pelicula->id) }}" class="hover:text-indigo-600 transition">
                            {{ $funcion->pelicula->titulo }}
                        </a>
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
                        <div>
                            <span class="font-semibold text-indigo-700">Género:</span> 
                            {{ $funcion->pelicula->genero }}
                        </div>
                        <div>
                            <span class="font-semibold text-indigo-700">Duración:</span> 
                            {{ $funcion->pelicula->duracion }} min.
                        </div>
                    </div>
                    
                    <h5 class="font-semibold text-gray-800 mt-4 mb-2">Sinopsis:</h5>
                    <p class="text-gray-600 text-justify leading-relaxed text-sm max-h-32 overflow-hidden">
                        {{ $funcion->pelicula->sinopsis }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Información de Auditoría -->
        <div class="pt-4 border-t">
            <p class="text-xs text-gray-500 text-right">
                Última actualización: {{ $funcion->updated_at->diffForHumans() }}
            </p>
        </div>

    </div>

    <!-- Botón de regreso -->
    <div class="mt-8 text-center">
        <a href="{{ route('funciones.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-150 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al listado de Funciones
        </a>
    </div>

</div>
@endsection