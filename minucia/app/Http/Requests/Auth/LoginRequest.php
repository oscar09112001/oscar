<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Autoriza esta petición (en este caso, siempre se permite).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación del formulario de login.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],     // El campo email debe existir y ser válido
            'password' => ['required', 'string'],           // El campo contraseña debe existir
        ];
    }

    /**
     * Intenta autenticar al usuario con los datos proporcionados.
     * Aplica también protección contra múltiples intentos fallidos (rate limiting).
     */
    public function authenticate(): void
    {
        // Verifica si no ha superado el límite de intentos fallidos
        $this->ensureIsNotRateLimited();

        // Intenta hacer login con las credenciales
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Si falla, suma un intento fallido
            RateLimiter::hit($this->throttleKey());

            // Lanza error de validación
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // Mensaje estándar: "Estas credenciales no coinciden..."
            ]);
        }

        // Si todo va bien, limpia los intentos fallidos
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Lanza excepción si se exceden los intentos permitidos (protección de fuerza bruta).
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return; // Si no ha pasado el límite, todo bien
        }

        // Lanza evento de bloqueo
        event(new Lockout($this));

        // Calcula el tiempo restante de espera
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Genera una clave única para limitar intentos por IP + correo.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
