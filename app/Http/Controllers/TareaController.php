<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index(Request $request)
    {
        $grupo_id = $request->input('grupo_id');
        $grupos = Grupo::where('profesor_id', Auth::id())->get();
        $tareas = Tarea::with('grupo')
            ->where('profesor_id', Auth::id())
            ->when($grupo_id, function ($query) use ($grupo_id) {
                $query->where('grupo_id', $grupo_id);
            })
            ->get();

        return view('profesor.tareas.index', compact('tareas', 'grupos'));
    }


    public function create()
    {
        $grupos = Grupo::where('profesor_id', Auth::id())->get();
        return view('profesor.tareas.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'grupo_id' => 'required|exists:grupos,id',
            'fecha_entrega' => 'required|date',
        ]);

        Tarea::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'grupo_id' => $request->grupo_id,
            'profesor_id' => Auth::id(),
            'fecha_entrega' => $request->fecha_entrega,
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente.');
    }

    public function show($tareaId)
    {
        $tarea = Tarea::findOrFail($tareaId);

        // Obtener alumnos del grupo relacionado con la tarea, y que tengan rol "Alumno"
        $alumnos = User::with(['entregas' => function ($query) use ($tareaId) {
            $query->where('tarea_id', $tareaId);
        }])
            ->whereHas('grupos', function ($query) use ($tarea) {
                $query->where('grupos.id', $tarea->grupo_id); // Solo alumnos del grupo asociado a la tarea
            })
            ->where('role', 'Alumno') // Filtrar solo por el rol "Alumno"
            ->get();
        /* dd($alumnos->toArray()); */


        return view('profesor.tareas.show', compact('tarea', 'alumnos'));
    }


    public function download($archivo)
    {
        $filePath = storage_path("app/public/entregas/{$archivo}");
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'El archivo no existe.');
    }
}
