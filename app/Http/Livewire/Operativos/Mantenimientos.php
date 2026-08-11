<?php

namespace App\Http\Livewire\Operativos;

use App\Models\Mantenimiento;
use App\Models\Proveedor;
use App\Models\TipoMantenimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Mantenimientos extends Component
{
    use WithFileUploads;

    // TIPOS
    public $nombreTipo;

    public $frecuencia;

    // PROVEEDORES
    public $nombreProveedor;

    public $telefono;

    public $tipoProveedor;

    // REGISTRO
    public $tipoMantenimiento;

    public $proveedor;

    public $fecha;

    public $monto;

    public $comprobante;

    public $imagenModal;

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
        TipoMantenimiento::create([
            'nombre' => $this->nombreTipo,
            'frecuencia_dias' => $this->frecuencia,
        ]);

        $this->reset(['nombreTipo', 'frecuencia']);
    }

    public function guardarProveedor()
    {
        Proveedor::create([
            'nombre' => $this->nombreProveedor,
            'telefono' => $this->telefono,
            'tipo_mantenimiento_id' => $this->tipoProveedor,
        ]);

        $this->reset(['nombreProveedor', 'telefono', 'tipoProveedor']);
    }

    public function guardarMantenimiento()
    {
        $ruta = null;

        if ($this->comprobante) {
            $file = $this->comprobante->store('public/mantenimientos');
            $ruta = 'mantenimientos/'.basename($file);
        }

        // 🔥 Obtener tipo de mantenimiento
        $tipo = TipoMantenimiento::find($this->tipoMantenimiento);

        // 🔥 Calcular fecha siguiente
        $fechaBase = Carbon::parse($this->fecha);

        $fechaSiguiente = $tipo
            ? $fechaBase->copy()->addDays($tipo->frecuencia_dias)
            : null;

        // 🔥 Guardar
        Mantenimiento::create([
            'tipo_mantenimiento_id' => $this->tipoMantenimiento,
            'proveedor_id' => $this->proveedor,
            'fecha' => $this->fecha,
            'fecha_siguiente' => $fechaSiguiente,
            'monto' => $this->monto,
            'comprobante' => $ruta,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['tipoMantenimiento', 'proveedor', 'fecha', 'monto', 'comprobante']);
    }

    public function render()
    {
        return view('livewire.operativos.mantenimientos', [
            'tipos' => TipoMantenimiento::all(),
            'proveedores' => Proveedor::with('tipo')->get(),
            'mantenimientos' => Mantenimiento::with('tipo', 'proveedor')
                ->latest()
                ->get(),
        ]);
    }
}
