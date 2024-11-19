@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center bg-gray-50 py-8">
    <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Profesor Dashboard</h1>

        <!-- Mensaje de éxito -->
        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-md">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabla para mostrar grupos y alumnos -->
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Grupos</h2>
            @if($grupos->isEmpty())
            <p class="text-gray-600">No tienes grupos asignados.</p>
            @else
            @foreach($grupos as $grupo)
            
            <!-- Display materia details -->
            <div class="bg-white p-4 mb-6 rounded-lg shadow">
                <p class="text-lg"><strong>Materia:</strong> {{ $grupo->materia ? $grupo->materia->nombre : 'No asignada' }}</p>
                <p><strong>Hora de inicio:</strong> {{ $grupo->hora_inicio }}</p>
                <p><strong>Hora de fin:</strong> {{ $grupo->hora_fin }}</p>
            </div>

            <!-- Tabla de alumnos -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-center py-3 px-4 font-semibold text-gray-600">Alumnos</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-600">Correo</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-600">Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupo->alumnos as $alumno)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $alumno->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $alumno->email }}</td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('profesor.calificacion.store', [$grupo->id, $alumno->id]) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="text" name="calificacion"
                                           value="{{ optional($alumno->calificaciones->firstWhere('grupo_id', $grupo->id))->calificacion }}"
                                           class="input input-bordered w-24"
                                           placeholder="Calificación">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
