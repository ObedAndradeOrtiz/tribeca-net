<?php

namespace App\Http\Livewire\Users;

use App\Models\Calls;
use App\Models\User;
use App\Models\Areas;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\activacion;
use App\Models\Roles;
use Livewire\WithPagination;

class ListaUser extends Component
{

    use WithPagination;
    public $open = false;
    public $user;
    public $telefono;
    public $busqueda = "";
    public $actividad = "Activo";
    public $areas;
    public $areaseleccionada = '';
    public $activado;
    public $fechaInicioMes;
    public $fechaActual;
    public $estadoUser = 'Activo';
    public $rolseleccionado = '';
    public $roles;
    protected $listeners = ['render' => 'render', 'configurarSistema' => 'configurarSistema'];
    public function mount()
    {
        $this->fechaInicioMes = date("Y-m-01");
        $this->fechaActual = now()->format('Y-m-d');
    }
    public function render()
    {
        $this->areas = Areas::where('estado', 'Activo')->get();
        if ($this->estadoUser == 'todos') {
            $users = User::where('sucursal', 'LIKE', '%' . $this->areaseleccionada . '%')->where('name', 'LIKE', '%' . $this->busqueda . '%')->where('rol', 'LIKE', '%' . $this->rolseleccionado . '%')->where('rol', '!=', 'Cliente')->orderBy('name', 'asc')->paginate(10);
        } else {
            $users = User::where('sucursal', 'LIKE', '%' . $this->areaseleccionada . '%')->where('name', 'LIKE', '%' . $this->busqueda . '%')->where('rol', 'LIKE', '%' . $this->rolseleccionado . '%')->where('rol', '!=', 'Cliente')->where('estado', $this->estadoUser)->orderBy('name', 'asc')->paginate(10);
        }

        $this->roles = Roles::where('estado', 'Activo')->get();
        return view('livewire.users.lista-user', compact('users'));
    }
    public function activarsistema()
    {
        // $users = User::where('rol', '!=', 'Cliente')->where('rol', '!=', 'Administrador')->orderBy('id', 'desc')->get();
        // foreach ($users as $user) {
        //     if ($this->activado->estado == 1) {
        //         $user->estado = 'Inactivo';
        //         $user->save();
        //     } else {
        //         $user->estado = 'Activo';
        //         $user->save();
        //     }
        // }
        // $this->activado->estado = $this->activado->estado == 0 ? 1 : 0;
        // $this->activado->save();
        // $this->emitTo('users.lista-user', 'render');
        $this->emit('alert', $this->activado->estado == 1 ? '¡Sistema activado para funcionarios!' : '¡Sistema desactivado para funcionarios!');
    }
    public function configurarSistema()
    {
    }
}
