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
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_propietario')->constrained('users');
            $table->string('nombre_tienda');
            $table->string('ciudad');
            $table->foreignId('id_categoria_tienda')->constrained('categoria_tiendas');
            $table->string('direccion')->nullable(); //no siempre tienen

            $table->string('celular');
            $table->foreignId('id_codigo_pais')->constrained('codigo_pais');

            $table->string('instagram_user')->nullable();
            $table->string('facebook_user')->nullable();
            $table->string('tiktok_user')->nullable();

            //geolocalizacion
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->boolean('estado');
            
            //en caso de tener vainas con delivery
            $table->boolean('is_delivery');
            $table->decimal('cargo_delivery')->nullable()->default(0);
            $table->integer('tiempo_delivery_min')->nullable()->default(0);

            //puntuacion de la tienda basada en las reseñas
            $table->float('puntuacion')->default(0);

            //descripcion
            $table->string('descripcion')->nullable();



            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiendas');
    }
};
