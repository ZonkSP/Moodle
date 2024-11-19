@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center my-6">Administrador</h1>

    <!-- Success message for Readers -->
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="container mx-auto mt-8">
        <div class="flex justify-center">
            <!-- Form Section -->
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md border border-gray-200">
                <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.create') }}" method="POST" class="space-y-4">
                    @csrf
                    @if(isset($user))
                    @method('PUT')
                    <h2 class="text-2xl font-bold text-center mb-4">Editar Usuario</h2>
                    @else
                    <h2 class="text-2xl font-bold text-center mb-4">Crear Usuario</h2>
                    @endif

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ isset($user) ? $user->name : old('name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ingresa el nombre">
                    </div>

                    <!-- Correo Electrónico -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ isset($user) ? $user->email : old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ingresa el correo electrónico">
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ingresa la contraseña">
                        @if(isset($user))
                        <small class="text-gray-500">Deja en blanco si no deseas cambiar la contraseña</small>
                        @endif
                    </div>

                    <!-- Rol -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" id="role" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Administrador" {{ isset($user) && $user->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Alumno" {{ isset($user) && $user->role == 'Alumno' ? 'selected' : '' }}>Alumno</option>
                            <option value="Profesor" {{ isset($user) && $user->role == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                    </div>

                    <!-- Botón de Enviar -->
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition-colors">
                        {{ isset($user) ? 'Actualizar Usuario' : 'Crear Usuario' }}
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Users Table -->
    <div class="container mx-auto mt-8 pt-2">
        <div class="flex justify-center">
            <!-- Table Section -->
            <div class="w-full max-w-5xl bg-white rounded-lg shadow-md border border-gray-200 p-6">
                <div class="overflow-auto max-h-80">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-gray-600 text-center">Nombre</th>
                                <th class="px-4 py-2 text-gray-600 text-center">Correo Electrónico</th>
                                <th class="px-4 py-2 text-gray-600 text-center">Rol</th>
                                <th class="px-4 py-2 text-gray-600 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->role }}</td>
                                <td class="px-4 py-2 text-center flex justify-center space-x-2">
                                    <!-- Botón de Editar -->
                                    <label for="editModal-{{ $user->id }}" class="bg-green-500 text-white px-3 py-1 rounded cursor-pointer hover:bg-green-600">Editar</label>

                                    <!-- Formulario para Eliminar -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @foreach ($users as $user)
    <input type="checkbox" id="editModal-{{ $user->id }}" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box relative">
            <!-- Cerrar el modal -->
            <label for="editModal-{{ $user->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <!-- Título del modal -->
            <h3 class="text-lg font-bold">Editar Usuario</h3>
            <!-- Formulario de edición -->
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4 mt-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="input input-bordered w-full">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="input input-bordered w-full">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" class="input input-bordered w-full">
                    <small class="text-gray-500">Deja en blanco si no deseas cambiar la contraseña</small>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="role" id="role" required class="select select-bordered w-full">
                        <option value="Administrador" {{ $user->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Alumno" {{ $user->role == 'Alumno' ? 'selected' : '' }}>Alumno</option>
                        <option value="Profesor" {{ $user->role == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                    </select>
                </div>

                <!-- Botones de acción -->
                <div class="modal-action">
                    <label for="editModal-{{ $user->id }}" class="btn">Cancelar</label>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach



    <!-- Formulario para agregar/editar materia -->
    <div class="max-w-md mx-auto mb-8 pt-2">
        <form action="{{ isset($materia) ? route('materias.update', $materia->id) : route('materias.create') }}" method="POST" class="p-6 bg-white rounded-lg shadow-lg">
            @csrf
            @if(isset($materia))
            @method('PUT')
            <h2 class="text-2xl font-semibold mb-4 text-center">Editar Materia</h2>
            @else
            <h2 class="text-2xl font-semibold mb-4 text-center">Agregar Materia</h2>
            @endif

            <div class="mb-4">
                <label for="clave" class="block text-sm font-medium text-gray-700">Clave</label>
                <input type="text" name="clave" id="clave" value="{{ isset($materia) ? $materia->clave : old('clave') }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Ingresa la clave">
            </div>

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ isset($materia) ? $materia->nombre : old('nombre') }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Ingresa el nombre">
            </div>

            <div class="mb-4">
                <label for="creditos" class="block text-sm font-medium text-gray-700">Créditos</label>
                <input type="number" name="creditos" id="creditos" value="{{ isset($materia) ? $materia->creditos : old('creditos') }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Ingresa los créditos">
            </div>

            <button type="submit" class="w-full py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition-colors">
                {{ isset($materia) ? 'Actualizar Materia' : 'Agregar Materia' }}
            </button>
        </form>
    </div>

    <!-- Tabla de materias -->
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden pt-2">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full bg-gray-100 border-b">
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Clave</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Nombre</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Créditos</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-center py-3 px-4">{{ $materia->clave }}</td>
                        <td class="text-center py-3 px-4">{{ $materia->nombre }}</td>
                        <td class="text-center py-3 px-4">{{ $materia->creditos }}</td>
                        <td class="text-center py-3 px-4 flex justify-center space-x-2">
                            <!-- Botón de editar con DaisyUI Modal -->
                            <label for="editMateriaModal-{{ $materia->id }}" class="btn btn-sm bg-green-500 text-white rounded hover:bg-green-600">Editar</label>

                            <!-- Formulario de eliminar -->
                            <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modales de edición para cada materia -->
    @foreach ($materias as $materia)
    <input type="checkbox" id="editMateriaModal-{{ $materia->id }}" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box relative">
            <!-- Cerrar el modal -->
            <label for="editMateriaModal-{{ $materia->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <!-- Contenido del modal -->
            <h3 class="text-lg font-bold">Editar Materia</h3>
            <form action="{{ route('materias.update', $materia->id) }}" method="POST" class="space-y-4 mt-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="clave" class="block text-sm font-medium text-gray-700">Clave</label>
                    <input type="text" name="clave" id="clave" value="{{ old('clave', $materia->clave) }}" required class="input input-bordered w-full">
                </div>

                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $materia->nombre) }}" required class="input input-bordered w-full">
                </div>

                <div>
                    <label for="creditos" class="block text-sm font-medium text-gray-700">Créditos</label>
                    <input type="number" name="creditos" id="creditos" value="{{ old('creditos', $materia->creditos) }}" required class="input input-bordered w-full">
                </div>

                <!-- Botones de acción -->
                <div class="modal-action">
                    <label for="editMateriaModal-{{ $materia->id }}" class="btn">Cancelar</label>
                    <button type="submit" class="btn btn-primary">Actualizar Materia</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- Formulario para agregar/editar grupo -->
    <div class="max-w-md mx-auto mb-8 pt-2">
        <form action="{{ isset($grupo) ? route('grupos.update', $grupo->id) : route('grupos.create') }}" method="POST" class="p-6 bg-white rounded-lg shadow-lg">
            @csrf
            @if(isset($grupo))
            @method('PUT')
            <h2 class="text-2xl font-semibold mb-4 text-center">Editar Grupo</h2>
            @else
            <h2 class="text-2xl font-semibold mb-4 text-center">Agregar Grupo</h2>
            @endif

            <div class="mb-4">
                <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                <select name="materia_id" id="materia_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                    <option value="">Seleccionar Materia</option>
                    @foreach($materias as $materia)
                    <option value="{{ $materia->id }}" {{ isset($grupo) && $grupo->materia_id == $materia->id ? 'selected' : '' }}>
                        {{ $materia->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="profesor_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                    <option value="">Seleccionar Profesor</option>
                    @foreach($profesores as $profesor)
                    <option value="{{ $profesor->id }}" {{ isset($grupo) && $grupo->profesor_id == $profesor->id ? 'selected' : '' }}>
                        {{ $profesor->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ isset($grupo) ? $grupo->hora_inicio : old('hora_inicio') }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                <input type="time" name="hora_fin" id="hora_fin" value="{{ isset($grupo) ? $grupo->hora_fin : old('hora_fin') }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition-colors">
                {{ isset($grupo) ? 'Actualizar Grupo' : 'Agregar Grupo' }}
            </button>
        </form>
    </div>

    <!-- Tabla de grupos -->
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden pt-2">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full bg-gray-100 border-b">
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Materia</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Profesor</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Hora de Inicio</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Hora de Fin</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-center py-3 px-4">{{ $grupo->materia->nombre }}</td>
                        <td class="text-center py-3 px-4">{{ $grupo->profesor->name }}</td>
                        <td class="text-center py-3 px-4">{{ $grupo->hora_inicio }}</td>
                        <td class="text-center py-3 px-4">{{ $grupo->hora_fin }}</td>
                        <td class="text-center py-3 px-4 flex justify-center space-x-2">
                            <!-- Botón de editar -->
                            <button class="px-3 py-1 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600" onclick="document.getElementById('editGrupoModal{{ $grupo->id }}').classList.remove('hidden')">Editar</button>

                            <!-- Formulario de eliminar -->
                            <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para editar grupo -->
    @foreach($grupos as $grupo)
    <div class="fixed inset-0 z-50 hidden pt-2" id="editGrupoModal{{ $grupo->id }}">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Editar Grupo</h3>
                    <button onclick="document.getElementById('editGrupoModal{{ $grupo->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">X</button>
                </div>
                <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                        <select name="materia_id" id="materia_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                            <option value="">Seleccionar Materia</option>
                            @foreach($materias as $materia)
                            <option value="{{ $materia->id }}" {{ $grupo->materia_id == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="profesor_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                        <select name="profesor_id" id="profesor_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                            <option value="">Seleccionar Profesor</option>
                            @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}" {{ $grupo->profesor_id == $profesor->id ? 'selected' : '' }}>
                                {{ $profesor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" value="{{ $grupo->hora_inicio }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" value="{{ $grupo->hora_fin }}" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition-colors">Actualizar Grupo</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Solicitudes de Inscripción Pendientes -->
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4 text-center">Solicitudes de Inscripción Pendientes</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Alumno</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Grupo</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-center py-3 px-4">{{ $request->Alumno->name }}</td>
                        <td class="text-center py-3 px-4">{{ $request->grupo->materia->nombre }}</td>
                        <td class="text-center py-3 px-4 flex justify-center space-x-2">
                            <!-- Botón de Aprobar -->
                            <form action="{{ route('enrollment.request.approve', $request->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm bg-green-500 text-white rounded-md hover:bg-green-600">Aprobar</button>
                            </form>

                            <!-- Botón de Rechazar -->
                            <form action="{{ route('enrollment.request.reject', $request->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm bg-red-500 text-white rounded-md hover:bg-red-600">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection