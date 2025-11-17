<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cine Laravel | @yield('title', 'Cartelera')</title>

    <!-- Carga de Tailwind CSS (vía CDN para simplicidad) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define la fuente Inter y un fondo suave */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb; /* Fondo muy claro */
            color: #1f2937; /* Texto oscuro */
        }
        /* Estilo para el contenedor principal centrado */
        .container {
            max-width: 1200px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Barra de Navegación Simple -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="{{ route('cartelera.index') }}" class="text-2xl font-extrabold text-indigo-700 hover:text-indigo-900 transition duration-300">
                Cine Laravel
            </a>
            <div>
                <!-- Enlace de Administración (asumiendo autenticación) -->
                <a href="{{ route('admin.peliculas.index') }}" class="text-gray-600 hover:text-indigo-700 font-medium px-3 py-2 rounded-lg transition duration-300">
                    Administración
                </a>
                <!-- Aquí irían los enlaces de Login/Registro si existieran -->
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Pie de Página (Opcional) -->
    <footer class="bg-gray-100 mt-10 py-4 text-center text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} Cine Laravel. Todos los derechos reservados.
    </footer>

    @stack('scripts')
</body>
</html>