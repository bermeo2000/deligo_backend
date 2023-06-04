<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmonestacionTienda extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_tienda',
        'id_tipo_advertencia',
        'motivo',
        'fecha_inicio',
        'fecha_fin',
        'multa_monetaria',
        'estado',
    ];
}
