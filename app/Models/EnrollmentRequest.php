<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'grupo_id',
        'status',
    ];

  public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming 'alumno_id' points to the 'users' table
    }

    // Define the 'grupo' relationship
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}