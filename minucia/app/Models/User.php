<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Habilita la factory para crear usuarios de prueba y las notificaciones (email, etc.)
    use HasFactory, Notifiable;

    /**
     * Atributos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atributos que se ocultan cuando el modelo se convierte a array o JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser casteados (convertidos automáticamente).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convierte a objeto fecha
            'password' => 'hashed', // Aplica hash automáticamente al guardar
        ];
    }
}
