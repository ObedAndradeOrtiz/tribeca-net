<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;

class PanelEmpleados extends Component
{
    public $presionado = 0;
    public $areas;
    protected $listeners = ['render' => 'render'];
    public $sucursalId;
    public $sucursalName;
    public function mount($idsucursal)
    {
        $this->sucursalId = $idsucursal;
        if ($this->sucursalId == 0 || $this->sucursalId == null) {
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal = 0;
            Auth::user()->save();
        } else {
            $area = Areas::find($idsucursal);
            $this->sucursalName = $area->area;
            Auth::user()->sesionsucursal = $area->id;
            $area = Areas::find($idsucursal);
            Auth::user()->sucursal = $area->area;
            Auth::user()->save();
        }
    }
    public function render()
    {
       $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.panel-empleados');
    }
}
