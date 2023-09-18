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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('ciudad'); // no es nullable para poder mostrar mejor en la pagina principal
            $table->string('cedula')->nullable(); //cedula, dni o pasaporte
            $table->string('imagen')->nullable();
            $table->string('telefono')->nullable();
            $table->boolean('estado');
            $table->boolean('is_plus')->default(0);
            $table->foreignId('id_tipo_usuario')->constrained('tipo_usuarios');
            $table->foreignId('id_codigo_pais')->nullable()->constrained('codigo_pais');
            $table->string('codigo_referido')->nullable();
            $table->string('codigo_referido_usuario')->nullable();
            $table->integer('ventas')->nullable();

            //PuntosGO
            $table->integer('puntos_go')->default(0);

            /* 
                por defecto si seleccionó o no irá 0 pero
                se cambiará cuando sea necesario, por eso tener en cuenta que 
                al ingresar un nuevo usuario desde el controlador no poner este campo
                o en su defecto hacer pruebas a ver que pasa 
            */
            $table->boolean('is_categoria_selec')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
