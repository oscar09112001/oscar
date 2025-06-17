<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'bloques'.
     */
    public function up(): void
    {
        Schema::create('bloques', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            // Relación con el proyecto al que pertenece el bloque
            $table->foreignId('proyecto_id')->constrained()->onDelete('cascade');

            $table->string('nombre'); // Nombre del bloque

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloques');
    }
};
