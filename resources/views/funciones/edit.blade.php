@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 border-b pb-2">
            Editar Función para: {{ $funcion->pelicula->titulo }}
        </h1>
        <p class="text-gray-600 mt-2">
            Modifica la fecha, hora, película o sala de esta proyección.
        </p>
    </div>

    <!-- Formulario de Edición -->
    <!-- Se usa el método POST y se añade @method('PUT') para simular la solicitud PUT -->
    <form action="{{ route('funciones.update', $funcion->id) }}" method="POST" class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-indigo-500">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <!-- SELECTOR DE PELÍCULA -->
            <div>
                <label for="pelicula_id" class="block text-sm font-medium text-gray-700 mb-1">Película</label>
                <select id="pelicula_id" name="pelicula_id" required
                        class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg rounded-lg shadow-sm">
                    <!-- Iterar sobre las películas disponibles -->
                    @foreach($peliculas as $pelicula)
                        <option value="{{ $pelicula->id }}" 
                            {{ old('pelicula_id', $funcion->pelicula_id) == $pelicula->id ? 'selected' : '' }}>
                            {{ $pelicula->titulo }} ({{ $pelicula->duracion }} min)
                        </option>
                    @endforeach
                </select>
                @error('pelicula_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- SELECTOR DE SALA -->
            <div>
                <label for="sala_id" class="block text-sm font-medium text-gray-700 mb-1">Sala de Proyección</label>
                <select id="sala_id" name="sala_id" required
                        class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg rounded-lg shadow-sm">
                    <!-- Iterar sobre las salas disponibles -->
                    @foreach($salas as $sala)
                        <option value="{{ $sala->id }}" 
                            {{ old('sala_id', $funcion->sala_id) == $sala->id ? 'selected' : '' }}>
                            {{ $sala->nombre }} (Capacidad: {{ $sala->capacidad }})
                        </option>
                    @endforeach
                </select>
                @error('sala_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CAMPO FECHA -->
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Proyección</label>
                    <input type="date" id="fecha" name="fecha" required
                           value="{{ old('fecha', \Carbon\Carbon::parse($funcion->fecha)->format('Y-m-d')) }}"
                           class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('fecha')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CAMPO HORA -->
                <div>
                    <label for="hora" class="block text-sm font-medium text-gray-700 mb-1">Hora de Inicio (HH:MM)</label>
                    <input type="time" id="hora" name="hora" required
                           value="{{ old('hora', \Carbon\Carbon::parse($funcion->hora)->format('H:i')) }}"
                           class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('hora')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>

        <!-- Botones de Acción -->
        <div class="mt-10 flex justify-end gap-3">
            <a href="{{ route('funciones.show', $funcion->id) }}" class="inline-flex justify-center py-3 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                Cancelar
            </a>
            <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                Guardar Cambios
            </button>
        </div>
    </form>
    
    <!-- Sección de Eliminación (Opcional, pero útil en un formulario de edición) -->
    <div class="mt-12 p-6 bg-red-50 border-2 border-red-300 rounded-xl shadow-inner">
        <h3 class="text-xl font-bold text-red-800 mb-3">Eliminar Función</h3>
        <p class="text-sm text-red-700 mb-4">
            Advertencia: Esta acción es permanente y eliminará todas las entradas asociadas a esta proyección.
        </p>
        
        <!-- Formulario de Eliminación con confirmación modal (usando JS simple) -->
        <form id="delete-form" action="{{ route('funciones.destroy', $funcion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas ELIMINAR esta función permanentemente? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                Eliminar Función
            </button>
        </form>
    </div>

</div>
@endsection