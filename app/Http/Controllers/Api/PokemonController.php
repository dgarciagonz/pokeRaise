<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PokemonResource;

class PokemonController extends Controller
{
    //buscar pokemon por id
    public function show($id)
    {
        $pkmn = Pokemon::findOrFail($id);

        if (!$pkmn) {
            return response()->json(['mensaje' => 'No se encontró el Pokémon.'], 404);
        }

        return new PokemonResource($pkmn);
    }


   public function activo()
{
    $userId = auth()->id();
    $pkmn = Pokemon::where('id_entrenador', $userId)->where('activo', true)->first();

    if (!$pkmn) {
        return response()->json(['mensaje' => 'No se encontró Pokémon activo en backend.'], 404);
    }

    return new PokemonResource($pkmn);
}

}
