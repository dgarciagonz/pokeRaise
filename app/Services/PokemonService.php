<?php

namespace App\Services;

use App\Models\Pokemon;
use App\Models\User;

class PokemonService
{
public function levelUp(Pokemon $pkmn, int $experienciaPkm):void{
    $experienciaActual = $pkmn->experiencia + $experienciaPkm;
        if ($experienciaActual >= 100) {
            //Si tiene 100 o mas de experiencia sube de nivel
            $pkmn->nivel += 1;
            $pkmn->experiencia = $experienciaActual - 100;

            //Comprobamos si cumple los requisitos de evolución
            $response = file_get_contents($pkmn->lineaEvolutiva);
            $data = json_decode($response, true);

            $evolucion1 = $data['chain']['evolves_to'][0] ?? null;
            $evolucion2 = $evolucion1['evolves_to'][0] ?? null;

            //Verificamos si hay evolución 1 y el nivel mínimo
            if (
                $evolucion1 &&
                isset($evolucion1['evolution_details'][0]['min_level']) &&
                $pkmn->nivel >= $evolucion1['evolution_details'][0]['min_level']
            ) {
                $pkmn->pokeapi_url = "https://pokeapi.co/api/v2/pokemon/" . $evolucion1['species']['name'] . "/";

                //Verificamos si hay evolución 2 y el nivel mínimo
                if (
                    $evolucion2 &&
                    isset($evolucion2['evolution_details'][0]['min_level']) &&
                    $pkmn->nivel >= $evolucion2['evolution_details'][0]['min_level']
                ) {
                    $pkmn->pokeapi_url = "https://pokeapi.co/api/v2/pokemon/" . $evolucion2['species']['name'] . "/";
                }
            }

        } else {
            $pkmn->experiencia = $experienciaActual;
        }

        $pkmn->felicidad += ($experienciaPkm / 10);
        $pkmn->save();
}

}