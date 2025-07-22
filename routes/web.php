<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('preferencias', function () {
    return Inertia::render('Preferencias');
})->middleware(['auth', 'verified'])->name('preferencias');


Route::get('/pokemons/activos', [\App\Http\Controllers\Api\PokemonController::class, 'activo'])->middleware('auth');


Route::post('/preferencias', [\App\Http\Controllers\Api\PreferenciaController::class, 'store'])->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
