<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre',
        'telefono',
        'tipo_mantenimiento_id'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoMantenimiento::class, 'tipo_mantenimiento_id');
    }
}