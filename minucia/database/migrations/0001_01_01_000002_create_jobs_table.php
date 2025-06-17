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
        // Tabla que Laravel usa para almacenar trabajos pendientes
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // ID del trabajo
            $table->string('queue')->index(); // Nombre de la cola
            $table->longText('payload'); // Datos del trabajo (serializados)
            $table->unsignedTinyInteger('attempts'); // Reintentos hechos
            $table->unsignedInteger('reserved_at')->nullable(); // Tiempo en que fue reservado por un worker
            $table->unsignedInteger('available_at'); // Cuándo estará disponible para ejecutarse
            $table->unsignedInteger('created_at'); // Cuándo fue creado
        });

        // Tabla usada cuando se trabaja con lotes de trabajos
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID del lote
            $table->string('name'); // Nombre del batch
            $table->integer('total_jobs'); // Total de trabajos en el lote
            $table->integer('pending_jobs'); // Cuántos aún están pendientes
            $table->integer('failed_jobs'); // Cuántos fallaron
            $table->longText('failed_job_ids'); // IDs de los trabajos fallidos
            $table->mediumText('options')->nullable(); // Configuraciones adicionales
            $table->integer('cancelled_at')->nullable(); // Si se canceló, cuándo
            $table->integer('created_at'); // Fecha de creación
            $table->integer('finished_at')->nullable(); // Fecha de finalización
        });

        // Tabla donde Laravel guarda los trabajos que fallaron definitivamente
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // ID del fallo
            $table->string('uuid')->unique(); // UUID único del job
            $table->text('connection'); // Tipo de conexión (base de datos, Redis, etc.)
            $table->text('queue'); // Cola del trabajo
            $table->longText('payload'); // Datos originales del job
            $table->longText('exception'); // Error que ocurrió
            $table->timestamp('failed_at')->useCurrent(); // Cuándo falló
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
