<?php

namespace App\Http\Livewire\Tipos;

use App\Models\tipohabitacion;
use Livewire\Component;

class CrearTipo extends Component
{
    public $tipo;
    public $crear = false;
    public function render()
    {
        return view('livewire.tipos.crear-tipo');
    }
    public function guardartodo()
    {

        $tipo = new tipohabitacion;
        $tipo->estado='Activo';
        $tipo->tipo = $this->tipo;
        $tipo->save();
        $this->emitTo('tipos.lista-tipo', 'render');
        $this->emit('alert', '¡Tipo creado satisfactoriamente!');
    }
}
