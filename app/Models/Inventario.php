<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_usuario',
        'id_objeto',
        'cantidad',
       
    ];

    public function ObjetoTienda()
{
    return $this->belongsToMany(Tienda::class, 'id');
}
public function InventarioUsuario()
    {
        return $this->belongsToMany(Inventario::class, 'id_usuario');
    }
}
