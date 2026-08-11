<?php

namespace App\Http\Livewire\Marketing;

use App\Models\campana;
use Livewire\Component;

class CrearCampana extends Component
{
    public $name;
    public $comentario;
    public $crearcuenta = false;
    public function render()
    {
        return view('livewire.marketing.crear-campana');
    }
    public function guardartodo()
    {
        $nuevo = new campana;
        $nuevo->tipo = $this->name;
        $nuevo->comentario = $this->comentario;
        $nuevo->estado = 'Activo';
        $nuevo->save();
        $this->emitTo('marketing.mark-campanas', 'render');
        $this->emit('alert', '¡Campaña agregada satisfactoriamente!');
    }
}
