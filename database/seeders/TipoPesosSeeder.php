<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoPesosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tipos_pesos = [
            'gr',
            'kg',
            'lb',
            'lt',
            'ml',
            'gal',
            'cc',
        ];

        foreach($tipos_pesos as $tp){
            DB::table('tipo_pesos')->insert([
            'descripcion' => $tp,
            'estado' => 1,
        ]);
        }

        
    }
}
