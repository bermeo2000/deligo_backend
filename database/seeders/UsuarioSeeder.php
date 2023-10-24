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
                'admin.png',
                '0987456123',
                1,
                1,
                6,
                0,
            ],
            [
                'Emprendedor',
                'Inicial',
                'emprendedor@emp.com',
                '12345678',
                'Calceta',
                '1234567890',
                'emprendedor.png',
                '0987456123',
                1,
                2,
                6,
                0
            ],
            //Emprendedores para probar el video de la beta
            [
                'Josselyn',
                'Mendoza',
                'joss_men@emp.com',
                '12345678',
                'Calceta',
                '1234567890',
                'Mujer1',
                '0987456123',
                1,
                2,
                6,
                0
            ],
            [
                'Luis',
                'Macías Bermeo',
                'bermeo2000@emp.com',
                '12345678',
                'Calceta',
                '1234567890',
                'Hombre1.jpg',
                '0987456123',
                1,
                2,
                6,
                0
            ],
            //USUARIOS
            [
                'Usuario',
                'Inicial',
                'usuario@user.com',
                '12345678',
                'Calceta',
                '1234567890',
                'usuario.png',
                '0987456123',
                1,
                3,
                6,
                0
            ],
            [
                'Andres',
                'Zambrano',
                'zambrasda17@gmail.com',
                '12345678',
                'Calceta',
                '1234567890',
                'Hombre2.jpg',
                '0987456123',
                1,
                3,
                6,
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
