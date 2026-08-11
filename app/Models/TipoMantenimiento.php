<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMantenimiento extends Model
{
    protected $table = 'tipos_mantenimientos';

    protected $fillable = [
        'nombre',
        'frecuencia_dias'
    ];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'tipo_mantenimiento_id');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'tipo_mantenimiento_id');
    }
}