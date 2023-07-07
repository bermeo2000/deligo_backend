<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $marcas = [
            [
                'MarcaT1',
                'marcat1.png',
                1,
                1
            ],
            [
                'MarcaT2',
                'marcat2.png',
                1,
                1
            ],
            [
                'MarcaT1',
                'marcat1.png',
                2,
                1
            ],
            [
                'MarcaT2',
                'marcat2.png',
                2,
                1
            ]

        ];

        foreach ($marcas as $m) {
            DB::table('marcas')->insert([
                'descripcion' => $m[0],
                'imagen' => $m[1],
                'id_tienda' => $m[2],
                'estado' => $m[3],
            ]);
        }

    }
}
