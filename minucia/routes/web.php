<?php

// Importación de controladores necesarios
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Esta ruta carga la vista Welcome.vue cuando el usuario entra al sitio.
// Solo se muestra si el usuario NO ha iniciado sesión (guest).
Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest');

// Grupo de rutas que solo pueden usar los usuarios autenticados
Route::middleware('auth')->group(function () {

    // Esta ruta muestra el formulario principal para registrar una pieza.
    Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario.index');

    // Esta ruta guarda en la base de datos la información del formulario (pieza registrada).
    Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');

    // Esta ruta muestra los registros que ya se han guardado (reportes).
    Route::get('/reportes', [FormularioController::class, 'reportes'])->name('formulario.reportes');
});

// Aquí incluyo todas las rutas relacionadas con el sistema de autenticación:
// login, logout, registro, etc., que vienen preconfiguradas por Laravel Breeze.
require __DIR__.'/auth.php';