<?php

namespace App\Http\Livewire\Tesoreria;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class EstadoDepartamentos extends Component
{
    public $busquedaDepartamento = '';

    public $tipoFiltro = '';

    public $anioFiltro = 2026;

    public $estadoFiltro = 'Todos';

    public $departamentoSeleccionado = '';

    public $tipoSeleccionado = '';

    public $costoSeleccionado = 0;

    public $tratamientoIdSeleccionado = null;

    public $modalDetalle = false;

    public $modalCrearExpensas = false;

    public $anioCrearExpensas = 2025;

    public $desdeMesCrear = 1;

    public $hastaMesCrear = 12;

    public $expensasDetalle = [];

    public $resumenDepartamento = [];

    public $soloIrregulares = false;

    public $modalIrregularidad = false;

    public $irregularidadesDepartamento = [];

    public $modalDividirPago = false;

    public $aplicacionDividirId = null;

    public $pagoDividir = [];

    public $partesDividir = [];

    public $modalAuditoria = false;

    public $auditorNombre = '';

    public $auditorCarnet = '';

    public $auditorCargo = 'Administrador / Auditor';

    public $auditoriaFechaRealizacion;

    public $auditoriaDesdeMes = 8;

    public $auditoriaDesdeAnio = 2024;

    public $auditoriaHastaMes;

    public $auditoriaHastaAnio;

    public $auditoriaTrabajoInicio;

    public $auditoriaTrabajoFin;

    public $auditoriaObservaciones = '';

    public function abrirModalAuditoria()
    {
        $this->modalAuditoria = true;

        $this->auditoriaFechaRealizacion = now()->format('Y-m-d');

        if (! $this->auditoriaHastaMes) {
            $this->auditoriaHastaMes = (int) now()->month;
        }

        if (! $this->auditoriaHastaAnio) {
            $this->auditoriaHastaAnio = (int) now()->year;
        }

        if (! $this->auditoriaTrabajoInicio) {
            $this->auditoriaTrabajoInicio = now()->format('Y-m-d');
        }

        if (! $this->auditoriaTrabajoFin) {
            $this->auditoriaTrabajoFin = now()->format('Y-m-d');
        }
    }

    public function cerrarModalAuditoria()
    {
        $this->modalAuditoria = false;
    }

    public function generarPdfAuditoriaGeneral()
    {
        $this->validate([
            'auditorNombre' => 'required|string|min:3',
            'auditorCarnet' => 'required|string|min:3',
            'auditoriaFechaRealizacion' => 'required|date',
            'auditoriaDesdeMes' => 'required|integer|min:1|max:12',
            'auditoriaDesdeAnio' => 'required|integer|min:2024',
            'auditoriaHastaMes' => 'required|integer|min:1|max:12',
            'auditoriaHastaAnio' => 'required|integer|min:2024',
        ]);

        $fechaInicio = Carbon::create(
            (int) $this->auditoriaDesdeAnio,
            (int) $this->auditoriaDesdeMes,
            1
        )->startOfMonth();

        $fechaFin = Carbon::create(
            (int) $this->auditoriaHastaAnio,
            (int) $this->auditoriaHastaMes,
            1
        )->endOfMonth();

        if ($fechaFin->lt($fechaInicio)) {
            $this->emit('error', 'La fecha final no puede ser menor a la fecha inicial.');

            return;
        }

        $data = $this->prepararAuditoriaGeneral($fechaInicio, $fechaFin);

        $pdf = Pdf::loadView('pdf.auditoria-general-tribeca', [
            'auditor' => [
                'nombre' => $this->auditorNombre,
                'carnet' => $this->auditorCarnet,
                'cargo' => $this->auditorCargo,
                'fecha_realizacion' => $this->auditoriaFechaRealizacion,
                'trabajo_inicio' => $this->auditoriaTrabajoInicio,
                'trabajo_fin' => $this->auditoriaTrabajoFin,
                'observaciones' => $this->auditoriaObservaciones,
            ],
            'rango' => [
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_fin' => $fechaFin->toDateString(),
                'texto_inicio' => $this->nombreMes((int) $fechaInicio->month).' '.$fechaInicio->year,
                'texto_fin' => $this->nombreMes((int) $fechaFin->month).' '.$fechaFin->year,
            ],
            'data' => $data,
            'fechaGeneracion' => now()->format('d/m/Y H:i'),
            'footer' => 'Sistema Tribeca · Auditoría digital · Digitbol · Esrom Obed Andrade Ortiz',
        ])->setPaper('letter', 'landscape');

        $nombreArchivo = 'auditoria-general-tribeca-'.
            $fechaInicio->format('Y-m').'-a-'.
            $fechaFin->format('Y-m').'.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    protected $queryString = [
        'busquedaDepartamento' => ['except' => ''],
        'tipoFiltro' => ['except' => ''],
        'anioFiltro' => ['except' => 2025],
        'estadoFiltro' => ['except' => 'Todos'],
    ];

    public function prepararAuditoriaGeneral(Carbon $fechaInicio, Carbon $fechaFin)
    {
        $fechaInicioStr = $fechaInicio->toDateString();
        $fechaFinStr = $fechaFin->toDateString();

        $totalIngresos = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioStr)
            ->whereDate('fecha', '<=', $fechaFinStr)
            ->sum('monto'), 2);

        $totalEgresos = round((float) DB::table('gastos')
            ->whereRaw("
            COALESCE(
                STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
                DATE(created_at)
            ) BETWEEN ? AND ?
        ", [$fechaInicioStr, $fechaFinStr])
            ->sum('cantidad'), 2);

        $saldoFinal = round($totalIngresos - $totalEgresos, 2);

        $totalAlquilerSalon = round((float) DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', 'iba.ingreso_bancario_id', '=', 'ib.id')
            ->whereDate('ib.fecha', '>=', $fechaInicioStr)
            ->whereDate('ib.fecha', '<=', $fechaFinStr)
            ->where(function ($q) {
                $q->where('iba.tipo_aplicacion', 'like', '%SALON%')
                    ->orWhere('iba.tipo_aplicacion', 'like', '%SALÓN%')
                    ->orWhere('ib.detalle', 'like', '%SALON%')
                    ->orWhere('ib.detalle', 'like', '%SALÓN%');
            })
            ->sum('ib.monto'), 2);

        $totalOtrosIngresos = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioStr)
            ->whereDate('fecha', '<=', $fechaFinStr)
            ->where(function ($q) {
                $q->where('tipo_ingreso', 'Otro ingreso')
                    ->orWhere('depositante', 'like', '%PAGO DE INTERES%')
                    ->orWhere('depositante', 'like', '%PAGO DE INTERESES%')
                    ->orWhere('depositante', 'like', '%EFECTIVO / OTROS%');
            })
            ->sum('monto'), 2);

        $totalGestionAnterior = round((float) DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', function ($join) {
                $join->on('iba.ingreso_bancario_id', '=', 'ib.id')
                    ->where('iba.estado', '!=', 'Anulado');
            })
            ->whereDate('ib.fecha', '>=', $fechaInicioStr)
            ->whereDate('ib.fecha', '<=', $fechaFinStr)
            ->where(function ($q) {
                $q->whereNull('iba.departamento_nombre')
                    ->orWhere('iba.departamento_nombre', '')
                    ->orWhere('iba.observacion', 'like', '%gestion anterior%')
                    ->orWhere('iba.observacion', 'like', '%gestión anterior%')
                    ->orWhere('ib.detalle', 'like', '%gestion anterior%')
                    ->orWhere('ib.detalle', 'like', '%gestión anterior%');
            })
            ->sum('ib.monto'), 2);

        $ingresosSinComprobante = DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioStr)
            ->whereDate('fecha', '<=', $fechaFinStr)
            ->where(function ($q) {
                $q->whereNull('numero_comprobante')
                    ->orWhere('numero_comprobante', '')
                    ->orWhere('numero_comprobante', 'like', 'SIN-COMPROBANTE%');
            })
            ->select('fecha', 'hora', 'depositante', 'numero_comprobante', 'monto', 'detalle')
            ->orderBy('fecha')
            ->get();

        $egresosSinComprobante = DB::table('gastos')
            ->whereRaw("
        COALESCE(
            STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
            STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y'),
            DATE(created_at)
        ) BETWEEN ? AND ?
    ", [$fechaInicioStr, $fechaFinStr])
            ->where(function ($q) {
                $q->whereNull('rutaarchivo')
                    ->orWhereRaw("TRIM(rutaarchivo) = ''");
            })
            ->select(
                'fechainicio',
                'fecha',
                'empresa',
                'tipo',
                'cantidad',
                'pagado',
                'estado',
                'rutaarchivo',
                'created_at'
            )
            ->orderBy('created_at')
            ->get();

        $departamentosResumen = $this->auditoriaResumenDepartamentos($fechaInicioStr, $fechaFinStr);

        $irregularidades = $this->auditoriaIrregularidadesDepartamentos($fechaInicioStr, $fechaFinStr);

        return [
            'total_ingresos' => $totalIngresos,
            'total_egresos' => $totalEgresos,
            'saldo_final' => $saldoFinal,
            'total_alquiler_salon' => $totalAlquilerSalon,
            'total_otros_ingresos' => $totalOtrosIngresos,
            'total_gestion_anterior' => $totalGestionAnterior,
            'ingresos_sin_comprobante' => $ingresosSinComprobante,
            'egresos_sin_comprobante' => $egresosSinComprobante,
            'departamentos_resumen' => $departamentosResumen,
            'irregularidades' => $irregularidades,
            'total_departamentos_revisados' => count($departamentosResumen),
            'departamentos_con_irregularidad' => collect($departamentosResumen)->where('tiene_irregularidad', true)->count(),
            'departamentos_sin_irregularidad' => collect($departamentosResumen)->where('tiene_irregularidad', false)->count(),
        ];
    }

    public function auditoriaIrregularidadesDepartamentos($fechaInicioStr, $fechaFinStr)
    {
        $irregularidades = [];

        $expensas = DB::table('expensas')
            ->whereBetween('fecha_mes', [$fechaInicioStr, $fechaFinStr])
            ->where(function ($q) {
                $q->where('saldo', '>', 0)
                    ->orWhere('estado', 'Parcial')
                    ->orWhere('estado', 'Pendiente');
            })
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->select(
                'departamento_nombre',
                'anio',
                'mes',
                'monto_expensa',
                'monto_pagado',
                'saldo',
                'estado',
                'tipo_estado'
            )
            ->orderBy('departamento_nombre')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        foreach ($expensas as $exp) {
            $irregularidades[] = [
                'departamento' => $exp->departamento_nombre,
                'tipo' => $exp->estado === 'Parcial' ? 'Pago parcial' : 'Saldo pendiente',
                'periodo' => $this->nombreMes((int) $exp->mes).' '.$exp->anio,
                'detalle' => 'Monto expensa Bs '.number_format((float) $exp->monto_expensa, 2).
                    ', pagado Bs '.number_format((float) $exp->monto_pagado, 2).
                    ', saldo Bs '.number_format((float) $exp->saldo, 2),
                'monto' => round((float) $exp->saldo, 2),
                'nivel' => $exp->estado === 'Parcial' ? 'Media' : 'Alta',
            ];
        }

        return $irregularidades;
    }

    public function auditoriaResumenDepartamentos($fechaInicioStr, $fechaFinStr)
    {
        $departamentos = DB::table('tratamientos')
            ->select('nombre')
            ->orderBy('nombre')
            ->get();

        $resultado = [];

        foreach ($departamentos as $dep) {
            $expensas = DB::table('expensas')
                ->where('departamento_nombre', $dep->nombre)
                ->whereBetween('fecha_mes', [$fechaInicioStr, $fechaFinStr])
                ->select(
                    'id',
                    'anio',
                    'mes',
                    'fecha_mes',
                    'monto_expensa',
                    'monto_con_descuento',
                    'fecha_limite_descuento',
                    'monto_pagado',
                    'saldo',
                    'estado',
                    'tipo_estado',
                    'aplica_descuento',
                    'no_cobrar',
                    'motivo_no_cobro'
                )
                ->orderBy('fecha_mes')
                ->get();

            $totalDeuda = round((float) $expensas->sum('saldo'), 2);
            $mesesConDeuda = $expensas->where('saldo', '>', 0)->count();
            $mesesParciales = $expensas->where('estado', 'Parcial')->count();
            $mesesPendientes = $expensas->where('estado', 'Pendiente')->count();
            $mesesNoCobrables = $expensas->where('no_cobrar', 1)->count();

            $pagosFueraFecha = 0;
            $pagosConDescuento = 0;
            $descuentosObservados = 0;
            $pagosAnticipadosOFueraMes = 0;

            foreach ($expensas as $exp) {
                $pagos = DB::table('ingresos_bancarios_aplicaciones as iba')
                    ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
                    ->where('iba.expensa_id', $exp->id)
                    ->where('iba.estado', '!=', 'Anulado')
                    ->select('ib.fecha', 'iba.estado_pago', 'iba.anio_pago', 'iba.mes_pago', 'iba.monto')
                    ->get();

                foreach ($pagos as $pago) {
                    if ($exp->fecha_limite_descuento && Carbon::parse($pago->fecha)->gt(Carbon::parse($exp->fecha_limite_descuento))) {
                        $pagosFueraFecha++;
                    }

                    if (strtoupper($pago->estado_pago ?? '') === 'DESCUENTO PRONTO PAGO') {
                        $pagosConDescuento++;
                    }

                    if (
                        (int) $pago->anio_pago !== (int) $exp->anio ||
                        (int) $pago->mes_pago !== (int) $exp->mes
                    ) {
                        $pagosAnticipadosOFueraMes++;
                    }
                }

                if (
                    (int) ($exp->aplica_descuento ?? 0) === 1 &&
                    $exp->monto_pagado > 0 &&
                    $exp->estado !== 'Pagado' &&
                    $exp->saldo > 0
                ) {
                    $descuentosObservados++;
                }
            }

            $tieneIrregularidad =
                $totalDeuda > 0 ||
                $mesesParciales > 0 ||
                $mesesPendientes > 0 ||
                $pagosFueraFecha > 0 ||
                $descuentosObservados > 0 ||
                $pagosAnticipadosOFueraMes > 0;

            $resultado[] = [
                'departamento' => $dep->nombre,
                'total_deuda' => $totalDeuda,
                'meses_con_deuda' => $mesesConDeuda,
                'meses_parciales' => $mesesParciales,
                'meses_pendientes' => $mesesPendientes,
                'meses_no_cobrables' => $mesesNoCobrables,
                'pagos_fuera_fecha' => $pagosFueraFecha,
                'pagos_con_descuento' => $pagosConDescuento,
                'descuentos_observados' => $descuentosObservados,
                'pagos_anticipados_fuera_mes' => $pagosAnticipadosOFueraMes,
                'tiene_irregularidad' => $tieneIrregularidad,
            ];
        }

        return $resultado;
    }

    public function limpiarNombreArchivo($texto)
    {
        $texto = strtoupper(trim($texto));
        $texto = preg_replace('/[^A-Z0-9]+/', '-', $texto);
        $texto = trim($texto, '-');

        return strtolower($texto);
    }

    public function prepararReporteDepartamento($departamentoNombre, $desde, $hasta)
    {
        $expensas = DB::table('expensas as e')
            ->where('e.departamento_nombre', $departamentoNombre)
            ->whereBetween('e.fecha_mes', [$desde, $hasta])
            ->select(
                'e.id',
                'e.departamento_nombre',
                'e.anio',
                'e.mes',
                'e.fecha_mes',
                'e.monto_expensa',
                'e.descuento_pronto_pago',
                'e.monto_con_descuento',
                'e.fecha_limite_descuento',
                'e.aplica_descuento',
                'e.monto_pagado',
                'e.saldo',
                'e.estado',
                'e.tipo_estado',
                'e.no_cobrar',
                'e.estado_cobro',
                'e.motivo_no_cobro',
                'e.observacion'
            )
            ->orderBy('e.fecha_mes')
            ->get();

        $resultado = [];

        foreach ($expensas as $expensa) {
            $pagos = DB::table('ingresos_bancarios_aplicaciones as iba')
                ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
                ->where('iba.expensa_id', $expensa->id)
                ->where('iba.estado', '!=', 'Anulado')
                ->select(
                    'iba.id',
                    'iba.monto',
                    'iba.estado_pago',
                    'iba.observacion',
                    'ib.fecha',
                    'ib.hora',
                    'ib.fecha_hora',
                    'ib.depositante',
                    'ib.numero_comprobante',
                    'ib.monto as monto_ingreso'
                )
                ->orderBy('ib.fecha')
                ->orderBy('ib.hora')
                ->orderBy('iba.id')
                ->get();

            $resultado[] = [
                'id' => $expensa->id,
                'departamento_nombre' => $expensa->departamento_nombre,
                'anio' => $expensa->anio,
                'mes' => $expensa->mes,
                'mes_nombre' => $this->nombreMes((int) $expensa->mes),
                'fecha_mes' => $expensa->fecha_mes,
                'monto_expensa' => round((float) $expensa->monto_expensa, 2),
                'descuento_pronto_pago' => round((float) ($expensa->descuento_pronto_pago ?? 0), 2),
                'monto_con_descuento' => round((float) ($expensa->monto_con_descuento ?? 0), 2),
                'fecha_limite_descuento' => $expensa->fecha_limite_descuento,
                'aplica_descuento' => (int) ($expensa->aplica_descuento ?? 0),
                'monto_pagado' => round((float) ($expensa->monto_pagado ?? 0), 2),
                'saldo' => round((float) ($expensa->saldo ?? 0), 2),
                'estado' => $expensa->estado,
                'tipo_estado' => $expensa->tipo_estado,
                'no_cobrar' => (int) ($expensa->no_cobrar ?? 0),
                'estado_cobro' => $expensa->estado_cobro ?? null,
                'motivo_no_cobro' => $expensa->motivo_no_cobro ?? null,
                'observacion' => $expensa->observacion,
                'pagos' => $pagos->map(function ($pago) {
                    return [
                        'fecha' => $pago->fecha,
                        'hora' => $pago->hora,
                        'fecha_hora' => $pago->fecha_hora,
                        'depositante' => $pago->depositante,
                        'numero_comprobante' => $pago->numero_comprobante,
                        'monto' => round((float) $pago->monto, 2),
                        'estado_pago' => $pago->estado_pago,
                        'observacion' => $pago->observacion,
                    ];
                })->toArray(),
            ];
        }

        $totalExpensas = collect($resultado)->sum('monto_expensa');
        $totalPagado = collect($resultado)->sum('monto_pagado');
        $totalSaldo = collect($resultado)->sum('saldo');

        $resumen = [
            'total_expensas' => round($totalExpensas, 2),
            'total_pagado' => round($totalPagado, 2),
            'total_saldo' => round($totalSaldo, 2),
            'cantidad_meses' => count($resultado),
            'pagadas' => collect($resultado)->where('estado', 'Pagado')->count(),
            'parciales' => collect($resultado)->where('estado', 'Parcial')->count(),
            'pendientes' => collect($resultado)->where('estado', 'Pendiente')->count(),
            'no_cobrables' => collect($resultado)->where('no_cobrar', 1)->count(),
        ];

        return [
            'expensas' => $resultado,
            'resumen' => $resumen,
        ];
    }

    public function generarPdfDepartamentoCompleto($departamentoNombre)
    {
        $departamentoNombre = trim($departamentoNombre);

        if ($departamentoNombre === '') {
            $this->emit('error', 'No se encontró el departamento.');

            return;
        }

        $desde = '2024-08-01';
        $hasta = now()->endOfMonth()->toDateString();

        $data = $this->prepararReporteDepartamento($departamentoNombre, $desde, $hasta);

        $pdf = Pdf::loadView('pdf.reporte-departamento', [
            'titulo' => 'Reporte completo de departamento',
            'subtitulo' => 'Desde agosto 2024 hasta '.now()->format('d/m/Y'),
            'departamento' => $departamentoNombre,
            'desde' => $desde,
            'hasta' => $hasta,
            'expensas' => $data['expensas'],
            'resumen' => $data['resumen'],
            'footer' => 'Sistema Tribeca · Digitbol · Esrom Obed Andrade Ortiz',
            'fechaGeneracion' => now()->format('d/m/Y H:i'),
        ])->setPaper('letter', 'landscape');

        $nombreArchivo = 'reporte-completo-'.$this->limpiarNombreArchivo($departamentoNombre).'.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    public function generarPdfDepartamentoAnual($departamentoNombre, $anio)
    {
        $departamentoNombre = trim($departamentoNombre);
        $anio = (int) $anio;

        if ($departamentoNombre === '') {
            $this->emit('error', 'No se encontró el departamento.');

            return;
        }

        $desde = Carbon::create($anio, 1, 1)->startOfMonth()->toDateString();
        $hasta = Carbon::create($anio, 12, 1)->endOfMonth()->toDateString();

        $data = $this->prepararReporteDepartamento($departamentoNombre, $desde, $hasta);

        $pdf = Pdf::loadView('pdf.reporte-departamento', [
            'titulo' => 'Reporte anual de departamento',
            'subtitulo' => 'Gestión '.$anio,
            'departamento' => $departamentoNombre,
            'desde' => $desde,
            'hasta' => $hasta,
            'expensas' => $data['expensas'],
            'resumen' => $data['resumen'],
            'footer' => 'Sistema Tribeca · Digitbol · Esrom Obed Andrade Ortiz',
            'fechaGeneracion' => now()->format('d/m/Y H:i'),
        ])->setPaper('letter', 'landscape');

        $nombreArchivo = 'reporte-'.$this->limpiarNombreArchivo($departamentoNombre).'-'.$anio.'.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    public function abrirModalDividirPago($aplicacionId)
    {
        $aplicacion = DB::table('ingresos_bancarios_aplicaciones as iba')
            ->leftJoin('expensas as e', 'e.id', '=', 'iba.expensa_id')
            ->leftJoin('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
            ->where('iba.id', $aplicacionId)
            ->where('iba.estado', '!=', 'Anulado')
            ->select(
                'iba.id',
                'iba.ingreso_bancario_id',
                'iba.expensa_id',
                'iba.departamento_nombre',
                'iba.fecha_inicio_pago',
                'iba.anio_pago',
                'iba.mes_pago',
                'iba.monto',
                'iba.estado_pago',
                'iba.observacion',
                'ib.fecha',
                'ib.hora',
                'ib.depositante',
                'ib.numero_comprobante',
                'e.anio',
                'e.mes',
                'e.fecha_mes'
            )
            ->first();

        if (! $aplicacion) {
            $this->emit('error', 'No se encontró el pago aplicado.');

            return;
        }

        if (! $aplicacion->expensa_id) {
            $this->emit('error', 'Este pago no está asociado a una expensa.');

            return;
        }

        $this->aplicacionDividirId = $aplicacion->id;

        $this->pagoDividir = [
            'id' => $aplicacion->id,
            'ingreso_bancario_id' => $aplicacion->ingreso_bancario_id,
            'expensa_id' => $aplicacion->expensa_id,
            'departamento_nombre' => $aplicacion->departamento_nombre,
            'fecha_inicio_pago' => $aplicacion->fecha_inicio_pago,
            'anio' => $aplicacion->anio_pago ?? $aplicacion->anio,
            'mes' => $aplicacion->mes_pago ?? $aplicacion->mes,
            'mes_nombre' => $this->nombreMes((int) ($aplicacion->mes_pago ?? $aplicacion->mes)),
            'monto' => round((float) $aplicacion->monto, 2),
            'estado_pago' => $aplicacion->estado_pago,
            'observacion' => $aplicacion->observacion,
            'depositante' => $aplicacion->depositante,
            'numero_comprobante' => $aplicacion->numero_comprobante,
        ];

        /*
            Por defecto:
            Si es 300, lo divide en 100 + 100 + 100.
            Si no, crea dos partes.
        */
        if (round((float) $aplicacion->monto, 2) == 300.00) {
            $this->partesDividir = [
                ['monto' => 100.00, 'observacion' => 'Parte 1 de pago dividido'],
                ['monto' => 100.00, 'observacion' => 'Parte 2 de pago dividido'],
                ['monto' => 100.00, 'observacion' => 'Parte 3 de pago dividido'],
            ];
        } else {
            $mitad = round(((float) $aplicacion->monto) / 2, 2);
            $resto = round(((float) $aplicacion->monto) - $mitad, 2);

            $this->partesDividir = [
                ['monto' => $mitad, 'observacion' => 'Parte 1 de pago dividido'],
                ['monto' => $resto, 'observacion' => 'Parte 2 de pago dividido'],
            ];
        }

        $this->modalDividirPago = true;
    }

    public function cerrarModalDividirPago()
    {
        $this->modalDividirPago = false;
        $this->aplicacionDividirId = null;
        $this->pagoDividir = [];
        $this->partesDividir = [];
    }

    public function agregarParteDividir()
    {
        $this->partesDividir[] = [
            'monto' => '',
            'observacion' => 'Parte de pago dividido',
        ];
    }

    public function quitarParteDividir($index)
    {
        unset($this->partesDividir[$index]);
        $this->partesDividir = array_values($this->partesDividir);
    }

    public function dividirRapidoPago($tipo)
    {
        $montoOriginal = round((float) ($this->pagoDividir['monto'] ?? 0), 2);

        if ($montoOriginal <= 0) {
            return;
        }

        if ($tipo === '100') {
            $this->partesDividir = [];

            $restante = $montoOriginal;
            $contador = 1;

            while ($restante > 0) {
                $monto = min(100, $restante);

                $this->partesDividir[] = [
                    'monto' => round($monto, 2),
                    'observacion' => 'Parte '.$contador.' de pago dividido',
                ];

                $restante = round($restante - $monto, 2);
                $contador++;
            }

            return;
        }

        if ($tipo === '200_100') {
            if ($montoOriginal < 300) {
                $this->emit('error', 'El monto original debe ser al menos Bs 300 para dividir en 200 y 100.');

                return;
            }

            $this->partesDividir = [
                ['monto' => 200.00, 'observacion' => 'Parte 1 de pago dividido'],
                ['monto' => round($montoOriginal - 200.00, 2), 'observacion' => 'Parte 2 de pago dividido'],
            ];
        }
    }

    public function guardarDivisionPago()
    {
        if (! $this->aplicacionDividirId || empty($this->pagoDividir)) {
            $this->emit('error', 'No hay pago seleccionado para dividir.');

            return;
        }

        $aplicacionOriginal = DB::table('ingresos_bancarios_aplicaciones')
            ->where('id', $this->aplicacionDividirId)
            ->where('estado', '!=', 'Anulado')
            ->first();

        if (! $aplicacionOriginal) {
            $this->emit('error', 'El pago original ya no existe o fue anulado.');

            return;
        }

        $montoOriginal = round((float) $aplicacionOriginal->monto, 2);

        $partes = collect($this->partesDividir)
            ->map(function ($parte) {
                return [
                    'monto' => round((float) ($parte['monto'] ?? 0), 2),
                    'observacion' => trim($parte['observacion'] ?? ''),
                ];
            })
            ->filter(function ($parte) {
                return $parte['monto'] > 0;
            })
            ->values();

        if ($partes->count() < 2) {
            $this->emit('error', 'Debes crear al menos dos partes para dividir el pago.');

            return;
        }

        $totalPartes = round((float) $partes->sum('monto'), 2);

        if (abs($totalPartes - $montoOriginal) > 0.01) {
            $this->emit('error', 'La suma de las partes debe ser igual al monto original.');

            return;
        }

        DB::transaction(function () use ($aplicacionOriginal, $partes) {
            /*
                Anulamos la aplicación original para mantener historial.
            */
            DB::table('ingresos_bancarios_aplicaciones')
                ->where('id', $aplicacionOriginal->id)
                ->update([
                    'estado' => 'Anulado',
                    'observacion' => trim(($aplicacionOriginal->observacion ?? '').' | Anulado por división de pago'),
                    'updated_at' => now(),
                ]);

            /*
                Creamos las partes nuevas sobre la misma expensa.
            */
            foreach ($partes as $index => $parte) {
                DB::table('ingresos_bancarios_aplicaciones')->insert([
                    'ingreso_bancario_id' => $aplicacionOriginal->ingreso_bancario_id,
                    'expensa_id' => $aplicacionOriginal->expensa_id,
                    'tipo_aplicacion' => $aplicacionOriginal->tipo_aplicacion,
                    'codigo_departamento' => $aplicacionOriginal->codigo_departamento,
                    'departamento_nombre' => $aplicacionOriginal->departamento_nombre,
                    'fecha_inicio_pago' => $aplicacionOriginal->fecha_inicio_pago,
                    'anio_pago' => $aplicacionOriginal->anio_pago,
                    'mes_pago' => $aplicacionOriginal->mes_pago,
                    'monto' => $parte['monto'],
                    'pago_id' => $aplicacionOriginal->pago_id,
                    'estado' => 'Confirmado',
                    'estado_pago' => $aplicacionOriginal->estado_pago,
                    'fecha_aplicacion' => now(),
                    'observacion' => trim(($parte['observacion'] ?: 'Pago dividido').' | División del pago #'.$aplicacionOriginal->id),
                    'iduser' => Auth::id(),
                    'nameuser' => Auth::user()->name ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            /*
                Recalcular la expensa.
                Este helper es el que ya usamos para mover pagos.
            */
            $this->recalcularExpensaDesdeAplicaciones($aplicacionOriginal->expensa_id);

            /*
                Recalcular el ingreso bancario.
            */
            $this->recalcularIngresoBancarioDesdeAplicaciones($aplicacionOriginal->ingreso_bancario_id);
        });

        $this->cerrarModalDividirPago();
        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'Pago dividido correctamente.');
    }

    public function recalcularIngresoBancarioDesdeAplicaciones($ingresoId)
    {
        $ingreso = DB::table('ingresos_bancarios')
            ->where('id', $ingresoId)
            ->first();

        if (! $ingreso) {
            return;
        }

        $totalAplicado = (float) DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $ingresoId)
            ->where('estado', '!=', 'Anulado')
            ->sum('monto');

        $saldo = round((float) $ingreso->monto - $totalAplicado, 2);

        if ($totalAplicado <= 0) {
            $estado = 'Pendiente';
        } elseif ($saldo > 0) {
            $estado = 'Aplicado parcial';
        } else {
            $estado = 'Aplicado completo';
            $saldo = 0;
        }

        DB::table('ingresos_bancarios')
            ->where('id', $ingresoId)
            ->update([
                'monto_aplicado' => round($totalAplicado, 2),
                'saldo_pendiente' => $saldo,
                'estado' => $estado,
                'updated_at' => now(),
            ]);
    }

    public function recalcularExpensaDesdeAplicaciones($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            return;
        }

        $totalPagado = round((float) DB::table('ingresos_bancarios_aplicaciones')
            ->where('expensa_id', $expensaId)
            ->where('estado', '!=', 'Anulado')
            ->sum('monto'), 2);

        $primeraFechaPago = DB::table('ingresos_bancarios_aplicaciones as iba')
            ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
            ->where('iba.expensa_id', $expensaId)
            ->where('iba.estado', '!=', 'Anulado')
            ->min('ib.fecha');

        /*
            Si está marcado como no cobrable, no debe generar deuda.
        */
        if ((int) ($expensa->no_cobrar ?? 0) === 1) {
            DB::table('expensas')
                ->where('id', $expensaId)
                ->update([
                    'monto_pagado' => $totalPagado,
                    'saldo' => 0.00,
                    'estado' => 'Pagado',
                    'updated_at' => now(),
                ]);

            return;
        }

        $montoExpensa = round((float) $expensa->monto_expensa, 2);

        $montoConDescuento = round((float) ($expensa->monto_con_descuento ?? 0), 2);

        if ($montoConDescuento <= 0) {
            $montoConDescuento = max(0, $montoExpensa - 100.00);
        }

        $montoObjetivo = $montoExpensa;
        $tipoEstado = null;

        if ($primeraFechaPago) {
            $fechaPagoCarbon = \Carbon\Carbon::parse($primeraFechaPago)->startOfDay();
            $fechaMesCarbon = \Carbon\Carbon::parse($expensa->fecha_mes)->startOfMonth();

            $expensaDesde2025 = $fechaMesCarbon->toDateString() >= '2025-01-01';

            /*
                Fecha límite correcta:
                Septiembre 2025 -> 10/10/2025
                Octubre 2025 -> 10/11/2025
                Si el 10 cae domingo, permite el 11.
            */
            $fechaLimite = $fechaMesCarbon->copy()->addMonth()->day(10);

            if ($fechaLimite->isSunday()) {
                $fechaLimite->addDay();
            }

            $pagoDentroDeFecha = $fechaPagoCarbon->lte($fechaLimite);

            /*
                Verificar deuda anterior real.
                No cuenta:
                - no_cobrar = 1
                - agosto 2024 si septiembre 2024 ya tiene pago
            */
            $septiembre2024TienePago = DB::table('expensas')
                ->where('departamento_nombre', $expensa->departamento_nombre)
                ->where('fecha_mes', '2024-09-01')
                ->where(function ($q) {
                    $q->where('estado', 'Pagado')
                        ->orWhere('monto_pagado', '>', 0);
                })
                ->exists();

            $tieneDeudaAnterior = DB::table('expensas')
                ->where('departamento_nombre', $expensa->departamento_nombre)
                ->where('fecha_mes', '<', $expensa->fecha_mes)
                ->where('saldo', '>', 0)
                ->where('estado', '!=', 'Pagado')
                ->where(function ($q) {
                    $q->whereNull('no_cobrar')
                        ->orWhere('no_cobrar', 0);
                })
                ->where(function ($q) use ($septiembre2024TienePago) {
                    if ($septiembre2024TienePago) {
                        $q->where('fecha_mes', '!=', '2024-08-01');
                    }
                })
                ->exists();

            /*
                Si pagó dentro de fecha y cubre Bs 200,
                se debe tomar como descuento pronto pago.
            */
            if (
                (int) ($expensa->aplica_descuento ?? 0) === 1 &&
                $expensaDesde2025 &&
                $pagoDentroDeFecha &&
                ! $tieneDeudaAnterior &&
                $totalPagado >= $montoConDescuento
            ) {
                $montoObjetivo = $montoConDescuento;
                $tipoEstado = 'Descuento pronto pago';
            }
        }

        $saldo = round(max(0, $montoObjetivo - $totalPagado), 2);

        if ($totalPagado <= 0) {
            $estado = 'Pendiente';
            $tipoEstado = null;
        } elseif ($saldo > 0) {
            $estado = 'Parcial';

            if (! $tipoEstado) {
                $tipoEstado = 'Parcial';
            }
        } else {
            $estado = 'Pagado';

            if (! $tipoEstado) {
                $tipoEstado = 'Pagado';
            }
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->update([
                'monto_pagado' => $totalPagado,
                'saldo' => $saldo,
                'estado' => $estado,
                'tipo_estado' => $tipoEstado,
                'updated_at' => now(),
            ]);

        /*
            También actualiza las aplicaciones si corresponde descuento.
        */
        if ($tipoEstado === 'Descuento pronto pago') {
            DB::table('ingresos_bancarios_aplicaciones')
                ->where('expensa_id', $expensaId)
                ->where('estado', '!=', 'Anulado')
                ->update([
                    'estado_pago' => 'Descuento pronto pago',
                    'updated_at' => now(),
                ]);
        }
    }

    public function moverPagoAplicado($aplicacionId, $direccion)
    {
        $aplicacion = DB::table('ingresos_bancarios_aplicaciones')
            ->where('id', $aplicacionId)
            ->where('estado', '!=', 'Anulado')
            ->first();

        if (! $aplicacion) {
            $this->emit('error', 'No se encontró el pago aplicado.');

            return;
        }

        if (! $aplicacion->expensa_id) {
            $this->emit('error', 'Este pago no está asociado a una expensa.');

            return;
        }

        $expensaActual = DB::table('expensas')
            ->where('id', $aplicacion->expensa_id)
            ->first();

        if (! $expensaActual) {
            $this->emit('error', 'No se encontró la expensa actual.');

            return;
        }

        if (! in_array($direccion, ['arriba', 'abajo'])) {
            $this->emit('error', 'Dirección no válida.');

            return;
        }

        $queryDestino = DB::table('expensas')
            ->where('departamento_nombre', $expensaActual->departamento_nombre);

        if ($direccion === 'arriba') {
            $queryDestino->where('fecha_mes', '<', $expensaActual->fecha_mes)
                ->orderByDesc('fecha_mes');
        } else {
            $queryDestino->where('fecha_mes', '>', $expensaActual->fecha_mes)
                ->orderBy('fecha_mes');
        }

        $expensaDestino = $queryDestino->first();

        if (! $expensaDestino) {
            $this->emit('error', 'No existe una expensa para mover el pago en esa dirección.');

            return;
        }

        if ((int) ($expensaDestino->no_cobrar ?? 0) === 1) {
            $this->emit('error', 'No se puede mover el pago a una expensa marcada como no cobrable.');

            return;
        }

        DB::transaction(function () use ($aplicacion, $expensaActual, $expensaDestino) {

            DB::table('ingresos_bancarios_aplicaciones')
                ->where('id', $aplicacion->id)
                ->update([
                    'expensa_id' => $expensaDestino->id,
                    'departamento_nombre' => $expensaDestino->departamento_nombre,
                    'fecha_inicio_pago' => $expensaDestino->fecha_mes,
                    'anio_pago' => $expensaDestino->anio,
                    'mes_pago' => $expensaDestino->mes,
                    'observacion' => trim(($aplicacion->observacion ?? '').' | Pago movido manualmente'),
                    'updated_at' => now(),
                ]);

            $this->recalcularExpensaDesdeAplicaciones($expensaActual->id);
            $this->recalcularExpensaDesdeAplicaciones($expensaDestino->id);
        });

        $this->cargarDetalleDepartamento();

    }

    public function detectarIrregularidadDepartamento($departamentoNombre)
    {
        /*
            Reglas:
            - Desde septiembre 2024 en adelante.
            - Agosto 2024 no se toma como irregular si septiembre ya tiene pago.
            - Irregular = tiene un mes posterior pagado, pero uno anterior pendiente.
        */

        $fechaInicio = '2024-09-01';

        if ((int) $this->anioFiltro > 2024) {
            $fechaInicio = $this->anioFiltro.'-01-01';
        }

        $fechaFin = $this->anioFiltro.'-12-01';

        $expensas = DB::table('expensas')
            ->where('departamento_nombre', $departamentoNombre)
            ->whereBetween('fecha_mes', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_mes')
            ->get();

        if ($expensas->count() === 0) {
            return [
                'es_irregular' => false,
                'cantidad' => 0,
                'detalle' => [],
            ];
        }

        $detalle = [];
        $hayMesPendienteAnterior = false;
        $mesesPendientesAnteriores = [];

        foreach ($expensas as $expensa) {
            $estaPagado = $expensa->estado === 'Pagado' || (float) $expensa->saldo <= 0;
            $tienePago = (float) $expensa->monto_pagado > 0;

            if (! $estaPagado) {
                $hayMesPendienteAnterior = true;

                $mesesPendientesAnteriores[] = [
                    'id' => $expensa->id,
                    'fecha_mes' => $expensa->fecha_mes,
                    'mes' => $this->nombreMes($expensa->mes),
                    'anio' => $expensa->anio,
                    'monto_expensa' => (float) $expensa->monto_expensa,
                    'monto_pagado' => (float) $expensa->monto_pagado,
                    'saldo' => (float) $expensa->saldo,
                    'estado' => $expensa->estado,
                ];
            }

            if (($estaPagado || $tienePago) && $hayMesPendienteAnterior) {
                foreach ($mesesPendientesAnteriores as $pendiente) {
                    $detalle[] = [
                        'expensa_pendiente_id' => $pendiente['id'],
                        'mes_pendiente' => $pendiente['mes'].' '.$pendiente['anio'],
                        'fecha_mes_pendiente' => $pendiente['fecha_mes'],
                        'saldo_pendiente' => $pendiente['saldo'],
                        'estado_pendiente' => $pendiente['estado'],
                        'mes_pagado_posterior' => $this->nombreMes($expensa->mes).' '.$expensa->anio,
                        'fecha_mes_pagado_posterior' => $expensa->fecha_mes,
                        'monto_pagado_posterior' => (float) $expensa->monto_pagado,
                    ];
                }

                break;
            }
        }

        return [
            'es_irregular' => count($detalle) > 0,
            'cantidad' => count($detalle),
            'detalle' => $detalle,
        ];
    }

    public function verIrregularidad($departamentoNombre)
    {
        $this->departamentoSeleccionado = $departamentoNombre;

        $resultado = $this->detectarIrregularidadDepartamento($departamentoNombre);

        $this->irregularidadesDepartamento = $resultado['detalle'];

        $this->modalIrregularidad = true;
    }

    public function eliminarExpensaIrregular($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        $tieneAplicaciones = DB::table('ingresos_bancarios_aplicaciones')
            ->where('expensa_id', $expensaId)
            ->where('estado', '!=', 'Anulado')
            ->exists();

        if ($tieneAplicaciones || (float) $expensa->monto_pagado > 0) {
            $this->emit('error', 'No se puede eliminar porque esta expensa tiene pagos aplicados.');

            return;
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->delete();

        $this->verIrregularidad($this->departamentoSeleccionado);
        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'Expensa eliminada correctamente.');
    }

    public function abrirDetalle($departamentoNombre)
    {
        $departamento = DB::table('tratamientos')
            ->where('nombre', $departamentoNombre)
            ->first();

        if (! $departamento) {
            $this->emit('error', 'No se encontró el departamento.');

            return;
        }

        $this->departamentoSeleccionado = $departamento->nombre;
        $this->tratamientoIdSeleccionado = $departamento->id;
        $this->costoSeleccionado = (float) $departamento->costo;
        $this->tipoSeleccionado = $departamento->TIPO ?? 'Sin tipo';

        $this->cargarDetalleDepartamento();

        $this->modalDetalle = true;
    }

    public function cargarDetalleDepartamento()
    {
        if (! $this->departamentoSeleccionado) {
            $this->expensasDetalle = [];
            $this->resumenDepartamento = [];

            return;
        }

        /*
            Regla especial 2024:
            Si septiembre 2024 está pagado o tiene algún pago,
            agosto 2024 se muestra, pero no se suma como deuda.
        */
        $septiembre2024TienePago = DB::table('expensas')
            ->where('departamento_nombre', $this->departamentoSeleccionado)
            ->where('fecha_mes', '2024-09-01')
            ->where(function ($q) {
                $q->where('estado', 'Pagado')
                    ->orWhere('monto_pagado', '>', 0);
            })
            ->exists();

        $expensas = DB::table('expensas as e')
            ->where('e.departamento_nombre', $this->departamentoSeleccionado)
            ->where('e.fecha_mes', '>=', '2024-08-01')
            ->when($this->anioFiltro, function ($q) {
                $q->where('e.anio', $this->anioFiltro);
            })
            ->orderBy('e.fecha_mes')
            ->get();

        $detalle = [];

        foreach ($expensas as $expensa) {
            $aplicaciones = DB::table('ingresos_bancarios_aplicaciones as iba')
                ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
                ->where('iba.expensa_id', $expensa->id)
                ->where('iba.estado', '!=', 'Anulado')
                ->select(
                    'iba.id',
                    'iba.monto',
                    'iba.estado',
                    'iba.estado_pago',
                    'iba.observacion',
                    'ib.fecha',
                    'ib.hora',
                    'ib.fecha_hora',
                    'ib.depositante',
                    'ib.numero_comprobante',
                    'ib.monto as monto_ingreso',
                    'ib.estado as estado_ingreso'
                )
                ->orderBy('ib.fecha')
                ->orderBy('ib.hora')
                ->get();

            $ignorarSaldoAgosto = false;

            if (
                $expensa->fecha_mes === '2024-08-01' &&
                $septiembre2024TienePago
            ) {
                $ignorarSaldoAgosto = true;
            }

            $diagnostico = $this->diagnosticarExpensaDetalle(
                $expensa,
                $aplicaciones,
                $ignorarSaldoAgosto
            );

            $saldoContable = $ignorarSaldoAgosto ? 0 : (float) $expensa->saldo;

            $detalle[] = [
                'id' => $expensa->id,
                'fecha_mes' => $expensa->fecha_mes,
                'anio' => $expensa->anio,
                'mes' => $expensa->mes,
                'mes_nombre' => $this->nombreMes($expensa->mes),
                'monto_expensa' => (float) $expensa->monto_expensa,
                'descuento_pronto_pago' => (float) ($expensa->descuento_pronto_pago ?? 0),
                'monto_con_descuento' => (float) ($expensa->monto_con_descuento ?? $expensa->monto_expensa),
                'fecha_limite_descuento' => $expensa->fecha_limite_descuento,
                'aplica_descuento' => (int) ($expensa->aplica_descuento ?? 0),
                'monto_pagado' => (float) $expensa->monto_pagado,
                'saldo' => (float) $expensa->saldo,
                'saldo_contable' => $saldoContable,
                'estado' => $expensa->estado,
                'tipo_estado' => $expensa->tipo_estado,
                'observacion' => $expensa->observacion,
                'ignorar_saldo_agosto' => $ignorarSaldoAgosto,
                'aplicaciones' => $aplicaciones->map(function ($a) {
                    return [
                        'id' => $a->id,
                        'fecha' => $a->fecha,
                        'hora' => $a->hora,
                        'fecha_hora' => $a->fecha_hora,
                        'depositante' => $a->depositante,
                        'numero_comprobante' => $a->numero_comprobante,
                        'monto' => (float) $a->monto,
                        'monto_ingreso' => (float) $a->monto_ingreso,
                        'estado_pago' => $a->estado_pago,
                        'estado_ingreso' => $a->estado_ingreso,
                        'observacion' => $a->observacion,
                    ];
                })->toArray(),
                'diagnostico' => $diagnostico,
            ];
        }

        $coleccion = collect($detalle);

        $this->expensasDetalle = $detalle;

        $this->resumenDepartamento = [
            'total_expensas' => $coleccion->sum('monto_expensa'),
            'total_pagado' => $coleccion->sum('monto_pagado'),
            'total_saldo' => $coleccion->sum('saldo_contable'),
            'meses_pendientes' => $coleccion->where('saldo_contable', '>', 0)->count(),
            'meses_pagados' => $coleccion->where('estado', 'Pagado')->count(),
            'pagos_observados' => $coleccion->filter(function ($item) {
                return in_array($item['diagnostico']['tipo'], [
                    'mal_descuento',
                    'pago_parcial',
                    'pendiente',
                    'pagado_tarde',
                ]);
            })->count(),
        ];
    }

    public function diagnosticarExpensaDetalle($expensa, $aplicaciones, $ignorarSaldoAgosto = false)
    {
        $totalPagado = round((float) $aplicaciones->sum('monto'), 2);
        $montoExpensa = round((float) $expensa->monto_expensa, 2);
        $montoConDescuento = round((float) ($expensa->monto_con_descuento ?? $montoExpensa), 2);
        $saldo = round((float) $expensa->saldo, 2);

        if ($ignorarSaldoAgosto) {
            return [
                'tipo' => 'agosto_no_contable',
                'label' => 'Agosto no suma',
                'clase' => 'diag-neutral',
                'mensaje' => 'Agosto 2024 queda visible, pero no se suma como deuda porque septiembre 2024 ya tiene pago.',
            ];
        }

        if ($totalPagado <= 0) {
            return [
                'tipo' => 'pendiente',
                'label' => 'Pendiente',
                'clase' => 'diag-pendiente',
                'mensaje' => 'No tiene pagos aplicados.',
            ];
        }

        /*
            Tomamos la primera aplicación real para validar fecha.
            Si hay varios pagos, se toma el primer pago aplicado.
        */
        $primeraAplicacion = $aplicaciones->sortBy(function ($a) {
            return ($a->fecha ?? '').' '.($a->hora ?? '');
        })->first();

        $fechaPago = $primeraAplicacion?->fecha;

        if (! $fechaPago) {
            return [
                'tipo' => 'revisar',
                'label' => 'Revisar',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene monto aplicado, pero no se encontró fecha de pago para validar.',
            ];
        }

        $fechaPagoCarbon = \Carbon\Carbon::parse($fechaPago)->startOfDay();
        $fechaMesCarbon = \Carbon\Carbon::parse($expensa->fecha_mes)->startOfMonth();

        /*
            REGLA GENERAL:
            - 2024 no se valida con descuento.
            - Si una expensa 2024 fue pagada en enero 2025, no se marca mal.
            - Desde enero 2025 sí puede aplicar descuento.
            - El descuento es válido hasta el día 10 del mes siguiente.
            - Si el día 10 cae domingo, se permite hasta el día 11.
        */
        $expensaDesde2025 = $fechaMesCarbon->toDateString() >= '2025-01-01';

        if (! $expensaDesde2025) {
            if ($saldo <= 0 || $totalPagado >= $montoExpensa) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado completo',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Expensa cubierta correctamente. En 2024 no corresponde validar descuento.',
                ];
            }

            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene pago aplicado, pero aún mantiene saldo pendiente.',
            ];
        }

        /*
            Fecha límite real: día 10 del mes siguiente.
            Ejemplo:
            - Junio 2025 vence con descuento el 10/07/2025.
            - Si el 10 cae domingo, se permite el 11.
        */
        $fechaLimiteDescuento = $fechaMesCarbon->copy()->addMonth()->day(10);

        if ($fechaLimiteDescuento->isSunday()) {
            $fechaLimiteDescuento->addDay();
        }

        $pagoDentroDeFecha = $fechaPagoCarbon->lte($fechaLimiteDescuento);

        /*
            Validar deuda anterior contable.
            Se ignora agosto 2024 si septiembre 2024 ya tiene pago.
        */
        $septiembre2024TienePago = DB::table('expensas')
            ->where('departamento_nombre', $expensa->departamento_nombre)
            ->where('fecha_mes', '2024-09-01')
            ->where(function ($q) {
                $q->where('estado', 'Pagado')
                    ->orWhere('monto_pagado', '>', 0);
            })
            ->exists();

        $tieneDeudaAnterior = DB::table('expensas')
            ->where('departamento_nombre', $expensa->departamento_nombre)
            ->where('fecha_mes', '<', $expensa->fecha_mes)
            ->where('saldo', '>', 0)
            ->where('estado', '!=', 'Pagado')
            ->where(function ($q) use ($septiembre2024TienePago) {
                if ($septiembre2024TienePago) {
                    $q->where('fecha_mes', '!=', '2024-08-01');
                }
            })
            ->exists();

        $tieneDescuentoAplicado = trim($expensa->tipo_estado ?? '') === 'Descuento pronto pago';

        /*
            CASO 1:
            Tiene descuento aplicado.
            Solo es error si pagó fuera del límite o tenía deuda anterior.
        */
        if ($tieneDescuentoAplicado) {
            if (! $pagoDentroDeFecha) {
                return [
                    'tipo' => 'mal_descuento',
                    'label' => 'Revisar descuento',
                    'clase' => 'diag-mal',
                    'mensaje' => 'Tiene descuento aplicado, pero el pago fue después de la fecha límite permitida.',
                ];
            }

            if ($tieneDeudaAnterior) {
                return [
                    'tipo' => 'mal_descuento',
                    'label' => 'Revisar descuento',
                    'clase' => 'diag-mal',
                    'mensaje' => 'Tiene descuento aplicado, pero existe deuda anterior pendiente.',
                ];
            }

            if ($totalPagado >= $montoConDescuento || $saldo <= 0) {
                return [
                    'tipo' => 'descuento_correcto',
                    'label' => 'Descuento correcto',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Descuento aplicado correctamente dentro del plazo permitido.',
                ];
            }

            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'El pago está dentro del plazo de descuento, pero aún no cubre el monto requerido.',
            ];
        }

        /*
            CASO 2:
            No tiene descuento aplicado, pero pagó dentro de fecha.
            Esto no siempre es error: puede haber pagado monto completo o adelanto.
        */
        if ($pagoDentroDeFecha && ! $tieneDeudaAnterior) {
            if ($totalPagado >= $montoExpensa || $saldo <= 0) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado completo',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Pago aplicado correctamente. Pagó dentro del plazo, pero fue registrado con monto completo.',
                ];
            }

            if ($totalPagado >= $montoConDescuento) {
                return [
                    'tipo' => 'revisar_descuento',
                    'label' => 'Revisar descuento',
                    'clase' => 'diag-parcial',
                    'mensaje' => 'El pago está dentro del plazo y cubre el monto con descuento, pero no está marcado como descuento pronto pago.',
                ];
            }
        }

        /*
            CASO 3:
            Pago fuera de fecha.
            Si cubre monto completo, está bien.
            Si no cubre monto completo, está atrasado/parcial.
        */
        if (! $pagoDentroDeFecha) {
            if ($totalPagado >= $montoExpensa || $saldo <= 0) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado completo',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Pago aplicado como monto completo porque fue posterior al plazo de descuento.',
                ];
            }

            return [
                'tipo' => 'pagado_tarde',
                'label' => 'Pago fuera de fecha',
                'clase' => 'diag-mal',
                'mensaje' => 'El pago fue posterior al plazo de descuento y no cubre el monto completo.',
            ];
        }

        /*
            CASO FINAL:
            Validación general.
        */
        if ($totalPagado >= $montoExpensa || $saldo <= 0) {
            return [
                'tipo' => 'pagado',
                'label' => 'Pagado completo',
                'clase' => 'diag-ok',
                'mensaje' => 'Expensa cubierta correctamente.',
            ];
        }

        if ($totalPagado > 0 && $totalPagado < $montoExpensa) {
            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene pago aplicado, pero todavía no cubre el monto requerido.',
            ];
        }

        return [
            'tipo' => 'pendiente',
            'label' => 'Pendiente',
            'clase' => 'diag-pendiente',
            'mensaje' => 'Sin diagnóstico específico.',
        ];
    }

    public function diagnosticarExpensa($expensa, $aplicaciones)
    {
        $totalPagado = round((float) $aplicaciones->sum('monto'), 2);

        $montoExpensa = round((float) $expensa->monto_expensa, 2);
        $montoConDescuento = round((float) ($expensa->monto_con_descuento ?? 0), 2);

        if ($montoConDescuento <= 0) {
            $montoConDescuento = max(0, $montoExpensa - 100);
        }

        if ($totalPagado <= 0) {
            return [
                'tipo' => 'pendiente',
                'label' => 'Pendiente',
                'clase' => 'diag-pendiente',
                'mensaje' => 'No tiene pagos aplicados.',
            ];
        }

        $primeraAplicacion = $aplicaciones->sortBy(function ($a) {
            return ($a->fecha ?? '').' '.($a->hora ?? '');
        })->first();

        $fechaPago = $primeraAplicacion?->fecha;

        if (! $fechaPago) {
            return [
                'tipo' => 'revisar',
                'label' => 'Revisar',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene pago aplicado, pero no se encontró fecha para validar.',
            ];
        }

        $fechaPagoCarbon = \Carbon\Carbon::parse($fechaPago)->startOfDay();
        $fechaMesCarbon = \Carbon\Carbon::parse($expensa->fecha_mes)->startOfMonth();

        /*
            2024 no se valida con descuento.
        */
        if ($fechaMesCarbon->toDateString() < '2025-01-01') {
            if ($totalPagado >= $montoExpensa) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Expensa pagada correctamente. En 2024 no corresponde validar descuento.',
                ];
            }

            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene pago aplicado, pero aún no cubre el monto requerido.',
            ];
        }

        /*
            Fecha límite correcta:
            Enero 2025 -> 10/02/2025
            Febrero 2025 -> 10/03/2025
            Mayo 2025 -> 10/06/2025

            Si el día 10 cae domingo, se permite día 11.
        */
        $fechaLimiteDescuento = $fechaMesCarbon->copy()->addMonth()->day(10);

        if ($fechaLimiteDescuento->isSunday()) {
            $fechaLimiteDescuento->addDay();
        }

        $pagoDentroDeFecha = $fechaPagoCarbon->lte($fechaLimiteDescuento);

        /*
            Buscar deuda anterior real.
            No cuenta:
            - no_cobrar = 1
            - agosto 2024 si septiembre 2024 ya tiene pago
        */
        $septiembre2024TienePago = DB::table('expensas')
            ->where('departamento_nombre', $expensa->departamento_nombre)
            ->where('fecha_mes', '2024-09-01')
            ->where(function ($q) {
                $q->where('estado', 'Pagado')
                    ->orWhere('monto_pagado', '>', 0);
            })
            ->exists();

        $tieneDeudaAnterior = DB::table('expensas')
            ->where('departamento_nombre', $expensa->departamento_nombre)
            ->where('fecha_mes', '<', $expensa->fecha_mes)
            ->where('saldo', '>', 0)
            ->where('estado', '!=', 'Pagado')
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->where(function ($q) use ($septiembre2024TienePago) {
                if ($septiembre2024TienePago) {
                    $q->where('fecha_mes', '!=', '2024-08-01');
                }
            })
            ->exists();

        $tieneDescuentoAplicado = trim($expensa->tipo_estado ?? '') === 'Descuento pronto pago';

        /*
            CASO CORRECTO:
            Pagó dentro de fecha, no tiene deuda anterior y cubre el monto con descuento.
            Aunque la BD diga Parcial, el diagnóstico debe reconocer que corresponde descuento.
        */
        if (
            (int) ($expensa->aplica_descuento ?? 0) === 1 &&
            $pagoDentroDeFecha &&
            ! $tieneDeudaAnterior &&
            $totalPagado >= $montoConDescuento
        ) {
            return [
                'tipo' => 'descuento_correcto',
                'label' => 'Descuento correcto',
                'clase' => 'diag-ok',
                'mensaje' => 'Pago dentro del plazo permitido. Cubre el monto con descuento.',
            ];
        }

        /*
            Si tiene descuento aplicado, pero algo no cumple.
        */
        if ($tieneDescuentoAplicado) {
            if (! $pagoDentroDeFecha) {
                return [
                    'tipo' => 'mal_descuento',
                    'label' => 'Revisar descuento',
                    'clase' => 'diag-mal',
                    'mensaje' => 'Tiene descuento aplicado, pero el pago fue después de la fecha límite permitida.',
                ];
            }

            if ($tieneDeudaAnterior) {
                return [
                    'tipo' => 'mal_descuento',
                    'label' => 'Revisar descuento',
                    'clase' => 'diag-mal',
                    'mensaje' => 'Tiene descuento aplicado, pero existe deuda anterior pendiente.',
                ];
            }

            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'El descuento está dentro de fecha, pero aún no cubre el monto requerido.',
            ];
        }

        /*
            Pago fuera de fecha.
        */
        if (! $pagoDentroDeFecha) {
            if ($totalPagado >= $montoExpensa) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado completo',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Pago aplicado como monto completo porque fue posterior al plazo de descuento.',
                ];
            }

            return [
                'tipo' => 'pagado_tarde',
                'label' => 'Pago fuera de fecha',
                'clase' => 'diag-mal',
                'mensaje' => 'El pago fue posterior al plazo de descuento y no cubre el monto completo.',
            ];
        }

        /*
            Pago dentro de fecha, pero con deuda anterior.
            En ese caso no corresponde descuento.
        */
        if ($pagoDentroDeFecha && $tieneDeudaAnterior) {
            if ($totalPagado >= $montoExpensa) {
                return [
                    'tipo' => 'pagado',
                    'label' => 'Pagado completo',
                    'clase' => 'diag-ok',
                    'mensaje' => 'Pago cubre el monto completo. No aplica descuento porque existe deuda anterior.',
                ];
            }

            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'Pagó dentro de fecha, pero existe deuda anterior. No corresponde descuento.',
            ];
        }

        if ($totalPagado >= $montoExpensa) {
            return [
                'tipo' => 'pagado',
                'label' => 'Pagado completo',
                'clase' => 'diag-ok',
                'mensaje' => 'Expensa pagada completa.',
            ];
        }

        if ($totalPagado > 0 && $totalPagado < $montoExpensa) {
            return [
                'tipo' => 'pago_parcial',
                'label' => 'Pago parcial',
                'clase' => 'diag-parcial',
                'mensaje' => 'Tiene pago aplicado, pero aún no cubre el monto requerido.',
            ];
        }

        return [
            'tipo' => 'pendiente',
            'label' => 'Pendiente',
            'clase' => 'diag-pendiente',
            'mensaje' => 'Sin diagnóstico.',
        ];
    }

    public function marcarIncompletoTolerado($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->update([
                'estado_cobro' => 'INCOMPLETO_TOLERADO',
                'no_cobrar' => 1,
                'motivo_no_cobro' => 'Saldo incompleto tolerado por error de pago del copropietario.',
                'fecha_no_cobro' => now(),
                'usuario_no_cobro_id' => Auth::id(),
                'usuario_no_cobro_nombre' => Auth::user()->name ?? null,
                'tipo_estado' => 'Incompleto tolerado',
                'updated_at' => now(),
            ]);

        $this->cargarDetalleDepartamento();

    }

    public function marcarExoneradoAdministrador($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->update([
                'estado_cobro' => 'EXONERADO_ADMINISTRADOR',
                'no_cobrar' => 1,
                'motivo_no_cobro' => 'Exonerado mientras el propietario cumple función de administrador.',
                'fecha_no_cobro' => now(),
                'usuario_no_cobro_id' => Auth::id(),
                'usuario_no_cobro_nombre' => Auth::user()->name ?? null,
                'tipo_estado' => 'Exonerado administrador',
                'estado' => 'Pagado',
                'saldo' => 0.00,
                'updated_at' => now(),
            ]);

        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'Expensa marcada como exonerada por administrador.');
    }

    public function quitarNoCobro($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        $montoExpensa = (float) $expensa->monto_expensa;
        $montoPagado = (float) $expensa->monto_pagado;
        $saldo = max(0, $montoExpensa - $montoPagado);

        $estado = 'Pendiente';

        if ($montoPagado > 0 && $saldo > 0) {
            $estado = 'Parcial';
        }

        if ($saldo <= 0) {
            $estado = 'Pagado';
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->update([
                'estado_cobro' => 'NORMAL',
                'no_cobrar' => 0,
                'motivo_no_cobro' => null,
                'fecha_no_cobro' => null,
                'usuario_no_cobro_id' => null,
                'usuario_no_cobro_nombre' => null,
                'saldo' => $saldo,
                'estado' => $estado,
                'tipo_estado' => $estado === 'Pagado' ? 'Pagado' : null,
                'updated_at' => now(),
            ]);

        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'La expensa volvió a estado normal de cobro.');
    }

    public function abrirCrearExpensas()
    {
        if (! $this->departamentoSeleccionado) {
            $this->emit('error', 'Selecciona un departamento.');

            return;
        }

        $this->anioCrearExpensas = $this->anioFiltro ?: 2025;
        $this->desdeMesCrear = 1;
        $this->hastaMesCrear = 12;

        $this->modalCrearExpensas = true;
    }

    public function crearExpensasDepartamento()
    {
        if (! $this->tratamientoIdSeleccionado || ! $this->departamentoSeleccionado) {
            $this->emit('error', 'No hay departamento seleccionado.');

            return;
        }

        $tratamiento = DB::table('tratamientos')
            ->where('id', $this->tratamientoIdSeleccionado)
            ->first();

        if (! $tratamiento) {
            $this->emit('error', 'No se encontró el departamento en tratamientos.');

            return;
        }

        $creadas = 0;

        for ($mes = (int) $this->desdeMesCrear; $mes <= (int) $this->hastaMesCrear; $mes++) {
            $fechaMes = sprintf('%04d-%02d-01', (int) $this->anioCrearExpensas, $mes);

            $existe = DB::table('expensas')
                ->where('tratamiento_id', $tratamiento->id)
                ->where('fecha_mes', $fechaMes)
                ->exists();

            if ($existe) {
                continue;
            }

            $aplicaDescuento = $fechaMes >= '2025-01-01' ? 1 : 0;
            $montoExpensa = (float) $tratamiento->costo;

            DB::table('expensas')->insert([
                'tratamiento_id' => $tratamiento->id,
                'departamento_nombre' => $tratamiento->nombre,
                'anio' => (int) $this->anioCrearExpensas,
                'mes' => $mes,
                'fecha_mes' => $fechaMes,
                'monto_expensa' => $montoExpensa,
                'descuento_pronto_pago' => $aplicaDescuento ? 100.00 : 0.00,
                'monto_con_descuento' => $aplicaDescuento ? max(0, $montoExpensa - 100.00) : $montoExpensa,
                'fecha_limite_descuento' => $aplicaDescuento ? date('Y-m-d', strtotime($fechaMes.' +9 days')) : null,
                'aplica_descuento' => $aplicaDescuento,
                'monto_pagado' => 0.00,
                'saldo' => $montoExpensa,
                'estado' => 'Pendiente',
                'tipo_estado' => null,
                'observacion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $creadas++;
        }

        $this->modalCrearExpensas = false;
        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'Expensas creadas: '.$creadas);
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

    public function getTiposProperty()
    {
        if (! Schema::hasColumn('tratamientos', 'tipo')) {
            return collect();
        }

        return DB::table('tratamientos')
            ->whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->select('tipo')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');
    }

    public function render()
    {
        $tieneTipo = Schema::hasColumn('tratamientos', 'tipo');

        $departamentos = DB::table('tratamientos as t')
            ->leftJoin('expensas as e', function ($join) {
                $join->on('e.tratamiento_id', '=', 't.id');

                if ($this->anioFiltro) {
                    $join->where('e.anio', '=', $this->anioFiltro);
                }

                /*
                    Desde agosto 2024 en adelante.
                    Para otros años, se filtra por el año seleccionado arriba.
                */
                $join->where('e.fecha_mes', '>=', '2024-08-01');
            })
            ->when($this->busquedaDepartamento, function ($q) {
                $q->where('t.nombre', 'like', '%'.$this->busquedaDepartamento.'%');
            })
            ->when($this->tipoFiltro && $tieneTipo, function ($q) {
                $q->where('t.tipo', $this->tipoFiltro);
            })
            ->select(
                't.id',
                't.nombre',
                't.costo'
            )
            ->when($tieneTipo, function ($q) {
                $q->addSelect('t.tipo');
            })
            ->selectRaw('COUNT(e.id) as total_meses')
            ->selectRaw('COALESCE(SUM(e.monto_expensa), 0) as total_expensa')
            ->selectRaw('COALESCE(SUM(e.monto_pagado), 0) as total_pagado')
            ->selectRaw('COALESCE(SUM(e.saldo), 0) as total_saldo')
            ->selectRaw("SUM(CASE WHEN e.estado = 'Pagado' THEN 1 ELSE 0 END) as meses_pagados")
            ->selectRaw('SUM(CASE WHEN e.saldo > 0 THEN 1 ELSE 0 END) as meses_pendientes')
            ->groupBy('t.id', 't.nombre', 't.costo')
            ->when($tieneTipo, function ($q) {
                $q->groupBy('t.tipo');
            })
            ->orderBy('t.nombre')
            ->get()
            ->map(function ($item) {
                $item->tipo = $item->tipo ?? 'Sin tipo';

                $totalSaldo = (float) $item->total_saldo;
                $totalPagado = (float) $item->total_pagado;
                $totalMeses = (int) $item->total_meses;

                if ($totalMeses > 0 && $totalSaldo <= 0) {
                    $item->estado_cuenta = 'Al día';
                    $item->estado_clase = 'status-ok';
                } elseif ($totalPagado > 0 && $totalSaldo > 0) {
                    $item->estado_cuenta = 'Parcial / Atrasado';
                    $item->estado_clase = 'status-warning';
                } else {
                    $item->estado_cuenta = 'Pendiente';
                    $item->estado_clase = 'status-danger';
                }

                $irregularidad = $this->detectarIrregularidadDepartamento($item->nombre);

                $item->es_irregular = $irregularidad['es_irregular'];
                $item->cantidad_irregularidades = $irregularidad['cantidad'];

                return $item;
            });

        /*
            Filtro Estado:
            - Todos
            - Irregular
            - Al día
            - Parcial / Atrasado
            - Pendiente
        */
        if ($this->estadoFiltro !== 'Todos') {
            if ($this->estadoFiltro === 'Irregular') {
                $departamentos = $departamentos->filter(function ($item) {
                    return $item->es_irregular;
                })->values();
            } else {
                $departamentos = $departamentos->filter(function ($item) {
                    return $item->estado_cuenta === $this->estadoFiltro;
                })->values();
            }
        }

        return view('livewire.tesoreria.estado-departamentos', [
            'departamentos' => $departamentos,
            'tieneTipo' => $tieneTipo,
        ]);
    }

    public function eliminarExpensa($expensaId)
    {
        $expensa = DB::table('expensas')
            ->where('id', $expensaId)
            ->first();

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        $tienePagosAplicados = DB::table('ingresos_bancarios_aplicaciones')
            ->where('expensa_id', $expensaId)
            ->where('estado', '!=', 'Anulado')
            ->exists();

        if ($tienePagosAplicados || (float) $expensa->monto_pagado > 0) {
            $this->emit('error', 'No se puede eliminar esta expensa porque tiene pagos aplicados.');

            return;
        }

        DB::table('expensas')
            ->where('id', $expensaId)
            ->delete();

        $this->cargarDetalleDepartamento();

        $this->emit('alert', 'Expensa eliminada correctamente.');
    }
}
