<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\DeseoController;

Route::resource('deseos', DeseoController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DeseoController::class, 'index']);
Route::post('/deseos/{id}/cumplir', [DeseoController::class, 'cumplir'])->name('deseos.cumplir');
Route::post('/deseos', [DeseoController::class, 'store'])->name('deseos.store');
Route::get('/deseos/create', [DeseoController::class, 'create'])->name('deseos.create');
Route::get('/deseos/{id}', [DeseoController::class, 'show'])->name('deseos.show');
Route::get('/deseos/{id}/edit', [DeseoController::class, 'edit'])->name('deseos.edit');
Route::put('/deseos/{id}', [DeseoController::class, 'update'])->name('deseos.update');
Route::delete('/deseos/{id}', [DeseoController::class, 'destroy'])->name('deseos.destroy');


Route::resource('deseos', DeseoController::class);
Route::post('deseos/{id}/cumplir', [DeseoController::class, 'cumplir'])->name('deseos.cumplir');
