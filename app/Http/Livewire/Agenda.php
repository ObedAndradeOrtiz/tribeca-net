<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Calls;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use App\Models\Areas;

class Agenda extends Component
{
    public $presionado = 5;
    public $areas;
    public $sucursalId;
    public $sucursalName;

    protected $listeners = ['render' => 'render'];
    public function mount()
    {
        if (Auth::user()->sesionsucursal == 0 || Auth::user()->sesionsucursal == null) {
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal = 0;
            Auth::user()->save();
        } else {
            $area = Areas::find(Auth::user()->sesionsucursal);
            $this->sucursalName = $area->area;
        }
    }
    public function render()
    {
       $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.agenda');
    }
}
