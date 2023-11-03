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
        $id_propietario = 3;
        $tiendas = [
            [
                'Animal Store',
                'public/images/seeders/1.png',
                'Calceta',
                1,
                'Calle 404',
                '0987456123',
                6,
                'animal_store_ig',
                'animal_store_fb',
                'animal_store_tiktok',
                1,
                1,
                1.25,
                20,
                'Tienda de venta de productos para tus mascotas',
            ],
            /* [
                'Farmacia Herbal',
                'farmacia_herbal.png',
                'Calceta',
                2,
                'Calle 201',
                '0987456123',
                6,
                'farmacia_herbal_ig',
                'farmacia_herbal_fb',
                'farmacia_herbal_tiktok',
                1,
                1,
                2.00,
                50,
                'Farmacia de productos químicos y naturales al alcance de tu mano',
            ],
            [
                'Ferretería Diamante',
                'ferreteria_diamante.png',
                'Calceta',
                1,
                'Calle 404',
                '0987456123',
                6,
                'ferreteria_diamante_ig',
                'ferreteria_diamante_fb',
                'ferreteria_diamante_tiktok',
                1,
                1,
                1.25,
                20,
                'Lugar donde puedes adquirir las herramientas e implementos que necesites para tus construcciones y reparaciones',
            ],
            [
                'Komida Bar',
                'komida_bar.png',
                'Calceta',
                2,
                'Calle 201',
                '0987456123',
                6,
                'komida_bar_ig',
                'komida_bar_fb',
                'komida_bar_tiktok',
                1,
                1,
                2.00,
                50,
                'Lo mejor en komida con k al alcance de tu mano',
            ],
            [
                'Solar Licorería',
                'licoreria_solar.png',
                'Calceta',
                1,
                'Calle 404',
                '0987456123',
                6,
                'solar_licor_ig',
                'solar_licor_fb',
                'solar_licor_tiktok',
                1,
                1,
                1.25,
                20,
                'El mejor trago para tus fiestas',
            ],
            [
                'Moda Store',
                'moda_store.png',
                'Calceta',
                2,
                'Calle 201',
                '0987456123',
                6,
                'moda_store_ig',
                'moda_store_fb',
                'moda_store_tiktok',
                1,
                1,
                2.00,
                50,
                'Tienda de ropa importada de las peores marcas chinas pero es ropa barata',
            ], */

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
