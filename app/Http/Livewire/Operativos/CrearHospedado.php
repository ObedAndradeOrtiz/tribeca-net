<?php

namespace App\Http\Livewire\Operativos;

use Livewire\Component;
use App\Models\Operativos;
use App\Models\Hospedados;
use App\Models\User;
class CrearHospedado extends Component
{
    public $ci;
    public $edad;
    public $name;
    public $crear=false;
    public $idoperativo;
    public $telefono;
    public $sexo;
    public $ocupacion;
    public function mount($idoperativo){
        $this->idoperativo=$idoperativo;
    }
    public function render()
    {
        return view('livewire.operativos.crear-hospedado');
    }
    public function guardartodo(){
        $ficha = new Hospedados();
        $ficha->nombre = $this->name;
        $ficha->identificacion = $this->ci;
        $ficha->edad=$this->edad;
        $ficha->sexo=$this->sexo;
        $ficha->telefono=$this->telefono;
        $ficha->ocupacion=$this->ocupacion;
        $ficha->idoperativo = $this->idoperativo;
        $ficha->estado='Pendiente';
        $ficha->save();
        $nuevo = new User;
        $nuevo->name = $this->name;
        $nuevo->email = $this->ci;
        $nuevo->rol = "Cliente";
        $nuevo->medio = "INGRESADO";
        $nuevo->tesoreria = "Inactivo";
        if ($this->ci != "") {
            $nuevo->ci = $this->ci;
        }
        $nuevo->password = "********";
        $nuevo->estado = "Activo";
        $nuevo->sucursal = "0";
        $nuevo->sexo = "I";
        $nuevo->ocupacion = "SO";
        $nuevo->save();
        $this->emit('alert', '¡Hospedado creado satisfactoriamente!');
    }
}
