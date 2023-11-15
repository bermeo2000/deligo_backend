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
        $tiendas = [
            [
                'Bar Sol',
                'public/images/seeders/tienda/bar_sol.png',
                'Calceta',
                2,
                'Calle 404',
                '0987456123',
                1,
                'animal_store_ig',
                'animal_store_fb',
                'animal_store_tiktok',
                1,
                1,
                1.25,
                20,
                'Los mejores platos de comida en el mejor bar.',
                3,
                '16:00:00',
                '20:00:00',
                '15',
            ],
            [
                'Ropa M',
                'public/images/seeders/tienda/tienda_ropa_m.png',
                'Calceta',
                1,
                'Calle 405',
                '0987456123',
                1,
                'animal_store_ig',
                'animal_store_fb',
                'animal_store_tiktok',
                1,
                1,
                1.25,
                20,
                'La mejor ropa de la ciudad en el mismo lugar.',
                3,
                '09:00:00',
                '20:00:00',
                '15',
            ],
            [
                'Belleza K',
                'public/images/seeders/tienda/servicio_belleza_k.png',
                'Calceta',
                7,
                'Calle 25',
                '0987456123',
                1,
                'animal_store_ig',
                'animal_store_fb',
                'animal_store_tiktok',
                1,
                1,
                1.25,
                20,
                'Los mejores servicios de belleza para todas las personas en el mismo lugar.',
                3,
                '09:00:00',
                '20:00:00',
                '15',
            ],




        ];
        
        foreach ($tiendas as $t) {
           DB::table('tiendas')->insert([
            
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
            'id_propietario' => $t[15],
            'hora_apertura' => $t[16],
            'hora_cierre' => $t[17],
            'llegada_previa' => $t[18],
           ]);
        }
    }
}
