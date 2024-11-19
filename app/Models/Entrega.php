<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = ['tarea_id', 'user_id', 'archivo', 'retroalimentacion', 'calificacion'];

    // Relación con el modelo Tarea
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    // Relación con el modelo User
    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
