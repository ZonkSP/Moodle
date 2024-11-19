@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center my-6">Panel del Alumno</h1>

    <!-- Success message -->
    @if (session('success'))
    <div class="alert alert-success shadow-lg mb-4">
        <div>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Table for displaying available groups -->
    <div class="bg-white rounded-lg shadow-lg p-6 border mb-8">
        <p class="text-xl font-semibold mb-4">Grupos Disponibles</p>
        <div class="overflow-x-auto max-h-96">
            <table class="table w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-center p-3 font-semibold text-gray-700">Materia</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Profesor</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Inicio</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Fin</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="text-center p-3">{{ $grupo->materia->nombre }}</td>
                        <td class="text-center p-3">{{ $grupo->profesor->name }}</td>
                        <td class="text-center p-3">{{ $grupo->hora_inicio }}</td>
                        <td class="text-center p-3">{{ $grupo->hora_fin }}</td>
                        <td class="text-center p-3">
                            @if(in_array($grupo->id, $pendingRequests))
                            <span class="badge badge-warning">Solicitud pendiente</span>
                            @else
                            <form action="{{ route('enrollment.request.store', $grupo->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Solicitar inscripción</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table for displaying enrolled groups -->
    <div class="bg-white rounded-lg shadow-lg p-6 border">
        <p class="text-xl font-semibold mb-4">Materias Inscritas</p>
        <div class="overflow-x-auto max-h-96">
            <table class="table w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-center p-3 font-semibold text-gray-700">Materia</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Profesor</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Inicio</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Fin</th>
                        <th class="text-center p-3 font-semibold text-gray-700">Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolledGroups as $grupo)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="text-center p-3">{{ $grupo->materia->nombre }}</td>
                        <td class="text-center p-3">{{ $grupo->profesor->name }}</td>
                        <td class="text-center p-3">{{ $grupo->hora_inicio }}</td>
                        <td class="text-center p-3">{{ $grupo->hora_fin }}</td>
                        <td class="text-center p-3">
                            @php
                            $calificacion = $grupo->calificaciones->firstWhere('alumno_id', Auth::id());
                            @endphp
                            @if($calificacion)
                            <span class="text-gray-700">{{ $calificacion->calificacion }}</span>
                            @else
                            <span class="text-gray-500">No disponible</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
