<?php

namespace App\Services;

use App\Models\Preferencia;
use App\Models\User;
use App\Models\Tarea;


class TareaService
{
    protected DiariaService $diariaService;
    public function __construct(DiariaService $diariaService)
    {
        $this->diariaService = $diariaService;
    }

    public function asignarTareas(User $usuario): void
    {
        //Buscar la categoria de las preferencias de los usuarios
        $categorias = $usuario->preferencias->pluck('id_categoria');


        //Coge 6 tareas aleatorias de las preferencias del usuario
        $tareas = Tarea::whereIn('id_categoria', $categorias)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $this->diariaService->crearDiarias($tareas,$usuario);



    }

}