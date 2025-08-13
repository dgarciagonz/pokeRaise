<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Preferencia;
use App\Models\Tarea;
use App\Models\Diaria;
use App\Services\PreferenciaService;
use App\Http\Resources\PreferenciaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PreferenciaController extends Controller
{

    protected PreferenciaService $preferenciaService;

    public function __construct(PreferenciaService $preferenciaService)
    {
        $this->preferenciaService = $preferenciaService;
    }
    //buscar preferencias por id de usuario
    public function preferenciasUsuario()
    {
        $idUser = auth()->id();
        $preferenciasUser = Preferencia::where('id_usuario', $idUser)->get();
        return PreferenciaResource::collection($preferenciasUser);
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
            'categorias.*' => 'integer|exists:categorias,id_categoria',
        ]);

        $idsCategorias = $request->input('categorias');

        $userId = Auth::id();
        $usuario = User::where('id_usuario', $userId)->first();
        $this->preferenciaService->actualizar($usuario, $idsCategorias);

        
        //Preferencias actuales del usuario (array de id_categoria)
        

        return response()->json(['message' => 'Preferencias actualizadas correctamente']);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'categorias' => 'required|array',
            'categorias.id' => 'integer|exists:categorias,id_categoria',

        ]);
        $userId = Auth::id();




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
