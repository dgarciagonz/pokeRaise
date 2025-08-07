<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DiariaResource;
use App\Models\Diaria;
use App\Models\User;
use App\Models\Pokemon;

class DiariaController extends Controller
{
    public function diarias()
    {
        $usuarioId = Auth::id();

        $tareasDiarias = Diaria::with('tarea')
            ->where('id_usuario', $usuarioId)
            ->get();

        return DiariaResource::collection($tareasDiarias);
    }

    public function completar_Diarias($id)
    {
        $userId = auth()->id();

        $tareaDiaria = Diaria::where('id',$id)->where('id_usuario',$userId)->first();
        $tareaDiaria->completado = true;
        $tareaDiaria->save();

        $experienciaPkm = $tareaDiaria->tarea->experiencia;
        $monedas = $tareaDiaria->tarea->recompensa;


        $pkmn = Pokemon::
            where('id_entrenador', $userId)
            ->where('activo', true)
            ->first();

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

        $pkmn->felicidad+=($experienciaPkm/2);
        $pkmn->save();

        //Añade las monedas a la cuenta del usuario
        $user = User::findOrFail($userId );
        $user->monedas += $monedas;
        $user->save();

        return response()->json([
            'pokemon' => [
                'nivel' => $pkmn->nivel,
                'experiencia' => $pkmn->experiencia,
                'felicidad' => $pkmn->felicidad,
                'hambre' => $pkmn->hambre,
                'pokeapi_url' => $pkmn->pokeapi_url,
            ],
            'usuario' => [
                'monedas' => $user->monedas,
            ],
        ]);

    }
}