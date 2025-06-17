<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Modifica la columna 'pieza_id' para que sea opcional (nullable).
     */
    public function up(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            // Elimina la relación actual con la clave foránea
            $table->dropForeign(['pieza_id']);

            // Cambia la columna para permitir valores nulos
            $table->unsignedBigInteger('pieza_id')->nullable()->change();

            // Vuelve a agregar la relación con onDelete('cascade')
            $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
        });
    }

    /**
     * Revierte el cambio: hace que 'pieza_id' vuelva a ser obligatoria.
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            // Elimina nuevamente la clave foránea
            $table->dropForeign(['pieza_id']);

            // Cambia la columna para que ya no acepte null
            $table->unsignedBigInteger('pieza_id')->nullable(false)->change();

            // Agrega la clave foránea de nuevo con onDelete('cascade')
            $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
        });
    }
};
