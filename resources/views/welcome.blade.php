<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control Escolar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-300">
    <header>
        <nav class="bg-white dark:bg-gray-800 shadow p-4">
            <div class="flex justify-between items-center max-w-7xl mx-auto">

                <div class="flex items-center space-x-4">
                    @auth
                    @if (Auth::user()->role === 'Administrador')
                    <a href="{{ url('/admin') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500">Dashboard Admin</a>
                    @elseif (Auth::user()->role === 'Alumno')
                    <a href="{{ url('/alumno') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500">Dashboard Alumno</a>
                    <a href="{{ route('alumnos.tareas.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500">Tareas</a>
                    @elseif (Auth::user()->role === 'Profesor')
                    <a href="{{ url('/profesor') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500">Dashboard Profesor</a>
                    <a href="{{ route('tareas.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500">Asignar Tareas</a>
                    @endif
                    <a href="{{ route('logout') }}" class="text-gray-700 dark:text-gray-200 hover:text-red-500" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 rounded-lg px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-600">Iniciar Sesión</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 rounded-lg px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-600">Registrar</a>
                    @endif
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="flex flex-col items-center justify-center h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <!-- Welcome Section -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Bienvenido al Sistema de Control Escolar</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Accede a tu panel de usuario para gestionar tus clases, calificaciones y mucho más.
            </p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>