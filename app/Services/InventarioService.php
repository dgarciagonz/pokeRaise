<?php

namespace App\Services;

use App\Models\Inventario;
use App\Models\User;
use App\Models\Tienda;

class InventarioService
{
    public function agregarItems(Tienda $objeto, int $cant, User $user): void
    {

        //Coge el objeto del usuario
        $inventario = Inventario::where('id_objeto', $objeto->id)
        ->where('id_usuario', $user->id_usuario)
        ->first();

        //Si existe, añade la cantidad, si no existe, crea uno nuevo
        if ($inventario) {
            $inventario->cantidad+=$cant;
            $inventario->save();
        } else {
            Inventario::create([
                'id_usuario' => $user->id_usuario,
                'id_objeto' => $objeto->id,
                'cantidad' => $cant
            ]);
        }

    }
}