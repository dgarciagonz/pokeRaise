<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TiendaResource;


class InventarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        return [
            'id_usuario'=>$this->id_usuario,
            'objeto' => new TiendaResource($this->objeto),
            'cantidad'=>$this->cantidad,
        ];
    }
}