<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;
class Administrador extends Component
{
    public $presionado = 2;
    public $areas;
    public $sucursalId;
    public $sucursalName;

    protected $listeners = ['render' => 'render'];
    public function mount()
    {


    }
    public function render()
    {
       $this->areas = Areas::where('estado','Activo')->get();
        return view('livewire.administrador');
    }
}
