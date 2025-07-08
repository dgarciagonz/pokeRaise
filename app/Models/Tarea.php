<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'experiencia',
        'recompensa',
    ];

    public function categoriaTarea()
{
    return $this->belongsTo(Categoria::class, 'id_categoria');
}
}
