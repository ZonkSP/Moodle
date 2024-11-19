<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use Illuminate\Support\Facades\Storage;

class EntregaController extends Controller
{
    public function update(Request $request, $entregaId)
    {
        // Buscar la entrega o devolver error 404
        $entrega = Entrega::findOrFail($entregaId);

        // Validar los datos de la solicitud
        $request->validate([
            'retroalimentacion' => 'nullable|string',
            'calificacion' => 'nullable|integer|min:0|max:100',
        ]);

        // Actualizar la entrega
        $entrega->update([
            'retroalimentacion' => $request->input('retroalimentacion'),
            'calificacion' => $request->input('calificacion'),
        ]);

        // Redirigir de vuelta con mensaje de éxito
        return redirect()->back()->with('success', 'Entrega actualizada correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tarea_id' => 'required|exists:tareas,id',
            'user_id' => 'required|exists:users,id',
            'retroalimentacion' => 'nullable|string',
            'calificacion' => 'nullable|integer|min:0|max:100',
        ]);

        Entrega::create([
            'tarea_id' => $request->tarea_id,
            'user_id' => $request->user_id,
            'retroalimentacion' => $request->retroalimentacion,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->back()->with('success', 'Entrega creada correctamente.');
    }

    public function download($archivo)
    {
        $filePath = storage_path('app/public/entregas/' . $archivo);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'Archivo no encontrado.');
        }
    }
}
