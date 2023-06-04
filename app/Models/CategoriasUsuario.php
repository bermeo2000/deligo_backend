<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasUsuario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_usuario',
        'id_categoria_tienda',
        'estado',
    ];
}
