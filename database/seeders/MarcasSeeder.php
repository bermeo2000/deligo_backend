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
                1
            ],
            [
                'MarcaT2',
                2
            ],
            [
                'MarcaT3',
                3
            ],
            [
                'MarcaT4',
                4
            ],
            [
                'MarcaT5',
                5
            ],
            [
                'MarcaT6',
                6
            ],

        ];

        foreach ($marcas as $m) {
            DB::table('marcas')->insert([
                'descripcion' => $m[0],
                'id_tienda' => $m[1],
                'estado' => 1,
            ]);
        }

    }
}
