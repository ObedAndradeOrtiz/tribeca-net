<?php

namespace App\Http\Livewire\Marketing;

use App\Models\Areas;
use App\Models\campana;
use App\Models\cuentacomercial;
use App\Models\publicidades;
use Carbon\Carbon;
use Livewire\Component;

class CrearPublicidad extends Component
{
    public $cuentas;
    public $crearpublicidad = false;
    public $elegido;
    public $fechainicio;
    public $fechafin;
    public $comentario;
    public $tipo;
    public $campañas;
    public $campañaelegida;
    public $cuentaelegida;
    public $areas;
    public $areaelegida;
    public function render()
    {
        $this->campañas = campana::where('estado', 'Activo')->get();
        $this->cuentas = cuentacomercial::where('estado', 'Activo')->get();
        $this->areas = Areas::where('estado', 'Activo')->get();
        return view('livewire.marketing.crear-publicidad');
    }
    public function guardartodo()
    {
        $nuevo = new publicidades;
        $nuevo->fechainicio = $this->fechainicio;
        $nuevo->fechafin = $this->fechafin;
        $nuevo->motivo = $this->comentario;
        $nuevo->idcampana = $this->campañaelegida;
        $campaña = campana::find($this->campañaelegida);
        $nuevo->nombrecampana = $campaña->tipo;
        $nuevo->idcuenta = $this->cuentaelegida;
        $cuenta = cuentacomercial::find($this->cuentaelegida);
        $nuevo->nombrecuenta = $cuenta->nombrecuenta;
        $nuevo->idsucursal = $this->areaelegida;
        $sucursal = Areas::find($this->areaelegida);
        $nuevo->sucursal = $sucursal->area;
        if ($this->fechafin) {
            // Si existe una fecha de fin
            $fechaActual = now(); // Obtiene la fecha actual en Laravel
            $fechaFin = Carbon::parse($this->fechafin); // Parsea la fecha de fin

            if ($fechaActual->greaterThanOrEqualTo($fechaFin)) {
                // Si la fecha actual es mayor o igual que la fecha de fin
                $nuevo->estado = 'Inactivo';
            } else {
                // Si la fecha actual es menor que la fecha de fin
                $nuevo->estado = 'Activo';
            }
            $nuevo->fechafin = $this->fechafin;
        } else {
            // Si no existe una fecha de fin, el estado es 'Activo'
            $nuevo->estado = 'Activo';
        }

        $nuevo->fechainicio = $this->fechainicio;
        $nuevo->motivo = $this->comentario;
        $nuevo->save();
        $this->emitTo('marketing.marketing', 'render');
        $this->emit('alert', '¡Publicidad agregada satisfactoriamente!');
    }
}
