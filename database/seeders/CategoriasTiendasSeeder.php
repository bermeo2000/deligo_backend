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
                'https://minecraftaso.com/wp-content/uploads/2023/08/ropa.png',
                1
            ],
            [
                'Comida',
                'https://minecraftaso.com/wp-content/uploads/2023/08/comida.png',
                1
            ],
            
            [
                'Electrónica',
                'https://minecraftaso.com/wp-content/uploads/2023/08/tecnologia.png',
                1
            ],
            [
                'Calzado',
                'https://minecraftaso.com/wp-content/uploads/2023/08/calzado.png',
                1
            ],
            [
                'Accesorios',
                'https://minecraftaso.com/wp-content/uploads/2023/08/Accesorios.png',
                1
            ],
            [
                'Mascotas',
                'https://minecraftaso.com/wp-content/uploads/2023/08/mascotas.png',
                1
            ],
            [
                'Hogar',
                'https://minecraftaso.com/wp-content/uploads/2023/08/Hogar.png',
                1
            ],
            [
                'Otros',
                'https://minecraftaso.com/wp-content/uploads/2023/08/Otros.png',
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
