<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista del formulario de inicio de sesión.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Procesa la solicitud de autenticación (inicio de sesión).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Valida las credenciales y autentica al usuario
        $request->authenticate();

        // Regenera la sesión para mayor seguridad
        $request->session()->regenerate();

        // Redirige a la página que el usuario intentaba visitar, o al formulario
        return redirect()->intended('/formulario');
    }

    /**
     * Cierra la sesión del usuario autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Cierra sesión

        $request->session()->invalidate(); // Invalida la sesión
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect('/'); // Redirige al inicio
    }
}
