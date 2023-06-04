<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'subtotal',
        'total',
        'fecha',
        'id_cliente',
        'id_tipo_pago',
        'id_estado_venta',
        'imagen_transferencia',
        'referencia',
        'lat',
        'lng',
        'codigo_comprobante',
        'estado',
    ];
}
