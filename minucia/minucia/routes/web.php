<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Muestra Welcome.vue a usuarios no autenticados
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guest');

// Redirige al formulario si está autenticado
Route::get('/dashboard', function () {
    return redirect()->route('formulario.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario.index');
    Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluye rutas de login/register
require __DIR__.'/auth.php';
