<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
   


    public function enroll(Request $request, Grupo $grupo)
{
    $enrollmentRequest = EnrollmentRequest::where('grupo_id', $grupo->id)
                                          ->where('alumno_id', $request->alumno_id)
                                          ->first();

    if ($enrollmentRequest && $enrollmentRequest->status == 'approved') {
        // Enroll the student (update their record, or link them to the group)
        $grupo->students()->attach($request->alumno_id); // Assuming many-to-many relationship

        return redirect()->route('admin.enrollment.requests')->with('success', 'Student enrolled successfully.');
    }

    return redirect()->route('admin.enrollment.requests')->with('error', 'Enrollment request not approved.');
}


    public function index()
    {
        $grupos = Grupo::all();
        return view('admin', compact('grupos'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return back()->with('success', 'Grupo eliminado con éxito.');
    }

    public function createGrupo(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:users,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
        ]);

        // Crea el grupo
        Grupo::create([
            'materia_id' => $request->materia_id,
            'profesor_id' => $request->profesor_id,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->back()->with('success', 'Grupo created successfully!');    
    }

    public function edit(Grupo $grupo)
    {
        return view('admin.dashboard', compact('grupo'));
    }


    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'materia_id' => 'required',
            'profesor_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $grupo->materia_id = $request->input('materia_id');
        $grupo->profesor_id = $request->input('profesor_id');
        $grupo->hora_inicio = $request->input('hora_inicio');
        $grupo->hora_fin = $request->input('hora_fin');
        $grupo->save();

        return redirect()->back()->with('success', 'Grupo updated successfully!');    
    }

}
