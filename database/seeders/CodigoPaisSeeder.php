<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;

class CodigoPaisSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = storage_path('app/CodigoPaises.csv'); 
        $csvReader = Reader::createFromPath($csvFile, 'r'); 
        $csvReader->setHeaderOffset(0); 

        $rowCount = $csvReader->count(); 
        $columnCount = count($csvReader->getHeader()); 
        echo "Número de filas: " . $rowCount . "\n";
        echo "Número de columnas: " . $columnCount . "\n";

        foreach ($csvReader as $row) { 
            $nombre = $row['nombre'];
            $name = $row['name'];
            $iso2 = $row['iso2'];
            $iso3 = $row['iso3'];
            $phoneCode = $row['phone_code'];
            $estado = $row['estado'];


            DB::table('codigo_pais')->insert([
                'nombre' => $nombre,
                'name' => $name,
                'iso2' => $iso2,
                'iso3' => $iso3,
                'phone_code' => $phoneCode,
                'estado' => $estado,
            ]);
        }

        DB::table('codigo_pais')->insert([
            'nombre' => $nombre,
            'name' => $name,
            'iso2' => $iso2,
            'iso3' => $iso3,
            'phone_code' => $phoneCode,
            'estado' => $estado,
        ]);
    }
}