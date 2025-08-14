<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Http\Resources\InventarioResource;
use App\Services\InventarioService;
class InventarioController extends Controller
{

    protected InventarioService $inventarioService;

    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

    //Muestra todos los inventarios
    public function index()
    {
        $indexInventarios = Inventario::paginate(15);
        return InventarioResource::collection($indexInventarios);
    }

    //Busca los objetos del inventario del usuario
    public function inventarioUser()
    {
        
        $userId = auth()->id();
        $inventario = Inventario::
            where('id_usuario', $userId)::paginate(15);

        return InventarioResource::collection($inventario);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {


    }


}