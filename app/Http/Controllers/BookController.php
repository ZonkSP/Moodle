<?php
// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('alumno.index', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'image|nullable|max:1999',
        ]);

        $imagePath = null; // Default image path

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store image in the 'public/images' directory
        }

        // Create the book
        Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'image' => $imagePath,
        ]);

        // Redirect based on user role
        return $this->redirectAfterAction('added');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        // Redirect based on user role
        return $this->redirectAfterAction('deleted');
    }

    protected function redirectAfterAction($action)
    {
        if (auth()->user()->role === 'Administrador') {
            return redirect()->route('admin.dashboard')->with('success', 'Book ' . $action . ' successfully.');
        }

        // Default to librarian dashboard
        return redirect()->route('alumno.dashboard')->with('success', 'Book ' . $action . ' successfully.');
    }
}
