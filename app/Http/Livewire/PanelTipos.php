<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PanelTipos extends Component
{
    public $presionado = 32;
    public $areas;
    protected $listeners = ['render' => 'render'];
    public $sucursalId;
    public $sucursalName;
    public function mount()
    {
        if (Auth::user()->sesionsucursal== 0 || Auth::user()->sesionsucursal== null) {
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal=1;
            Auth::user()->save();
        }
        else{
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal=1;
            Auth::user()->save();
        }
    }
    public function render()
    {
        $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.panel-tipos');
    }
}
