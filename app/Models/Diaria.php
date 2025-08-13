<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diaria extends Model
{
            public $timestamps = false;

    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'id_usuario',
        'id_tarea',
        'fecha',
        'completado',
    ];


    //Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    //Relación con tarea
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }

}
