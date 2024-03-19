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
            [
                'Ropa',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/ropa.png',
                1
            ],
            [
                'Comida',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/comida.png',
                1
            ],
            
            [
                'Electrónica',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/tecnologia.png',
                1
            ],
            [
                'Calzado',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/calzado.png',
                1
            ],
            [
                'Accesorios',
                'https://minecraftaso.com/wp-content/uploads/2023/08/Accesorios.png',
                1
            ],
            [
                'Mascotas',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/mascotas.png',
                1
            ],
            [
                'Servicios',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/mueble.png',
                1
            ],
            [
                'Otros',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/category/salud.png',
                1
            ]

       ];

        foreach($categoria_tiendas as $ct){
            DB::table('categoria_tiendas')->insert([
            'nombre' => $ct[0],
            'imagen' => $ct[1],
            'estado' => $ct[2],
        ]);
        }
    }
}
