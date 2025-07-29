<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use Illuminate\Http\Request;
use App\Http\Resources\TiendaResource;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indexObjetos = Tienda::orderBy("precio", "asc")->orderBy("objeto","asc")->paginate(15);
        return TiendaResource::collection($indexObjetos);
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
