<?php

use App\Http\Controllers\Api\PokemonController;
//use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriaController;
//use App\Http\Controllers\Api\PreferenciaController;
use App\Http\Controllers\Api\TiendaController;
use App\Http\Controllers\Api\DiariaController;
use App\Http\Controllers\Api\TareaController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/usuarios', [UserController::class, 'index']); //Todos los usuarios
Route::get('/usuarios/{id}', [UserController::class, 'show']); //Usuario por id

Route::get('/pokemon/{id}',[PokemonController::class,'show']); //Pokemon por id

Route::get('/categorias',[CategoriaController::class,'index']); //Todas las categorias
Route::get('/categoria/{id}',[CategoriaController::class,'show']); //Categoria por id

Route::get('/stock',[TiendaController::class,'index']);//Todos los objetos de la tienda
Route::get('/objeto/{id}',[TiendaController::class,'show']); //ObjetoPorID

Route::get('/tarea/{id}',[TareaController::class,'show']);//Obtener tarea por Id

