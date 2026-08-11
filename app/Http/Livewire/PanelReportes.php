<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class PanelReportes extends Component
{
    public $presionado=35;
    public $areas;
    public $sucursalId;
    public $sucursalName;

    protected $listeners = ['render' => 'render'];
    public function mount()
    {


    }

    public function render()
    {
        $this->areas=Areas::where('estado','Activo')->get();
        return view('livewire.panel-reportes');
    }
}
