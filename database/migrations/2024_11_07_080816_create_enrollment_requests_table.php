<?php
// database/migrations/xxxx_xx_xx_create_enrollment_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('enrollment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Alumno
            $table->foreignId('grupo_id')->constrained()->onDelete('cascade'); // Grupo
            $table->string('status')->default('pending'); // Estado de la solicitud
            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('enrollment_requests');
    }
}
