<?php

namespace App\Http\Livewire\Tesoreria;

use App\Models\Expensa;
use App\Models\IngresoBancarioAplicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RegularizarIngresos extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $anio = 2025;

    public $anioExpensas = 2025;

    public $mes = '';

    public $estado = 'Pendiente';

    public $busqueda = '';

    public $filtroTipoMonto = 'Todos';

    public $modalRegularizar = false;

    public $modalCrearIngreso = false;

    public $ingresoId;

    public $ingresoFecha;

    public $ingresoHora;

    public $ingresoDepositante;

    public $ingresoComprobante;

    public $ingresoMonto = 0;

    public $ingresoAplicado = 0;

    public $ingresoSaldo = 0;

    public $departamentoSeleccionado = '';

    public $expensasDepartamento = [];

    public $lineas = [];

    public $tipoAplicacionEspecial = '';

    public $montoEspecial = '';

    public $observacionEspecial = '';

    public $nuevoFecha;

    public $nuevoHora;

    public $nuevoDepositante;

    public $nuevoComprobante;

    public $nuevoMonto;

    public $nuevoDetalle;

    public $nuevoTipoIngreso = 'Pendiente';

    public $nuevoObservacion;

    public $modalReporteDeudas = false;

    public $anioReporteDeudas = 2025;

    public $reporteDeudas = [];

    public $totalDepartamentosDeudores = 0;

    public $totalDeudaReporte = 0;

    public $criterioReporteDeudas = '';

    public $modalResultadoPagoAutomatico = false;

    public $resultadoPagoAutomatico = [];

    public $totalIngresosFiltrado = 0;

    public $labelTotalIngresos = '';

    public $modalImportarIngresos = false;

    public $archivoImportacion;

    public $importacionErrores = [];

    public $importacionResumen = [];

    public $importacionPreview = [];

    public $importacionDatos = [];

    public $importacionValida = false;

    public function abrirReporteDeudas()
    {
        $this->anioReporteDeudas = $this->anio ?: 2025;
        $this->generarReporteDeudas();
        $this->modalReporteDeudas = true;
    }

    public function descargarPlantillaIngresos()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ingresos');

        $headers = [
            'fecha_banco',
            'hora',
            'depositante',
            'numero_comprobante',
            'detalle',
            'tipo_aplicacion',
            'monto_total_ingreso',
            'departamento',
            'anio_pago',
            'meses_pago',
            'monto_a_aplicar',
            'observacion',
        ];

        $sheet->fromArray($headers, null, 'A1');

        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $validation = $sheet->getCell('F2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"Expensa,Gestion anterior,Alquiler salon,Otro ingreso,No identificado"');

        for ($row = 2; $row <= 300; $row++) {
            $sheet->getCell('F'.$row)->setDataValidation(clone $validation);
        }

        $help = $spreadsheet->createSheet();
        $help->setTitle('Departamentos');
        $help->fromArray(['departamento', 'tipo'], null, 'A1');

        $departamentos = DB::table('tratamientos')
            ->select('nombre', 'TIPO')
            ->orderBy('nombre')
            ->get()
            ->map(fn ($d) => [$d->nombre, $d->TIPO])
            ->toArray();

        if ($departamentos) {
            $help->fromArray($departamentos, null, 'A2');
        }

        $help->getColumnDimension('A')->setAutoSize(true);
        $help->getColumnDimension('B')->setAutoSize(true);

        $tipos = $spreadsheet->createSheet();
        $tipos->setTitle('Tipos ingreso');
        $tipos->fromArray(['tipo_aplicacion', 'uso'], null, 'A1');
        $tipos->fromArray([
            ['Expensa', 'Aplica el pago a una o varias expensas de departamentos. Requiere departamento, anio_pago y meses_pago.'],
            ['Gestion anterior', 'Registra un ingreso aplicado a gestion anterior. No requiere departamento ni meses.'],
            ['Alquiler salon', 'Registra alquiler de salon u otros espacios comunes. No requiere departamento ni meses.'],
            ['Otro ingreso', 'Registra ingresos varios no asociados a expensas. No requiere departamento ni meses.'],
            ['No identificado', 'Marca el dinero como aplicado pero aun sin clasificacion final. No requiere departamento ni meses.'],
        ], null, 'A2');
        $tipos->getColumnDimension('A')->setAutoSize(true);
        $tipos->getColumnDimension('B')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'plantilla-ingresos-bancarios.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function abrirImportarIngresos()
    {
        $this->reset([
            'archivoImportacion',
            'importacionErrores',
            'importacionResumen',
            'importacionPreview',
            'importacionDatos',
            'importacionValida',
        ]);

        $this->modalImportarIngresos = true;
    }

    public function validarImportacionIngresos()
    {
        $this->validate([
            'archivoImportacion' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $this->importacionErrores = [];
        $this->importacionResumen = [];
        $this->importacionPreview = [];
        $this->importacionDatos = [];
        $this->importacionValida = false;

        $spreadsheet = IOFactory::load($this->archivoImportacion->getRealPath());
        $rows = $spreadsheet->getSheetByName('Ingresos')
            ? $spreadsheet->getSheetByName('Ingresos')->toArray(null, true, true, true)
            : $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $departamentosValidos = DB::table('tratamientos')->pluck('nombre')->map(fn ($n) => mb_strtoupper(trim($n), 'UTF-8'))->toArray();
        $ingresos = [];
        $aplicaciones = [];

        foreach ($rows as $index => $row) {
            if ($index === 1) {
                continue;
            }

            $fecha = trim((string) ($row['A'] ?? ''));
            $depositante = trim((string) ($row['C'] ?? ''));
            $comprobante = trim((string) ($row['D'] ?? ''));
            $tipoAplicacion = $this->normalizarTipoAplicacionExcel($row['F'] ?? '');
            $usaPlantillaAnterior = ! $tipoAplicacion && is_numeric($row['F'] ?? null);

            if ($usaPlantillaAnterior) {
                $tipoAplicacion = 'Expensa';
                $montoTotal = (float) ($row['F'] ?? 0);
                $departamento = mb_strtoupper(trim((string) ($row['G'] ?? '')), 'UTF-8');
                $anioPago = (int) ($row['H'] ?? 0);
                $mesesPago = trim((string) ($row['I'] ?? ''));
                $montoAplicar = (float) ($row['J'] ?? 0);
                $observacion = trim((string) ($row['K'] ?? ''));
            } else {
                $montoTotal = (float) ($row['G'] ?? 0);
                $departamento = mb_strtoupper(trim((string) ($row['H'] ?? '')), 'UTF-8');
                $anioPago = (int) ($row['I'] ?? 0);
                $mesesPago = trim((string) ($row['J'] ?? ''));
                $montoAplicar = (float) ($row['K'] ?? 0);
                $observacion = trim((string) ($row['L'] ?? ''));
            }

            if ($fecha === '' && $depositante === '' && $comprobante === '' && $departamento === '') {
                continue;
            }

            $erroresFila = [];
            $fechaNormalizada = $this->normalizarFechaExcel($fecha);
            $hora = $this->normalizarHoraExcel($row['B'] ?? null);

            if (! $fechaNormalizada) {
                $erroresFila[] = 'fecha_banco invalida';
            }

            if ($montoTotal <= 0) {
                $erroresFila[] = 'monto_total_ingreso debe ser mayor a 0';
            }

            if ($montoAplicar <= 0) {
                $erroresFila[] = 'monto_a_aplicar debe ser mayor a 0';
            }

            if (! $tipoAplicacion) {
                $erroresFila[] = 'tipo_aplicacion invalido';
            }

            if ($fechaNormalizada && $comprobante !== '' && $montoTotal > 0) {
                $duplicado = DB::table('ingresos_bancarios')
                    ->where('fecha', $fechaNormalizada)
                    ->where('numero_comprobante', $comprobante)
                    ->where('monto', $montoTotal)
                    ->exists();

                if ($duplicado) {
                    $erroresFila[] = 'ya existe un ingreso con la misma fecha, comprobante y monto';
                }
            }

            $meses = $this->parseMesesImportacion($mesesPago);

            if ($tipoAplicacion === 'Expensa') {
                if (! in_array($departamento, $departamentosValidos, true)) {
                    $erroresFila[] = 'departamento no existe: '.$departamento;
                }

                if ($anioPago < 2024 || $anioPago > 2035) {
                    $erroresFila[] = 'anio_pago invalido';
                }

                if (empty($meses)) {
                    $erroresFila[] = 'meses_pago invalido';
                }

                foreach ($meses as $mes) {
                    $expensa = DB::table('expensas')
                        ->where('departamento_nombre', $departamento)
                        ->where('anio', $anioPago)
                        ->where('mes', $mes)
                        ->first();

                    if (! $expensa) {
                        $erroresFila[] = 'no existe expensa '.$departamento.' '.$mes.'/'.$anioPago;
                    }
                }
            }

            if ($erroresFila) {
                $this->importacionErrores[] = 'Fila '.$index.': '.implode(', ', $erroresFila);
                continue;
            }

            $key = $fechaNormalizada.'|'.$hora.'|'.$comprobante.'|'.$depositante.'|'.$montoTotal;

            $ingresos[$key] = [
                'fecha' => $fechaNormalizada,
                'hora' => $hora,
                'depositante' => mb_strtoupper($depositante, 'UTF-8'),
                'numero_comprobante' => $comprobante,
                'detalle' => mb_strtoupper(trim((string) ($row['E'] ?? $depositante)), 'UTF-8'),
                'monto' => $montoTotal,
                'tipo_ingreso' => $tipoAplicacion,
                'observacion' => $observacion,
            ];

            if (($ingresos[$key]['tipo_ingreso'] ?? $tipoAplicacion) !== $tipoAplicacion) {
                $ingresos[$key]['tipo_ingreso'] = 'Mixto';
            }

            $aplicaciones[] = [
                'key' => $key,
                'tipo_aplicacion' => $tipoAplicacion,
                'departamento' => $departamento,
                'anio' => $anioPago,
                'meses' => $meses,
                'monto' => $montoAplicar,
                'observacion' => $observacion,
                'fila' => $index,
            ];
        }

        foreach (collect($aplicaciones)->groupBy('key') as $key => $items) {
            $totalAplicar = round($items->sum('monto'), 2);
            $montoIngreso = round((float) ($ingresos[$key]['monto'] ?? 0), 2);

            if ($totalAplicar > $montoIngreso + 0.01) {
                $this->importacionErrores[] = 'Ingreso '.$key.': aplicaciones Bs '.$totalAplicar.' superan monto total Bs '.$montoIngreso;
            }
        }

        if ($this->importacionErrores) {
            return;
        }

        $this->importacionDatos = [
            'ingresos' => array_values($ingresos),
            'aplicaciones' => $aplicaciones,
        ];

        $this->importacionResumen = [
            'ingresos' => count($ingresos),
            'aplicaciones' => count($aplicaciones),
            'monto_total' => round(collect($ingresos)->sum('monto'), 2),
            'monto_aplicar' => round(collect($aplicaciones)->sum('monto'), 2),
        ];

        $this->importacionPreview = array_slice($aplicaciones, 0, 12);
        $this->importacionValida = true;
    }

    public function confirmarImportacionIngresos()
    {
        if (! $this->importacionValida || empty($this->importacionDatos['ingresos'])) {
            $this->emit('error', 'Primero valida el archivo.');

            return;
        }

        DB::transaction(function () {
            $ids = [];

            foreach ($this->importacionDatos['ingresos'] as $ingreso) {
                $fechaHora = $ingreso['fecha'].' '.($ingreso['hora'] ?: '00:00:00');
                $key = $ingreso['fecha'].'|'.$ingreso['hora'].'|'.$ingreso['numero_comprobante'].'|'.$ingreso['depositante'].'|'.$ingreso['monto'];

                $ids[$key] = DB::table('ingresos_bancarios')->insertGetId([
                    'fecha' => $ingreso['fecha'],
                    'hora' => $ingreso['hora'],
                    'fecha_hora' => $fechaHora,
                    'anio' => (int) date('Y', strtotime($ingreso['fecha'])),
                    'mes' => (int) date('m', strtotime($ingreso['fecha'])),
                    'depositante' => $ingreso['depositante'],
                    'detalle' => $ingreso['detalle'],
                    'numero_comprobante' => $ingreso['numero_comprobante'],
                    'monto' => $ingreso['monto'],
                    'tipo_ingreso' => $ingreso['tipo_ingreso'] ?? 'Pendiente',
                    'estado' => 'Pendiente',
                    'monto_aplicado' => 0,
                    'saldo_pendiente' => $ingreso['monto'],
                    'origen' => 'EXCEL',
                    'archivo_origen' => optional($this->archivoImportacion)->getClientOriginalName(),
                    'observacion' => $ingreso['observacion'],
                    'iduser' => Auth::id(),
                    'nameuser' => Auth::user()->name ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($this->importacionDatos['aplicaciones'] as $aplicacion) {
                $this->aplicarImportacionDesdeExcel($ids[$aplicacion['key']], $aplicacion);
                $this->ingresoId = $ids[$aplicacion['key']];
                $this->actualizarTotalesIngresoEnBD();
            }
        });

        $this->modalImportarIngresos = false;
        $this->reset(['archivoImportacion', 'importacionErrores', 'importacionResumen', 'importacionPreview', 'importacionDatos', 'importacionValida']);
        $this->emit('alert', 'Importacion completada correctamente.');
    }

    public function generarReporteDeudas()
    {
        $anio = (int) $this->anioReporteDeudas;

        $this->reporteDeudas = [];
        $this->totalDepartamentosDeudores = 0;
        $this->totalDeudaReporte = 0;

        if ($anio === 2024) {
            $fechaInicio = '2024-08-01';
            $fechaFin = '2024-11-01';

            $this->criterioReporteDeudas = '2024: se revisa agosto a noviembre, pero solo se muestran departamentos que tienen septiembre 2024 pendiente.';

            $departamentosConSeptiembrePendiente = DB::table('expensas')
                ->where('fecha_mes', '2024-09-01')
                ->where('saldo', '>', 0)
                ->where('estado', '!=', 'Pagado')
                ->where(function ($q) {
                    $q->whereNull('no_cobrar')
                        ->orWhere('no_cobrar', 0);
                })
                ->pluck('departamento_nombre')
                ->toArray();

            if (empty($departamentosConSeptiembrePendiente)) {
                return;
            }

            $expensas = DB::table('expensas')
                ->whereIn('departamento_nombre', $departamentosConSeptiembrePendiente)
                ->whereBetween('fecha_mes', [$fechaInicio, $fechaFin])
                ->where('saldo', '>', 0)
                ->where('estado', '!=', 'Pagado')
                ->where(function ($q) {
                    $q->whereNull('no_cobrar')
                        ->orWhere('no_cobrar', 0);
                })
                ->orderBy('departamento_nombre')
                ->orderBy('fecha_mes')
                ->get();
        } else {
            $fechaInicio = $anio.'-01-01';
            $fechaFin = $anio.'-11-01';

            $this->criterioReporteDeudas = $anio.': se revisa enero a noviembre y se muestran departamentos con saldo pendiente.';

            $expensas = DB::table('expensas')
                ->whereBetween('fecha_mes', [$fechaInicio, $fechaFin])
                ->where('saldo', '>', 0)
                ->where('estado', '!=', 'Pagado')
                ->where(function ($q) {
                    $q->whereNull('no_cobrar')
                        ->orWhere('no_cobrar', 0);
                })
                ->orderBy('departamento_nombre')
                ->orderBy('fecha_mes')
                ->get();
        }

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

        $agrupado = $expensas->groupBy('departamento_nombre')->map(function ($items, $departamento) use ($meses) {
            $mesesAdeudados = $items->map(function ($item) use ($meses) {
                $numeroMes = (int) date('n', strtotime($item->fecha_mes));

                return [
                    'mes' => $meses[$numeroMes] ?? $item->fecha_mes,
                    'fecha_mes' => $item->fecha_mes,
                    'monto_expensa' => (float) $item->monto_expensa,
                    'monto_pagado' => (float) $item->monto_pagado,
                    'saldo' => (float) $item->saldo,
                    'estado' => $item->estado,
                ];
            })->values()->toArray();

            return [
                'departamento' => $departamento,
                'cantidad_meses' => count($mesesAdeudados),
                'meses' => $mesesAdeudados,
                'total_deuda' => collect($mesesAdeudados)->sum('saldo'),
            ];
        })->values();

        $this->reporteDeudas = $agrupado->toArray();
        $this->totalDepartamentosDeudores = count($this->reporteDeudas);
        $this->totalDeudaReporte = collect($this->reporteDeudas)->sum('total_deuda');
    }

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingMes()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function cambiarAnioExpensas()
    {
        $this->buscarDepartamento();
    }

    public function abrirRegularizar($id)
    {
        $ingreso = DB::table('ingresos_bancarios')->where('id', $id)->first();

        if (! $ingreso) {
            $this->emit('error', 'No se encontró el ingreso.');

            return;
        }

        $this->ingresoId = $ingreso->id;
        $this->ingresoFecha = $ingreso->fecha;
        $this->ingresoHora = $ingreso->hora;
        $this->ingresoDepositante = $ingreso->depositante;
        $this->ingresoComprobante = $ingreso->numero_comprobante;
        $this->ingresoMonto = (float) $ingreso->monto;

        $this->cargarTotalesIngreso();

        $this->departamentoSeleccionado = '';
        $this->anioExpensas = 2024;
        $this->expensasDepartamento = [];
        $this->lineas = [];

        $this->tipoAplicacionEspecial = '';
        $this->montoEspecial = '';
        $this->observacionEspecial = '';

        $this->modalRegularizar = true;
    }

    public function usarSugerencia($ingresoId)
    {
        $ingreso = DB::table('ingresos_bancarios')->where('id', $ingresoId)->first();

        if (! $ingreso) {
            $this->emit('error', 'No se encontró el ingreso.');

            return;
        }

        $sugerencia = $this->obtenerDepartamentoSugerido($ingreso->depositante);

        if (! $sugerencia) {
            $this->emit('error', 'No hay sugerencia disponible para este ingreso.');

            return;
        }

        $this->abrirRegularizar($ingresoId);

        $departamento = $sugerencia['departamento'];

        $this->departamentoSeleccionado = $departamento;

        $this->anioExpensas = (int) date('Y', strtotime($ingreso->fecha));

        $expensa = $this->obtenerPrimeraExpensaAdeudada($departamento, $ingreso->fecha);

        if ($expensa) {
            $this->anioExpensas = (int) $expensa->anio;
            $this->buscarDepartamento();

            $calculo = $this->calcularMontoObjetivoExpensa($expensa, $ingreso->fecha);

            $montoSugerido = min(
                (float) $calculo['saldo_real'],
                (float) $this->ingresoSaldo
            );

            if ($montoSugerido > 0) {
                $estadoPago = 'Pagado';

                if ($calculo['tipo_estado'] === 'Descuento pronto pago') {
                    $estadoPago = 'Descuento pronto pago';
                }

                $this->lineas[] = [
                    'tipo' => 'Expensa',
                    'expensa_id' => $expensa->id,
                    'departamento_nombre' => $expensa->departamento_nombre,
                    'anio' => $expensa->anio,
                    'mes' => $expensa->mes,
                    'fecha_mes' => $expensa->fecha_mes,
                    'monto' => $montoSugerido,
                    'estado_pago' => $estadoPago,
                    'observacion' => 'Aplicado desde sugerencia automática',
                ];
            }
        } else {
            $this->buscarDepartamento();
            $this->emit('error', 'No se encontró una expensa pendiente para este departamento.');
        }
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

    public function pagarAutomaticoSugerencia($ingresoId, $departamentoForzado = null)
    {
        $ingreso = DB::table('ingresos_bancarios')
            ->where('id', $ingresoId)
            ->first();

        if (! $ingreso) {
            $this->emit('error', 'No se encontró el ingreso.');

            return;
        }

        /*
            Si llega un departamento desde las sugerencias múltiples,
            usa ese departamento.
            Si no llega nada, usa la sugerencia normal anterior.
        */
        if ($departamentoForzado) {
            $departamento = trim($departamentoForzado);
        } else {
            $sugerencia = $this->obtenerDepartamentoSugerido($ingreso->depositante);

            if (! $sugerencia || empty($sugerencia['departamento'])) {
                $this->emit('error', 'No hay sugerencia disponible para este ingreso.');

                return;
            }

            $departamento = $sugerencia['departamento'];
        }

        $montoAplicadoActual = (float) DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $ingreso->id)
            ->where('estado', '!=', 'Anulado')
            ->sum('monto');

        $saldoIngreso = round((float) $ingreso->monto - $montoAplicadoActual, 2);

        if ($saldoIngreso <= 0) {
            $this->emit('error', 'Este ingreso ya no tiene saldo pendiente.');

            return;
        }

        $detalleAplicado = [];
        $saldoInicialIngreso = $saldoIngreso;

        DB::transaction(function () use ($ingreso, $departamento, &$saldoIngreso, &$detalleAplicado) {
            $vueltas = 0;

            while ($saldoIngreso > 0 && $vueltas < 36) {
                $vueltas++;

                $expensa = $this->obtenerPrimeraExpensaAdeudada($departamento, $ingreso->fecha);

                if (! $expensa) {
                    break;
                }

                $calculo = $this->calcularMontoObjetivoExpensa($expensa, $ingreso->fecha);

                $saldoRealExpensa = round((float) $calculo['saldo_real'], 2);

                if ($saldoRealExpensa <= 0) {
                    break;
                }

                $montoAplicar = min($saldoIngreso, $saldoRealExpensa);
                $montoAplicar = round((float) $montoAplicar, 2);

                if ($montoAplicar <= 0) {
                    break;
                }

                $estadoPago = 'Pagado';

                if ($montoAplicar < $saldoRealExpensa) {
                    $estadoPago = 'Parcial';
                }

                if (($calculo['tipo_estado'] ?? null) === 'Descuento pronto pago') {
                    $estadoPago = 'Descuento pronto pago';
                }

                IngresoBancarioAplicacion::create([
                    'ingreso_bancario_id' => $ingreso->id,
                    'expensa_id' => $expensa->id,
                    'tipo_aplicacion' => 'Expensa',
                    'codigo_departamento' => null,
                    'departamento_nombre' => $expensa->departamento_nombre,
                    'fecha_inicio_pago' => $expensa->fecha_mes,
                    'anio_pago' => $expensa->anio,
                    'mes_pago' => $expensa->mes,
                    'monto' => $montoAplicar,
                    'pago_id' => null,
                    'estado' => 'Confirmado',
                    'estado_pago' => $estadoPago,
                    'fecha_aplicacion' => now(),
                    'observacion' => 'Pago automático desde sugerencia',
                    'iduser' => Auth::id(),
                    'nameuser' => Auth::user()->name ?? null,
                ]);

                $nuevoPagado = round((float) $expensa->monto_pagado + $montoAplicar, 2);
                $montoObjetivo = round((float) $calculo['monto_objetivo'], 2);
                $nuevoSaldo = round(max(0, $montoObjetivo - $nuevoPagado), 2);

                if ($nuevoPagado <= 0) {
                    $estadoExpensa = 'Pendiente';
                } elseif ($nuevoSaldo > 0) {
                    $estadoExpensa = 'Parcial';
                } else {
                    $estadoExpensa = 'Pagado';
                }

                $tipoEstadoFinal = $calculo['tipo_estado'] ?? null;

                if (! $tipoEstadoFinal) {
                    if ($estadoExpensa === 'Pagado') {
                        $tipoEstadoFinal = 'Pagado';
                    } elseif ($estadoExpensa === 'Parcial') {
                        $tipoEstadoFinal = 'Parcial';
                    } else {
                        $tipoEstadoFinal = null;
                    }
                }

                /*
                    Se actualiza con query builder para que funcione aunque
                    obtenerPrimeraExpensaAdeudada devuelva objeto DB o modelo.
                */
                DB::table('expensas')
                    ->where('id', $expensa->id)
                    ->update([
                        'monto_pagado' => $nuevoPagado,
                        'saldo' => $nuevoSaldo,
                        'estado' => $estadoExpensa,
                        'tipo_estado' => $tipoEstadoFinal,
                        'updated_at' => now(),
                    ]);

                $detalleAplicado[] = [
                    'departamento' => $expensa->departamento_nombre,
                    'fecha_mes' => $expensa->fecha_mes,
                    'mes' => $this->nombreMes((int) $expensa->mes),
                    'anio' => $expensa->anio,
                    'monto_expensa' => (float) $expensa->monto_expensa,
                    'monto_objetivo' => $montoObjetivo,
                    'monto_aplicado' => $montoAplicar,
                    'nuevo_pagado' => $nuevoPagado,
                    'nuevo_saldo' => $nuevoSaldo,
                    'estado_expensa' => $estadoExpensa,
                    'estado_pago' => $estadoPago,
                    'tipo_estado' => $tipoEstadoFinal,
                ];

                $saldoIngreso = round($saldoIngreso - $montoAplicar, 2);
            }

            $aplicadoTotal = (float) DB::table('ingresos_bancarios_aplicaciones')
                ->where('ingreso_bancario_id', $ingreso->id)
                ->where('estado', '!=', 'Anulado')
                ->sum('monto');

            $aplicadoTotal = round($aplicadoTotal, 2);

            $saldoFinal = round((float) $ingreso->monto - $aplicadoTotal, 2);

            $estadoIngreso = 'Pendiente';

            if ($aplicadoTotal > 0 && $saldoFinal > 0) {
                $estadoIngreso = 'Aplicado parcial';
            }

            if ($aplicadoTotal > 0 && $saldoFinal <= 0) {
                $estadoIngreso = 'Aplicado completo';
                $saldoFinal = 0;
            }

            DB::table('ingresos_bancarios')
                ->where('id', $ingreso->id)
                ->update([
                    'monto_aplicado' => $aplicadoTotal,
                    'saldo_pendiente' => $saldoFinal,
                    'estado' => $estadoIngreso,
                    'updated_at' => now(),
                ]);
        });

        if (empty($detalleAplicado)) {
            $this->emit('error', 'No se encontró una expensa pendiente para aplicar este ingreso.');

            return;
        }

        $this->resultadoPagoAutomatico = [
            'departamento' => $departamento,
            'depositante' => $ingreso->depositante,
            'fecha' => $ingreso->fecha,
            'hora' => $ingreso->hora,
            'comprobante' => $ingreso->numero_comprobante,
            'monto_ingreso' => (float) $ingreso->monto,
            'saldo_inicial' => $saldoInicialIngreso,
            'total_aplicado' => collect($detalleAplicado)->sum('monto_aplicado'),
            'saldo_restante' => $saldoIngreso,
            'detalle' => $detalleAplicado,
        ];

        $this->modalResultadoPagoAutomatico = true;

    }

    public function cargarTotalesIngreso()
    {
        $this->ingresoAplicado = (float) DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $this->ingresoId)
            ->where('estado', '!=', 'Anulado')
            ->sum('monto');

        $this->ingresoSaldo = round($this->ingresoMonto - $this->ingresoAplicado, 2);
    }

    public function buscarDepartamento()
    {
        if (! $this->departamentoSeleccionado) {
            $this->expensasDepartamento = [];

            return;
        }

        $fechaInicio = $this->anioExpensas.'-01-01';
        $fechaFin = $this->anioExpensas.'-12-01';

        if ((int) $this->anioExpensas === 2024) {
            $fechaInicio = '2024-08-01';
            $fechaFin = '2024-12-01';
        }

        $this->expensasDepartamento = Expensa::where('departamento_nombre', $this->departamentoSeleccionado)
            ->whereBetween('fecha_mes', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_mes')
            ->get()
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'departamento_nombre' => $e->departamento_nombre,
                    'fecha_mes' => $e->fecha_mes,
                    'anio' => $e->anio,
                    'mes' => $e->mes,
                    'monto_expensa' => (float) $e->monto_expensa,
                    'descuento_pronto_pago' => (float) ($e->descuento_pronto_pago ?? 0),
                    'monto_con_descuento' => (float) ($e->monto_con_descuento ?? $e->monto_expensa),
                    'fecha_limite_descuento' => $e->fecha_limite_descuento,
                    'aplica_descuento' => (int) ($e->aplica_descuento ?? 0),
                    'monto_pagado' => (float) $e->monto_pagado,
                    'saldo' => (float) $e->saldo,
                    'estado' => $e->estado,
                    'tipo_estado' => $e->tipo_estado,

                    // NUEVO
                    'estado_cobro' => $e->estado_cobro ?? 'NORMAL',
                    'no_cobrar' => (int) ($e->no_cobrar ?? 0),
                    'motivo_no_cobro' => $e->motivo_no_cobro ?? null,
                ];
            })
            ->toArray();
    }

    public function eliminarIngresoBancario($ingresoId)
    {
        $ingreso = DB::table('ingresos_bancarios')
            ->where('id', $ingresoId)
            ->first();

        if (! $ingreso) {
            $this->emit('error', 'No se encontró el ingreso bancario.');

            return;
        }

        $tieneAplicacionesActivas = DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $ingresoId)
            ->where('estado', '!=', 'Anulado')
            ->exists();

        if ($tieneAplicacionesActivas) {
            $this->emit('error', 'No se puede eliminar este ingreso porque tiene pagos aplicados.');

            return;
        }

        DB::transaction(function () use ($ingresoId) {
            /*
                Primero se eliminan aplicaciones anuladas si existieran,
                porque ya no afectan contabilidad.
            */
            DB::table('ingresos_bancarios_aplicaciones')
                ->where('ingreso_bancario_id', $ingresoId)
                ->delete();

            /*
                Luego se elimina el ingreso bancario.
            */
            DB::table('ingresos_bancarios')
                ->where('id', $ingresoId)
                ->delete();
        });

        $this->emit('alert', 'Ingreso bancario eliminado correctamente.');
    }

    public function obtenerPrimeraExpensaAdeudada($departamento, $fechaIngreso)
    {
        if (! $departamento || ! $fechaIngreso) {
            return null;
        }

        $fechaIngresoCarbon = \Carbon\Carbon::parse($fechaIngreso);
        $anioIngreso = (int) $fechaIngresoCarbon->year;

        /*
            Protección agosto 2024:
            - Si septiembre 2024 ya tiene pago, agosto no entra en automático.
            - Si septiembre 2024 no tiene pago, agosto sí puede entrar.
            - Las expensas con no_cobrar = 1 nunca entran al automático.
        */
        $tienePagadoDesdeSeptiembre2024 = Expensa::where('departamento_nombre', $departamento)
            ->whereBetween('fecha_mes', ['2024-09-01', '2024-12-01'])
            ->where(function ($q) {
                $q->where('estado', 'Pagado')
                    ->orWhere('monto_pagado', '>', 0);
            })
            ->exists();

        if ($anioIngreso === 2024) {
            $inicio2024 = $tienePagadoDesdeSeptiembre2024
                ? '2024-09-01'
                : '2024-08-01';

            return Expensa::where('departamento_nombre', $departamento)
                ->whereBetween('fecha_mes', [$inicio2024, '2024-12-01'])
                ->where('saldo', '>', 0)
                ->where('estado', '!=', 'Pagado')
                ->where(function ($q) {
                    $q->whereNull('no_cobrar')
                        ->orWhere('no_cobrar', 0);
                })
                ->orderBy('fecha_mes')
                ->first();
        }

        /*
            Desde 2025:
            Primero busca deuda 2024, pero excluyendo no_cobrar.
        */
        $inicio2024 = $tienePagadoDesdeSeptiembre2024
            ? '2024-09-01'
            : '2024-08-01';

        $deuda2024 = Expensa::where('departamento_nombre', $departamento)
            ->whereBetween('fecha_mes', [$inicio2024, '2024-12-01'])
            ->where('saldo', '>', 0)
            ->where('estado', '!=', 'Pagado')
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->orderBy('fecha_mes')
            ->first();

        if ($deuda2024) {
            return $deuda2024;
        }

        /*
            Luego busca desde enero 2025 hacia adelante.
            Excluye incompleto tolerado y exonerados.
        */
        return Expensa::where('departamento_nombre', $departamento)
            ->where('fecha_mes', '>=', '2025-01-01')
            ->where('saldo', '>', 0)
            ->where('estado', '!=', 'Pagado')
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->orderBy('fecha_mes')
            ->first();
    }

    public function calcularMontoObjetivoExpensa($expensa, $fechaIngreso)
    {
        $montoObjetivo = (float) $expensa->monto_expensa;
        $tipoEstado = null;

        /*
            Si está marcado como no cobrable, el automático no debe cobrar nada.
        */
        if ((int) ($expensa->no_cobrar ?? 0) === 1) {
            return [
                'monto_objetivo' => 0,
                'saldo_real' => 0,
                'tipo_estado' => $expensa->tipo_estado ?? 'No cobrable',
            ];
        }

        if (! $fechaIngreso || ! $expensa->fecha_mes) {
            return [
                'monto_objetivo' => $montoObjetivo,
                'saldo_real' => max(0, $montoObjetivo - (float) $expensa->monto_pagado),
                'tipo_estado' => $tipoEstado,
            ];
        }

        $fechaIngresoCarbon = \Carbon\Carbon::parse($fechaIngreso)->startOfDay();
        $fechaMesExpensa = \Carbon\Carbon::parse($expensa->fecha_mes)->startOfMonth();

        /*
            REGLA FINAL:
            - 2024 no tiene descuento.
            - Desde enero 2025 sí tiene descuento.
            - La expensa se puede pagar con descuento hasta el día 10 del mes siguiente.
            - Si el día 10 cae domingo, se permite el día 11.
            - Para aplicar descuento no debe tener deuda anterior real.
            - Las expensas no_cobrar = 1 no cuentan como deuda anterior.
        */
        $expensaDesde2025 = $fechaMesExpensa->toDateString() >= '2025-01-01';

        $fechaLimite = $fechaMesExpensa->copy()->addMonth()->day(10);

        if ($fechaLimite->isSunday()) {
            $fechaLimite = $fechaLimite->copy()->addDay();
        }

        $pagoDentroDeFecha = $fechaIngresoCarbon->lte($fechaLimite);

        $tieneDeudaAnterior = DB::table('expensas')
            ->where('departamento_nombre', $expensa->departamento_nombre)
            ->where('fecha_mes', '<', $expensa->fecha_mes)
            ->where('saldo', '>', 0)
            ->where('estado', '!=', 'Pagado')
            ->where(function ($q) {
                $q->whereNull('no_cobrar')
                    ->orWhere('no_cobrar', 0);
            })
            ->where(function ($q) {
                $q->where('fecha_mes', '!=', '2024-08-01')
                    ->orWhereNotExists(function ($sub) {
                        $sub->select(DB::raw(1))
                            ->from('expensas as sep')
                            ->whereColumn('sep.departamento_nombre', 'expensas.departamento_nombre')
                            ->where('sep.fecha_mes', '2024-09-01')
                            ->where(function ($qq) {
                                $qq->where('sep.estado', 'Pagado')
                                    ->orWhere('sep.monto_pagado', '>', 0);
                            });
                    });
            })
            ->exists();

        if (
            (int) ($expensa->aplica_descuento ?? 0) === 1 &&
            $expensaDesde2025 &&
            $pagoDentroDeFecha &&
            ! $tieneDeudaAnterior
        ) {
            $montoObjetivo = (float) ($expensa->monto_con_descuento ?? 0);

            if ($montoObjetivo <= 0) {
                $montoObjetivo = max(0, (float) $expensa->monto_expensa - 100.00);
            }

            $tipoEstado = 'Descuento pronto pago';
        }

        return [
            'monto_objetivo' => $montoObjetivo,
            'saldo_real' => max(0, $montoObjetivo - (float) $expensa->monto_pagado),
            'tipo_estado' => $tipoEstado,
        ];
    }

    public function agregarLineaExpensa($expensaId)
    {
        $expensa = Expensa::find($expensaId);

        if (! $expensa) {
            $this->emit('error', 'No se encontró la expensa.');

            return;
        }

        if ((int) ($expensa->no_cobrar ?? 0) === 1) {
            $this->emit('error', 'Esta expensa está marcada como no cobrable. No se puede aplicar pago.');

            return;
        }

        $this->cargarTotalesIngreso();

        $fechaBanco = DB::table('ingresos_bancarios')
            ->where('id', $this->ingresoId)
            ->value('fecha');

        $calculo = $this->calcularMontoObjetivoExpensa($expensa, $fechaBanco);

        $montoSugerido = min(
            (float) $calculo['saldo_real'],
            (float) $this->ingresoSaldo
        );

        if ($montoSugerido <= 0) {
            $montoSugerido = (float) $calculo['monto_objetivo'];
        }

        if ($montoSugerido <= 0) {
            $this->emit('error', 'No hay monto pendiente para esta expensa.');

            return;
        }

        $estadoPago = 'Pagado';

        if ($montoSugerido < (float) $calculo['saldo_real']) {
            $estadoPago = 'Parcial';
        }

        if (($calculo['tipo_estado'] ?? null) === 'Descuento pronto pago') {
            $estadoPago = 'Descuento pronto pago';
        }

        $this->lineas[] = [
            'tipo' => 'Expensa',
            'expensa_id' => $expensa->id,
            'departamento_nombre' => $expensa->departamento_nombre,
            'anio' => $expensa->anio,
            'mes' => $expensa->mes,
            'fecha_mes' => $expensa->fecha_mes,
            'monto' => $montoSugerido,
            'estado_pago' => $estadoPago,
            'observacion' => '',
        ];
    }

    public function agregarLineaLibre()
    {
        $this->lineas[] = [
            'tipo' => 'Expensa',
            'expensa_id' => '',
            'departamento_nombre' => '',
            'anio' => $this->anio ?: 2024,
            'mes' => '',
            'fecha_mes' => '',
            'monto' => '',
            'estado_pago' => 'Pagado',
            'observacion' => '',
        ];
    }

    public function quitarLinea($index)
    {
        unset($this->lineas[$index]);
        $this->lineas = array_values($this->lineas);
    }

    public function agregarEspecial()
    {
        if (! $this->tipoAplicacionEspecial || ! $this->montoEspecial) {
            $this->emit('error', 'Selecciona tipo y monto.');

            return;
        }

        $this->lineas[] = [
            'tipo' => $this->tipoAplicacionEspecial,
            'expensa_id' => '',
            'departamento_nombre' => null,
            'anio' => null,
            'mes' => null,
            'fecha_mes' => null,
            'monto' => (float) $this->montoEspecial,
            'estado_pago' => $this->tipoAplicacionEspecial,
            'observacion' => trim($this->observacionEspecial ?? ''),
        ];

        $this->tipoAplicacionEspecial = '';
        $this->montoEspecial = '';
        $this->observacionEspecial = '';
    }

    public function guardarRegularizacion()
    {
        if (! $this->ingresoId) {
            $this->emit('error', 'No hay ingreso seleccionado.');

            return;
        }

        $totalLineas = collect($this->lineas)->sum(function ($l) {
            return (float) ($l['monto'] ?? 0);
        });

        if ($totalLineas <= 0) {
            $this->emit('error', 'No hay monto para aplicar.');

            return;
        }

        $this->cargarTotalesIngreso();

        if ($totalLineas > $this->ingresoSaldo + 0.01) {
            $this->emit('error', 'El monto aplicado supera el saldo del ingreso.');

            return;
        }

        DB::transaction(function () {
            foreach ($this->lineas as $linea) {
                $monto = (float) ($linea['monto'] ?? 0);

                if ($monto <= 0) {
                    continue;
                }

                $expensa = null;

                if (! empty($linea['expensa_id'])) {
                    $expensa = Expensa::find($linea['expensa_id']);
                }

                if ($expensa && (int) ($expensa->no_cobrar ?? 0) === 1) {
                    continue;
                }

                IngresoBancarioAplicacion::create([
                    'ingreso_bancario_id' => $this->ingresoId,
                    'expensa_id' => $expensa?->id,
                    'tipo_aplicacion' => $linea['tipo'] ?? 'Expensa',
                    'codigo_departamento' => null,
                    'departamento_nombre' => $expensa?->departamento_nombre ?? ($linea['departamento_nombre'] ?? null),
                    'fecha_inicio_pago' => $expensa?->fecha_mes ?? ($linea['fecha_mes'] ?? null),
                    'anio_pago' => $expensa?->anio ?? ($linea['anio'] ?? null),
                    'mes_pago' => $expensa?->mes ?? ($linea['mes'] ?? null),
                    'monto' => $monto,
                    'pago_id' => null,
                    'estado' => 'Confirmado',
                    'estado_pago' => $linea['estado_pago'] ?? 'Pagado',
                    'fecha_aplicacion' => now(),
                    'observacion' => trim($linea['observacion'] ?? ''),
                    'iduser' => Auth::id(),
                    'nameuser' => Auth::user()->name ?? null,
                ]);

                if ($expensa) {
                    $nuevoPagado = round((float) $expensa->monto_pagado + $monto, 2);

                    $fechaBanco = DB::table('ingresos_bancarios')
                        ->where('id', $this->ingresoId)
                        ->value('fecha');

                    $calculo = $this->calcularMontoObjetivoExpensa($expensa, $fechaBanco);

                    $montoObjetivo = round((float) $calculo['monto_objetivo'], 2);
                    $tipoEstadoFinal = $linea['estado_pago'] ?? null;

                    if (($calculo['tipo_estado'] ?? null) === 'Descuento pronto pago') {
                        $tipoEstadoFinal = 'Descuento pronto pago';
                    }

                    $nuevoSaldo = round(max(0, $montoObjetivo - $nuevoPagado), 2);

                    if ($nuevoSaldo <= 0) {
                        $estado = 'Pagado';
                    } elseif ($nuevoPagado > 0) {
                        $estado = 'Parcial';
                    } else {
                        $estado = 'Pendiente';
                    }

                    $expensa->update([
                        'monto_pagado' => $nuevoPagado,
                        'saldo' => $nuevoSaldo,
                        'estado' => $estado,
                        'tipo_estado' => $tipoEstadoFinal,
                        'updated_at' => now(),
                    ]);
                }
            }

            $this->actualizarTotalesIngresoEnBD();
        });

        $this->lineas = [];
        $this->cargarTotalesIngreso();

        if ($this->departamentoSeleccionado) {
            $this->buscarDepartamento();
        }
    }

    public function anularAplicacion($aplicacionId)
    {
        $aplicacion = IngresoBancarioAplicacion::find($aplicacionId);

        if (! $aplicacion || $aplicacion->estado === 'Anulado') {
            return;
        }

        DB::transaction(function () use ($aplicacion) {
            if ($aplicacion->expensa_id) {
                $expensa = Expensa::find($aplicacion->expensa_id);

                if ($expensa) {
                    $nuevoPagado = max(0, (float) $expensa->monto_pagado - (float) $aplicacion->monto);

                    if ((int) ($expensa->no_cobrar ?? 0) === 1) {
                        $expensa->update([
                            'monto_pagado' => $nuevoPagado,
                            'updated_at' => now(),
                        ]);
                    } else {
                        $primeraFechaPago = DB::table('ingresos_bancarios_aplicaciones as iba')
                            ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
                            ->where('iba.expensa_id', $expensa->id)
                            ->where('iba.estado', '!=', 'Anulado')
                            ->where('iba.id', '!=', $aplicacion->id)
                            ->min('ib.fecha');

                        $montoObjetivo = (float) $expensa->monto_expensa;
                        $tipoEstadoFinal = $expensa->tipo_estado;

                        if (
                            (int) $expensa->aplica_descuento === 1 &&
                            $primeraFechaPago &&
                            $expensa->fecha_limite_descuento &&
                            $primeraFechaPago <= $expensa->fecha_limite_descuento
                        ) {
                            $montoObjetivo = (float) ($expensa->monto_con_descuento ?? $expensa->monto_expensa);
                            $tipoEstadoFinal = 'Descuento pronto pago';
                        } else {
                            if ($tipoEstadoFinal === 'Descuento pronto pago') {
                                $tipoEstadoFinal = null;
                            }
                        }

                        $nuevoSaldo = max(0, $montoObjetivo - $nuevoPagado);

                        if ($nuevoPagado <= 0) {
                            $estado = 'Pendiente';
                        } elseif ($nuevoSaldo > 0) {
                            $estado = 'Parcial';
                        } else {
                            $estado = 'Pagado';
                        }

                        $expensa->update([
                            'monto_pagado' => $nuevoPagado,
                            'saldo' => $nuevoSaldo,
                            'estado' => $estado,
                            'tipo_estado' => $tipoEstadoFinal,
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            $aplicacion->update([
                'estado' => 'Anulado',
                'observacion' => trim(($aplicacion->observacion ?? '').' | Anulado'),
                'updated_at' => now(),
            ]);

            $this->actualizarTotalesIngresoEnBD();
        });

        $this->cargarTotalesIngreso();

        if ($this->departamentoSeleccionado) {
            $this->buscarDepartamento();
        }

        $this->emit('alert', 'Aplicación anulada.');
    }

    public function actualizarTotalesIngresoEnBD()
    {
        $aplicado = DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $this->ingresoId)
            ->where('estado', '!=', 'Anulado')
            ->sum('monto');

        $ingreso = DB::table('ingresos_bancarios')->where('id', $this->ingresoId)->first();

        if (! $ingreso) {
            return;
        }

        $saldo = round(((float) $ingreso->monto) - ((float) $aplicado), 2);

        $estado = 'Pendiente';

        if ($aplicado > 0 && $saldo > 0) {
            $estado = 'Aplicado parcial';
        }

        if ($aplicado > 0 && $saldo <= 0) {
            $estado = 'Aplicado completo';
            $saldo = 0;
        }

        DB::table('ingresos_bancarios')
            ->where('id', $this->ingresoId)
            ->update([
                'monto_aplicado' => $aplicado,
                'saldo_pendiente' => $saldo,
                'estado' => $estado,
                'updated_at' => now(),
            ]);
    }

    public function abrirCrearIngreso()
    {
        $this->reset([
            'nuevoFecha',
            'nuevoHora',
            'nuevoDepositante',
            'nuevoComprobante',
            'nuevoMonto',
            'nuevoDetalle',
            'nuevoTipoIngreso',
            'nuevoObservacion',
        ]);

        $this->nuevoFecha = now()->toDateString();
        $this->nuevoHora = now()->format('H:i');
        $this->nuevoTipoIngreso = 'Pendiente';

        $this->modalCrearIngreso = true;
    }

    public function guardarIngresoBancario()
    {
        $this->validate([
            'nuevoFecha' => 'required|date',
            'nuevoHora' => 'nullable',
            'nuevoDepositante' => 'nullable|string|max:255',
            'nuevoComprobante' => 'nullable|string|max:100',
            'nuevoMonto' => 'required|numeric|min:0.01',
            'nuevoDetalle' => 'nullable|string',
            'nuevoTipoIngreso' => 'required|string|max:100',
            'nuevoObservacion' => 'nullable|string',
        ]);

        $hora = null;

        if ($this->nuevoHora) {
            $hora = strlen($this->nuevoHora) === 5
                ? $this->nuevoHora.':00'
                : $this->nuevoHora;
        }

        $fechaHora = $this->nuevoFecha.' '.($hora ?: '00:00:00');

        DB::table('ingresos_bancarios')->insert([
            'fecha' => $this->nuevoFecha,
            'hora' => $hora,
            'fecha_hora' => $fechaHora,

            'anio' => (int) date('Y', strtotime($this->nuevoFecha)),
            'mes' => (int) date('m', strtotime($this->nuevoFecha)),

            'depositante' => mb_strtoupper(trim($this->nuevoDepositante ?? ''), 'UTF-8'),
            'detalle' => mb_strtoupper(trim($this->nuevoDetalle ?: $this->nuevoDepositante), 'UTF-8'),
            'numero_comprobante' => trim($this->nuevoComprobante ?? ''),
            'monto' => (float) $this->nuevoMonto,

            'tipo_ingreso' => $this->nuevoTipoIngreso,
            'estado' => 'Pendiente',

            'monto_aplicado' => 0,
            'saldo_pendiente' => (float) $this->nuevoMonto,

            'origen' => 'MANUAL',
            'archivo_origen' => 'REGISTRO MANUAL',
            'observacion' => $this->nuevoObservacion,

            'iduser' => Auth::id(),
            'nameuser' => Auth::user()->name ?? null,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->modalCrearIngreso = false;

        $this->emit('alert', 'Ingreso bancario creado correctamente.');
    }

    public function obtenerDepartamentoSugerido($depositante)
    {
        if (! $depositante) {
            return null;
        }

        $depositante = trim($depositante ?? '');

        if (
            $depositante === '' ||
            strtoupper($depositante) === 'SIN NOMBRE' ||
            str_contains(strtoupper($depositante), 'SIN NOMBRE')
        ) {
            return null;
        }
        $sugerenciaAplicaciones = DB::table('ingresos_bancarios_aplicaciones')
            ->whereNotNull('departamento_nombre')
            ->where('departamento_nombre', '!=', '')
            ->where('estado', '!=', 'Anulado')
            ->whereIn('ingreso_bancario_id', function ($query) use ($depositante) {
                $query->select('id')
                    ->from('ingresos_bancarios')
                    ->where('depositante', 'like', '%'.$depositante.'%');
            })
            ->select(
                'departamento_nombre',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('departamento_nombre')
            ->orderByDesc('cantidad')
            ->first();

        if ($sugerenciaAplicaciones) {
            return [
                'departamento' => $sugerenciaAplicaciones->departamento_nombre,
                'origen' => 'Regularizado',
                'confianza' => 'Alta',
                'cantidad' => $sugerenciaAplicaciones->cantidad,
            ];
        }

        $nombreCorto = $this->normalizarNombreCorto($depositante);

        $sugerenciaPagos = DB::table('pagos')
            ->whereNotNull('empresa')
            ->where('empresa', '!=', '')
            ->where(function ($q) use ($depositante, $nombreCorto) {
                $q->where('namebeneficiario', 'like', '%'.$depositante.'%')
                    ->orWhere('namebeneficiario', 'like', '%'.$nombreCorto.'%');
            })
            ->select(
                'empresa',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('empresa')
            ->orderByDesc('cantidad')
            ->first();

        if ($sugerenciaPagos) {
            return [
                'departamento' => $sugerenciaPagos->empresa,
                'origen' => 'Pagos antiguos',
                'confianza' => 'Media',
                'cantidad' => $sugerenciaPagos->cantidad,
            ];
        }

        return null;
    }

    public function normalizarNombreCorto($nombre)
    {
        $nombre = trim($nombre);
        $partes = preg_split('/\s+/', $nombre);

        if (count($partes) >= 2) {
            return $partes[0].' '.$partes[1];
        }

        return $nombre;
    }

    public function getAplicacionesActualesProperty()
    {
        if (! $this->ingresoId) {
            return collect();
        }

        return DB::table('ingresos_bancarios_aplicaciones')
            ->where('ingreso_bancario_id', $this->ingresoId)
            ->orderBy('id')
            ->get();
    }

    public function getDepartamentosProperty()
    {
        return DB::table('tratamientos')
            ->select('id', 'nombre', 'costo')
            ->orderBy('nombre')
            ->get();
    }

    public function obtenerSugerenciasMultiples($ingreso)
    {
        $depositante = trim($ingreso->depositante ?? '');

        if (
            $depositante === '' ||
            strtoupper($depositante) === 'SIN NOMBRE' ||
            str_contains(strtoupper($depositante), 'SIN NOMBRE')
        ) {
            return [];
        }
        $sugerencias = collect();

        $montoIngreso = round((float) $ingreso->monto, 2);
        $depositante = trim($ingreso->depositante ?? '');

        if ($depositante === '') {
            return [];
        }

        /*
            1. Sugerencia principal por nombre del depositante
        */
        $sugerenciaPrincipal = $this->obtenerDepartamentoSugerido($depositante);

        if ($sugerenciaPrincipal && ! empty($sugerenciaPrincipal['departamento'])) {
            $sugerencias->push([
                'departamento' => $sugerenciaPrincipal['departamento'],
                'origen' => 'Sugerencia principal',
                'prioridad' => 1,
            ]);
        }

        /*
            2. Buscar historial del mismo depositante.
            Si esa persona ya pagó 12E, 12F, 12G, el sistema aprende de eso.
        */
        $historialDepartamentos = DB::table('ingresos_bancarios as ib')
            ->join('ingresos_bancarios_aplicaciones as iba', 'iba.ingreso_bancario_id', '=', 'ib.id')
            ->where('iba.estado', '!=', 'Anulado')
            ->where('ib.depositante', $depositante)
            ->whereNotNull('iba.departamento_nombre')
            ->select(
                'iba.departamento_nombre',
                DB::raw('COUNT(*) as veces'),
                DB::raw('MAX(iba.fecha_aplicacion) as ultima_aplicacion')
            )
            ->groupBy('iba.departamento_nombre')
            ->orderByDesc('veces')
            ->orderByDesc('ultima_aplicacion')
            ->get();

        foreach ($historialDepartamentos as $historial) {
            $sugerencias->push([
                'departamento' => $historial->departamento_nombre,
                'origen' => 'Historial del depositante',
                'prioridad' => 2,
            ]);

            /*
                3. También buscar el siguiente departamento.
                Ejemplo: si pagó 12E, sugerir 12F.
            */
            $siguiente = $this->obtenerSiguienteDepartamento($historial->departamento_nombre);

            if ($siguiente) {
                $sugerencias->push([
                    'departamento' => $siguiente,
                    'origen' => 'Siguiente correlativo',
                    'prioridad' => 3,
                ]);
            }
        }

        /*
            4. Quitar duplicados y validar que tenga deuda pendiente
        */
        $sugerencias = $sugerencias
            ->unique('departamento')
            ->values()
            ->filter(function ($item) use ($ingreso, $montoIngreso) {
                $expensa = $this->obtenerPrimeraExpensaAdeudada($item['departamento'], $ingreso->fecha);

                if (! $expensa) {
                    return false;
                }

                $calculo = $this->calcularMontoObjetivoExpensa($expensa, $ingreso->fecha);

                $saldoReal = round((float) $calculo['saldo_real'], 2);
                $montoExpensa = round((float) $expensa->monto_expensa, 2);
                $montoConDescuento = round((float) ($expensa->monto_con_descuento ?? 0), 2);

                /*
                    Acepta:
                    - monto exacto
                    - monto con descuento
                    - monto normal menos 100 Bs
                    - pago parcial menor al saldo
                */
                $coincideMonto =
                    $montoIngreso == $saldoReal ||
                    $montoIngreso == $montoConDescuento ||
                    $montoIngreso == round($montoExpensa - 100, 2) ||
                    $montoIngreso < $saldoReal;

                return $coincideMonto;
            })
            ->map(function ($item) use ($ingreso) {
                $expensa = $this->obtenerPrimeraExpensaAdeudada($item['departamento'], $ingreso->fecha);
                $calculo = $this->calcularMontoObjetivoExpensa($expensa, $ingreso->fecha);

                $item['mes'] = $this->nombreMes((int) $expensa->mes);
                $item['anio'] = $expensa->anio;
                $item['monto_expensa'] = (float) $expensa->monto_expensa;
                $item['monto_objetivo'] = (float) $calculo['monto_objetivo'];
                $item['saldo_real'] = (float) $calculo['saldo_real'];
                $item['tipo_estado'] = $calculo['tipo_estado'];

                return $item;
            })
            ->sortBy('prioridad')
            ->values();

        return $sugerencias->take(5)->toArray();
    }

    public function obtenerSiguienteDepartamento($departamentoNombre)
    {
        $departamentoNombre = trim($departamentoNombre);

        /*
            Busca patrón tipo:
            12E, 12-F, DPTO 12E, DEPTO 12E
        */
        preg_match('/(\d+)\s*[-]?\s*([A-Z])$/i', $departamentoNombre, $matches);

        if (count($matches) < 3) {
            return null;
        }

        $numero = $matches[1];
        $letra = strtoupper($matches[2]);

        $siguienteLetra = chr(ord($letra) + 1);

        if ($siguienteLetra > 'Z') {
            return null;
        }

        /*
            Busca en tratamientos un departamento parecido.
            Ejemplo: si llega 12E, busca 12F.
        */
        $posibles = DB::table('tratamientos')
            ->where(function ($q) use ($numero, $siguienteLetra) {
                $q->where('nombre', 'like', '%'.$numero.$siguienteLetra.'%')
                    ->orWhere('nombre', 'like', '%'.$numero.'-'.$siguienteLetra.'%')
                    ->orWhere('nombre', 'like', '%DEPTO '.$numero.$siguienteLetra.'%')
                    ->orWhere('nombre', 'like', '%DPTO '.$numero.$siguienteLetra.'%');
            })
            ->orderBy('nombre')
            ->first();

        return $posibles->nombre ?? null;
    }

    public function usarSugerenciaDepartamento($ingresoId, $departamento)
    {
        $ingreso = DB::table('ingresos_bancarios')
            ->where('id', $ingresoId)
            ->first();

        if (! $ingreso) {
            $this->emit('error', 'No se encontró el ingreso.');

            return;
        }

        $departamento = trim($departamento ?? '');

        if ($departamento === '') {
            $this->emit('error', 'No se recibió el departamento sugerido.');

            return;
        }

        /*
            IMPORTANTE:
            Abrimos el modal con el mismo método que ya funciona
            en usarSugerencia().
        */
        $this->abrirRegularizar($ingresoId);

        /*
            Cargamos el departamento elegido desde las sugerencias múltiples.
        */
        $this->departamentoSeleccionado = $departamento;

        /*
            Año inicial según la fecha del ingreso.
            Luego se reemplaza por el año real de la expensa encontrada.
        */
        $this->anioExpensas = (int) date('Y', strtotime($ingreso->fecha));

        /*
            Buscar la primera expensa pendiente del departamento seleccionado.
        */
        $expensa = $this->obtenerPrimeraExpensaAdeudada($departamento, $ingreso->fecha);

        if (! $expensa) {
            $this->buscarDepartamento();
            $this->emit('error', 'No se encontró una expensa pendiente para este departamento.');

            return;
        }

        /*
            Cargar el año correcto y buscar sus expensas.
        */
        $this->anioExpensas = (int) $expensa->anio;
        $this->buscarDepartamento();

        /*
            Calcular monto sugerido según regla:
            normal, descuento o parcial.
        */
        $calculo = $this->calcularMontoObjetivoExpensa($expensa, $ingreso->fecha);

        $saldoRealExpensa = round((float) ($calculo['saldo_real'] ?? 0), 2);
        $saldoIngreso = round((float) ($this->ingresoSaldo ?? 0), 2);

        if ($saldoIngreso <= 0) {
            $saldoIngreso = round((float) ($ingreso->saldo_pendiente ?? $ingreso->monto), 2);
        }

        $montoSugerido = min($saldoRealExpensa, $saldoIngreso);
        $montoSugerido = round((float) $montoSugerido, 2);

        if ($montoSugerido <= 0) {
            $this->emit('error', 'No hay saldo disponible para aplicar.');

            return;
        }

        $estadoPago = 'Pagado';

        if ($montoSugerido < $saldoRealExpensa) {
            $estadoPago = 'Parcial';
        }

        if (($calculo['tipo_estado'] ?? null) === 'Descuento pronto pago') {
            $estadoPago = 'Descuento pronto pago';
        }

        /*
            Evitar duplicar la misma expensa si se hace doble click.
        */
        $yaExisteLinea = collect($this->lineas)->contains(function ($linea) use ($expensa) {
            return (int) ($linea['expensa_id'] ?? 0) === (int) $expensa->id;
        });

        if (! $yaExisteLinea) {
            $this->lineas[] = [
                'tipo' => 'Expensa',
                'expensa_id' => $expensa->id,
                'departamento_nombre' => $expensa->departamento_nombre,
                'anio' => $expensa->anio,
                'mes' => $expensa->mes,
                'fecha_mes' => $expensa->fecha_mes,
                'monto' => $montoSugerido,
                'estado_pago' => $estadoPago,
                'observacion' => 'Aplicado desde sugerencia múltiple',
            ];
        }
    }

    protected function aplicarImportacionDesdeExcel($ingresoId, $aplicacion)
    {
        if (($aplicacion['tipo_aplicacion'] ?? 'Expensa') === 'Expensa') {
            $this->aplicarImportacionAExpensas($ingresoId, $aplicacion);

            return;
        }

        IngresoBancarioAplicacion::create([
            'ingreso_bancario_id' => $ingresoId,
            'expensa_id' => null,
            'tipo_aplicacion' => $aplicacion['tipo_aplicacion'],
            'codigo_departamento' => null,
            'departamento_nombre' => null,
            'fecha_inicio_pago' => null,
            'anio_pago' => null,
            'mes_pago' => null,
            'monto' => round((float) $aplicacion['monto'], 2),
            'pago_id' => null,
            'estado' => 'Confirmado',
            'estado_pago' => $aplicacion['tipo_aplicacion'],
            'fecha_aplicacion' => now(),
            'observacion' => $aplicacion['observacion'] ?: 'Importado por Excel',
            'iduser' => Auth::id(),
            'nameuser' => Auth::user()->name ?? null,
        ]);
    }

    protected function aplicarImportacionAExpensas($ingresoId, $aplicacion)
    {
        $montoPendiente = round((float) $aplicacion['monto'], 2);

        foreach ($aplicacion['meses'] as $mes) {
            if ($montoPendiente <= 0) {
                break;
            }

            $expensa = DB::table('expensas')
                ->where('departamento_nombre', $aplicacion['departamento'])
                ->where('anio', $aplicacion['anio'])
                ->where('mes', $mes)
                ->first();

            if (! $expensa) {
                continue;
            }

            $saldoExpensa = round((float) ($expensa->saldo ?? 0), 2);
            $montoAplicar = min($montoPendiente, $saldoExpensa > 0 ? $saldoExpensa : $montoPendiente);
            $montoAplicar = round((float) $montoAplicar, 2);

            if ($montoAplicar <= 0) {
                continue;
            }

            $nuevoPagado = round((float) ($expensa->monto_pagado ?? 0) + $montoAplicar, 2);
            $nuevoSaldo = round(max(0, (float) ($expensa->monto_expensa ?? 0) - $nuevoPagado), 2);
            $estadoPago = $nuevoSaldo <= 0 ? 'Pagado' : 'Parcial';

            IngresoBancarioAplicacion::create([
                'ingreso_bancario_id' => $ingresoId,
                'expensa_id' => $expensa->id,
                'tipo_aplicacion' => 'Expensa',
                'codigo_departamento' => null,
                'departamento_nombre' => $expensa->departamento_nombre,
                'nombre_departamento' => $expensa->departamento_nombre,
                'fecha_inicio_pago' => $expensa->fecha_mes,
                'anio_pago' => $expensa->anio,
                'mes_pago' => $expensa->mes,
                'monto' => $montoAplicar,
                'pago_id' => null,
                'estado' => 'Confirmado',
                'estado_pago' => $estadoPago,
                'fecha_aplicacion' => now(),
                'observacion' => $aplicacion['observacion'] ?: 'Importado por Excel',
                'iduser' => Auth::id(),
                'nameuser' => Auth::user()->name ?? null,
            ]);

            DB::table('expensas')
                ->where('id', $expensa->id)
                ->update([
                    'monto_pagado' => $nuevoPagado,
                    'saldo' => $nuevoSaldo,
                    'estado' => $estadoPago,
                    'tipo_estado' => $estadoPago,
                    'updated_at' => now(),
                ]);

            $montoPendiente = round($montoPendiente - $montoAplicar, 2);
        }
    }

    protected function normalizarTipoAplicacionExcel($value)
    {
        $value = mb_strtoupper(trim((string) $value), 'UTF-8');
        $value = str_replace(['Á', 'É', 'Í', 'Ó', 'Ú'], ['A', 'E', 'I', 'O', 'U'], $value);

        $tipos = [
            'EXPENSA' => 'Expensa',
            'EXPENSAS' => 'Expensa',
            'PAGO EXPENSA' => 'Expensa',
            'PAGO EXPENSAS' => 'Expensa',
            'GESTION ANTERIOR' => 'Gestion anterior',
            'ALQUILER SALON' => 'Alquiler salon',
            'ALQUILER DE SALON' => 'Alquiler salon',
            'OTRO INGRESO' => 'Otro ingreso',
            'OTROS INGRESOS' => 'Otro ingreso',
            'NO IDENTIFICADO' => 'No identificado',
        ];

        return $tipos[$value] ?? null;
    }

    protected function normalizarFechaExcel($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function normalizarHoraExcel($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('H:i:s');
        }

        if (is_numeric($value) && (float) $value < 1) {
            $seconds = (int) round((float) $value * 86400);

            return gmdate('H:i:s', $seconds);
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        return strlen($value) === 5 ? $value.':00' : $value;
    }

    protected function parseMesesImportacion($value)
    {
        $mesesTexto = [
            'ENERO' => 1,
            'FEBRERO' => 2,
            'MARZO' => 3,
            'ABRIL' => 4,
            'MAYO' => 5,
            'JUNIO' => 6,
            'JULIO' => 7,
            'AGOSTO' => 8,
            'SEPTIEMBRE' => 9,
            'SETIEMBRE' => 9,
            'OCTUBRE' => 10,
            'NOVIEMBRE' => 11,
            'DICIEMBRE' => 12,
        ];

        return collect(preg_split('/[,;|]+/', mb_strtoupper((string) $value, 'UTF-8')))
            ->map(fn ($mes) => trim($mes))
            ->filter()
            ->map(fn ($mes) => is_numeric($mes) ? (int) $mes : ($mesesTexto[$mes] ?? null))
            ->filter(fn ($mes) => $mes >= 1 && $mes <= 12)
            ->unique()
            ->values()
            ->toArray();
    }

    public function render()
    {
        $queryBase = DB::table('ingresos_bancarios')
            ->when($this->anio, function ($q) {
                $q->where('anio', $this->anio);
            })
            ->when($this->mes, function ($q) {
                $q->where('mes', $this->mes);
            })
            ->when($this->estado != 'Todos', function ($q) {
                $q->where('estado', $this->estado);
            })
            ->when($this->busqueda, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('depositante', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('numero_comprobante', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('detalle', 'like', '%'.$this->busqueda.'%');
                });
            })
            ->when($this->filtroTipoMonto === 'salon', function ($q) {
                $q->where('monto', '<=', 150);
            })
            ->when($this->filtroTipoMonto === 'expensa', function ($q) {
                $q->where('monto', '>', 150);
            });

        /*
            TOTAL SEGÚN FILTROS:
            - Si seleccionas año y mes: total del mes.
            - Si seleccionas solo año: total de la gestión.
            - También respeta estado y búsqueda.
        */
        $this->totalIngresosFiltrado = (float) (clone $queryBase)->sum('monto');

        if ($this->anio && $this->mes) {
            $this->labelTotalIngresos = 'Total del mes';
        } elseif ($this->anio) {
            $this->labelTotalIngresos = 'Total de la gestión';
        } else {
            $this->labelTotalIngresos = 'Total general';
        }
        $ingresos = DB::table('ingresos_bancarios')
            ->when($this->anio, function ($q) {
                $q->where('anio', $this->anio);
            })
            ->when($this->mes, function ($q) {
                $q->where('mes', $this->mes);
            })
            ->when($this->estado != 'Todos', function ($q) {
                $q->where('estado', $this->estado);
            })
            ->when($this->busqueda, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('depositante', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('numero_comprobante', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('detalle', 'like', '%'.$this->busqueda.'%');
                });
            })
            ->when($this->filtroTipoMonto === 'salon', function ($q) {
                $q->where('monto', '<=', 150);
            })
            ->when($this->filtroTipoMonto === 'expensa', function ($q) {
                $q->where('monto', '>', 150);
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->paginate(25);

        $ingresos->getCollection()->transform(function ($item) {
            /*
                Sugerencia principal anterior.
                Se mantiene para no romper el Blade actual.
            */
            $item->sugerencia_departamento = $this->obtenerDepartamentoSugerido($item->depositante);

            /*
                Nueva lista de sugerencias:
                - sugerencia principal
                - historial del depositante
                - siguiente correlativo: 12E -> 12F -> 12G
                - validación por monto normal o con descuento
            */
            $item->sugerencias_multiples = $this->obtenerSugerenciasMultiples($item);

            return $item;
        });

        return view('livewire.tesoreria.regularizar-ingresos', [
            'ingresos' => $ingresos,
        ]);
    }
}
