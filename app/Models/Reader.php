<?php

// app/Models/Reader.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
