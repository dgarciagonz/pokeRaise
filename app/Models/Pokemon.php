<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $primaryKey = 'id_pokemon';
    protected $fillable = [
        'pokeapiInfo',
        // nombre del pokemon, sprite, tipos, etc.
        'id_entrenador',
        'nivel',
        'experiencia',
        'hambre',
        'felicidad',
        'variocolor',
        'activo',
        'apodo',
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
