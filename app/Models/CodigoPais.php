<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoPais extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'name',
        'iso2',
        'iso3',
        'phone_code',
        'estado'
    ];
}
