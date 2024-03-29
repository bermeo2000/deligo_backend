<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'descripcion',
        'id_tienda',
        'estado',
    ];
}
