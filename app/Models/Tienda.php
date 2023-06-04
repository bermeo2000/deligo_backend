<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_propietario',
        'nombre_tienda',
        'ciudad',
        'id_categoria_tienda',
        'direccion',
        'celular',
        'id_codigo_pais',
        'instagram_user',
        'facebook_user',
        'tiktok_user',
        'lat',
        'lng',
        'estado',
        'is_delivery',
        'cargo_delivery',
        'tiempo_delivery_minutos',
        'puntuacion',
        'descrpcion',
    ];
}
