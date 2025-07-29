<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'username',
        'email',
        'password',
        'rol', 
        'monedas',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function amigos()
    {
        return $this->hasMany(Amigo::class, 'id_usuario');
    }

    public function amigosDe()
    {
        return $this->hasMany(Amigo::class,  'id_amigo');
    }


    public function pokemons()
    {
        return $this->hasMany(Pokemon::class, 'id_entrenador');
    }

    public function tareasAcabadas()
    {
        return $this->hasMany(Tarea::class, 'id_usuario');
    }

    public function tareasPendientes()
    {
        return $this->hasMany(Tarea::class, 'id_usuario');
    }
public function inventario()
    {
        return $this->hasMany(Inventario::class, 'id_usuario');
    }
}
