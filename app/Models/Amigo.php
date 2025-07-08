<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    public $incrementing = false;

    public function amigos()
    {
        return $this->belongsToMany(User::class, 'id_usuario');
    }

    public function amigosDe()
    {
        return $this->belongsToMany(User::class,  'id_amigo');
    }


    public $timestamps = false;
}
