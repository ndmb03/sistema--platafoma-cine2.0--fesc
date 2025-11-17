@extends('layouts.app')

@section('title', 'Gestión de Películas')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">🎥 Listado de Películas</h2>
        <a href="{{ route('peliculas.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
            + Agregar Película
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Género</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duración</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Clasificación</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
    @forelse ($peliculas as $pelicula)
        <tr class="hover:bg-gray-50">
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pelicula->titulo }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pelicula->genero }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pelicula->duracion }} min</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $pelicula->clasificacion }}</span>
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm space-x-2">
                <a href="{{ route('peliculas.show', $pelicula->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                <a href="{{ route('peliculas.edit', $pelicula->id) }}" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                <form action="{{ route('peliculas.destroy', $pelicula->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar esta película?')">Eliminar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">Aún no hay películas registradas.</td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>
@endsection