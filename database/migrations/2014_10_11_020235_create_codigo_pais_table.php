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
        Schema::create('codigo_pais', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('name');
            $table->string('iso2');
            $table->string('iso3');
            $table->string('phone_code');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_pais');
    }
};
