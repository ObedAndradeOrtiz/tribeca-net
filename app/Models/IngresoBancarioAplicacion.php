<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoBancarioAplicacion extends Model
{
    protected $table = 'ingresos_bancarios_aplicaciones';

    protected $fillable = [
        'ingreso_bancario_id',
        'expensa_id',
        'tipo_aplicacion',
        'codigo_departamento',
        'departamento_nombre',
        'fecha_inicio_pago',
        'anio_pago',
        'mes_pago',
        'monto',
        'pago_id',
        'estado',
        'estado_pago',
        'fecha_aplicacion',
        'observacion',
        'iduser',
        'nameuser',
    ];
}