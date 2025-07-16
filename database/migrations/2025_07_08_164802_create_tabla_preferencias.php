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
        Schema::create('preferencias', function (Blueprint $table) {
            $table->id('id_preferencia');
            $table->foreignId(column: 'id_usuario')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferencias');
    }
};
