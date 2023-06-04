<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingsProductos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_producto',
        'id_toppings',
        'estado',
    ];
}
