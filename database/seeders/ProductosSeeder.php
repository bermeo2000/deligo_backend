<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos_t = [
            [
                //tienda 1
                [
                    //nombre
                    'Arenero Gatos',
                    //precio
                    50.00,
                    //imagen
                    'arenerogatos.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Arenero para gatos jajaja',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Cama Perros',
                    //precio
                    50.00,
                    //imagen
                    'camaperro.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Cama comoda para gatos',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Casa Gatos',
                    //precio
                    75.00,
                    //imagen
                    'casagatos.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Mansión para gatos jajaja',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Jueguete Gatos',
                    //precio
                    50.00,
                    //imagen
                    'juguetegato.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Bola para gatos jajaja',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Juguete Perro',
                    //precio
                    50.00,
                    //imagen
                    'jugueteperro.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Juguete para perros jajaja',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Transporte animal',
                    //precio
                    50.00,
                    //imagen
                    'transportemascota.png',
                    //id_categoria_productos
                    1,
                    //id_marca
                    1,
                    //id_tienda 
                    1,
                    //descripcion
                    'Transporte para tus mascotas',
                    //is_topping
                    0, 
                ],
            ],
            [
                //tienda 2
                [
                    //nombre
                    'Aspirina ',
                    //precio
                    10.00,
                    //imagen
                    'aspirina.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'Para el dolor de cabeza (?)',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Bonfiest Plus',
                    //precio
                    3.00,
                    //imagen
                    'bonfiest.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'Para el chuchaqui',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Buscapina',
                    //precio
                    5.00,
                    //imagen
                    'buscapina.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'Para el malestar del estómago',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Duo Ultrasensible',
                    //precio
                    7.00,
                    //imagen
                    'condonesduo.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'La mejor protección',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Vaporal Pastillas',
                    //precio
                    1.00,
                    //imagen
                    'vaporal.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'Para la gripe y tos',
                    //is_topping
                    0, 
                ],
                [
                    //nombre
                    'Mascarillas',
                    //precio
                    2.00,
                    //imagen
                    'facemask.png',
                    //id_categoria_productos
                    2,
                    //id_marca
                    2,
                    //id_tienda 
                    2,
                    //descripcion
                    'Para el covid que ya no hay',
                    //is_topping
                    0, 
                ],
            ],
            [
                //tienda 3
            ],
            [
                //tienda 4
            ],
            [
                //tienda 5
            ],
            [
                //tienda 6
            ],
        ];

        foreach ($productos_t as $productos) {
            foreach($productos as $p){
                DB::table('productos')->insert([
                    'nombre' => $p[0],
                    'precio' => $p[1],
                    'imagen' => $p[2],
                    'id_categoria_productos' => $p[3],
                    'id_marca' => $p[4],
                    'id_tienda' => $p[5],
                    'descripcion' => $p[6],
                    'is_topping' => $p[7],
                    'estado' => 1,
                ]);
            }
        }
    }
}
