<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expensa extends Model
{
    protected $table = 'expensas';

    protected $fillable = [
        'tratamiento_id',
        'departamento_nombre',
        'anio',
        'mes',
        'fecha_mes',
        'monto_expensa',
        'monto_pagado',
        'saldo',
        'estado',
        'tipo_estado',
        'observacion',
    ];
}