<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TareaCompletada extends Model
{
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'repeticiones',
    ];

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'id_tarea');
    }
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'id_usuario');
    }
}
