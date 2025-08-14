<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use Illuminate\Http\Request;
use App\Http\Resources\TiendaResource;
use App\Services\TiendaService;


class TiendaController extends Controller
{
    protected TiendaService $tiendaService;

    public function __construct(TiendaService $tiendaService)
    {
        $this->tiendaService = $tiendaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indexObjetos = Tienda::orderBy("precio", "asc")->orderBy("objeto", "asc")->paginate(15);
        return TiendaResource::collection($indexObjetos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function comprar(Request $request, $id)
    {
        //Busca el objeto
        $objeto = Tienda::findOrFail($id);

        if (!$objeto) {
            return response()->json(['mensaje' => 'No se encontró el objeto.'], 404);
        }
        //Valida si cantidad es un numero
        $request->validate([
            'cantidad' => 'required|numeric',
        ]);

        $cantidad = $request->cantidad;
        $user = $request->user();

        //Llama a la funcion comprarObjeto con los valores requeridos
        $this->tiendaService->comprarObjeto($objeto, $cantidad, $user);

        //Devuelve la cantidad de monedas que le quedan al usuario tras la compra
        return response()->json([
            'usuario' => [
                'monedas' => $user->monedas,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tienda $tienda)
    {
        $objeto = Tienda::findOrFail($tienda);

        if (!$objeto) {
            return response()->json(['mensaje' => 'No se encontró el Objeto.'], 404);
        }

        return new TiendaResource($objeto);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tienda $tienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tienda $tienda)
    {
        //
    }
}
