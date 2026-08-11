<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PanelPago extends Component
{

    public $areas;
    protected $listeners = ['render' => 'render'];
    public $sucursalId;
    public $sucursalName;
    public $idoperativo;
    public function mount($idoperativo)
    {

        $this->idoperativo = $idoperativo;
        Auth::user()->idoperativo = $idoperativo;
        if (Auth::user()->sesionsucursal == 0 || Auth::user()->sesionsucursal == null) {
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal = 0;
            Auth::user()->sucursal = '';

            Auth::user()->save();
        } else {
            $this->sucursalName = Auth::user()->sucursal;
        }
        // } else {
        //     $this->sucursalName = "HOTEL ROJAS GENERAL";
        //     Auth::user()->sesionsucursal = 0;
        //     Auth::user()->sucursal = 'CENTRAL URBARI';
        //     Auth::user()->save();
        // }
    }
    public function render()
    {
        $this->idoperativo;
       $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.panel-pago');
    }
}
