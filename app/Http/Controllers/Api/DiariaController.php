<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DiariaResource;
use App\Models\Diaria;

class DiariaController extends Controller
{
    public function index()
    {
        $usuarioId = Auth::id();
        $hoy = now()->toDateString();

        $tareasDiarias = Diaria::with('tarea')
            ->where('id_usuario', $usuarioId)
            ->where('fecha', $hoy)
            ->get();

        return DiariaResource::collection($tareasDiarias);
    }
}