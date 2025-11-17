@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg">
    <!-- Verificar si se recibió la variable $pelicula (asumiendo Laravel) -->
    @if(isset($pelicula))
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Película: {{ $pelicula->titulo }}</h2>

        <!-- Contenedor para mensajes de éxito/error del JS -->
        <div id="message-box" class="hidden"></div>
        
        <!-- El formulario con el ID 'pelicula-form' que utiliza el JS -->
        <form id="pelicula-form">
            @csrf
            <!-- Campo oculto ID (con valor para edición) -->
            <input type="hidden" name="id" value="{{ $pelicula->id }}">

            <!-- Título -->
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" id="titulo" name="titulo" value="{{ $pelicula->titulo }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
                <p id="error-titulo" class="error-message text-sm mt-1"></p>
            </div>

            <!-- Sinopsis -->
            <div class="mb-4">
                <label for="sinopsis" class="block text-sm font-medium text-gray-700">Sinopsis</label>
                <textarea id="sinopsis" name="sinopsis" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>{{ $pelicula->sinopsis }}</textarea>
                <p id="error-sinopsis" class="error-message text-sm mt-1"></p>
            </div>

            <!-- Género -->
            <div class="mb-4">
                <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                <input type="text" id="genero" name="genero" value="{{ $pelicula->genero }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
                <p id="error-genero" class="error-message text-sm mt-1"></p>
            </div>

            <!-- Duración (en minutos) -->
            <div class="mb-6">
                <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                <input type="number" id="duracion" name="duracion" value="{{ $pelicula->duracion }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
                <p id="error-duracion" class="error-message text-sm mt-1"></p>
            </div>

            <!-- Botón de Envío -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Actualizar Película
                </button>
            </div>
        </form>
    @else
        <p class="text-red-500">No se encontró la película para editar.</p>
    @endif
</div>

<!-- Enlaza el script JS específico para Películas -->
<script type="module" src="{{ asset('resources/js/admin/pelicula_crud.js') }}"></script>
@endsection