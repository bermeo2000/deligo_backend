<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use League\Csv\Reader;

class CodigoPaisSeeder extends Seeder
{
    public function run(): void
    {
          $csvFile = storage_path('app/CodigoPaises.csv'); // para obtener la ruta completa al archivo CSV.
          $csvReader = Reader::createFromPath($csvFile, 'r'); //crear la instancia de Reader, league/csv para leer y manipular los datos del archivo CSV
          $csvReader->setHeaderOffset(0); // Si el archivo CSV tiene encabezados de columna en la primera fila

             $rowCount = $csvReader->count(); // Cuenta el número de filas
             $columnCount = count($csvReader->getHeader()); // Cuenta el número de columnas (asumiendo que el archivo tiene encabezados de columna)
             echo "Número de filas: " . $rowCount . "\n";
             echo "Número de columnas: " . $columnCount . "\n";

     foreach ($csvReader as $row) {  //Dentro del bucle foreach, puedes acceder a los valores de cada columna utilizando los encabezados como índices en el array $row.
       $nombre = $row['nombre'];
       $name = $row['name'];
       $iso2 = $row['iso2'];
       $iso3 = $row['iso3'];
       $phoneCode = $row['phone_code'];
       $estado = $row['estado'];

     // Realiza las operaciones necesarias con los datos obtenidos del archivo CSV
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
}
