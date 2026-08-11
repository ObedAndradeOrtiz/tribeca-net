<?php

namespace App\Http\Livewire\Tesoreria;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EstadisticasAuditoria extends Component
{
    public $anio;
    public $mes;

    public $fechaInicioSistema = '2024-08-01';

    public $totalIngresosMes = 0;
    public $totalEgresosMes = 0;
    public $saldoMes = 0;

    public $totalIngresosAnio = 0;
    public $totalEgresosAnio = 0;
    public $saldoAnio = 0;

    public $totalIngresosGeneral = 0;
    public $totalEgresosGeneral = 0;
    public $saldoGeneral = 0;

    public $totalDeuda = 0;
    public $cantidadDeudores = 0;
    public $cantidadDepartamentos = 0;

    public $ingresosPendientes = 0;
    public $montoIngresosPendientes = 0;

    public $egresosSinComprobante = 0;
    public $montoEgresosSinComprobante = 0;

    public $ingresosGestionAnterior = 0;
    public $ingresosSalon = 0;
    public $otrosIngresos = 0;

    public $chartIngresosMensuales = [];
    public $chartEgresosMensuales = [];
    public $chartSaldoMensual = [];

    public $chartComparativoMes = [];
    public $chartIngresosEspeciales = [];
    public $chartEstadoDepartamentos = [];
    public $chartTopDeudores = [];
    public $chartIrregularidades = [];

    public $topDeudores = [];
    public $departamentosIrregulares = [];

    public function mount()
    {
        $this->anio = (int) now()->year;
        $this->mes = (int) now()->month;

        $this->cargarEstadisticas();
    }

    public function updatedAnio()
    {
        $this->cargarEstadisticas();
    }

    public function updatedMes()
    {
        $this->cargarEstadisticas();
    }

    public function cargarEstadisticas()
    {
        $this->cargarResumenPrincipal();
        $this->cargarGraficosMensuales();
        $this->cargarIngresosEspeciales();
        $this->cargarEstadoDepartamentos();
        $this->cargarTopDeudores();
        $this->cargarIrregularidades();

        $this->emit('estadisticasActualizadas', [
            'ingresosMensuales' => $this->chartIngresosMensuales,
            'egresosMensuales' => $this->chartEgresosMensuales,
            'saldoMensual' => $this->chartSaldoMensual,
            'comparativoMes' => $this->chartComparativoMes,
            'ingresosEspeciales' => $this->chartIngresosEspeciales,
            'estadoDepartamentos' => $this->chartEstadoDepartamentos,
            'topDeudores' => $this->chartTopDeudores,
            'irregularidades' => $this->chartIrregularidades,
        ]);
    }

    public function cargarResumenPrincipal()
    {
        $fechaInicioMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $fechaInicioAnio = Carbon::create((int) $this->anio, 1, 1)
            ->startOfYear()
            ->toDateString();

        $fechaFinAnio = Carbon::create((int) $this->anio, 12, 31)
            ->endOfYear()
            ->toDateString();

        $this->totalIngresosMes = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioMes)
            ->whereDate('fecha', '<=', $fechaFinMes)
            ->sum('monto'), 2);

        $this->totalEgresosMes = round((float) $this->totalEgresosEntreFechas($fechaInicioMes, $fechaFinMes), 2);

        $this->saldoMes = round($this->totalIngresosMes - $this->totalEgresosMes, 2);

        $this->totalIngresosAnio = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioAnio)
            ->whereDate('fecha', '<=', $fechaFinAnio)
            ->sum('monto'), 2);

        $this->totalEgresosAnio = round((float) $this->totalEgresosEntreFechas($fechaInicioAnio, $fechaFinAnio), 2);

        $this->saldoAnio = round($this->totalIngresosAnio - $this->totalEgresosAnio, 2);

        $this->totalIngresosGeneral = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $this->fechaInicioSistema)
            ->whereDate('fecha', '<=', now()->toDateString())
            ->sum('monto'), 2);

        $this->totalEgresosGeneral = round((float) $this->totalEgresosEntreFechas(
            $this->fechaInicioSistema,
            now()->toDateString()
        ), 2);

        $this->saldoGeneral = round($this->totalIngresosGeneral - $this->totalEgresosGeneral, 2);

        $this->totalDeuda = round((float) DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->sum('saldo'), 2);

        $this->cantidadDeudores = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFinMes)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');

        $this->cantidadDepartamentos = DB::table('tratamientos')
            ->count();

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

        $this->egresosSinComprobante = DB::table('gastos')
            ->whereRaw("
                COALESCE(
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
                    DATE(created_at)
                ) BETWEEN ? AND ?
            ", [$fechaInicioMes, $fechaFinMes])
            ->where(function ($q) {
                $q->whereNull('rutaarchivo')
                    ->orWhereRaw("TRIM(rutaarchivo) = ''");
            })
            ->count();

        $this->montoEgresosSinComprobante = round((float) DB::table('gastos')
            ->whereRaw("
                COALESCE(
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
                    DATE(created_at)
                ) BETWEEN ? AND ?
            ", [$fechaInicioMes, $fechaFinMes])
            ->where(function ($q) {
                $q->whereNull('rutaarchivo')
                    ->orWhereRaw("TRIM(rutaarchivo) = ''");
            })
            ->sum('cantidad'), 2);

        $this->chartComparativoMes = [
            'labels' => ['Ingresos', 'Egresos', 'Saldo'],
            'data' => [
                $this->totalIngresosMes,
                $this->totalEgresosMes,
                $this->saldoMes,
            ],
        ];
    }

    public function cargarGraficosMensuales()
    {
        $labels = [];
        $ingresos = [];
        $egresos = [];
        $saldos = [];

        for ($m = 1; $m <= 12; $m++) {
            $fechaInicio = Carbon::create((int) $this->anio, $m, 1)
                ->startOfMonth()
                ->toDateString();

            $fechaFin = Carbon::create((int) $this->anio, $m, 1)
                ->endOfMonth()
                ->toDateString();

            $ingresoMes = round((float) DB::table('ingresos_bancarios')
                ->whereDate('fecha', '>=', $fechaInicio)
                ->whereDate('fecha', '<=', $fechaFin)
                ->sum('monto'), 2);

            $egresoMes = round((float) $this->totalEgresosEntreFechas($fechaInicio, $fechaFin), 2);

            $labels[] = $this->nombreMesCorto($m);
            $ingresos[] = $ingresoMes;
            $egresos[] = $egresoMes;
            $saldos[] = round($ingresoMes - $egresoMes, 2);
        }

        $this->chartIngresosMensuales = [
            'labels' => $labels,
            'data' => $ingresos,
        ];

        $this->chartEgresosMensuales = [
            'labels' => $labels,
            'data' => $egresos,
        ];

        $this->chartSaldoMensual = [
            'labels' => $labels,
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'saldos' => $saldos,
        ];
    }

    public function cargarIngresosEspeciales()
    {
        $fechaInicio = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFin = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $this->ingresosSalon = round((float) DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', function ($join) {
                $join->on('iba.ingreso_bancario_id', '=', 'ib.id')
                    ->where('iba.estado', '!=', 'Anulado');
            })
            ->whereDate('ib.fecha', '>=', $fechaInicio)
            ->whereDate('ib.fecha', '<=', $fechaFin)
            ->where(function ($q) {
                $q->where('iba.tipo_aplicacion', 'like', '%SALON%')
                    ->orWhere('iba.tipo_aplicacion', 'like', '%SALÓN%')
                    ->orWhere('ib.detalle', 'like', '%SALON%')
                    ->orWhere('ib.detalle', 'like', '%SALÓN%');
            })
            ->sum('ib.monto'), 2);

        $this->otrosIngresos = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicio)
            ->whereDate('fecha', '<=', $fechaFin)
            ->where(function ($q) {
                $q->where('tipo_ingreso', 'Otro ingreso')
                    ->orWhere('depositante', 'like', '%PAGO DE INTERES%')
                    ->orWhere('depositante', 'like', '%PAGO DE INTERESES%')
                    ->orWhere('depositante', 'like', '%EFECTIVO / OTROS%');
            })
            ->sum('monto'), 2);

        $this->ingresosGestionAnterior = round((float) DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', function ($join) {
                $join->on('iba.ingreso_bancario_id', '=', 'ib.id')
                    ->where('iba.estado', '!=', 'Anulado');
            })
            ->whereDate('ib.fecha', '>=', $fechaInicio)
            ->whereDate('ib.fecha', '<=', $fechaFin)
            ->where(function ($q) {
                $q->whereNull('iba.departamento_nombre')
                    ->orWhere('iba.departamento_nombre', '')
                    ->orWhere('iba.observacion', 'like', '%gestion anterior%')
                    ->orWhere('iba.observacion', 'like', '%gestión anterior%')
                    ->orWhere('ib.detalle', 'like', '%gestion anterior%')
                    ->orWhere('ib.detalle', 'like', '%gestión anterior%');
            })
            ->sum('ib.monto'), 2);

        $ingresosOrdinarios = max(0, round(
            $this->totalIngresosMes - $this->ingresosSalon - $this->otrosIngresos - $this->ingresosGestionAnterior,
            2
        ));

        $this->chartIngresosEspeciales = [
            'labels' => [
                'Expensas ordinarias',
                'Gestión anterior',
                'Alquiler salón',
                'Otros ingresos',
            ],
            'data' => [
                $ingresosOrdinarios,
                $this->ingresosGestionAnterior,
                $this->ingresosSalon,
                $this->otrosIngresos,
            ],
        ];
    }

    public function cargarEstadoDepartamentos()
    {
        $fechaFin = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $pagados = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('estado', 'Pagado')
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');

        $parciales = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('estado', 'Parcial')
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');

        $pendientes = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('estado', 'Pendiente')
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');

        $noCobrables = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('no_cobrar', 1)
            ->distinct('departamento_nombre')
            ->count('departamento_nombre');

        $this->chartEstadoDepartamentos = [
            'labels' => ['Pagados', 'Parciales', 'Pendientes', 'No cobrables'],
            'data' => [$pagados, $parciales, $pendientes, $noCobrables],
        ];
    }

    public function cargarTopDeudores()
    {
        $fechaFin = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $registros = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->select(
                'departamento_nombre',
                DB::raw('SUM(saldo) as total_deuda'),
                DB::raw('COUNT(*) as meses_deuda')
            )
            ->groupBy('departamento_nombre')
            ->orderByDesc('total_deuda')
            ->limit(10)
            ->get();

        $this->topDeudores = $registros->map(function ($item) {
            return [
                'departamento' => $item->departamento_nombre,
                'total_deuda' => round((float) $item->total_deuda, 2),
                'meses_deuda' => (int) $item->meses_deuda,
            ];
        })->toArray();

        $this->chartTopDeudores = [
            'labels' => $registros->pluck('departamento_nombre')->toArray(),
            'data' => $registros->map(function ($item) {
                return round((float) $item->total_deuda, 2);
            })->toArray(),
        ];
    }

    public function cargarIrregularidades()
    {
        $fechaFin = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $pagosParciales = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('estado', 'Parcial')
            ->count();

        $pendientes = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('estado', 'Pendiente')
            ->where('saldo', '>', 0)
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->count();

        $noCobrables = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where('no_cobrar', 1)
            ->count();

        $ingresosSinComprobante = DB::table('ingresos_bancarios')
            ->whereDate('fecha', '<=', $fechaFin)
            ->where(function ($q) {
                $q->whereNull('numero_comprobante')
                    ->orWhere('numero_comprobante', '')
                    ->orWhere('numero_comprobante', 'like', 'SIN-COMPROBANTE%');
            })
            ->count();

        $egresosSinComprobante = DB::table('gastos')
            ->whereRaw("
                COALESCE(
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
                    DATE(created_at)
                ) <= ?
            ", [$fechaFin])
            ->where(function ($q) {
                $q->whereNull('rutaarchivo')
                    ->orWhereRaw("TRIM(rutaarchivo) = ''");
            })
            ->count();

        $this->chartIrregularidades = [
            'labels' => [
                'Pagos parciales',
                'Pendientes',
                'No cobrables',
                'Ingresos sin comp.',
                'Egresos sin comp.',
            ],
            'data' => [
                $pagosParciales,
                $pendientes,
                $noCobrables,
                $ingresosSinComprobante,
                $egresosSinComprobante,
            ],
        ];

        $this->departamentosIrregulares = DB::table('expensas')
            ->where('fecha_mes', '<=', $fechaFin)
            ->where(function ($q) {
                $q->where('saldo', '>', 0)
                    ->orWhere('estado', 'Parcial')
                    ->orWhere('no_cobrar', 1);
            })
            ->select(
                'departamento_nombre',
                DB::raw('SUM(saldo) as deuda'),
                DB::raw("SUM(CASE WHEN estado = 'Parcial' THEN 1 ELSE 0 END) as parciales"),
                DB::raw("SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) as pendientes"),
                DB::raw("SUM(CASE WHEN no_cobrar = 1 THEN 1 ELSE 0 END) as no_cobrables")
            )
            ->groupBy('departamento_nombre')
            ->orderByDesc('deuda')
            ->limit(12)
            ->get()
            ->map(function ($item) {
                return [
                    'departamento' => $item->departamento_nombre,
                    'deuda' => round((float) $item->deuda, 2),
                    'parciales' => (int) $item->parciales,
                    'pendientes' => (int) $item->pendientes,
                    'no_cobrables' => (int) $item->no_cobrables,
                ];
            })
            ->toArray();
    }

    public function totalEgresosEntreFechas($fechaInicio, $fechaFin)
    {
        return DB::table('gastos')
            ->whereRaw("
                COALESCE(
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                    STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
                    DATE(created_at)
                ) BETWEEN ? AND ?
            ", [$fechaInicio, $fechaFin])
            ->sum('cantidad');
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

    public function nombreMesCorto($mes)
    {
        $meses = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic',
        ];

        return $meses[(int) $mes] ?? $mes;
    }

    public function render()
    {
        return view('livewire.tesoreria.estadisticas-auditoria');
    }
}