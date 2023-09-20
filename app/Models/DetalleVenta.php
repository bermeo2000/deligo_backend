<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleVentaTopping;
use App\Models\Toppings;

class DetalleVenta extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = [
        'anotes',
        'precio',
        'cantidad',
        'id_producto',
        'id_tienda',
        'id_promocion_producto',
        'id_venta',
        'estado',
        'id_producto_servicio',
        'fecha_cita',
        'hora_cita',
    ];

    public function detalleVentaToppings()
    {
        return $this->hasMany(DetalleVentaTopping::class,'id_detalle_venta');
    }
    
    public function toppings()
    {
        return $this->hasManyThrough(Toppings::class, DetalleVentaTopping::class,'id_detalle_venta', 'id');
        
    }
}
