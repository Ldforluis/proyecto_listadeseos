<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeseoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Ruta principal
Route::get('/', [DeseoController::class, 'index'])->name('home');

// Rutas de autenticación (opción 1: manualmente)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro (correctamente asignadas a RegisterController)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Rutas CRUD para deseos
    Route::resource('deseos', DeseoController::class)->except(['index']);

    // Ruta adicional para marcar como cumplido
    Route::post('/deseos/{id}/cumplir', [DeseoController::class, 'cumplir'])->name('deseos.cumplir');
});

// Redirección alternativa
Route::get('/index', [DeseoController::class, 'index']);
