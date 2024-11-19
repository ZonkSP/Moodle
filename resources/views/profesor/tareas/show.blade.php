@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h4 class="text-lg font-bold mb-4">Revisar Entregas de la Tarea: {{ $tarea->nombre }}</h4>
    <p class="text-gray-600 mb-4">Descripción: {{ $tarea->descripcion }}</p>
    <p class="text-gray-600 mb-4">Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>
    <table class="table-auto w-full bg-white rounded-lg shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Alumno</th>
                <th class="px-4 py-2">Archivo</th>
                <th class="px-4 py-2">Retroalimentación</th>
                <th class="px-4 py-2">Calificación</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td class="border px-4 py-2">{{ $alumno->name }}</td>
                <td class="border px-4 py-2">
                    @php
                    $entrega = $alumno->entregas->first();
                    @endphp

                    @if ($entrega && $entrega->archivo)
                    <a href="{{ asset('storage/' . $entrega->archivo) }}" class="btn btn-sm btn-primary">Descargar</a>
                    @else
                    <span class="text-gray-500">No entregado</span>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    <form method="POST"
                        action="{{ $entrega 
                    ? route('entregas.update', ['entrega' => $entrega->id]) 
                    : route('entregas.store') }}">
                        @csrf
                        @if ($entrega)
                        @method('PUT')
                        @endif
                        <textarea name="retroalimentacion" rows="2" class="textarea textarea-bordered w-full">{{ $entrega->retroalimentacion ?? '' }}</textarea>
                </td>
                <td class="border px-4 py-2">
                    <input type="number" name="calificacion" class="input input-bordered w-full" value="{{ $entrega->calificacion ?? '' }}">
                </td>
                <td class="border px-4 py-2">
                    <input type="hidden" name="tarea_id" value="{{ $tarea->id }}">
                    <input type="hidden" name="user_id" value="{{ $alumno->id }}">
                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection