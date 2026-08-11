<?php

namespace App\Http\Livewire\Recepcionista;

use App\Models\Areas;
use App\Models\Operativos;
use App\Models\Tratamiento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListaRecepcion extends Component
{
    use WithPagination;
    public $open = false;
    public $opcion = 0;
    public $area;
    public $telefono;
    public $busqueda = "";
    public $actividad = "Pendiente";
    public $mostraroperativo = false;
    public $rangoseleccionado = "Todos";
    public $fechaInicioMes;
    public $fechaActual;
    public $areas;
    public $botonRecepcion = true;
    public $areaseleccionada = "";
    public $actividadBoton = 'Activo';
    public $busquedaCliente = '';
    public $agendados = 0;
    public $confirmados;
    public $dineroesperado;
    public $dinerobtenido;
    public $nuevosclientes;
    public $deuda;
    public $asistido = 0;
    public $botonagenda = "Agendados";
    public $habitaciones;
    public $areaseleccionadacalendario;
    public $estados;
    public $habitacionesEstado;
    protected $listeners = ['render' => 'render'];
    public function setOpcion($num)
    {
        $this->opcion = $num;
    }
    public function mount()
    {
        if (Auth::user()->sucseleccionada) {
            $this->areaseleccionadacalendario = Auth::user()->sucseleccionada;
        } else {
            $this->areaseleccionadacalendario = 1;
            $user = User::find(Auth::user()->id);
            $user->sucseleccionada = $this->areaseleccionadacalendario;
        }
        $this->fechaInicioMes = Carbon::now()->toDateString();
        $this->fechaActual = Carbon::now()->toDateString();
        $this->areas = Areas::where('estado', 'Activo')->get();
        $this->areaseleccionada = Auth::user()->sucursal;
    }
    public function render()
    {
        $this->estados = [
            'Activo' => 'Departamentos Desocupados',
            'Ocupado' => 'Departamentos Ocupados',
            'limpieza' => 'Habitaciones en Limpieza',
            'mantenimiento' => 'Habitaciones en Mantenimiento',
            'reservado' => 'Habitaciones Reservadas',
        ];
        $this->habitaciones = Tratamiento::where('sucursal', Auth::user()->sucursal)->where('nombre', 'LIKE', '%' . $this->busqueda . '%')->orderByRaw("FIELD(estado, 'Activo', 'Ocupado', 'limpieza', 'mantenimiento', 'reservado')")->get();
        $this->agendados = Operativos::where('fecha', '<=', $this->fechaActual)
        ->where('fechafin', '>=', $this->fechaInicioMes)
        ->where('area', 'LIKE', '%' . Auth::user()->sucursal . '%')
        ->count();
        $llamadas = Operativos::where(function ($query) {
            $query->orWhere('empresa', 'LIKE', '%' . $this->busqueda . '%');
            $query->orWhere('telefono', 'LIKE', '%' . $this->busqueda . '%');
        })
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fechafin', '>=', $this->fechaInicioMes)
            ->where('area', 'LIKE', '%' . Auth::user()->sucursal . '%')
            ->orderBy('hora', 'asc')
            ->paginate(10);
        return view('livewire.recepcionista.lista-recepcion', compact('llamadas'));
    }
}
