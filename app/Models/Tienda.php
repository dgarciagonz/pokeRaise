<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'objeto',
        'categoria',
        'precio',
        'descripcion',
        'imagen',
    ];

    public function inventario()
{
    return $this->hasMany(Inventario::class, 'id_objeto');
}
}
