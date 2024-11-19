<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('grupo_id');
            $table->float('calificacion');
            $table->timestamps();
        
            // Define foreign keys
            $table->foreign('alumno_id')->references('id')->on('users')->onDelete('cascade'); // Cambiar 'alumnos' a 'users'
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
        });        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
