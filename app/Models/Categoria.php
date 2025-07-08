<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $primaryKey = 'id_categoria';
    protected $fillable = [
        'nombre',¡
    ];


    public function tareasConCategoria()
{
    return $this->hasMany(Tarea::class, 'categoria');
}
}
