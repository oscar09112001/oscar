<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        // Tabla de usuarios del sistema
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Email único
            $table->timestamp('email_verified_at')->nullable(); // Marca si el correo está verificado
            $table->string('password'); // Contraseña
            $table->rememberToken(); // Token para "recordarme"
            $table->timestamps(); // created_at y updated_at
        });

        // Tabla para recuperar contraseñas (tokens de recuperación)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email del usuario
            $table->string('token'); // Token para el reset
            $table->timestamp('created_at')->nullable(); // Cuándo se generó
        });

        // Tabla para guardar sesiones de usuarios 
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión
            $table->foreignId('user_id')->nullable()->index(); // Relación con usuario
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario
            $table->text('user_agent')->nullable(); // Navegador y sistema del usuario
            $table->longText('payload'); // Datos de la sesión
            $table->integer('last_activity')->index(); // Última actividad (timestamp)
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina las tablas si existen
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
