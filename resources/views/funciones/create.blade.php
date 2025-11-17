@extends('layouts.app')

@section('title', 'Programar Nueva Función')

@section('content')

<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">➕ Programar Función</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <p><strong>¡Error!</strong> Corrige los siguientes errores:</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('funciones.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="pelicula_id" class="block text-sm font-medium text-gray-700">Película</label>
                <select name="pelicula_id" id="pelicula_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Seleccione una Película --</option>
                    @foreach ($peliculas as $pelicula)
                        <option value="{{ $pelicula->id }}" {{ old('pelicula_id') == $pelicula->id ? 'selected' : '' }}>
                            {{ $pelicula->titulo }} ({{ $pelicula->clasificacion }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sala_id" class="block text-sm font-medium text-gray-700">Sala</label>
                <select name="sala_id" id="sala_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Seleccione una Sala --</option>
                    @foreach ($salas as $sala)
                        <option value="{{ $sala->id }}" {{ old('sala_id') == $sala->id ? 'selected' : '' }}>
                            Sala #{{ $sala->numero }} ({{ $sala->tipo }} - {{ $sala->capacidad }} asientos)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="horario" class="block text-sm font-medium text-gray-700">Horario (Fecha y Hora)</label>
                {{-- Nota: El input type=datetime-local no es soportado universalmente, pero es la opción más sencilla --}}
                <input type="datetime-local" name="horario" id="horario" value="{{ old('horario') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div></div>

        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('funciones.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">Programar Función</button>
        </div>
    </form>
</div>

@endsection