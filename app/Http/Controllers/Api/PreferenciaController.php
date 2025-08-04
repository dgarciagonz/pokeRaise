<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Preferencia;
use App\Models\Tarea;
use App\Models\Diaria;
use App\Http\Resources\UserResource;
use App\Http\Resources\PreferenciaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PreferenciaController extends Controller
{
    //buscar preferencias por id de usuario
    public function preferenciasUsuario()
    {

        $idUser = auth()->id();
        if (!$idUser) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

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

        $userId = Auth::id();
        $usuario = User::where('id_usuario', $userId)->first();
        //Preferencias actuales del usuario (array de id_categoria)
        $preferenciasActuales = Preferencia::where('id_usuario', $userId)
            ->pluck('id_categoria')
            ->toArray();

        $categoriasNuevas = $request->categorias; //array de ids enviados por el usuario

        //Añadir nuevas preferencias que no existían
        foreach ($categoriasNuevas as $categoriaId) {
            if (!in_array($categoriaId, $preferenciasActuales)) {
                Preferencia::create([
                    'id_usuario' => $userId,
                    'id_categoria' => $categoriaId,
                ]);
            }
        }

        //Eliminar preferencias que ya no están en la lista enviada
        Preferencia::where('id_usuario', $userId)
            ->whereNotIn('id_categoria', $categoriasNuevas)
            ->delete();

        if (empty($preferenciasActuales)) {
            $hoy = Carbon::now()->toDateString();

            $categorias = $usuario->preferencias->pluck('id_categoria');

            //Coge 6 tareas aleatorias de las preferencias del usuario
            $tareasAleatorias = Tarea::whereIn('id_categoria', $categorias)
                ->inRandomOrder()
                ->limit(6)
                ->get();


            foreach ($tareasAleatorias as $tarea) {
                Diaria::create([
                    'id_usuario' => $usuario->id_usuario,
                    'id_tarea' => $tarea->id_tarea,
                    'fecha' => $hoy,
                    'completado' => false,
                ]);
            }
        }

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
