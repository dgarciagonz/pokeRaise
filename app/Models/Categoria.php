<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
        public $timestamps = false;

    protected $primaryKey = 'id_categoria';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];


    public function tareasConCategoria()
{
    return $this->hasMany(Tarea::class, 'categoria');
}
}
