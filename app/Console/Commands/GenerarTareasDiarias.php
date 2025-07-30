<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Diaria;
use App\Models\Tarea;
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
        //Obtener fecha de hoy
        $hoy = Carbon::now()->toDateString();

        //Eliminar tareas del día anterior
        Diaria::where('fecha', $hoy)->delete();

        //Obtener las preferencias de los usuarios
        $usuarios = User::with('preferencias')->get();

        foreach ($usuarios as $usuario) {
            //Buscar la categoria de las preferencias de los usuarios
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

        $this->info('Tareas diarias generadas correctamente.');
    }

    
}
