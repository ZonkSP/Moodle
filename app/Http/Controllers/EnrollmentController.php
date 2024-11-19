<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\EnrollmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    // Store the enrollment request
    public function store(Request $request, $grupoId)
    {
        // Assuming you want to enroll the currently authenticated user
        $user = Auth::user();


        // Ensure the user is an "Alumno"
        if ($user->role !== 'Alumno') {
            return redirect()->back()->with('error', 'Only students can enroll.');
        }
        // Verificar si ya existe una solicitud pendiente o aprobada para este grupo
        $existingRequest = EnrollmentRequest::where('user_id', $user->id)
            ->where('grupo_id', $grupoId)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente o aprobada para este grupo.');
        }

        // Crear la solicitud de inscripción
        EnrollmentRequest::create([
            'user_id' => $user->id,
            'grupo_id' => $grupoId,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Enrollment requested successfully!');
    }

    public function approve($id)
    {
        $request = EnrollmentRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        // Añadir al alumno al grupo (tabla pivot)
        $request->grupo->alumnos()->attach($request->user_id);

        return redirect()->back()->with('success', 'Solicitud aprobada.');
    }

    public function reject($id)
    {
        $request = EnrollmentRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Solicitud rechazada.');
    }
}
