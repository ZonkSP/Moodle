<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    // Assuming you have a foreign key for alumno_id and grupo_id
    protected $fillable = ['calificacion', 'alumno_id', 'grupo_id'];
    protected $table = 'calificaciones';
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }
}
