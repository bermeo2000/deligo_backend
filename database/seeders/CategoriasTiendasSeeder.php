<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoriasTiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoria_tiendas = [
            'Calzado',
            'Ropa',
            'Accesorios',
            'Comida y bebidas',
            'Electrónica',
            'Otros'

       ];

        foreach($categoria_tiendas as $ct){
            DB::table('categoria_tiendas')->insert([
            'nombre' => $ct,
            'imagen' => $ct.'.png',
            'estado' => 1,
        ]);
        }
    }
}
