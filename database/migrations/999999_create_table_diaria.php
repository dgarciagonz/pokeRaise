<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'id_usuario')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_tarea')->constrained('tareas', 'id_tarea')->onDelete('cascade');
            $table->dateTime('fecha');
            $table->boolean('completado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
