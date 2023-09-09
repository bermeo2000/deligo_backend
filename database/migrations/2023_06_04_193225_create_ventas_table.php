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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

           // $table->decimal('subtotal');
            $table->decimal('total');

            $table->date('fecha');

            $table->foreignId('id_cliente')->constrained('users');
            $table->foreignId('id_tipo_pago')->constrained('tipo_pagos');
           //$table->foreignId('id_estado_venta')->constrained('estado_ventas');

            $table->string('imagen_transferencia')->nullable();
           // $table->string('referencia')->nullable();
            //geolocalizacion
            //$table->string('lat')->nullable();
            //$table->string('lng')->nullable();

            $table->string('codigo_comprobante');

            $table->boolean('estado');
            
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
