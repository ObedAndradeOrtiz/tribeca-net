<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PanelInformacion extends Component
{
    public $areas;
    protected $listeners = ['render' => 'render'];
    public $sucursalId;
    public $sucursalName;
    public $idoperativo;
    public function mount($idoperativo)
    {

        $this->idoperativo = $idoperativo;
        $user = User::find(Auth::user()->id);
        $user->idoperativo = $idoperativo;
        $user->save();
        if (Auth::user()->sesionsucursal == 0 || Auth::user()->sesionsucursal == null) {
            $this->sucursalName = "HOTEL ROJAS GENERAL";
            Auth::user()->sesionsucursal = 0;
            Auth::user()->sucursal = '';
            Auth::user()->save();
        } else {
            $this->sucursalName = Auth::user()->sucursal;
        }
    }
    public function render()
    {
        $this->idoperativo;
       $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.panel-informacion');
    }
}
