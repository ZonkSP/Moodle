<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\EnrollmentRequest;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function dashboard()
    {
        // Obtener el alumno autenticado
        $alumno = Auth::user();

        // Obtener todos los grupos, filtrando los que ya están inscritos o con solicitud aprobada
        $grupos = Grupo::whereDoesntHave('enrollmentRequests', function($query) use ($alumno) {
            $query->where('user_id', $alumno->id)
                  ->where('status', 'approved');
        })->get();

        // Obtener los grupos en los que el alumno está inscrito
        $enrolledGroups = $alumno->grupos;

        // Obtener solicitudes pendientes para el alumno y sus respectivos grupos
        $pendingRequests = EnrollmentRequest::where('user_id', $alumno->id)
                                            ->where('status', 'pending')
                                            ->pluck('grupo_id')
                                            ->toArray();

        return view('alumno.dashboard', compact('grupos', 'enrolledGroups', 'pendingRequests'));
    }
}


