<?php

namespace App\Services;

use App\Models\Preferencia;
use App\Models\User;
use Carbon\Carbon;


class PreferenciaService
{
    protected TareaService $tareaService;
    public function __construct(TareaService $tareaService)
    {
        $this->tareaService = $tareaService;
    }
    public function actualizar(User $usuario,  array $request): void
    {
        $preferenciasActuales = Preferencia::where('id_usuario', $usuario->id_usuario)
            ->pluck('id_categoria')
            ->toArray();

        $categoriasNuevas = $request; //array de ids enviados por el usuario

        //Añadir nuevas preferencias que no existían
        foreach ($categoriasNuevas as $categoriaId) {
            if (!in_array($categoriaId, $preferenciasActuales)) {
                Preferencia::create([
                    'id_usuario' => $usuario->id_usuario,
                    'id_categoria' => $categoriaId,
                ]);
            }
        }

        //Eliminar preferencias que ya no están en la lista enviada
        Preferencia::where('id_usuario', $usuario->id_usuario)
            ->whereNotIn('id_categoria', $categoriasNuevas)
            ->delete();

        if (empty($preferenciasActuales)) {
            $hoy = Carbon::now()->toDateString();

            $this->tareaService->asignarTareas($usuario);
            //Coge 6 tareas aleatorias de las preferencias del usuario
            
        }
    }
}