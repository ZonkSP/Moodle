@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h4 class="text-lg font-bold mb-4">Detalles de la Tarea: {{ $tarea->nombre }}</h4>
    <p class="text-gray-600 mb-4">Descripción: {{ $tarea->descripcion }}</p>
    <p class="text-gray-600 mb-4">Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="text-lg font-bold">Retroalimentación</h5>
        <p>{{ $tarea->entregas->first()->retroalimentacion ?? 'No disponible' }}</p>

        <h5 class="text-lg font-bold mt-4">Calificación</h5>
        <p>{{ $tarea->entregas->first()->calificacion ?? 'No disponible' }}</p>
    </div>

    <a href="{{ route('alumnos.tareas.index') }}" class="btn btn-primary mt-6">Regresar</a>
</div>
@endsection
