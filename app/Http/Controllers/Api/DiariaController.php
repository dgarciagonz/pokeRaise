<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DiariaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DiariaResource;
use App\Models\Diaria;
use App\Models\Pokemon;

class DiariaController extends Controller
{

    protected DiariaService $diariaService;

    public function __construct(DiariaService $diariaService)
    {
        $this->diariaService = $diariaService;
    }
    public function diarias()
    {
        $usuarioId = Auth::id();

        $tareasDiarias = Diaria::with('tarea.categoria')
            ->where('id_usuario', $usuarioId)
            ->get();

        return DiariaResource::collection($tareasDiarias);
    }

    public function completar_Diarias(Request $request,$id)
    {
        $user = $request->user();
        $diaria = Diaria::where('id', $id)->where('id_usuario', $user->id_usuario)->first();
        $pkmn = Pokemon::
            where('id_entrenador', $user->id_usuario)
            ->where('activo', true)
            ->first();

        $this->diariaService->completar($diaria, $pkmn, $user);

        return response()->json([
            'pokemon' => [
                'nivel' => $pkmn->nivel,
                'experiencia' => $pkmn->experiencia,
                'felicidad' => $pkmn->felicidad,
                'hambre' => $pkmn->hambre,
                'pokeapi_url' => $pkmn->pokeapi_url,
                'variocolor' => $pkmn->variocolor,
            ],
            'usuario' => [
                'monedas' => $user->monedas,
            ],
        ]);

    }
}