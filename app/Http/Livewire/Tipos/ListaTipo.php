<?php

namespace App\Http\Livewire\Tipos;

use Livewire\Component;
use App\Models\tipohabitacion;

class ListaTipo extends Component
{
    public $tipos;
    protected $listeners = ['render'=>'render','eliminarTipo'=>'eliminarTipo'];
    public function render()
    {
         $this->tipos=tipohabitacion::where('estado','Activo')->orderBy('tipo','ASC')->get();
        return view('livewire.tipos.lista-tipo');
    }
    public function eliminarTipo($idtipo){
          $tipo =tipohabitacion::find($idtipo);
          $tipo->delete();
          $this->render();
    }
}
