@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna Izquierda: Botones de Grupos -->
        <div class="w-full lg:w-1/4">
            <h4 class="text-lg font-bold mb-4">Grupos</h4>
            <div class="flex flex-col space-y-2">
                <!-- Botón para Ver Todas las Tareas -->
                <a href="{{ route('alumnos.tareas.index') }}"
                    class="btn {{ !request('grupo_id') ? 'btn-primary' : 'btn-outline' }}">
                    Ver Todas las Tareas
                </a>
                <!-- Botones de grupos -->
                @foreach ($grupos as $grupo)
                <div class="p-4 bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('alumnos.tareas.index', ['grupo_id' => $grupo->id]) }}"
                        class="block text-lg font-bold px-4 py-2 rounded-lg text-center {{ request('grupo_id') == $grupo->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-500 hover:text-white' }} transition-colors duration-300">
                        {{ $grupo->materia->nombre }}
                    </a>
                    <p class="text-sm text-gray-600 mt-2">Profesor: {{ $grupo->profesor->name }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Columna Derecha: Tareas -->
        <div class="w-full lg:w-3/4">
            <h4 class="text-lg font-bold mb-4">Tareas</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tareas Pendientes -->
                <div>
                    <h5 class="font-bold">Pendientes</h5>
                    @foreach ($tareasPendientes as $tarea)
                    @if (!request('grupo_id') || $tarea->grupo_id == request('grupo_id'))
                    <div class="card bg-gray-100 shadow-md p-4">
                        <h6>{{ $tarea->nombre }}</h6>
                        <p>{{ $tarea->descripcion }}</p>
                        <p>Fecha de entrega: {{ $tarea->fecha_entrega }}</p>
                        <button
                            class="btn btn-primary"
                            data-tarea-id="{{ $tarea->id }}"
                            data-tarea-nombre="{{ $tarea->nombre }}"
                            onclick="handleEntregaClick(this)">
                            Entregar
                        </button>
                    </div>
                    @endif
                    @endforeach
                </div>
                <!-- Tareas Completadas -->
                <div>
                    <h5 class="font-bold">Completadas</h5>
                    @foreach ($tareasCompletadas as $tarea)
                    @if (!request('grupo_id') || $tarea->grupo_id == request('grupo_id'))
                    <div class="card bg-gray-100 shadow-md p-4">
                        <h6>{{ $tarea->nombre }}</h6>
                        <p>{{ $tarea->descripcion }}</p>
                        <p>Fecha de entrega: {{ $tarea->fecha_entrega }}</p>
                        <button class="btn btn-secondary">Editar Entrega</button>
                    </div>
                    @endif
                    @endforeach
                </div>
                <!-- Tareas Revisadas -->
                <div>
                    <h5 class="font-bold">Revisadas</h5>
                    @foreach ($tareasRevisadas as $tarea)
                    @if (!request('grupo_id') || $tarea->grupo_id == request('grupo_id'))
                    <div class="card bg-gray-100 shadow-md p-4">
                        <h6>{{ $tarea->nombre }}</h6>
                        <p>{{ $tarea->descripcion }}</p>
                        <p>Fecha de entrega: {{ $tarea->fecha_entrega }}</p>
                        <a href="{{ route('alumnos.tareas.show', ['tarea' => $tarea->id]) }}"
                            class="btn btn-success">Ver Retroalimentación</a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleEntregaClick(button) {
        const tareaId = button.getAttribute('data-tarea-id');
        const tareaNombre = button.getAttribute('data-tarea-nombre');

        Swal.fire({
            title: `Entregar Tarea: ${tareaNombre}`,
            html: `
            <form id="entregaForm" method="POST" action="{{ route('entregas.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tarea_id" value="${tareaId}">
                <div class="mb-4">
                    <label for="archivo" class="block text-sm font-medium text-gray-700">Subir Archivo (PDF)</label>
                    <input type="file" id="archivo" name="archivo" accept="application/pdf"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>
            </form>
        `,
            confirmButtonText: 'Entregar',
            showCancelButton: true,
            preConfirm: () => {
                const form = document.getElementById('entregaForm');
                if (!form.reportValidity()) {
                    Swal.showValidationMessage('Por favor sube un archivo PDF válido.');
                    return false;
                }
                form.submit();
            }
        });
    }
</script>