<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cat_productos  = [
            [
                'Comida',
                1
            ],
            [
                'Bebidas',
                1
            ],
            [
                'Piqueos',
                1
            ],
            [
                'Mujer',
                2
            ],
            [
                'Hombre',
                2
            ],
            [
                'Niños/as',
                2
            ],
            [
                'Cabello',
                3
            ],
            [
                'Uñas',
                3
            ],

        ];

        foreach ($cat_productos as $c) {
            DB::table('categorias_productos')->insert([
                'descripcion' => $c[0],
                'id_tienda' => $c[1],
                'estado' => 1,
            ]);
        }
    }
}
