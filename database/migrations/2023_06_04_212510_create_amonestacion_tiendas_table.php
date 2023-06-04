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
        Schema::create('amonestacion_tiendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tienda')->constrained('tiendas');
            $table->foreignId('id_tipo_advertencia')->constrained('tipo_advertencias');
            $table->string('motivo', 500);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('multa_monetaria')->nullable();
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amonestacion_tiendas');
    }
};
