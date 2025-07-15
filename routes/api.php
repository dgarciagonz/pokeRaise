<?php

use App\Http\Controllers\Api\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/usuarios', [UserController::class, 'index']); //Todos los usuarios
Route::get('/usuarios/{id}', [UserController::class, 'show']); //Usuario por id

Route::get('/pokemon/{id}',[PokemonController::class,'show']); //Pokemon por id
Route::get('/pokemons/activos', [PokemonController::class, 'activo'])->middleware('auth:sanctum');

