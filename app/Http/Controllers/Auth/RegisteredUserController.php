<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pokemon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //Creamos un pokemon aleatorio para el nuevo usuario.

        $numEvolucionPkm = rand(1, 477); //Cogemos la linea evolutiva del pokemon
        $urlLineaEvolutiva= "https://pokeapi.co/api/v2/evolution-chain/".$numEvolucionPkm."";

        //Llamada a la api
        $response = file_get_contents($urlLineaEvolutiva);
        $data = json_decode($response, true);

        $nombrePokemon = $data['chain']['species']['name'];//Nombre del pokemon
        $pokeapi_url = "https://pokeapi.co/api/v2/pokemon/".$nombrePokemon."/"; //URL del pokemon

        $probshiny=rand(1,450);
        $variocolor=$probshiny==1 ? true : false; //Probabilidad de que el pokemon sea variocolor (1 de 450)

        $pokemon = Pokemon::create([
        'id_entrenador' => $user->id_usuario,
        'pokeapi_url'=>$pokeapi_url,
        'variocolor'=>$variocolor,
        'activo'=>true,
        'apodo'=>$nombrePokemon,
        'lineaEvolutiva'=>$urlLineaEvolutiva,
        'entrenador_original'=>$user->id_usuario,
        ]);

        Auth::login($user);

        return to_route('dashboard');
    }
}
