<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = [
        'precio',
        'cantidad',
        'id_producto',
        'id_promocion_producto',
        'id_venta',
        'estado',
        'array_toppings_selec',
    ];
}
