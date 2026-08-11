<?php

namespace App\Http\Livewire\Pagos;

use App\Models\Pagos;
use App\Models\registroinventario;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaPagosProductos extends Component
{
    public $pagos;
    public $registro;
    public $editar = false;
    public $idoperativo;
    public $eliminarboton = false;
    protected $listeners = ['render' => 'render', 'eliminar' => 'eliminar'];
    protected $rules = [
        'registro.precio' => 'required',
        'registro.modo' => 'required',
        'registro.fecha' => 'required',
    ];
    public function mount($idoperativo)
    {
        $this->idoperativo = $idoperativo;
    }
    public function editarpago($idregistro)
    {
        $this->registro = registroinventario::find($idregistro);
        $this->editar = true;
    }
    public function preeliminar($idregistro)
    {
        $this->registro = registroinventario::find($idregistro);
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
        $this->render();
    }

    public function render()
    {
        $this->pagos = DB::table('registroinventarios')
            ->select('registroinventarios.estado', 'registroinventarios.nombreproducto', 'registroinventarios.id', 'registroinventarios.precio', 'registroinventarios.fecha', 'registroinventarios.modo')
            ->join('historial_clientes', 'registroinventarios.idcliente', '=', 'historial_clientes.idtratamiento')
            ->where('historial_clientes.idoperativo', $this->idoperativo)
            ->where('registroinventarios.motivo', 'compra')
            ->where('registroinventarios.estado', 'Pagado')
            ->get();

        return view('livewire.pagos.lista-pagos-productos');
    }
}
