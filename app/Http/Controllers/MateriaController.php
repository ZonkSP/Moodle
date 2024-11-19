<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('admin', compact('materias'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'clave' => 'required',
            'nombre' => 'required',
            'creditos' => 'required|numeric',
        ]);

        $materia->clave = $request->input('clave');
        $materia->nombre = $request->input('nombre');
        $materia->creditos = $request->input('creditos');
        $materia->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'User updated successfully!');
    }
 
    
    public function createMateria(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'clave' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'creditos' => 'required|integer',
        ]);
    
        // Create the new materia using validated data
        Materia::create($validatedData);
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Materia created successfully!');
    }
    

    public function edit(Materia $materia)
    {
        return view('admin.dashboard', compact('materia'));
    }

    public function destroy($id)
    {
        // Find the materia by ID and delete it
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return back()->with('success', 'Materia eliminada con éxito.');
    }
}
