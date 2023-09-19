<?php

use Illuminate\Console\View\Components\Mutators\EnsurePunctuation;
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
        Schema::create('producto_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_emp_servicio')->constrained('tiendas');
            $table->foreignId('id_categoria_productos')->constrained('categorias_productos');
            $table->string('nombre');
            $table->string('imagen');
            $table->string('descripcion', 500)->nullable();
            $table->integer('duracion'); // duración del servicio brindado
            $table->decimal('precio');
            $table->float('puntuacion')->default(0);
            $table->boolean('estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_servicios');
    }
};
