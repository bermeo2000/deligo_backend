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
                'Alimentos y bebidas',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/foods_and_drinks.png',
                1
            ],
            [
                'Ropa, calzado y accesorios',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/clothes_and_shoes.png',
                1
            ],
            
            [
                'Equipos eléctronicos',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/computers.png',
                1
            ],
            [
                'Belleza y cuidado personal',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/selfcare.png',
                1
            ],
            [
                'Servicios',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/services.png',
                1
            ],
            [
                'Otros',
                'https://deligobucketbcb.s3.amazonaws.com/public/assets/categories_new/others.png',
                1
            ],
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
