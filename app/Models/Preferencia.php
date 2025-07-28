<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{
    
    protected $primaryKey = 'id_preferencia';
        public $timestamps = false;

     protected $fillable = [
        'id_usuario',
        'id_categoria',
    ];

    public function prefiereCategoria()
    {
        return $this->belongsToMany(Categoria::class, 'id_categoria');
    }
    public function prefiereUsuarios()
    {
        return $this->belongsToMany(User::class, 'id_usuario');
    }
}
