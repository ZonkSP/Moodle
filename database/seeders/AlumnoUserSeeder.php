<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlumnoUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Alumno',
            'email' => 'biblio@example.com',
            'password' => Hash::make('password'),
            'role' => 'Alumno', // Admin role
        ]);
    }
}
