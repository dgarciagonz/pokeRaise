<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TareaResource;


class DiariaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        
        return [
            'id' => $this->id,
            'id_usuario' => $this->id_usuario,
            'tarea'=> new TareaResource($this->tarea),
            'fecha' =>$this->fecha,
            'completado' => $this->completado,
        ];
    }
}