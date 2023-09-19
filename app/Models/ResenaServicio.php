<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResenaServicio extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_producto_servicio',
        'id_user',
        'texto',
        'puntuacion_estrellas',
        'estado',
    ];
}
