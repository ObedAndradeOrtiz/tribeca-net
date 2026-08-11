<?php

namespace App\Http\Livewire\Operativos;

use App\Models\Mantenimiento;
use App\Models\Proveedor;
use App\Models\TipoMantenimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Mantenimientos extends Component
{
    use WithFileUploads;

    public $nombreTipo;

    public $frecuencia;

    public $nombreProveedor;

    public $telefono;

    public $tipoProveedor;

    public $tipoMantenimiento;

    public $proveedor;

    public $fecha;

    public $monto;

    public $descripcion;

    public $comprobante;

    public $imagenModal;

    public $editandoId;

    public $editTipoMantenimiento;

    public $editProveedor;

    public $editFecha;

    public $editMonto;

    public $editDescripcion;

    public $editComprobante;

    public $eliminandoId;

    public function verImagen($ruta)
    {
        $this->imagenModal = $ruta;
    }

    public function cerrarImagen()
    {
        $this->imagenModal = null;
    }

    public function guardarTipo()
    {
        $this->validate([
            'nombreTipo' => ['required', 'string', 'max:255'],
            'frecuencia' => ['required', 'integer', 'min:1'],
        ]);

        TipoMantenimiento::create([
            'nombre' => $this->nombreTipo,
            'frecuencia_dias' => $this->frecuencia,
        ]);

        $this->reset(['nombreTipo', 'frecuencia']);
    }

    public function guardarProveedor()
    {
        $this->validate([
            'nombreProveedor' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:255'],
            'tipoProveedor' => ['required', 'exists:tipos_mantenimientos,id'],
        ]);

        Proveedor::create([
            'nombre' => $this->nombreProveedor,
            'telefono' => $this->telefono,
            'tipo_mantenimiento_id' => $this->tipoProveedor,
        ]);

        $this->reset(['nombreProveedor', 'telefono', 'tipoProveedor']);
    }

    public function guardarMantenimiento()
    {
        $this->validate([
            'tipoMantenimiento' => ['required', 'exists:tipos_mantenimientos,id'],
            'proveedor' => ['required', 'exists:proveedores,id'],
            'fecha' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'comprobante' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);

        $ruta = $this->guardarComprobante($this->comprobante);
        $tipo = TipoMantenimiento::find($this->tipoMantenimiento);

        Mantenimiento::create([
            'tipo_mantenimiento_id' => $this->tipoMantenimiento,
            'proveedor_id' => $this->proveedor,
            'fecha' => $this->fecha,
            'fecha_siguiente' => $this->calcularFechaSiguiente($this->fecha, $tipo),
            'monto' => $this->monto,
            'descripcion' => $this->descripcion,
            'comprobante' => $ruta,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['tipoMantenimiento', 'proveedor', 'fecha', 'monto', 'descripcion', 'comprobante']);
    }

    public function abrirEditar($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (! $mantenimiento) {
            return;
        }

        $this->resetValidation();
        $this->editandoId = $mantenimiento->id;
        $this->editTipoMantenimiento = $mantenimiento->tipo_mantenimiento_id;
        $this->editProveedor = $mantenimiento->proveedor_id;
        $this->editFecha = $mantenimiento->fecha ? Carbon::parse($mantenimiento->fecha)->format('Y-m-d\TH:i') : null;
        $this->editMonto = $mantenimiento->monto;
        $this->editDescripcion = $mantenimiento->descripcion;
        $this->editComprobante = null;
    }

    public function guardarEdicion()
    {
        $this->validate([
            'editTipoMantenimiento' => ['required', 'exists:tipos_mantenimientos,id'],
            'editProveedor' => ['required', 'exists:proveedores,id'],
            'editFecha' => ['required', 'date'],
            'editMonto' => ['required', 'numeric', 'min:0'],
            'editDescripcion' => ['nullable', 'string', 'max:1000'],
            'editComprobante' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);

        $mantenimiento = Mantenimiento::find($this->editandoId);

        if (! $mantenimiento) {
            $this->cerrarModal();

            return;
        }

        $ruta = $mantenimiento->comprobante;

        if ($this->editComprobante) {
            if ($ruta) {
                Storage::disk('public')->delete($ruta);
            }

            $ruta = $this->guardarComprobante($this->editComprobante);
        }

        $tipo = TipoMantenimiento::find($this->editTipoMantenimiento);

        $mantenimiento->update([
            'tipo_mantenimiento_id' => $this->editTipoMantenimiento,
            'proveedor_id' => $this->editProveedor,
            'fecha' => $this->editFecha,
            'fecha_siguiente' => $this->calcularFechaSiguiente($this->editFecha, $tipo),
            'monto' => $this->editMonto,
            'descripcion' => $this->editDescripcion,
            'comprobante' => $ruta,
        ]);

        $this->cerrarModal();
    }

    public function confirmarEliminar($id)
    {
        $this->eliminandoId = $id;
    }

    public function eliminarMantenimiento()
    {
        $mantenimiento = Mantenimiento::find($this->eliminandoId);

        if ($mantenimiento) {
            if ($mantenimiento->comprobante) {
                Storage::disk('public')->delete($mantenimiento->comprobante);
            }

            $mantenimiento->delete();
        }

        $this->cerrarModal();
    }

    public function cerrarModal()
    {
        $this->reset([
            'editandoId',
            'editTipoMantenimiento',
            'editProveedor',
            'editFecha',
            'editMonto',
            'editDescripcion',
            'editComprobante',
            'eliminandoId',
        ]);
        $this->resetValidation();
    }

    protected function guardarComprobante($archivo)
    {
        if (! $archivo) {
            return null;
        }

        $file = $archivo->store('public/mantenimientos');

        return 'mantenimientos/'.basename($file);
    }

    protected function calcularFechaSiguiente($fecha, $tipo)
    {
        if (! $fecha || ! $tipo) {
            return null;
        }

        return Carbon::parse($fecha)->copy()->addDays((int) $tipo->frecuencia_dias);
    }

    public function render()
    {
        return view('livewire.operativos.mantenimientos', [
            'tipos' => TipoMantenimiento::orderBy('nombre')->get(),
            'proveedores' => Proveedor::with('tipo')->orderBy('nombre')->get(),
            'mantenimientos' => Mantenimiento::with('tipo', 'proveedor')->latest()->get(),
        ]);
    }
}
