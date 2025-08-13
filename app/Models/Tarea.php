<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
            public $timestamps = false;

    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'titulo',
        'id_categoria',
        'experiencia',
        'recompensa',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function diarias()
    {
        return $this->hasMany(Diaria::class, 'id_tarea');
    }


}
