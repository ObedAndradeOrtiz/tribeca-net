<?php

namespace App\Http\Livewire\Tesoreria;

use App\Models\Areas;
use App\Models\Gastos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EgresoInterno extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $open = false;
    public $area;
    public $modo = 'Todos';
    public $telefono;
    public $busqueda = '';
    public $actividad = 'Areas';
    public $tipos = 'Historial';
    public $idempresa;
    public $verclienteslogic = false;
    public $seguridad = true;
    public $contra = '';
    public $activar = false;
    public $openAreaGasto = false;
    public $tipogasto;
    public $modopago;
    public $fechagasto;
    public $montoegreso;
    public $destinario;
    public $comentario = '';
    public $modogeneral = 'Todos';
    public $fechaInicioMes;
    public $fechaActual;
    public $sucursal = '';
    public $tipogastolista = 'general';
    public $lista = 'historial';
    public $imagenModal;
    public $modalEditarEgreso = false;
    public $egresoEditarId;
    public $editarArea;
    public $editarModo;
    public $editarFecha;
    public $editarMonto;
    public $editarTipo;
    public $editarDetalle;
    public $editarPertenece;
    public $editarComprobante;
    public $editarRutaArchivo;

    public $filtroComprobante = 'Todos';

    protected $listeners = ['render' => 'render'];

    public function mount()
    {
        $this->fechaInicioMes = Carbon::now()->toDateString();
        $this->fechaActual = Carbon::now()->toDateString();
    }

    public function render()
    {
        $areas = Areas::where('estado', 'Activo')
            ->orderBy('id', 'desc')
            ->latest()
            ->limit(10)
            ->get();

        $usersl = User::where('name', 'like', '%'.$this->busqueda.'%')
            ->where('estado', 'Activo')
            ->where('sucursal', $this->sucursal)
            ->where('rol', '!=', 'Cliente')
            ->get();

        return view('livewire.tesoreria.egreso-interno', compact('usersl', 'areas'));
    }

    public function editarEgreso($id)
    {
        $gasto = Gastos::find($id);

        if (! $gasto) {
            $this->emit('error', 'No se encontró el egreso.');
            return;
        }

        $this->egresoEditarId = $gasto->id;
        $this->editarArea = $gasto->idarea;
        $this->editarModo = $gasto->modo;
        $this->editarFecha = $gasto->fechainicio;
        $this->editarMonto = $gasto->cantidad;
        $this->editarTipo = $gasto->tipo;
        $this->editarDetalle = $gasto->empresa;
        $this->editarPertenece = $gasto->pertence;
        $this->editarRutaArchivo = $gasto->rutaarchivo;
        $this->editarComprobante = null;
        $this->modalEditarEgreso = true;
    }

    public function actualizarEgreso()
    {
        $this->validate([
            'editarFecha' => 'required|date',
            'editarMonto' => 'required|numeric|min:0',
            'editarModo' => 'required',
            'editarTipo' => 'required',
            'editarDetalle' => 'nullable|string|max:255',
            'editarComprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:4096',
        ]);

        $gasto = Gastos::find($this->egresoEditarId);

        if (! $gasto) {
            $this->emit('error', 'No se encontró el egreso.');
            return;
        }

        $gasto->modo = $this->editarModo;
        $gasto->fechainicio = $this->editarFecha;
        $gasto->cantidad = $this->editarMonto;
        $gasto->tipo = $this->editarTipo;
        $gasto->empresa = $this->editarDetalle;
        $gasto->pertence = $this->editarPertenece;

        if ($this->editarArea) {
            $area = Areas::find($this->editarArea);

            if ($area) {
                $gasto->idarea = $area->id;
                $gasto->area = $area->area;
            }
        }

        if ($this->editarComprobante) {
            if ($gasto->rutaarchivo && Storage::disk('public')->exists($gasto->rutaarchivo)) {
                Storage::disk('public')->delete($gasto->rutaarchivo);
            }

            $ruta = $this->editarComprobante->store('comprobantes-egresos', 'public');
            $gasto->rutaarchivo = $ruta;
        }

        $gasto->nameuser = Auth::user()->name;
        $gasto->save();

        $this->reset([
            'modalEditarEgreso',
            'egresoEditarId',
            'editarArea',
            'editarModo',
            'editarFecha',
            'editarMonto',
            'editarTipo',
            'editarDetalle',
            'editarPertenece',
            'editarComprobante',
            'editarRutaArchivo',
        ]);

        $this->emit('alert', 'Egreso actualizado correctamente.');
    }

    public function eliminarComprobanteEgreso()
    {
        $gasto = Gastos::find($this->egresoEditarId);

        if (! $gasto) {
            $this->emit('error', 'No se encontró el egreso.');
            return;
        }

        if ($gasto->rutaarchivo && Storage::disk('public')->exists($gasto->rutaarchivo)) {
            Storage::disk('public')->delete($gasto->rutaarchivo);
        }

        $gasto->rutaarchivo = null;
        $gasto->save();

        $this->editarRutaArchivo = null;

        $this->emit('alert', 'Comprobante eliminado correctamente.');
    }

    public function verImagen($ruta)
    {
        $this->imagenModal = $ruta;
    }

    public function cerrarImagen()
    {
        $this->imagenModal = null;
    }

    public function confirmar()
    {
        if (($this->montoegreso && $this->modopago && $this->tipogasto && $this->fechagasto) != '') {
            $nuevo = new Gastos;
            $nuevo->idarea = $this->sucursal;

            $miarea = Areas::find($this->sucursal);
            $nuevo->area = $miarea ? $miarea->area : null;

            $nuevo->modo = $this->modopago;
            $nuevo->fechainicio = $this->fechagasto;
            $nuevo->cantidad = $this->montoegreso;
            $nuevo->empresa = $this->comentario;

            $usuarionuevo = User::where('name', $this->destinario)->get();
            $idnew = 0;

            foreach ($usuarionuevo as $gg) {
                $idnew = $gg->id;
            }

            $nuevo->iduser = $idnew;
            $nuevo->nameuser = Auth::user()->name;
            $nuevo->tipo = $this->tipogasto;

            if ($this->tipogasto == 'Sueldo') {
                $nuevo->pertence = $this->destinario;
            }

            if ($this->tipogasto == 'Bono') {
                $nuevo->tipo = $this->tipogasto;
                $nuevo->pertence = $this->destinario;
            }

            $nuevo->save();

            $this->reset(['openAreaGasto', 'montoegreso', 'modopago', 'tipogasto', 'fechagasto']);

            $this->emitTo('tesoreria.egreso-interno', 'render');
            $this->emit('alert', '¡Egreso guardado satisfactoriamente!');
        } else {
            $this->emit('error', '¡Algo anda mal!');
        }
    }
}