<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = [
        'tipo_mantenimiento_id',
        'proveedor_id',
        'fecha',
        'fecha_siguiente',
        'monto',
        'descripcion',
        'comprobante',
        'user_id'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoMantenimiento::class, 'tipo_mantenimiento_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}