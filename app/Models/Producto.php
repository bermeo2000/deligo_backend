<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'precio',
        'peso',
        'imagen',
        'estado',
        'id_categoria_productos',
        'id_marca',
        'id_tipo_peso',
        'id_tienda',
        'descripcion',
        'is_topping',
        'puntuacion'
    ];
}
