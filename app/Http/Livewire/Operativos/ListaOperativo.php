<?php

namespace App\Http\Livewire\Operativos;

use Livewire\Component;
use App\Models\Operativos;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class ListaOperativo extends Component
{

    use WithPagination;
    public $open=false;
    public $area;
    public $telefono;
    public $busqueda="";
    public $actividad="Pendiente";
    protected $listeners = ['render'=>'render'];
    public function render()
    {
       $operativos=Operativos::where('empresa','LIKE', '%'.$this->busqueda.'%')->orderBy('id','desc')->paginate(10);
        return view('livewire.operativos.lista-operativo',compact('operativos'));
    }

}
