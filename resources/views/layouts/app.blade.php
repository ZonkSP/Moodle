<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Alumno') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/charts.js'])
</head>
<body class="bg-gray-100 font-sans antialiased dark:bg-gray-900 dark:text-white">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-900 dark:text-white shadow">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <!-- Brand -->
                <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800 dark:text-white">
                    {{ config('app.name', 'Sistema de Alumno') }}
                </a>

                <!-- Navbar Toggle for Mobile -->
                <div class="lg:hidden">
                    <button id="navbar-toggle" class="text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navbar Links -->
                <div id="navbar-menu" class="hidden lg:flex space-x-4">
                    <ul class="flex items-center space-x-4">
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">
                                        {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else

                            <!-- User Dropdown -->
                            <li class="relative">
                                <button id="user-menu-button" class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                                    {{ Auth::user()->name }}
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-md z-20">
                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

    <!-- Toggle Navbar Script for Mobile -->
    <script>
        document.getElementById('navbar-toggle').onclick = function() {
            document.getElementById('navbar-menu').classList.toggle('hidden');
        };

        // Toggle user dropdown menu
        document.getElementById('user-menu-button').onclick = function() {
            document.getElementById('user-menu').classList.toggle('hidden');
        };
    </script>
</body>
</html>
