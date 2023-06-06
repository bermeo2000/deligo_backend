<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoAdvertenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tipo_advertencias = [
            'Grave',
            'Media',
            'Leve'
        ];

        foreach($tipo_advertencias as $tp){
            DB::table('tipo_advertencias')->insert([
            'descripcion' => $tp,
            'estado' => 1,
        ]);
        }
    }
}
