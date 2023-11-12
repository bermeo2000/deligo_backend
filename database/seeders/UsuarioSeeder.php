<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $usuarios = [
            [
                'Administrador',
                'Principal',
                'admin@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 1.jpeg',
                '0987456123',
                1,
                1,
                1,
                0,
            ],
            [
                'Gabriel',
                'Rivas',
                'gabriel.rivas@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 2.jpeg',
                '0987456123',
                1,
                2,
                1,
                0
            ],
            //Emprendedores para probar el video de la beta
            [
                'Josselyn',
                'Mendoza',
                'josselyn.mendoza@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 2.jpeg',
                '0987456123',
                1,
                2,
                1,
                0
            ],
            [
                'Luis',
                'Macías Bermeo',
                'bermeo2000@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 2.jpeg',
                '0987456123',
                1,
                2,
                1,
                0
            ],
            //USUARIOS
            [
                'Alex',
                'Arqui',
                'alex.arqui@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 3.jpeg',
                '0987456123',
                1,
                3,
                1,
                0
            ],
            [
                'Andres',
                'Zambrano',
                'andres.zambrano@deligo.com',
                '12345678',
                'Calceta',
                '1234567890',
                'public/images/seeders/users/user 4.jpeg',
                '0987456123',
                1,
                3,
                1,
                0
            ],
        ];

        foreach($usuarios as $u){
            DB::table('users')->insert([
                'nombre' => $u[0],
                'apellido' => $u[1],
                'email' => $u[2],
                'password' => Hash::make($u[3]),
                'ciudad' => $u[4],
                'cedula' => $u[5],
                'imagen' => $u[6],
                'telefono' => $u[7],
                'estado' => $u[8],
                'id_tipo_usuario' => $u[9],
                'id_codigo_pais' => $u[10],
                'is_categoria_selec' => $u[11],
            ]);
        }
    }
}
