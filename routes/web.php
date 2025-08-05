<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\PokemonController;
use App\Http\Controllers\Api\PreferenciaController;
use App\Http\Controllers\Api\DiariaController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('preferencias', function () {
    return Inertia::render('Preferencias');
})->middleware(['auth', 'verified'])->name('preferencias');

Route::get('tienda', function () {
    return Inertia::render('Tienda');
})->middleware(['auth', 'verified'])->name('tienda');

Route::get('/usuarioActivo',[UserController::class,'activo'])->middleware('auth');

Route::get('/pokemons/activos', [PokemonController::class, 'activo'])->middleware('auth');

Route::get('/preferenciasUser', [PreferenciaController::class, 'preferenciasUsuario'])->middleware('auth');
Route::post('/preferencias', [PreferenciaController::class, 'store'])->middleware('auth');
Route::put('/cambiarPreferencias', [PreferenciaController::class, 'update'])->middleware('auth');

Route::get( '/diarias', [DiariaController::class,'diarias']);
Route::patch('/diaria/{id}', [DiariaController::class, 'completar_Diarias']);


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
