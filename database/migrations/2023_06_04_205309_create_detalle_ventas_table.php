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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio');
            $table->integer('cantidad');
            $table->string('anotes')->nullable();
            $table->foreignId('id_producto')->nullable()->constrained('productos');
            $table->foreignId('id_promocion_producto')->nullable()->constrained('promocion_productos');

            $table->foreignId('id_venta')->constrained('ventas');

            $table->boolean('estado');

            /* 
            array_toppings_selec: este array guardaria los ids de los topping seleccionados 
            para ese producto en ese venta, es una solución que creemos que es viable 
            porque ya antes la hemos aplicado y funcionaba, solo que a nivel de codigo 
            es un poco mas compleja, pero aun asi manejable
            */

            $table->string('array_toppings_selec')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
