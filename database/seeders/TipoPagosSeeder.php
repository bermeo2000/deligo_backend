<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tipo_pagos = [
            'Efectivo',
            'Transferencia',
            'Tarjeta'
        ];

        foreach($tipo_pagos as $tp){
            DB::table('tipo_pagos')->insert([
            'descripcion' => $tp,
            'estado' => 1,
        ]);
        }

    }
}
