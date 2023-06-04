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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio');
            $table->decimal('peso')->nullable();
            $table->string('imagen');
            $table->boolean('estado');

            $table->foreignId('id_categoria_tienda')->constrained('categorias_productos');
            $table->foreignId('id_marca')->constrained('marcas');
            $table->foreignId('id_tipo_peso')->constrained('tipo_pesos');
            $table->foreignId('id_tienda')->constrained('tiendas');

            $table->string('descripcion')->nullable();

            /* 
                is_topping: en el caso de que sea verdadero indica que el producto 
                lleva topping y se genera registro mediante una tabla intermedia
            */
            $table->boolean('is_topping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
