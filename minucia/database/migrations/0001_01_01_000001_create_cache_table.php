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
        // Tabla que Laravel usa internamente para almacenar datos en caché
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();    // Clave única del ítem en caché
            $table->mediumText('value');         // Valor serializado del ítem
            $table->integer('expiration');       // Timestamp de vencimiento
        });

        // Tabla para manejar bloqueos de caché, útil en tareas simultáneas
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();    // Clave del bloqueo
            $table->string('owner');             // Identificador del que tiene el bloqueo
            $table->integer('expiration');       // Tiempo en que expira el bloqueo
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina las tablas de caché si existen
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
