<?php

namespace App\Http\Livewire\Pagos;

use App\Events\EnviarMensaje;
use App\Models\Areas;
use App\Models\Tratamiento;
use App\Models\HistorialCliente;
use App\Models\Operativos;
use App\Models\Pagos;
use App\Models\registropago;
use App\Models\TratamientoCliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class ListaPagos extends Component
{
    public $pagos;
    public $registro;
    public $editar = false;
    public $idoperativo;
    public $eliminarboton = false;
    protected $listeners = ['render' => 'render', 'eliminar' => 'eliminar'];
    protected $rules = [
        'registro.monto' => 'required',
        'registro.modo' => 'required',
        'registro.fecha' => 'required',
    ];
    public function mount($idoperativo)
    {
        $this->idoperativo = $idoperativo;
    }
    public function editarpago($idregistro)
    {
        $this->registro = registropago::find($idregistro);
        $this->editar = true;
    }
    public function preeliminar($idregistro)
    {
        $this->registro = registropago::find($idregistro);
        $this->eliminarboton = true;
    }
    public function guardartodo()
    {
        $this->validate();
        $this->registro->save();
        $this->emitTo('operativos.pagos-cliente', 'render');
        $this->emit('alert', '¡Pago editado!');

        $this->render();
    }
    public function eliminarPago()
    {
        $this->registro->delete();
        $this->emitTo('operativos.pagos-cliente', 'render');
        $this->emit('alert', '¡Pago eliminado!');
    }

    public function render()
    {
        $this->pagos = registropago::where('idoperativo', $this->idoperativo)->get();
        return view('livewire.pagos.lista-pagos');
    }
    
}