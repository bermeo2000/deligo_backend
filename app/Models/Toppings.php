<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleVenta;
use App\Models\DetalleVentaTopping;
class Toppings extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'descripcion',
        'imagen',
        'precio',
        'id_tienda',
        'estado',
    ];

    public function detalleVentaTopping()
    {
        return $this->hasMany(DetalleVentaTopping::class);
    }

    public function detalles()
    {
        return $this->hasManyThrough(DetalleVenta::class, DetalleVentaTopping::class, 'id_topping', 'id_detalle_venta');
    }
}
