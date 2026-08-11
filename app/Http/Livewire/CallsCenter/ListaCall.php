<?php

namespace App\Http\Livewire\CallsCenter;

use App\Models\Areas;
use App\Models\Calls;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListaCall extends Component
{
    use WithPagination;
    public $open = false;
    public $area;
    public $telefono;
    public $busqueda = "";
    public $actividad = "llamadas";
    public $mostraroperativo = false;
    public $rangoseleccionado = "Diario";
    public $fechaInicioMes;
    public $fechaActual;
    public $areas;
    public $areaseleccionada = "";
    public $realizadas = 0;
    public $agendadas = 0;
    public $confirmadas = 0;
    public $faltantes = 0;
    public $misllamadas = 0;
    public $misagendados = 0;
    public $opcion = 0;
    public $eventos = [];
    public $areaseleccionadacalendario;
    public $responsableseleccionado = "";
    public $responsables;
    public $asistidos;

    protected $listeners = ['render' => 'render', 'operativos' => 'operativos'];
    public function mount()
    {
        $this->responsables = User::where('estado', 'Activo')->where('rol', '!=', 'Cliente')->get();
        if (Auth::user()->sucseleccionada) {
            $this->areaseleccionadacalendario = Auth::user()->sucseleccionada;
        } else {
            $this->areaseleccionadacalendario = 1;
            $user = User::find(Auth::user()->id);
            $user->sucseleccionada = $this->areaseleccionadacalendario;
        }

        $this->eventos = [];
        $all_events = DB::table('operativos')->where('area', Auth::user()->sucursal)->get();
        foreach ($all_events as $event) {
            $this->eventos[] = [
                'title' => 'CITA: ' . $event->empresa,
                'start' => $event->fecha . ' ' . $event->hora,
                'end' => $event->fecha . ' ' . $event->hora,
                'color' => '#167D27',
            ];
        }
        $this->fechaInicioMes = Carbon::now()->toDateString();
        $this->fechaActual = Carbon::now()->toDateString();
        $this->areas = Areas::where('estado', 'Activo')->get();
    }
    public function actulizargrafico()
    {
        $user = User::find(Auth::user()->id);
        $user->sucseleccionada = $this->areaseleccionadacalendario;
        $user->save();
        $this->emit('updateIframe');
        $this->render();
    }
    public function render()
    {
        $this->callrender();
        if ($this->rangoseleccionado == "Todos") {
            $llamadas = Calls::where(function ($query) {
                $query->OrWhere('empresa', 'LIKE', '%' . $this->busqueda . '%');
                $query->OrWhere('telefono', 'LIKE', '%' . $this->busqueda . '%');
            })
                ->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)
                ->where('area', 'LIKE', '%' . $this->areaseleccionada)
                ->where('estado', $this->actividad)
                ->orderBy('id', 'desc')
                ->paginate(10);
            $this->asistidos = DB::table('calls')
                ->where(function ($query) {
                    $query->orWhere('calls.empresa', 'LIKE', '%' . $this->busqueda . '%')
                        ->orWhere('calls.telefono', 'LIKE', '%' . $this->busqueda . '%');
                })
                ->where('calls.responsable', 'LIKE', '%' . $this->responsableseleccionado . '%')
                ->where('calls.area', 'LIKE', '%' . $this->areaseleccionada . '%')


                ->join('operativos', 'operativos.idllamada', '=', 'calls.id')
                ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                ->orderBy('calls.id', 'desc')
                ->count();
            $listaasistidos = DB::table('calls')
                ->where(function ($query) {
                    $query->orWhere('calls.empresa', 'LIKE', '%' . $this->busqueda . '%')
                        ->orWhere('calls.telefono', 'LIKE', '%' . $this->busqueda . '%');
                })
                ->where('calls.responsable', 'LIKE', '%' . $this->responsableseleccionado . '%')
                ->where('calls.area', 'LIKE', '%' . $this->areaseleccionada . '%')


                ->join('operativos', 'operativos.idllamada', '=', 'calls.id')
                ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                ->orderBy('calls.id', 'desc')
                ->paginate(10);
        } else {
            $llamadas = Calls::where(function ($query) {
                $query->OrWhere('empresa', 'LIKE', '%' . $this->busqueda . '%');
                $query->OrWhere('telefono', 'LIKE', '%' . $this->busqueda . '%');
            })
                ->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)
                ->where('area', 'LIKE', '%' . $this->areaseleccionada)
                ->where('estado', $this->actividad)
                ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
                ->orderBy('id', 'desc')
                ->paginate(10);

            $this->asistidos = DB::table('calls')
                ->where(function ($query) {
                    $query->orWhere('calls.empresa', 'LIKE', '%' . $this->busqueda . '%')
                        ->orWhere('calls.telefono', 'LIKE', '%' . $this->busqueda . '%');
                })
                ->where('calls.responsable', 'LIKE', '%' . $this->responsableseleccionado . '%')
                ->where('calls.area', 'LIKE', '%' . $this->areaseleccionada . '%')

                ->whereBetween('calls.fecha', [$this->fechaInicioMes, $this->fechaActual])
                ->join('operativos', 'operativos.idllamada', '=', 'calls.id')
                ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                ->orderBy('calls.id', 'desc')
                ->count();
            $listaasistidos = DB::table('calls')
                ->where(function ($query) {
                    $query->orWhere('calls.empresa', 'LIKE', '%' . $this->busqueda . '%')
                        ->orWhere('calls.telefono', 'LIKE', '%' . $this->busqueda . '%');
                })
                ->where('calls.responsable', 'LIKE', '%' . $this->responsableseleccionado . '%')
                ->where('calls.area', 'LIKE', '%' . $this->areaseleccionada . '%')

                ->whereBetween('calls.fecha', [$this->fechaInicioMes, $this->fechaActual])
                ->join('operativos', 'operativos.idllamada', '=', 'calls.id')
                ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                ->orderBy('calls.id', 'desc')
                ->paginate(10);
        }
        return view('livewire.calls-center.lista-call', compact('llamadas', 'listaasistidos'));
    }
    public function setOpcion($num)
    {

        if ($num == 0) {
            $this->actividad = "llamadas";
        }
        if ($num == 1) {
            $this->actividad = "Pendiente";
        }
        if ($num == 2) {
        }
        $this->opcion = $num;
    }
    public function callrender()
    {
        switch ($this->rangoseleccionado) {
            case "Diario":
                $this->fechaInicioMes = Carbon::now()->toDateString();
                $this->fechaActual = Carbon::now()->toDateString();
                $this->realizadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'Pendiente')->count();
                break;
            case "Semanal":
                $this->fechaInicioMes = Carbon::now()->subDays(5)->toDateString();
                $this->fechaActual = Carbon::now()->subDays(5)->toDateString();
                $this->realizadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'Pendiente')->count();
                break;
            case "Mensual":
                $this->fechaInicioMes = Carbon::now()->subDays(30)->toDateString();
                $this->fechaActual = Carbon::now()->subDays(30)->toDateString();
                $this->realizadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'Pendiente')->count();
                break;
            case "Ayer":
                $this->fechaInicioMes = Carbon::now()->subDays(1)->toDateString();
                $this->fechaActual = Carbon::now()->subDays(1)->toDateString();
                $this->realizadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'Pendiente')->count();
                break;
            case "Personalizado":
                $this->realizadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('area', 'LIKE', '%' . $this->areaseleccionada)->where('responsable', 'LIKE', '%' . $this->responsableseleccionado)->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])->where('estado', 'Pendiente')->count();
                break;
            case "Todos":
                $this->realizadas = Calls::where('estado', 'llamadas')->count();
                $this->agendadas = Calls::where('estado', 'Pendiente')->count();
                break;
            default:
                echo "Opción no válida";
        };
    }
    public function copiarConsultaAlPortapapeles()
    {
        $resultados = DB::table('calls')
            ->select('empresa', 'telefono')
            ->where('area', 'LIKE', '%' . $this->areaseleccionada)
            ->where('estado', 'Pendiente')
            ->orderBy('id', 'desc')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->get();
        // Formatea los resultados en una cadena de texto
        $texto = "LISTA DE AGENDADOS DEL DIA\n";
        foreach ($resultados as $resultado) {
            $texto .= $resultado->empresa . " - " . $resultado->telefono . "\n";
        }
        // Escapa las comillas simples y dobles en el texto generado
        $texto = addslashes($texto);
        // Ejecuta el script JavaScript
        $this->emit('copiarTabla', $texto);
    }
}
