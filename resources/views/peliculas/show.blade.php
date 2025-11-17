@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detalles de la Película
        </h1>
        
        <!-- Botón para editar (asumiendo que tienes una ruta 'peliculas.edit') -->
        <a href="{{ route('peliculas.edit', $pelicula->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-150">
            Editar Película
        </a>
    </div>

    <!-- Tarjeta de Detalle de la Película -->
    <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-indigo-500">
        
        <!-- Título principal -->
        <div class="border-b pb-4 mb-4">
            <h2 class="text-4xl font-extrabold text-gray-900">{{ $pelicula->titulo }}</h2>
        </div>

        <!-- Información de Metadatos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <!-- Duración -->
            <div class="flex items-center space-x-3 p-3 bg-indigo-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-500">Duración</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $pelicula->duracion }} minutos</p>
                </div>
            </div>

            <!-- Género -->
            <div class="flex items-center space-x-3 p-3 bg-indigo-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-500">Género</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $pelicula->genero }}</p>
                </div>
            </div>
        </div>

        <!-- Sinopsis Detallada -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2 border-b pb-1">Sinopsis</h3>
            <p class="text-gray-700 leading-relaxed indent-6 text-justify">
                {{ $pelicula->sinopsis }}
            </p>
        </div>

        <!-- Fechas y Tiempos de Auditoría (opcional) -->
        <div class="pt-4 border-t">
            <div class="flex justify-between text-xs text-gray-500">
                <p>Creado: {{ $pelicula->created_at->format('d/m/Y H:i') }}</p>
                <p>Actualizado: {{ $pelicula->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

    </div>

    <!-- Botón de regreso -->
    <div class="mt-8 text-center">
        <a href="{{ route('peliculas.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-150">
            &larr; Volver al listado de Películas
        </a>
    </div>

</div>
@endsection