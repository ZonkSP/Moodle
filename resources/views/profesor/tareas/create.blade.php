@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Tarea</h1>
    <form method="POST" action="{{ route('tareas.store') }}">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre de la Tarea</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="grupo_id">Grupo</label>
            <select class="form-control" id="grupo_id" name="grupo_id" required>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->materia->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_entrega">Fecha de Entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
