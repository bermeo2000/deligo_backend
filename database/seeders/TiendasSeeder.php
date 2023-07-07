<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $id_propietario = 2;
        $tiendas = [
            [
                'Tienda 1',
                'tienda1.jpg',
                'Calceta',
                1,
                'Calle 404',
                '0987456123',
                57,
                'tienda1_ig',
                'tienda1_fb',
                'tienda1_tiktok',
                1,
                1,
                1.25,
                20,
                'Tienda de calzado ecuatoriano para todos los públicos',
            ],
            [
                'Tienda 2',
                'tienda2.jpg',
                'Calceta',
                2,
                'Calle 201',
                '0987456123',
                57,
                'tienda2_ig',
                'tienda2_fb',
                'tienda2_tiktok',
                1,
                1,
                2.00,
                50,
                'Tienda de ropa importada de las peores marcas chinas pero es ropa barata',
            ]

        ];
        
        foreach ($tiendas as $t) {
           DB::table('tiendas')->insert([
            'id_propietario' => $id_propietario,
            'nombre_tienda' => $t[0],
            'imagen' => $t[1],
            'ciudad' => $t[2],
            'id_categoria_tienda' => $t[3],
            'direccion' => $t[4],
            'celular' => $t[5],
            'id_codigo_pais' => $t[6],
            'instagram_user' => $t[7],
            'facebook_user' => $t[8],
            'tiktok_user' => $t[9],
            'estado' => $t[10],
            'is_delivery' => $t[11],
            'cargo_delivery' => $t[12],
            'tiempo_delivery_min' => $t[13],
            'descripcion' => $t[14],
           ]);
        }
    }
}
