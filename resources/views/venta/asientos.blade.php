@extends('layouts.app')

@section('title', 'Selección de Asientos - ' . $funcion->pelicula->titulo)

@section('content')

    <div class="max-w-6xl mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $funcion->pelicula->titulo }}</h1>
        <p class="text-lg text-indigo-600 mb-8">
            <span class="font-semibold">Sala {{ $funcion->sala->numero }} ({{ $funcion->sala->tipo }})</span> - 
            {{ $funcion->horario->format('D, d M Y - H:i') }} hrs
        </p>

        <div class="flex flex-col lg:flex-row gap-8 bg-white p-6 rounded-xl shadow-2xl border border-gray-100">
            
            <!-- Columna Principal: Mapa de Asientos -->
            <div class="lg:w-3/4">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Selecciona tus Asientos</h2>

                <!-- Pantalla del Cine -->
                <div class="bg-gray-800 text-white text-center py-2.5 mb-8 rounded-t-lg shadow-inner shadow-gray-900/50">
                    <span class="font-bold tracking-widest uppercase">PANTALLA</span>
                </div>
                
                <!-- Contenedor del Mapa de Asientos -->
                <div id="seat-map-container" class="flex flex-col items-center overflow-x-auto p-4 bg-gray-50 rounded-lg shadow-inner">
                    <!-- Los asientos se renderizarán aquí mediante JavaScript -->
                    <div id="seat-map" class="inline-block">
                        <div class="text-center text-gray-500 py-10">Cargando mapa de asientos...</div>
                    </div>
                </div>

                <!-- Leyenda -->
                <div class="mt-8 p-4 bg-indigo-50 rounded-lg flex justify-center flex-wrap gap-x-6 gap-y-3 text-sm font-medium border border-indigo-200">
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-green-500 rounded-md shadow-sm mr-2"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-yellow-500 rounded-md shadow-sm mr-2"></div>
                        <span>Seleccionado</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-red-600 rounded-md shadow-sm mr-2"></div>
                        <span>Ocupado</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-gray-300 rounded-md shadow-sm mr-2"></div>
                        <span>No Seleccionable</span>
                    </div>
                </div>

                <!-- Mensajes del sistema -->
                <div id="message-box" class="mt-4 p-3 rounded-lg text-center font-semibold hidden"></div>

            </div>

            <!-- Columna Lateral: Resumen de Compra -->
            <div class="lg:w-1/4 bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-inner sticky top-24 self-start">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Tu Pedido</h2>

                <div class="space-y-3">
                    <p class="flex justify-between text-gray-600">
                        <span>Precio por Boleto:</span>
                        <span class="font-semibold text-green-700">${{ number_format($funcion->precio_base, 2) }}</span>
                    </p>
                    <p class="flex justify-between text-gray-600">
                        <span>Boletos Seleccionados:</span>
                        <span id="selected-count" class="font-semibold">0</span>
                    </p>
                </div>
                
                <hr class="my-4 border-gray-300">

                <div class="flex justify-between text-xl font-bold text-gray-900">
                    <span>Total a Pagar:</span>
                    <span id="total-price">$0.00</span>
                </div>

                <ul id="selected-seats-list" class="mt-4 text-sm space-y-1 h-32 overflow-y-auto border-t pt-2 border-gray-200">
                    <!-- Lista de asientos seleccionados por JS -->
                    <li class="text-gray-500" id="empty-list-message">Ningún asiento seleccionado.</li>
                </ul>

                <button id="buy-button" 
                        class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition duration-300 shadow-xl shadow-green-500/50 disabled:opacity-50"
                        disabled>
                    Comprar Boletos
                </button>

                <!-- Campos ocultos para enviar la data -->
                <input type="hidden" id="funcion-id" value="{{ $funcion->id }}">
                <input type="hidden" id="base-price" value="{{ $funcion->precio_base }}">
                <input type="hidden" id="sala-capacidad" value="{{ $funcion->sala->capacidad }}">
                
                <!-- CSRF Token para Laravel -->
                <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Cargamos el archivo JavaScript después del contenido para asegurar que el DOM esté listo -->
    <script src="{{ asset('js/asiento_selector.js') }}"></script>
@endpush