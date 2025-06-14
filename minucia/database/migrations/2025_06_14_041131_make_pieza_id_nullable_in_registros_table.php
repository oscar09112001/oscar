<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registros', function (Blueprint $table) {
        $table->dropForeign(['pieza_id']);
        $table->unsignedBigInteger('pieza_id')->nullable()->change();
        $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
        $table->dropForeign(['pieza_id']);
        $table->unsignedBigInteger('pieza_id')->nullable(false)->change();
        $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
        });
    }
};
