<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Diaria;
use App\Models\Tarea;
use App\Services\TareaService;

class GenerarTareasDiarias extends Command
{

    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tareas:generar-diarias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera tareas diarias para cada usuario según sus preferencias';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $tareaService = app(TareaService::class);

        //Obtener fecha de hoy
        $hoy = Carbon::now()->toDateString();

        //Eliminar tareas del día anterior
        Diaria::where('fecha', '!=', $hoy)->delete();

        //Obtener las preferencias de los usuarios
        $usuarios = User::with('preferencias')->get();

        foreach ($usuarios as $usuario) {
            //Buscar la categoria de las preferencias de los usuarios
            $tareaService->asignarTareas($usuario);
        }

        $this->info('Tareas diarias generadas correctamente.');
    }


}
