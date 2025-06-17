<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'registros'.
     */
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            // Relación con el usuario que creó el registro
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relación con la pieza registrada
            $table->foreignId('pieza_id')->constrained()->onDelete('cascade');

            // Peso real de la pieza
            $table->float('peso_real');

            // created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};

