<?php

// Importo todos los controladores necesarios para manejar autenticación y seguridad
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Grupo de rutas accesibles solo si el usuario NO está autenticado
Route::middleware('guest')->group(function () {

    // Ruta para mostrar el formulario de registro
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

    // Ruta para procesar el registro de un nuevo usuario
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Ruta para mostrar el formulario de login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    // Ruta para procesar el inicio de sesión
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Ruta para mostrar el formulario de recuperación de contraseña
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

    // Ruta para enviar el correo de recuperación
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Ruta para mostrar el formulario donde se establece la nueva contraseña (después de hacer clic en el correo)
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

    // Ruta para guardar la nueva contraseña en la base de datos
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Grupo de rutas protegidas por middleware 'auth' (requiere estar logueado)
Route::middleware('auth')->group(function () {

    // Vista donde se le pide al usuario verificar su email (si aún no lo ha hecho)
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');

    // Ruta que se accede al hacer clic en el enlace de verificación enviado por correo
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1']) // Protege con firma y límite de intentos
        ->name('verification.verify');

    // Ruta para reenviar el correo de verificación de email
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1') // Límite: 6 intentos por minuto
        ->name('verification.send');

    // Ruta para mostrar un formulario de confirmación de contraseña (para operaciones sensibles)
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');

    // Ruta para confirmar la contraseña del usuario actual
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Ruta para cambiar la contraseña desde el perfil
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Ruta para cerrar sesión (logout)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});