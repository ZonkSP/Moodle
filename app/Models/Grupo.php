<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'materia_id',
        'profesor_id',
        'hora_inicio',
        'hora_fin',
    ];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'grupo_user'); // assuming a pivot table 'grupo_user'
    }

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function enrollmentRequests()
    {
        return $this->hasMany(EnrollmentRequest::class);
    }


    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'grupo_user', 'grupo_id', 'user_id');
    }



    // Relación con Profesor
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
