<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use App\Models\Roles;
use App\Models\RolesVista;
class ListaRoles extends Component
{
    public $actividad="Activo";
    public $roles;
    protected $listeners = ['render'=>'render','borrarRol'=>'borrarRol'];
    public function mount(){

    }
    public function render()
    {
        $this->roles=Roles::where('estado','Activo')->get();
        return view('livewire.roles.lista-roles');
    }
    public function borrarRol($idrol){

        $rol=Roles::find($idrol);
        $rol->estado="Inactivo";
        $rol->save();
        $this->emitTo('administrador','render');
        $this->emit('saved','¡Rol eliminado!');
    }
    public function guardartodo($id)
    {
        $vistaRole = RolesVista::findOrFail($id);
        // Cambiar el estado
        $vistaRole->estado = ($vistaRole->estado == 'Activo') ? 'Inactivo' : 'Activo';
        $vistaRole->save();
        $this->emitTo('panel','render');
        $this->emitTo('administrador','render');
        $this->emit('saved','¡Rol cambiado!');
    }

}
