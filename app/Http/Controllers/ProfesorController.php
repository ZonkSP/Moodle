<?php

namespace App\Http\Controllers;

use App\Models\User;  // Assuming User model has 'role' and 'grupos' relationship
use App\Models\Grupo; // Assuming Grupo model has 'alumnos' relationship
use Illuminate\Http\Request;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;


class ProfesorController extends Controller
{
    public function showDashboard()
    {
        $profesor_id = Auth::id();
        // Fetch the groups that belong to this professor
        $grupos = Grupo::where('profesor_id', $profesor_id)
            ->with(['alumnos.calificaciones'])
            ->get();


        // Pass the groups to the view
        return view('profesor.dashboard', compact('grupos'));
    }

    public function storeCalificacion(Request $request, $grupo_id, $alumno_id)
    {
        // Validar la calificación
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10', // assuming grade is between 0 and 10
        ]);

        // Crear o actualizar la calificación para el alumno en el grupo
        Calificacion::updateOrCreate(
            ['grupo_id' => $grupo_id, 'alumno_id' => $alumno_id],
            ['calificacion' => $request->calificacion]
        );

        return redirect()->route('profesor.dashboard')->with('success', 'Calificación actualizada correctamente');
    }
}
