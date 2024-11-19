<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect or return response
        return back()->with('success', 'User deleted successfully');
    }


    
    public function edit(User $user)
{
    return view('users.edit', compact('user'));
}


public function update(Request $request, User $user)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8|confirmed',
        'role' => 'required|string',
    ]);

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($request->password) {
        $user->password = bcrypt($validatedData['password']);
    }
    $user->role = $validatedData['role'];
    $user->save();

    return redirect()->back()->with('success', 'User updated successfully!');
}


    public function index()
    {
        $users = User::all(); // Or use pagination or filters if necessary

        return view('users.index', compact('users'));
    }

    public function createUser(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:Administrador,Alumno,Profesor',
        ]);
    
        // Debugging - check the validated data
        // dd($validated);  // This will dump the validated data
    
        // Create the new user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
    
        return redirect()->back()->with('success', 'User created successfully!');
    }
    
    
}
