<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de perfil del usuario.
     * Esta vista permite editar el nombre, correo, etc.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail, // Verifica si el usuario requiere validar su correo
            'status' => session('status'), // Muestra estado de acciones previas (por ejemplo, "Perfil actualizado")
        ]);
    }

    /**
     * Actualizar la información del perfil del usuario.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Llena el modelo User con los datos validados del formulario
        $request->user()->fill($request->validated());

        // Si el correo cambió, se marca como no verificado
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guarda los cambios en la base de datos
        $request->user()->save();

        // Redirige de nuevo al formulario de edición del perfil
        return Redirect::route('profile.edit');
    }

    /**
     * Eliminar la cuenta del usuario actual.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valida que el usuario haya ingresado correctamente su contraseña actual
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Obtiene el usuario actual y cierra la sesión
        $user = $request->user();
        Auth::logout();

        // Elimina al usuario de la base de datos
        $user->delete();

        // Invalida la sesión actual y genera un nuevo token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige a la página principal del sitio
        return Redirect::to('/');
    }
}
