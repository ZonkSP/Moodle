<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EnrollmentRequest;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    // AdminController.php
    public function dashboard()
    {
        // Retrieve pending enrollment requests with alumno and grupo relationships
        $requests = EnrollmentRequest::with(['user', 'grupo'])
            ->where('status', 'pending')
            ->get();
        Log::info('Información de requests:', ['requests' => $requests]);

        return view('admin.dashboard', compact('requests'));
    }

    public function enrollStudentInGroup($requestId)
    {
        $request = EnrollmentRequest::findOrFail($requestId);

        // Logic to enroll the alumno in the group
        $grupo = $request->grupo;
        $alumno = $request->alumno;

        // Add the alumno to the group (e.g., creating an enrollment record)
        // Assuming you have a many-to-many relationship set up between users and grupos
        $grupo->alumnos()->attach($alumno);

        // Update the enrollment request status
        $request->status = 'approved';
        $request->save();

        return redirect()->route('admin.dashboard')->with('success', 'Inscripción aprobada.');
    }
}
