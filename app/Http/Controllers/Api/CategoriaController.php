<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Resources\CategoriaResource;

class CategoriaController extends Controller
{
    //buscar categorias por id
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'No se encontró la categoria.'], 404);
        }

        return new CategoriaResource($categoria);
    }

    public function index()
    {
        $indexCategorias = Categoria::paginate(15);
        return CategoriaResource::collection($indexCategorias);
    }  

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    public function destroy(Categoria $categoria)
    {
        //
    }
}