<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//metodo para que funcione Inertia y direccione a la vista correcta que es welcome.vue
Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest'); // Solo si NO está logueado

//metodo para usuarios autenticados puedan a estas rutas
Route::middleware('auth')->group(function () {
    Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario.index');
    Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');
    Route::get('/reportes', [FormularioController::class, 'reportes'])->name('formulario.reportes');
});



require __DIR__.'/auth.php';
