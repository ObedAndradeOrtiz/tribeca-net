<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'ocupacions';

    protected $fillable = [
        'tratamiento_id',
        'user_id',
        'tipo',
        'nombre',
        'parentesco',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];
}