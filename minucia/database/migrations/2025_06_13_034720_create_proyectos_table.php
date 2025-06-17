<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'proyectos'.
     */
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            $table->timestamps(); // created_at y updated_at

            $table->string('nombre'); // Nombre del proyecto
        });
    }

    /**
     * Elimina la tabla si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
