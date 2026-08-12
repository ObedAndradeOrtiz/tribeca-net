<?php

namespace App\Http\Livewire\Tratamientos;

use App\Models\Areas;
use App\Models\Tratamiento;
use App\Models\TratamientoArea;
use Livewire\Component;

class VistaTratamiento extends Component
{
    public $tratamiento;
    public $openArea = false;
    public $editar = false;
    public $area;
    public $puede_usar_piscina = false;
    public $puede_usar_salon = false;
    protected $rules = [
        'tratamiento.nombre' => 'required',
        'tratamiento.descripcion' => 'required',
        'tratamiento.costo' => 'required',
        'tratamiento.estado' => 'required',
        'tratamiento.capacidad' => 'required',
        'tratamiento.TIPO' => 'required',
        'tratamiento.sucursal' => 'required'
    ];
    public function mount($idtratamiento)
    {
        $this->tratamiento = Tratamiento::find($idtratamiento);
        $this->cargarPermisosAreas();
    }
    public function render()
    {
        return view('livewire.tratamientos.vista-tratamiento');
    }
    public function inactivarTratamiento()
    {
        $this->tratamiento->delete();
        $this->emit('alert', '¡Departamento eliminado satisfactoriamente!');
        $this->emitTo('tratamientos.lista-tratamientos', 'render');
    }
    public function activarTratamiento()
    {
        $this->tratamiento->estado = "Activo";
        $this->tratamiento->save();
        $this->emit('alert', '¡Ativado satisfactoriamente!');
        $this->emitTo('tratamientos.lista-tratamientos', 'render');
    }
    public function guardartodo()
    {
        $this->tratamiento->save();
        $this->sincronizarAccesoArea($this->tratamiento->id, 'PISCINA', $this->puede_usar_piscina);
        $this->sincronizarAccesoArea($this->tratamiento->id, 'SALON', $this->puede_usar_salon);
        $this->openArea = false;
        $this->editar = false;
        $this->emit('alert', '¡Departamento editado satisfactoriamente!');
        $this->emitTo('tratamientos.lista-tratamientos', 'render');
    }

    protected function cargarPermisosAreas(): void
    {
        if (! $this->tratamiento) {
            return;
        }

        $this->puede_usar_piscina = $this->tieneAreaActiva('PISCINA');
        $this->puede_usar_salon = $this->tieneAreaActiva('SALON') || $this->tieneAreaActiva('SALÓN');
    }

    protected function tieneAreaActiva($areaTexto): bool
    {
        $areaId = Areas::where('estado', 'Activo')
            ->where('area', 'like', '%'.$areaTexto.'%')
            ->value('id');

        if (! $areaId) {
            return false;
        }

        return TratamientoArea::where('tratamiento_id', $this->tratamiento->id)
            ->where('area_id', $areaId)
            ->where('estado', 'Activo')
            ->exists();
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
