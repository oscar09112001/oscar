<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Define cómo se deben generar usuarios de prueba con la factory.
 */
class UserFactory extends Factory
{
    // Variable estática para guardar la contraseña generada
    protected static ?string $password;

    /**
     * Define los valores por defecto de un usuario.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Genera un nombre aleatorio
            'email' => fake()->unique()->safeEmail(), // Email único y seguro
            'email_verified_at' => now(), // El email ya está verificado
            'password' => static::$password ??= Hash::make('password'), // Contraseña encriptada
            'remember_token' => Str::random(10), // Token para "recordarme"
        ];
    }

    /**
     * Indica que el usuario no tiene su email verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // No está verificado
        ]);
    }
}
