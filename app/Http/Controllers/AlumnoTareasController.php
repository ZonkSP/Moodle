<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrega;
use Illuminate\Http\Request;

class AlumnoTareasController extends Controller
{
    public function index()
    {
        // Obtener los grupos en los que el alumno está inscrito, incluyendo la relación con el profesor
        $grupos = Grupo::with('profesor', 'materia')->whereHas('alumnos', function ($query) {
            $query->where('users.id', Auth::id());
        })->get();
        /* dd($grupos)->toArray(); */

        // Dividir tareas por estado
        $tareasPendientes = Tarea::whereDoesntHave('entregas', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $tareasCompletadas = Tarea::whereHas('entregas', function ($query) {
            $query->where('user_id', Auth::id())->whereNotNull('archivo')->whereNull('calificacion');
        })->get();

        $tareasRevisadas = Tarea::whereHas('entregas', function ($query) {
            $query->where('user_id', Auth::id())->whereNotNull('calificacion');
        })->get();

        return view('alumno.tareas.index', compact('grupos', 'tareasPendientes', 'tareasCompletadas', 'tareasRevisadas'));
    }

    public function showTarea($tareaId)
    {
        $tarea = Tarea::with(['entregas' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->findOrFail($tareaId);

        return view('alumno.tareas.show', compact('tarea'));
    }

    public function storeEntrega(Request $request)
    {
        $request->validate([
            'tarea_id' => 'required|exists:tareas,id',
            'archivo' => 'required|file|mimes:pdf|max:2048',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->withErrors(['user_id' => 'El usuario no está autenticado.']);
        }

        // Guardar archivo con nombre único
        $filename = 'entrega_' . Auth::id() . '_' . $request->tarea_id . '.' . $request->file('archivo')->getClientOriginalExtension();
        $path = $request->file('archivo')->storeAs('entregas', $filename, 'public');

        // Crear registro de entrega
        Entrega::create([
            'tarea_id' => $request->tarea_id,
            'user_id' => Auth::id(),
            'archivo' => $path,
        ]);

        return redirect()->route('alumnos.tareas.index')->with('success', 'La tarea fue entregada correctamente.');
    }
}
