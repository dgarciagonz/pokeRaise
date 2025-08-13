<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiendaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->id,
            'objeto' => $this->objeto,
            'categoria' => $this->categoria,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'imagen' => $this->imagen
       
        ];
    }
}
