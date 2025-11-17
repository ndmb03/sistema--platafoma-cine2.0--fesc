@extends('layouts.app')

@section('title', 'Agregar Nueva Película')

@section('content')

<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">➕ Agregar Película</h2>
    
    <form action="{{ route('peliculas.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" id="titulo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                <input type="text" name="genero" id="genero" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                <input type="number" name="duracion" id="duracion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="clasificacion" class="block text-sm font-medium text-gray-700">Clasificación</label>
                <select name="clasificacion" id="clasificacion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="G">G (General)</option>
                    <option value="PG">PG (Parental Guidance)</option>
                    <option value="PG-13">PG-13 (Parents Strongly Cautioned)</option>
                    <option value="R">R (Restricted)</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('peliculas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">Guardar Película</button>
        </div>
    </form>
</div>

@endsection