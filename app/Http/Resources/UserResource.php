<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id_usuario,
            'username' => $this->username,
            'email' => $this->email,
            'rol' => $this->rol,
            'monedas' => $this->monedas,

            // relaciones
            'pokemons' => PokemonResource::collection($this->whenLoaded('pokemons')),
            //'tareas_acabadas' => TareaResource::collection($this->whenLoaded('tareasAcabadas')),
            //'tareas_pendientes' => TareaResource::collection($this->whenLoaded('tareasPendientes')),
        ];
    }
}
