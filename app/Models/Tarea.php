<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'grupo_id',
        'profesor_id',
        'fecha_entrega',
        'estado'
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}
