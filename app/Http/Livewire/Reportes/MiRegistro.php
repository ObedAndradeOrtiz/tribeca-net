<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Calls;
use App\Models\Operativos;
use App\Models\Empresas;
use App\Models\Pagos;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Areas;
use App\Models\registroinventario;
use App\Models\Productos;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MiRegistro extends Component
{
    public $fechaInicioMes;
    public $fechaActual;
    public $responsableseleccionado;
    public $responsables;
    public $usuario;
    public function mount()
    {
        $this->fechaInicioMes = Carbon::now()->toDateString();
        $this->fechaActual = Carbon::now()->toDateString();
        $this->responsableseleccionado = Auth::user()->name;
        $this->responsables = User::where('estado', 'Activo')->where('rol', '!=', 'Cliente')->orderBy('name')->get();
    }
    public function render()
    {
        $this->usuario = User::where('name', $this->responsableseleccionado)->first();

        return view('livewire.reportes.mi-registro');
    }
}
