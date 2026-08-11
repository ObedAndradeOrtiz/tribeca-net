<?php

namespace App\Http\Livewire\Operativos;

use App\Models\Hospedados;
use App\Models\Operativos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListaHospedados extends Component
{
    public $crear=false;
    public $name="";
    public $ci="";
    public $edad=0;
    public $misfichas;
    public $eliminar = false;
    public $operativo;
    public $tratamiento = "";
    public $sesion = "1";
    public $fecha;
    public $user;
    public $idtratamientoseleccionado;
    public $idoperativo;
    public $hospedados;

    public function mount($idoperativo)
    {
        $this->idoperativo=$idoperativo;
        $this->fecha = Carbon::now()->toDateString();
        $this->user = User::find(Auth::user()->id);
        $this->operativo = Operativos::find($idoperativo);
    }
    public function render()
    {
        $this->hospedados=Hospedados::where('estado','Pendiente')->where('idoperativo', $this->idoperativo)->get();
        return view('livewire.operativos.lista-hospedados');
    }
    public function guardartodo()
    {
        $ficha = new Hospedados();
        $ficha->nombre = $this->name;
        $ficha->identificacion = $this->ci;
        $ficha->edad=$this->edad;
        $ficha->idoperativo = $this->idoperativo;
        $ficha->estado='Pendiente';
        $ficha->save();
        $this->render();
    }
    public function preeliminar($idtratamiento)
    {
        $this->idtratamientoseleccionado = $idtratamiento;
        $this->eliminar = true;
    }
    public function eliminarinformacion()
    {
        $tratamientohistorial = fichacliente::find($this->idtratamientoseleccionado);
        $tratamientohistorial->delete();
        $this->eliminar = false;
        $this->render();
    }
}
