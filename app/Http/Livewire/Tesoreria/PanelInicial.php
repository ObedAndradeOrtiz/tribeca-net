<?php

namespace App\Http\Livewire\Tesoreria;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PanelInicial extends Component
{
    public $anio;
    public $mes;

    public $totalDeudores = 0;
    public $totalDeuda = 0;

    public $totalIngresosMes = 0;
    public $totalEgresosMes = 0;
    public $saldoMes = 0;

    public $ingresosPendientes = 0;
    public $montoIngresosPendientes = 0;

    public $deudores = [];
    public $departamentosVerificar = [];
    public $ultimosIngresosPendientes = [];

    public $anuncios = [];

    public function mount()
    {
        $this->anio = (int) now()->year;
        $this->mes = (int) now()->month;

        $this->cargarPanel();
    }

    public function updatedAnio()
    {
        $this->cargarPanel();
    }

    public function updatedMes()
    {
        $this->cargarPanel();
    }

    public function cargarPanel()
    {
        $this->cargarResumenFinanciero();
        $this->cargarDeudores();
        $this->cargarDepartamentosVerificar();
        $this->cargarIngresosPendientes();
        $this->cargarAnuncios();
    }

    public function cargarResumenFinanciero()
    {
        $fechaInicioMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $this->totalIngresosMes = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioMes)
            ->whereDate('fecha', '<=', $fechaFinMes)
            ->sum('monto'), 2);

        $this->totalEgresosMes = round((float) DB::table('gastos')
            ->whereRaw("
                COALESCE(
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y')
                ) BETWEEN ? AND ?
            ", [$fechaInicioMes, $fechaFinMes])
            ->sum('cantidad'), 2);

        $this->saldoMes = round($this->totalIngresosMes - $this->totalEgresosMes, 2);

        $this->totalDeuda = round((float) DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->sum('saldo'), 2);

        $this->totalDeudores = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');
    }

    public function cargarDeudores()
    {
        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $registros = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->select(
                'departamento_nombre',
                DB::raw('SUM(saldo) as total_deuda'),
                DB::raw('COUNT(*) as meses_deuda'),
                DB::raw('MIN(fecha_mes) as primer_mes_deuda'),
                DB::raw('MAX(fecha_mes) as ultimo_mes_deuda')
            )
            ->groupBy('departamento_nombre')
            ->orderByDesc('total_deuda')
            ->limit(20)
            ->get();

        $this->deudores = $registros->map(function ($item) {
            return [
                'departamento' => $item->departamento_nombre,
                'total_deuda' => round((float) $item->total_deuda, 2),
                'meses_deuda' => (int) $item->meses_deuda,
                'primer_mes_deuda' => $item->primer_mes_deuda,
                'ultimo_mes_deuda' => $item->ultimo_mes_deuda,
                'prioridad' => $this->calcularPrioridadDeudor(
                    (float) $item->total_deuda,
                    (int) $item->meses_deuda
                ),
            ];
        })->toArray();
    }

    public function cargarDepartamentosVerificar()
    {
        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $parciales = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('estado', 'Parcial')
            ->where('saldo', '>', 0)
            ->select(
                'departamento_nombre',
                'anio',
                'mes',
                'fecha_mes',
                'monto_expensa',
                'monto_pagado',
                'saldo',
                'tipo_estado',
                'observacion'
            )
            ->orderByDesc('saldo')
            ->limit(8)
            ->get();

        $sinCobro = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('no_cobrar', 1)
            ->select(
                'departamento_nombre',
                'anio',
                'mes',
                'fecha_mes',
                'monto_expensa',
                'monto_pagado',
                'saldo',
                'estado_cobro',
                'motivo_no_cobro'
            )
            ->orderByDesc('fecha_mes')
            ->limit(8)
            ->get();

        $resultado = [];

        foreach ($parciales as $item) {
            $resultado[] = [
                'tipo' => 'Pago parcial',
                'departamento' => $item->departamento_nombre,
                'mes' => $this->nombreMes((int) $item->mes) . ' ' . $item->anio,
                'detalle' => 'Saldo pendiente Bs ' . number_format((float) $item->saldo, 2),
                'nivel' => 'warning',
            ];
        }

        foreach ($sinCobro as $item) {
            $resultado[] = [
                'tipo' => 'No cobrable',
                'departamento' => $item->departamento_nombre,
                'mes' => $this->nombreMes((int) $item->mes) . ' ' . $item->anio,
                'detalle' => $item->motivo_no_cobro ?: $item->estado_cobro ?: 'Revisar motivo de no cobro',
                'nivel' => 'info',
            ];
        }

        $this->departamentosVerificar = array_slice($resultado, 0, 10);
    }

    public function cargarIngresosPendientes()
    {
        $fechaInicioMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $this->ingresosPendientes = DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioMes)
            ->whereDate('fecha', '<=', $fechaFinMes)
            ->where(function ($q) {
                $q->where('estado', 'Pendiente')
                    ->orWhere('saldo_pendiente', '>', 0);
            })
            ->count();

        $this->montoIngresosPendientes = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioMes)
            ->whereDate('fecha', '<=', $fechaFinMes)
            ->where(function ($q) {
                $q->where('estado', 'Pendiente')
                    ->orWhere('saldo_pendiente', '>', 0);
            })
            ->sum(DB::raw("
                CASE
                    WHEN saldo_pendiente IS NOT NULL AND saldo_pendiente > 0 THEN saldo_pendiente
                    ELSE monto
                END
            ")), 2);

        $registros = DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioMes)
            ->whereDate('fecha', '<=', $fechaFinMes)
            ->where(function ($q) {
                $q->where('estado', 'Pendiente')
                    ->orWhere('saldo_pendiente', '>', 0);
            })
            ->select(
                'id',
                'fecha',
                'hora',
                'depositante',
                'numero_comprobante',
                'monto',
                'saldo_pendiente',
                'estado'
            )
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->limit(8)
            ->get();

        $this->ultimosIngresosPendientes = $registros->map(function ($item) {
            return [
                'fecha' => $item->fecha,
                'hora' => $item->hora,
                'depositante' => $item->depositante,
                'numero_comprobante' => $item->numero_comprobante,
                'monto' => round((float) $item->monto, 2),
                'saldo_pendiente' => round((float) ($item->saldo_pendiente ?: $item->monto), 2),
                'estado' => $item->estado,
            ];
        })->toArray();
    }

    public function cargarAnuncios()
    {
        $this->anuncios = [];

        if ($this->totalDeudores > 0) {
            $this->anuncios[] = [
                'titulo' => 'Gestión de cobranza',
                'detalle' => 'Existen ' . $this->totalDeudores . ' departamentos con saldo pendiente hasta la fecha seleccionada.',
                'tipo' => 'danger',
            ];
        }

        if ($this->ingresosPendientes > 0) {
            $this->anuncios[] = [
                'titulo' => 'Ingresos por regularizar',
                'detalle' => 'Hay ' . $this->ingresosPendientes . ' ingresos bancarios pendientes de aplicación o revisión.',
                'tipo' => 'warning',
            ];
        }

        if ($this->saldoMes < 0) {
            $this->anuncios[] = [
                'titulo' => 'Saldo mensual negativo',
                'detalle' => 'Los egresos del mes superan los ingresos registrados.',
                'tipo' => 'danger',
            ];
        }

        if (count($this->anuncios) === 0) {
            $this->anuncios[] = [
                'titulo' => 'Panel sin alertas críticas',
                'detalle' => 'No se detectan alertas financieras importantes para el mes seleccionado.',
                'tipo' => 'success',
            ];
        }
    }

    public function calcularPrioridadDeudor($totalDeuda, $mesesDeuda)
    {
        if ($totalDeuda >= 1000 || $mesesDeuda >= 4) {
            return 'Alta';
        }

        if ($totalDeuda >= 500 || $mesesDeuda >= 2) {
            return 'Media';
        }

        return 'Baja';
    }

    public function nombreMes($mes)
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses[(int) $mes] ?? $mes;
    }

    public function render()
    {
        return view('livewire.tesoreria.panel-inicial');
    }
}