<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoServicio extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_emp_servicio',
        'id_categoria_productos',
        'nombre',
        'imagen',
        'descripcion',
        'duracion',
        'precio',
        'puntuacion',
        'estado',
    ];
}
