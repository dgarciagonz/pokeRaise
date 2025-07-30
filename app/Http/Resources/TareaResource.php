<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_tarea' => $this->id_tarea,
            'titulo' => $this->titulo,
            'categoria' => $this->id_categoria,
            'experiencia' => $this->experiencia,
            'recompensa'=>$this->recompensa,
      
        ];
    }
}
