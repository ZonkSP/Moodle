@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna Izquierda: Botones de Grupos -->
        <div class="w-full lg:w-1/4">
            <h4 class="text-lg font-bold mb-4">Grupos</h4>
            <div class="flex flex-col space-y-2">
                @foreach ($grupos as $grupo)
                <a href="{{ route('tareas.index', ['grupo_id' => $grupo->id]) }}"
                    class="btn {{ request('grupo_id') == $grupo->id ? 'btn-primary' : 'btn-outline' }}">
                    {{ $grupo->materia->nombre }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Columna Central: Formulario para Crear Tareas -->
        <div class="w-full lg:w-1/2 bg-white shadow-md rounded-lg p-6">
            <h4 class="text-lg font-bold mb-4">Crear Tarea</h4>
            <form method="POST" action="{{ route('tareas.store') }}">
                @csrf
                <input type="hidden" name="grupo_id" value="{{ request('grupo_id') }}">
                <div class="form-control mb-4">
                    <label for="nombre" class="label">
                        <span class="label-text">Nombre de la Tarea</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" class="input input-bordered w-full" required>
                </div>
                <div class="form-control mb-4">
                    <label for="descripcion" class="label">
                        <span class="label-text">Descripción</span>
                    </label>
                    <textarea id="descripcion" name="descripcion" class="textarea textarea-bordered w-full" rows="3" required></textarea>
                </div>
                <div class="form-control mb-4">
                    <label for="fecha_entrega" class="label">
                        <span class="label-text">Fecha de Entrega</span>
                    </label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" class="input input-bordered w-full" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">Guardar Tarea</button>
            </form>
        </div>

        <!-- Columna Derecha: Lista de Tareas -->
        <div class="w-full lg:w-1/4">
            <h4 class="text-lg font-bold mb-4">Tareas Asignadas</h4>
            @if ($tareas->isEmpty())
            <p class="text-gray-500">No hay tareas asignadas para este grupo.</p>
            @else
            <ul class="space-y-4">
                @foreach ($tareas as $tarea)
                <li class="bg-gray-100 p-4 rounded-lg shadow">
                    <h5 class="font-bold">{{ $tarea->nombre }}</h5>
                    <p class="text-sm text-gray-600">Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('tareas.show', ['tarea' => $tarea->id]) }}" class="btn btn-sm btn-primary">Ver</a>
                        <!-- <a href="#" class="btn btn-sm btn-warning">Editar</a> -->
                        <!-- <a href="#" class="btn btn-sm btn-success">Enviar Revisión</a> -->
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

    </div>
</div>
@endsection