<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reader_id',
        'fecha_prestamo',
        'fecha_devolucion',
    ];

    // Define the relationship with the Book model
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Define the relationship with the Reader model
    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }
}
