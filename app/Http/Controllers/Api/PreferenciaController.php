<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Preferencia;
use App\Http\Resources\UserResource;
use App\Http\Resources\PreferenciaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PreferenciaController extends Controller
{
    //buscar preferencias por id de usuario
    public function show($idUser)
    {
        $preferenciasUser = Preferencia::where('id_usuario', $idUser);
        return new PreferenciaResource($preferenciasUser);
    }

    //mostrar todas las preferencias
    public function index()
    {
        $preferencias = Preferencia::paginate(10);
        return PreferenciaResource::collection($preferencias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categorias' => 'required|array',
            'categorias.id' => 'integer|exists:categorias,id_categoria',

        ]);
        $userId = Auth::id();

        foreach ($request->categorias as $categoriaId) {
            Preferencia::create([
                'id_usuario' => $userId, 
                'id_categoria' => $categoriaId
                ]
            );
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
