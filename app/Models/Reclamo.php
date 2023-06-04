<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_venta',
        'texto',
        'imagen',
        'estado',
    ];
}
