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
        Schema::create('resena_tiendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tienda')->constrained('tiendas');
            $table->foreignId('id_user')->constrained('users');
            $table->string('texto', 500);
            $table->integer('puntuacion_estrellas');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resena_tiendas');
    }
};
