<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id('id_pokemon');
            $table->foreignId('id_entrenador')
                ->constrained('users', 'id_usuario')
                ->onDelete('cascade');
            $table->string('pokeapi_url', 200);
            $table->integer('nivel')->default(1);
            $table->integer('experiencia')->default(0);
            $table->integer('hambre')->default(100);
            $table->integer('felicidad')->default(0);
            $table->boolean('variocolor')->default(false);
            $table->boolean('activo')->default(true);
            $table->string('apodo', 50);
            $table->string('lineaEvolutiva', 200)->nullable();
            $table->foreignId('entrenador_original')->nullable()
                ->constrained('users', 'id_usuario')
                ->onDelete('set null');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};
