<?php

namespace App\Http\Livewire\Recepcionista;

use Livewire\Component;
use App\Models\Tratamiento;

class Estados extends Component
{
    public $idhabitacion;
    public $habitacion;
    public function mount($habitacion){

       $this->habitacion=Tratamiento::find($habitacion->id);
    }
    public function render()
    {
        return view('livewire.recepcionista.estados');
    }
    public function cambiar($estado){
        $this->habitacion->estado=$estado;
        $this->habitacion->save();
        $this->emitTo('recepcionista.lista-recepcion','render');
        $this->emit('alert','¡Cámbio de estado!');
        $this->render();
    }
}
