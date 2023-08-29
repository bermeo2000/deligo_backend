<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasProductos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'descripcion',
       /*  'imagen', */
        'id_tienda',
        'estado',
    ];
}
