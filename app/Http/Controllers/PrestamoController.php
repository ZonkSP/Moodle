<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with(['reader', 'book'])->get();
        $readers = Reader::all();
        $books = Book::all();
        if (auth()->user()->role === 'Administrador') {
            return view('admin.index', compact('prestamos', 'readers', 'books'));
        }else{
            return view('alumno.index', compact('prestamos', 'readers', 'books'));
        }      
    }
       

    public function store(Request $request)
    {
        $request->validate([
            'reader_id' => 'required|exists:readers,id',
            'book_id' => 'required|exists:books,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date',
        ]);

        Prestamo::create($request->all());
        if (auth()->user()->role === 'Administrador') {
            return redirect()->route('admin.dashboard')->with('prestamo_success', 'Préstamo añadido exitosamente.');
        }else{
            return redirect()->route('alumno.dashboard')->with('prestamo_success', 'Préstamo añadido exitosamente.');
        }   
    }

    public function destroy($id)
    {
        // Find the Prestamo by ID
        $prestamo = Prestamo::find($id);

        // Check if the Prestamo exists
        if (!$prestamo) {
            if (auth()->user()->role === 'Administrador') {
                return redirect()->route('admin.dashboard')->with('error', 'Loan not found.');
            }else{
                return redirect()->route('alumno.dashboard')->with('error', 'Loan not found.');
            }  
        }

        // Delete the Prestamo
        $prestamo->delete();

        // Return a success message
        if (auth()->user()->role === 'Administrador') {
            return redirect()->route('admin.dashboard')->with('success', 'Loan deleted successfully.');
        }else{
            return redirect()->route('alumno.dashboard')->with('success', 'Loan deleted successfully.');
        }  
    }
    
}
