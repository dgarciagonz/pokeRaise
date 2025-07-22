<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
            public $timestamps = false;

    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'titulo',
        'categoria',
        'experiencia',
        'recompensa',
    ];

    public function categoriaTarea()
{
    return $this->belongsTo(Categoria::class, 'id_categoria');
}
}
