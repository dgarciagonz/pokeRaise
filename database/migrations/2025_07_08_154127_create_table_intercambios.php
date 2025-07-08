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
        Schema::create('intercambios', function (Blueprint $table) {
            $table->id('id_intercambio');
            $table->foreignId('id_origen')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_ofrecido')->constrained('pokemons', 'id_pokemon')->onDelete('cascade');
            $table->foreignId('id_destino')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_deseado')->constrained('pokemons', 'id_pokemon')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])
                ->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_intercambios');
    }
};
