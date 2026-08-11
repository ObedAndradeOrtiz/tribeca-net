<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TratamientoArea extends Model
{
    protected $table = 'tratamiento_areas';

    protected $fillable = [
        'tratamiento_id',
        'area_id',
        'estado'
    ];
}