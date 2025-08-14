<?php

namespace App\Services;

use App\Models\Inventario;
use App\Models\User;
use App\Models\Tienda;
use App\Models\Pokemon;

class TiendaService
{
    protected InventarioService $inventarioService;
    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

    public function comprarObjeto(Tienda $tienda, int $cantidad, User $user): void
    {
        $this->inventarioService->agregarItems($tienda, $cantidad, $user);
        $coste=$cantidad * $tienda->precio;
        $user->monedas -= $coste;
        $user->save();
        
    }
}