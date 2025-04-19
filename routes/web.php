<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeseoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Ruta principal (pública)
Route::get('/', [DeseoController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Ruta index para deseos (DENTRO del grupo auth)
    Route::get('/deseos', [DeseoController::class, 'index'])->name('deseos.index');

    // Rutas CRUD para deseos (usando resource sin excluir index)
    Route::resource('deseos', DeseoController::class)->except(['index']);
    /* Esto genera:
    GET         /deseos/create  → deseo.create
    POST        /deseos         → deseo.store
    GET         /deseos/{deseo} → deseo.show
    GET         /deseos/{deseo}/edit → deseo.edit
    PUT/PATCH   /deseos/{deseo} → deseo.update
    DELETE      /deseos/{deseo} → deseo.destroy
    */

    // Ruta adicional para marcar como cumplido
    Route::post('/deseos/{deseo}/cumplir', [DeseoController::class, 'cumplir'])->name('deseos.cumplir');
});

// Redirección alternativa (pública)
Route::get('/index', [DeseoController::class, 'index']);
