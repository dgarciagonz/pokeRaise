<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id_pokemon,
        'id_entrenador'=> $this->id_entrenador,
        'pokeapi_url' =>$this->pokeapi_url,
        'nivel' =>$this->nivel,
        'experiencia' =>$this->experiencia,
        'hambre' =>$this->hambre,
        'felicidad'=> $this->felicidad,
        'variocolor'=>$this->variocolor,
        'activo'=>$this->activo,
        'apodo'=>$this->apodo,
        'lineaEvolutiva'=> $this->lineaEvolutiva,
        'entrenador_original'=> $this->entrenador_original,
        ];
    }
}
