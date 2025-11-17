@extends('layouts.app')

@section('title', 'Editar Sala')

@section('content')

<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">✏️ Editar Sala #{{ $sala->numero }}</h2>
    
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

    <form action="{{ route('salas.update', $sala->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf
        @method('PUT') {{-- Importante para las actualizaciones --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="numero" class="block text-sm font-medium text-gray-700">Número de Sala</label>
                <input type="number" name="numero" id="numero" value="{{ old('numero', $sala->numero) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="capacidad" class="block text-sm font-medium text-gray-700">Capacidad (Asientos)</label>
                <input type="number" name="capacidad" id="capacidad" value="{{ old('capacidad', $sala->capacidad) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Sala</label>
                <select name="tipo" id="tipo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="2D" {{ old('tipo', $sala->tipo) == '2D' ? 'selected' : '' }}>2D (Estándar)</option>
                    <option value="3D" {{ old('tipo', $sala->tipo) == '3D' ? 'selected' : '' }}>3D</option>
                    <option value="VIP" {{ old('tipo', $sala->tipo) == 'VIP' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('salas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">Cancelar</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">Actualizar Sala</button>
        </div>
    </form>
</div>

@endsection