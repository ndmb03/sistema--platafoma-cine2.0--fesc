@extends('layouts.app')

@section('title', 'Gestión de Salas')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">🛋️ Listado de Salas</h2>
        <a href="{{ route('salas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Agregar Sala
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
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Número de Sala
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Capacidad
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tipo
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($salas as $sala)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $sala->numero }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $sala->capacidad }} asientos</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($sala->tipo == 'VIP') bg-yellow-100 text-yellow-800 
                                @elseif($sala->tipo == '3D') bg-blue-100 text-blue-800 
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $sala->tipo }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm space-x-2">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            <a href="#" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                            <form action="#" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar esta sala?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">Aún no hay salas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection