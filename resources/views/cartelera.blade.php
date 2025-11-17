@extends('layouts.app')

@section('title', 'Cartelera Actual')

@section('content')

    <h1 class="text-4xl font-extrabold text-indigo-700 mb-8 border-b-2 border-gray-200 pb-2">🎬 Cartelera de Cine</h1>

    @if ($funcionesActivas->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">No hay funciones programadas.</p>
            <p>Por favor, revisa la sección de Administración para programar una función futura.</p>
        </div>
    @else
        
        @foreach ($funcionesActivas as $peliculaId => $funciones)
            @php
                $pelicula = $funciones->first()->pelicula; // Obtiene los datos de la película
            @endphp

            <div class="bg-white shadow-lg rounded-xl p-6 mb-8 border border-gray-200">
                <div class="flex items-start">
                    <div class="w-24 h-32 bg-gray-300 flex items-center justify-center rounded-lg mr-6 flex-shrink-0">
                        <span class="text-sm text-gray-600">Póster</span>
                    </div>

                    <div class="flex-grow">
                        <div class="flex justify-between items-center">
                            <h2 class="text-3xl font-bold text-gray-800">{{ $pelicula->titulo }}</h2>
                            <span class="text-sm font-semibold px-3 py-1 rounded-full bg-red-100 text-red-800 border border-red-300">
                                {{ $pelicula->clasificacion }}
                            </span>
                        </div>
                        <p class="text-gray-600 mt-1">{{ $pelicula->genero }} | {{ $pelicula->duracion }} min</p>

                        <h3 class="text-xl font-semibold text-gray-700 mt-4 mb-2">Horarios Disponibles:</h3>
                        
                        <div class="flex flex-wrap gap-3">
                            @foreach ($funciones as $funcion)
                                @php
                                    $carbonHorario = \Carbon\Carbon::parse($funcion->horario);
                                    
                                @endphp
                                
@endphp
<a href="{{ route('venta.asientos', $funcion->id) }}" 
    class="bg-indigo-100 hover:bg-indigo-600 hover:text-white text-indigo-600 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out border border-indigo-300"
    title="Sala #{{ $funcion->sala->numero }} ({{ $funcion->sala->tipo }})">
    <span class="text-sm font-bold">{{ $carbonHorario->format('H:i') }}</span>
    <span class="text-xs">({{ $funcion->sala->tipo }})</span>
</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

@endsection