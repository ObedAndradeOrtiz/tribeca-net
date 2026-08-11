<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;

class Tesoreria extends Component
{
    public $presionado=10;
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
        return view('livewire.tesoreria');
    }
}
