<?php

namespace App\Http\Livewire\Clientes;


use App\Models\User;
use App\Models\Empresas;
use App\Models\Areas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListaClientes extends Component
{
    use WithPagination;
    public $open = false;
    public $user;
    public $telefono;
    public $busqueda = "";
    public $actividad = "Activo";
    public $empresaseleccionada = "";
    public $ocupaciones;
    protected $listeners = ['render' => 'render'];
    public function mount()
    {
        $this->emit('sacarboton', []);
    }
    public function render()
    {
        
        $this->ocupaciones = \App\Models\Ocupacion::where('estado', 'Activo')->get();
        $empresas = Areas::where('estado', 'Activo')->get();
        $users = User::where(function ($query) {
            $query->OrWhere('name', 'LIKE', '%' . $this->busqueda . '%');
            $query->OrWhere('telefono', 'LIKE', '%' . $this->busqueda . '%');
        })->where('estado', $this->actividad)->where('rol', 'Cliente')->paginate(10);
        return view('livewire.clientes.lista-clientes', compact('users', 'empresas'));
    }
}
