<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * Laravel will automatically assume the table name is "materias"
     * based on the model name. If your table name is different, specify it here:
     *
     * @var string
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clave',
        'nombre',
        'creditos',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'creditos' => 'integer',
    ];

    /**
     * Additional relationships or attributes can be defined here if needed.
     */
}
