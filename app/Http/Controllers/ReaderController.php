<?php

// app/Http/Controllers/ReaderController.php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::all();
        if (auth()->user()->role === 'Administrador') {
            return view('admin.index', compact('readers'));
        }else{
            return view('alumno.index', compact('readers'));
        }   
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:readers,email',
        ]);

        Reader::create($request->all());
        if (auth()->user()->role === 'Administrador') {
            return redirect()->route('admin.dashboard')->with('success', 'Reader added successfully.');
        }else{
            return redirect()->route('alumno.dashboard')->with('success', 'Reader added successfully.');
        }     
    }

    public function destroy($id)
    {
        $reader = Reader::findOrFail($id);
        $reader->delete();
        if (auth()->user()->role === 'Administrador') {
            return redirect()->route('admin.dashboard')->with('success', 'Reader deleted successfully.');
        }else{
            return redirect()->route('alumno.dashboard')->with('success', 'Reader deleted successfully.');
        } 
    }
}
