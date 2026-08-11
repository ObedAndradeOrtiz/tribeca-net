<?php

namespace App\Http\Livewire\Marketing;

use App\Models\tarjetas;
use Livewire\Component;

class EditarTarjeta extends Component
{
    public $tarjeta;
    protected $listeners = ['editarTarjeta' => 'editarTarjeta', 'convPrincipal' => 'convPrincipal'];
    public function mount($idtarjeta)
    {
        $this->tarjeta = tarjetas::find($idtarjeta);
    }
    public function render()
    {
        return view('livewire.marketing.editar-tarjeta');
    }
    public function editarTarjeta($idtarjeta)
    {
        $tarjeta = tarjetas::find($idtarjeta);
        $tarjeta->estado = 'Inactivo';
        $tarjeta->save();
        $this->emitTo('marketing.mark-tarjetas', 'render');
    }
    public function convPrincipal($idtarjeta)
    {
        $principal = tarjetas::where("motivo", "1")->first();
        if ($principal) {
            $principal->motivo = "0";
            $principal->save();
        }


        $tarjeta = tarjetas::find($idtarjeta);
        $tarjeta->motivo = '1';
        $tarjeta->save();
        $this->emitTo('marketing.mark-tarjetas', 'render');
    }
}
