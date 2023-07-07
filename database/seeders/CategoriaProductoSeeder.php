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
                'CatProdT1',
                'CatProdT1.png',
                1,
                1
            ],
            [
                'CatProdT2',
                'CatProdT2.png',
                1,
                1
            ],
            [
                'CatProdT1',
                'CatProdT1.png',
                2,
                1
            ],
            [
                'CatProdT2',
                'CatProdT2.png',
                2,
                1
            ]

        ];

        foreach ($cat_productos as $c) {
            DB::table('categorias_productos')->insert([
                'descripcion' => $c[0],
                'imagen' => $c[1],
                'id_tienda' => $c[2],
                'estado' => $c[3],
            ]);
        }
    }
}
