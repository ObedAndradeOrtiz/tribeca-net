<?php

namespace App\Http\Livewire\Tratamientos;

use App\Models\Tratamiento;
use Livewire\Component;

class VistaTratamiento extends Component
{
    public $tratamiento;
    public $openArea = false;
    public $editar = false;
    public $area;
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
        $this->openArea = false;
        $this->editar = false;
        $this->emit('alert', '¡Departamento editado satisfactoriamente!');
        $this->emitTo('tratamientos.lista-tratamientos', 'render');
    }
}
