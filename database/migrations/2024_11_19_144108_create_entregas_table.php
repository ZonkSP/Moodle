<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained()->onDelete('cascade'); // Relación con la tabla tareas
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla usuarios
            $table->string('archivo')->nullable(); // Nombre del archivo subido por el alumno
            $table->text('retroalimentacion')->nullable(); // Retroalimentación del profesor
            $table->integer('calificacion')->nullable(); // Calificación asignada por el profesor
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('entregas');
    }
}
