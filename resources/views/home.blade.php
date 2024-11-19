@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8">
    <div class="max-w-md w-full mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">{{ __('Bienvenido') }}</h1>
        </div>

        @if(Auth::check())
            @php $user = Auth::user(); @endphp
            <div class="space-y-4">
                @if($user->role === 'Administrador')
                <a href="{{ url('/admin') }}" class="btn w-full bg-red-500 text-white text-lg font-semibold rounded-lg px-4 py-2 transition-colors hover:bg-red-600 focus:ring focus:ring-red-400 focus:ring-opacity-75">
                    ← Clic para ir al Dashboard Admin →
                </a>
                @elseif($user->role === 'Alumno')
                <a href="{{ url('/alumno') }}" class="btn w-full bg-blue-500 text-white text-lg font-semibold rounded-lg px-4 py-2 transition-colors hover:bg-blue-600 focus:ring focus:ring-blue-400 focus:ring-opacity-75">
                    ← Clic para ir al Dashboard Alumno →
                </a>
                @elseif($user->role === 'Profesor')
                <a href="{{ url('/profesor') }}" class="btn w-full bg-green-500 text-white text-lg font-semibold rounded-lg px-4 py-2 transition-colors hover:bg-green-600 focus:ring focus:ring-green-400 focus:ring-opacity-75">
                    ← Clic para ir al Dashboard Profesor →
                </a>
                @endif
            </div>
        @endif

        @if (session('status'))
            <div class="mt-6 p-4 bg-green-100 text-green-800 text-center rounded-lg shadow">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
@endsection
