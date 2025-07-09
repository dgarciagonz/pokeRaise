<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';
    protected $primaryKey = 'id_pokemon';
    protected $fillable = [
        'id_entrenador',
        'pokeapi_url',
        // nombre del pokemon, sprite, tipos, etc.
        'nivel',
        'experiencia',
        'hambre',
        'felicidad',
        'variocolor',
        'activo',
        'apodo',
        'lineaEvolutiva',
        'entrenador_original',
         
    ];

    public function Entrenador()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_entrenador');
    }
    public function EntrenadorOriginal()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'entrenador_original');
    }
}
