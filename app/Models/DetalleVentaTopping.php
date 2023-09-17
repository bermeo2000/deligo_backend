<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleVenta;
use App\Models\Toppings;

class DetalleVentaTopping extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = [
       'id_detalle_venta',
       'id_topping',
       'cantidad',
       'total_toppings',
       'estado'
    ];

    public function detalle()
    {
        return $this->belongsTo(DetalleVenta::class, 'id_detalle_venta');
    }

    public function topping()
    {
        return $this->belongsTo(Toppings::class, 'id_topping');
    }
}
