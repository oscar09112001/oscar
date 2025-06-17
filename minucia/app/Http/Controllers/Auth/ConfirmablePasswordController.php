<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmablePasswordController extends Controller
{
    /**
     * Muestra la vista donde el usuario debe confirmar su contraseña
     * (por ejemplo, antes de eliminar su cuenta o cambiar algo importante).
     */
    public function show(): Response
    {
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Valida la contraseña ingresada para confirmar identidad.
     */
    public function store(Request $request): RedirectResponse
    {
        // Verifica si la contraseña ingresada coincide con la del usuario actual
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Si no coincide, lanza error de validación
            throw ValidationException::withMessages([
                'password' => __('auth.password'), // mensaje: "La contraseña es incorrecta"
            ]);
        }

        // Guarda en sesión la hora en que se confirmó la contraseña
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirige al dashboard u otra ruta segura
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
