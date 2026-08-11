<?php

namespace App\Http\Livewire\Operativos\Accion;

use App\Models\HistorialCliente;
use Livewire\Component;

class Eliminar extends Component
{
    public $idtratamiento;
    protected $listeners = ['eliminarTratamientoVista' => 'eliminarTratamientoVista'];
    public function mount($idtratamiento)
    {
        $this->idtratamiento = $idtratamiento;
    }
    public function eliminarTratamientoVista($idtratamiento)
    {
        $tratamientohistorial = HistorialCliente::find($idtratamiento);
        // $pago = Pagos::where('idoperativo', $this->operativo->id)->first();
        // if ($pago) {
        //     if ($pago->cantidad > 0 && $pago->cantidad != "") {
        //         $pago->cantidad = (float) $pago->cantidad - (float) $tratamientohistorial->costo;
        //     }
        //     $pago->save();
        // }
        $tratamientohistorial->delete();
    }
    public function render()
    {
        return view('livewire.operativos.accion.eliminar');
    }
}
