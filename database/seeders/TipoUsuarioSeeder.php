<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $tipos_usuarios = ['Administrador', 'Emprendedor', 'Usuario'];

        foreach($tipos_usuarios as $tp){
            DB::table('tipo_usuarios')->insert([
            'tipo' => $tp,
            'estado' => 1,
        ]);
        }

        
    }
}
