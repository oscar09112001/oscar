<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'piezas'.
     */
    public function up(): void
    {
        Schema::create('piezas', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            // Relación con el bloque al que pertenece la pieza
            $table->foreignId('bloque_id')->constrained()->onDelete('cascade');

            $table->string('nombre'); // Nombre de la pieza

            // Peso teórico de la pieza (por defecto 0.00)
            $table->decimal('peso_teorico', 8, 2)->default(0);

            // Estado actual de la pieza (por defecto: Pendiente)
            $table->string('estado')->default('Pendiente');

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};
