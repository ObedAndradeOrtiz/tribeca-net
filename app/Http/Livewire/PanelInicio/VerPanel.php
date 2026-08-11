<?php

namespace App\Http\Livewire\PanelInicio;

use App\Models\Mappoint;
use App\Models\Operativos;
use App\Models\registropago;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tratamiento;

class VerPanel extends Component
{
    use WithPagination;
    public $agregar=false;
    public $busqueda="";
    public $name; // Nombre del área
    public $coordinates = []; // Puntos seleccionados
    public $fechainicio;
    public $activeTab='Pendiente';
    protected $listeners = ['guardarjson' => 'guardarjson'];

    public function mount()
    {
        $this->fechainicio=Carbon::now()->toDateString();
    }
    public function guardarjson()
    {
        $operativo= new Operativos;
        $operativo->encargado=Auth::user()->name;
        $operativo->responsable=Auth::user()->id;
        $operativo->estado='Pendiente';
        $operativo->fecha=$this->fechainicio;
        $operativo->save();

        // Convertir a formato JSON si no lo es ya
        $this->coordinates = json_encode( $this->coordinates);

        // Guardar en la base de datos
        $mapa = new Mappoint;
        $mapa->idoperativo=$operativo->id;
        $mapa->name=$this->name;
        $mapa->coordinates = $this->coordinates; // Almacena la cadena JSON
        $mapa->save();
        $this->agregar=false;

        // Emitir alerta
        $this->emit('alert', '¡Mapa creado satisfactoriamente!');
    }

    public function setOpcion($num)
    {
        $this->opcion = $num;


    }
    public function render()
    {
        return view('livewire.panel-inicio.ver-panel');
    }
}
