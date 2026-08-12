<?php

namespace App\Http\Livewire\Tratamientos;

use Livewire\Component;
use App\Models\Areas;
use App\Models\Tratamiento;
use App\Models\TratamientoArea;

class CrearTratamiento extends Component
{
    public $nombre;
    public $descripcion;
    public $costo=0;
    public $crear = false;
    public $tipo = "matrimonial";
    public $capacidad=0;
    public $area="";
    public $puede_usar_piscina = false;
    public $puede_usar_salon = false;
    public function render()
    {
        return view('livewire.tratamientos.crear-tratamiento');
    }
    public function guardartodo()
    {
        $tratamiento = new Tratamiento;
        $tratamiento->nombre = $this->nombre;
        $tratamiento->descripcion = $this->descripcion;
        $tratamiento->estado = 'Activo';
        $tratamiento->costo = $this->costo;
        $tratamiento->tipo = $this->tipo;
        $tratamiento->capacidad=$this->capacidad;
        $tratamiento->sucursal=$this->area;
        $tratamiento->save();
        $this->sincronizarAccesoArea($tratamiento->id, 'PISCINA', $this->puede_usar_piscina);
        $this->sincronizarAccesoArea($tratamiento->id, 'SALON', $this->puede_usar_salon);
        $this->crear = false;
        $this->emit('alert', '¡Habitación creada satisfactoriamente!');
        $this->emitTo('tratamientos.lista-tratamientos', 'render');
    }

    protected function sincronizarAccesoArea($tratamientoId, $areaTexto, $activo): void
    {
        $areaId = Areas::where('estado', 'Activo')
            ->where('area', 'like', '%'.$areaTexto.'%')
            ->value('id');

        if (! $areaId && $areaTexto === 'SALON') {
            $areaId = Areas::where('estado', 'Activo')
                ->where('area', 'like', '%SALÓN%')
                ->value('id');
        }

        if (! $areaId) {
            return;
        }

        TratamientoArea::updateOrCreate(
            [
                'tratamiento_id' => $tratamientoId,
                'area_id' => $areaId,
            ],
            [
                'estado' => $activo ? 'Activo' : 'Inactivo',
            ]
        );
    }
}
