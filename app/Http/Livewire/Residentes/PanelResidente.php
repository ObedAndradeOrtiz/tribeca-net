<?php

namespace App\Http\Livewire\Residentes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PanelResidente extends Component
{
    public $nombre = '';

    public $ci = '';

    public $departamentosSolicitados = [];

    public $mensaje = '';

    public $tabActiva = 'autorizados';

    public $busquedaDepartamento = '';

    public function mount()
    {
        abort_unless(Auth::check() && Auth::user()->rol === 'residente', 403);

        $this->nombre = Auth::user()->name;
        $this->ci = Auth::user()->ci;
        $this->departamentosSolicitados = $this->solicitudesActuales();
    }

    public function guardarPerfil()
    {
        $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ci' => ['nullable', 'string', 'max:255'],
        ]);

        Auth::user()->forceFill([
            'name' => $this->nombre,
            'ci' => $this->ci ?: null,
            'resident_profile_completed' => 1,
        ])->save();

        $this->mensaje = 'Datos guardados correctamente.';
    }

    public function solicitarAccesos()
    {
        foreach ($this->departamentosSolicitados as $tratamientoId) {
            $departamento = DB::table('tratamientos')->where('id', $tratamientoId)->first();

            if (! $departamento) {
                continue;
            }

            $existe = DB::table('resident_department_access')
                ->where('user_id', Auth::id())
                ->where('tratamiento_id', $departamento->id)
                ->exists();

            if ($existe) {
                continue;
            }

            DB::table('resident_department_access')->insert([
                'user_id' => Auth::id(),
                'tratamiento_id' => $departamento->id,
                'departamento_nombre' => $departamento->nombre,
                'status' => 'Solicitado',
                'requested_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->mensaje = 'Solicitud enviada. El administrador debe autorizarla.';
        $this->departamentosSolicitados = $this->solicitudesActuales();
        $this->tabActiva = 'autorizados';
    }

    public function solicitudesActuales()
    {
        return DB::table('resident_department_access')
            ->where('user_id', Auth::id())
            ->pluck('tratamiento_id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
    }

    public function getDepartamentosProperty()
    {
        return DB::table('tratamientos')
            ->when(trim($this->busquedaDepartamento) !== '', function ($q) {
                $busqueda = '%'.trim($this->busquedaDepartamento).'%';

                $q->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', $busqueda)
                        ->orWhere('TIPO', 'like', $busqueda);
                });
            })
            ->select('id', 'nombre', 'costo', 'TIPO')
            ->orderBy('nombre')
            ->get();
    }

    public function getAccesosAprobadosProperty()
    {
        return DB::table('resident_department_access')
            ->where('user_id', Auth::id())
            ->where('status', 'Aprobado')
            ->orderBy('departamento_nombre')
            ->get();
    }

    public function getAccesosProperty()
    {
        return DB::table('resident_department_access')
            ->where('user_id', Auth::id())
            ->orderBy('departamento_nombre')
            ->get();
    }

    public function estadoDepartamento($tratamientoId)
    {
        return $this->accesos
            ->firstWhere('tratamiento_id', (int) $tratamientoId)
            ->status ?? null;
    }

    public function resumenDepartamento($departamentoNombre)
    {
        $expensas = DB::table('expensas')
            ->where('departamento_nombre', $departamentoNombre)
            ->where('fecha_mes', '>=', '2024-08-01');

        $pagos = DB::table('ingresos_bancarios_aplicaciones as iba')
            ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
            ->where('iba.departamento_nombre', $departamentoNombre)
            ->where('iba.estado', '!=', 'Anulado')
            ->select(
                'ib.fecha',
                'ib.hora',
                'ib.numero_comprobante',
                'ib.depositante',
                'iba.monto',
                'iba.anio_pago',
                'iba.mes_pago',
                'iba.estado_pago'
            )
            ->orderByDesc('ib.fecha')
            ->orderByDesc('ib.hora')
            ->limit(8)
            ->get();

        return [
            'total_expensas' => round((float) (clone $expensas)->sum('monto_expensa'), 2),
            'total_pagado' => round((float) (clone $expensas)->sum('monto_pagado'), 2),
            'saldo' => round((float) (clone $expensas)->sum('saldo'), 2),
            'pagos' => $pagos,
        ];
    }

    public function render()
    {
        return view('livewire.residentes.panel-residente');
    }
}
