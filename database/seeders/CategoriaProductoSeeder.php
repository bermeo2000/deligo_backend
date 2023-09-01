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
                1
            ],
            [
                'CatProdT2',
                2
            ],
            [
                'CatProdT1',
                3
            ],
            [
                'CatProdT2',
                4
            ],
            [
                'CatProdT1',
                5
            ],
            [
                'CatProdT2',
                6
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
