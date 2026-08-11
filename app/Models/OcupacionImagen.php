<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcupacionImagen extends Model
{
    protected $table = 'ocupacion_imagenes';

    protected $fillable = [
        'ocupacion_id',
        'ruta'
    ];
}