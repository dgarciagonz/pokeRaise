<?php

namespace App\Services;

use App\Models\Pokemon;
use App\Models\User;
use App\Models\Diaria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DiariaService
{
    protected PokemonService $pokemonService;
    protected UserService $userService;

    public function __construct(PokemonService $pokemonService, UserService $userService)
    {
        $this->pokemonService = $pokemonService;
        $this->userService = $userService;
    }


    public function completar(Diaria $diaria, Pokemon $pkmn, User $usuario): void
    {
        $diaria->completado = true;
        $diaria->save();

        $experienciaPkm = $diaria->tarea->experiencia;
        $monedas = $diaria->tarea->recompensa;

        $this->pokemonService->levelUp($pkmn, $experienciaPkm);
        $this->userService->incrementar($usuario,$monedas);

        //Añade las monedas a la cuenta del usuario
        $usuario->monedas += $monedas;
        $usuario->save();
    }

    public function crearDiarias(Collection $tareas, User $usuario){
        $hoy = Carbon::now()->toDateString();

        foreach ($tareas as $tarea) {
            Diaria::create([
                'id_usuario' => $usuario->id_usuario,
                'id_tarea' => $tarea->id_tarea,
                'fecha' => $hoy,
                'completado' => false,
            ]);
        }
    }

}
