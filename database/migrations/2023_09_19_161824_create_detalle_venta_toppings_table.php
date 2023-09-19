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
        Schema::create('detalle_venta_toppings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_detalle_venta')->constrained('detalle_ventas');
            $table->foreignId('id_topping')->constrained('toppings');
            $table->integer('cantidad')->nullable();
            $table->decimal('total_toppings')->nullable();
            $table->boolean('estado');
            //$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_venta_toppings');
    }
};
