@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">{{ __('Iniciar sesión') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Correo electrónico') }}</label>
                <input id="email" type="email" class="w-full mt-1 px-3 py-2 border  rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Contraseña') }}</label>
                <input id="password" type="password" class="w-full mt-1 px-3 py-2 border  rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input class="w-4 h-4 text-red-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-200" for="remember">
                        {{ __('Recuérdame') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-red-500 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition-colors">
                    {{ __('Iniciar sesión') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
