<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\CombateController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('entrenadores', EntrenadorController::class)->parameters([
    'entrenadores' => 'entrenador']);
// Ruta para mostrar Pokémon disponibles para capturar
Route::get('/pokemon/available', [PokemonController::class, 'available'])->name('pokemon.available');

// Ruta para capturar un Pokémon
Route::post('/pokemon/{pokemon}/capture', [PokemonController::class, 'capture'])->name('pokemon.capture');

// Ruta para liberar un Pokémon
Route::post('/pokemon/{pokemon}/release', [PokemonController::class, 'release'])->name('pokemon.release');

Route::resource('pokemon', PokemonController::class);

Route::get('/combates', function() {
    return redirect()->route('entrenadores.index')
                    ->with('info', 'La sección de Combates estará disponible próximamente');
})->name('combates.index');

// Rutas para autenticación (placeholder para compatibilidad con las vistas)
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::post('/logout', function() {
    return redirect()->route('home');
})->name('logout');
