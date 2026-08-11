<?php

namespace App\Http\Livewire\Tesoreria;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Process\Process;

class InformeIngresosEgresos extends Component
{
    public $anio;

    public $mes;

    public $tabActiva = 'ingresos';

    public $ingresos = [];

    public $totalIngresosMes = 0;

    public $totalEgresosMes = 0;

    public $totalIngresosAcumulado = 0;

    public $totalEgresosAcumulado = 0;

    public $totalCuenta = 0;

    public $saldoAnterior = 0;

    public $saldoFinalIngresos = 0;

    public $egresos = [];

    public $resumenMes = [
        'ingresos_expensas' => 0,
        'expensas_no_registradas' => 0,
        'alquiler_salon' => 0,
        'otros' => 0,
        'total_ingresos_mes' => 0,
        'total_egresos_mes' => 0,
        'saldo_anterior' => 0,
        'saldo_final_mes' => 0,
    ];

    public function exportarExcel()
    {
        $spreadsheet = new Spreadsheet();

        /*
        |--------------------------------------------------------------------------
        | INGRESOS
        |--------------------------------------------------------------------------
        */

        $ingresos = DB::table('ingresos_bancarios')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | EGRESOS
        |--------------------------------------------------------------------------
        */

        $egresos = DB::table('gastos')
            ->orderBy('fechainicio', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RESUMEN
        |--------------------------------------------------------------------------
        */

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('cantidad');
        $saldo = $totalIngresos - $totalEgresos;

        $hojaResumen = $spreadsheet->getActiveSheet();
        $hojaResumen->setTitle('Resumen');

        $hojaResumen->setCellValue('A1', 'TRIBECA SOHO');
        $hojaResumen->setCellValue('A2', 'RESUMEN FINANCIERO');

        $hojaResumen->setCellValue('A4', 'Total ingresos');
        $hojaResumen->setCellValue('B4', $totalIngresos);

        $hojaResumen->setCellValue('A5', 'Total egresos');
        $hojaResumen->setCellValue('B5', $totalEgresos);

        $hojaResumen->setCellValue('A6', 'Saldo');
        $hojaResumen->setCellValue('B6', $saldo);

        /*
        |--------------------------------------------------------------------------
        | HOJA INGRESOS
        |--------------------------------------------------------------------------
        */

        $hojaIngresos = $spreadsheet->createSheet();
        $hojaIngresos->setTitle('Ingresos');

        $hojaIngresos->fromArray([
            [
                'Fecha',
                'Hora',
                'Depositante',
                'Detalle',
                'Comprobante',
                'Monto',
                'Tipo',
                'Estado',
                'Saldo pendiente',
            ],
        ]);

        $fila = 2;

        foreach ($ingresos as $ingreso) {

            $hojaIngresos->setCellValue('A'.$fila, $ingreso->fecha);
            $hojaIngresos->setCellValue('B'.$fila, $ingreso->hora);
            $hojaIngresos->setCellValue('C'.$fila, $ingreso->depositante);
            $hojaIngresos->setCellValue('D'.$fila, $ingreso->detalle);
            $hojaIngresos->setCellValue('E'.$fila, $ingreso->numero_comprobante);
            $hojaIngresos->setCellValue('F'.$fila, $ingreso->monto);
            $hojaIngresos->setCellValue('G'.$fila, $ingreso->tipo_ingreso);
            $hojaIngresos->setCellValue('H'.$fila, $ingreso->estado);
            $hojaIngresos->setCellValue('I'.$fila, $ingreso->saldo_pendiente);

            $fila++;
        }

        /*
        |--------------------------------------------------------------------------
        | HOJA EGRESOS
        |--------------------------------------------------------------------------
        */

        $hojaEgresos = $spreadsheet->createSheet();
        $hojaEgresos->setTitle('Egresos');

        $hojaEgresos->fromArray([
            [
                'Fecha',
                'Detalle',
                'Tipo',
                'Modo',
                'Área',
                'Responsable',
                'Monto',
            ],
        ]);

        $fila = 2;

        foreach ($egresos as $egreso) {

            $hojaEgresos->setCellValue(
                'A'.$fila,
                $egreso->fechainicio
            );

            $hojaEgresos->setCellValue(
                'B'.$fila,
                $egreso->empresa
            );

            $hojaEgresos->setCellValue(
                'C'.$fila,
                $egreso->tipo
            );

            $hojaEgresos->setCellValue(
                'D'.$fila,
                $egreso->modo
            );

            $hojaEgresos->setCellValue(
                'E'.$fila,
                $egreso->area
            );

            $hojaEgresos->setCellValue(
                'F'.$fila,
                $egreso->nameuser
            );

            $hojaEgresos->setCellValue(
                'G'.$fila,
                $egreso->cantidad
            );

            $fila++;
        }

        /*
        |--------------------------------------------------------------------------
        | AJUSTAR COLUMNAS
        |--------------------------------------------------------------------------
        */

        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {

            foreach ($worksheet->getColumnIterator() as $column) {
                $worksheet
                    ->getColumnDimension($column->getColumnIndex())
                    ->setAutoSize(true);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR
        |--------------------------------------------------------------------------
        */

        $nombreArchivo =
            'TRIBECA_SOHO_FINANZAS_'.
            date('Y-m-d_H-i-s').
            '.xlsx';

        $ruta = storage_path('app/'.$nombreArchivo);

        $writer = new Xlsx($spreadsheet);
        $writer->save($ruta);

        return response()
            ->download($ruta)
            ->deleteFileAfterSend(true);
    }

    public function exportarSql()
    {
        $connection = config('database.default');
        $config = config("database.connections.$connection");

        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;

        $nombreArchivo = 'TRIBECA_SOHO_BACKUP_'.date('Y-m-d_H-i-s').'.sql';

        $ruta = storage_path('app/'.$nombreArchivo);

        if ($connection === 'mysql') {

            $process = new Process([
                'mysqldump',
                '--host='.$host,
                '--port='.$port,
                '--user='.$username,
                '--single-transaction',
                '--routines',
                '--triggers',
                '--events',
                '--default-character-set=utf8mb4',
                $database,
            ]);

            /*
             * Evitamos poner la contraseña directamente
             * dentro del comando.
             */
            $process->setEnv([
                'MYSQL_PWD' => $password,
            ]);

            $process->setTimeout(300);

            $process->run(function ($type, $buffer) use ($ruta) {
                if ($type === Process::OUT) {
                    File::append($ruta, $buffer);
                }
            });

            if (! $process->isSuccessful()) {

                if (File::exists($ruta)) {
                    File::delete($ruta);
                }

                $this->emit(
                    'alert',
                    'No se pudo generar el respaldo SQL: '.$process->getErrorOutput()
                );

                return;
            }

        } else {

            $this->emit(
                'alert',
                'Por ahora esta función está configurada para MySQL.'
            );

            return;
        }

        return response()->download($ruta)->deleteFileAfterSend(true);
    }

    public function generarPdf()
    {
        $this->cargarTodo();

        $nombreMes = $this->nombreMes((int) $this->mes);

        $orientacion = $this->tabActiva === 'resumen'
            ? 'portrait'
            : 'landscape';

        $titulo = match ($this->tabActiva) {
            'ingresos' => 'Informe de Ingresos',
            'egresos' => 'Informe de Egresos',
            'resumen' => 'Resumen del Mes',
            default => 'Informe',
        };

        $data = [
            'titulo' => $titulo,
            'tabActiva' => $this->tabActiva,
            'anio' => $this->anio,
            'mes' => $this->mes,
            'nombreMes' => $nombreMes,

            'ingresos' => $this->ingresos,
            'egresos' => $this->egresos,
            'resumenMes' => $this->resumenMes,

            'totalIngresosMes' => $this->totalIngresosMes,
            'totalEgresosMes' => $this->totalEgresosMes,
            'totalIngresosAcumulado' => $this->totalIngresosAcumulado,
            'totalEgresosAcumulado' => $this->totalEgresosAcumulado,
            'totalCuenta' => $this->totalCuenta,
            'saldoAnterior' => $this->saldoAnterior,
            'saldoFinalIngresos' => $this->saldoFinalIngresos,

            'footer' => 'Generado por Sistema Tribeca · Digitbol · Esrom Obed Andrade Ortiz',
            'fechaGeneracion' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.informe-ingresos-egresos', $data)
            ->setPaper('letter', $orientacion);

        $nombreArchivo = strtolower($this->tabActiva).'-'.strtolower($nombreMes).'-'.$this->anio.'.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    public function mount()
    {
        $this->anio = (int) now()->year;
        $this->mes = (int) now()->month;

        $this->cargarTodo();
    }

    public function updatedAnio()
    {
        $this->cargarTodo();
    }

    public function updatedMes()
    {
        $this->cargarTodo();
    }

    public function cambiarTab($tab)
    {
        $this->tabActiva = $tab;
        $this->cargarTodo();
    }

    public function cargarTodo()
    {

        $this->calcularTotalesGenerales();
        $this->cargarIngresos();
        $this->cargarEgresos();
        $this->calcularResumenMes();
    }

    public function cargarIngresos()
    {
        $this->ingresos = [];
        $this->totalIngresosMes = 0;
        $this->saldoAnterior = $this->calcularSaldoAnteriorReal();
        $this->saldoFinalIngresos = $this->saldoAnterior;

        $registros = DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', function ($join) {
                $join->on('iba.ingreso_bancario_id', '=', 'ib.id')
                    ->where('iba.estado', '!=', 'Anulado');
            })
            ->where('ib.anio', (int) $this->anio)
            ->where('ib.mes', (int) $this->mes)
            ->select(
                'ib.id',
                'ib.fecha',
                'ib.hora',
                'ib.fecha_hora',
                'ib.depositante',
                'ib.detalle',
                'ib.numero_comprobante',
                'ib.monto',
                'ib.tipo_ingreso',
                'ib.estado',
                DB::raw("GROUP_CONCAT(DISTINCT iba.departamento_nombre ORDER BY iba.departamento_nombre SEPARATOR ', ') AS departamentos"),
                DB::raw("GROUP_CONCAT(DISTINCT CONCAT(iba.mes_pago, '/', iba.anio_pago) ORDER BY iba.anio_pago, iba.mes_pago SEPARATOR ', ') AS meses_aplicados"),
                DB::raw("GROUP_CONCAT(DISTINCT iba.tipo_aplicacion ORDER BY iba.tipo_aplicacion SEPARATOR ', ') AS tipos_aplicacion"),
                DB::raw("GROUP_CONCAT(DISTINCT iba.observacion ORDER BY iba.id SEPARATOR ' | ') AS observaciones_aplicacion"),
                DB::raw('COUNT(iba.id) AS cantidad_aplicaciones')
            )
            ->groupBy(
                'ib.id',
                'ib.fecha',
                'ib.hora',
                'ib.fecha_hora',
                'ib.depositante',
                'ib.detalle',
                'ib.numero_comprobante',
                'ib.monto',
                'ib.tipo_ingreso',
                'ib.estado'
            )
            ->orderBy('ib.fecha')
            ->orderBy('ib.hora')
            ->orderBy('ib.id')
            ->get();

        $saldoAcumulado = $this->saldoAnterior;

        foreach ($registros as $item) {
            $monto = round((float) $item->monto, 2);
            $saldoAcumulado = round($saldoAcumulado + $monto, 2);

            $departamentos = trim($item->departamentos ?? '');
            $meses = $this->formatearMesesAplicados($item->meses_aplicados);

            $detalleBase = trim($item->detalle ?: $item->depositante ?: '');
            $usoSalon = '';
            $otro = '';

            $tiposAplicacion = strtoupper($item->tipos_aplicacion ?? '');
            $tipoIngreso = strtoupper($item->tipo_ingreso ?? '');
            $depositanteUpper = strtoupper($item->depositante ?? '');
            $detalleUpper = strtoupper($detalleBase);

            /*
                USO DE SALÓN
            */
            if (
                str_contains($tiposAplicacion, 'SALON') ||
                str_contains($tiposAplicacion, 'SALÓN') ||
                str_contains($detalleUpper, 'SALON') ||
                str_contains($detalleUpper, 'SALÓN')
            ) {
                $usoSalon = $item->observaciones_aplicacion ?: $detalleBase;
            }

            /*
                OTROS
            */
            if (
                $tipoIngreso === 'OTRO INGRESO' ||
                str_contains($depositanteUpper, 'PAGO DE INTERES') ||
                str_contains($depositanteUpper, 'PAGO DE INTERESES') ||
                str_contains($depositanteUpper, 'EFECTIVO / OTROS')
            ) {
                $otro = $detalleBase;
            }

            /*
                Si no encuentra departamento, pero hay detalle disponible,
                se marca como Gestión anterior y en meses va la descripción.
            */
            if ($departamentos === '' && $detalleBase !== '' && $otro === '' && $usoSalon === '') {
                $departamentos = 'Gestión anterior';

                $observacionGestionAnterior = trim($item->observaciones_aplicacion ?? '');

                if ($observacionGestionAnterior !== '') {
                    $meses = $observacionGestionAnterior;
                } else {
                    $meses = $detalleBase;
                }
            }

            /*
                Si no tiene aplicaciones y tampoco detalle útil,
                queda como sin registrar.
            */
            if ((int) $item->cantidad_aplicaciones === 0 && $departamentos === '') {
                $departamentos = '-';
                $meses = '-';
            }
            $categoriaIngreso = 'expensas';

            if ($usoSalon !== '') {
                $categoriaIngreso = 'alquiler_salon';
            }

            if ($otro !== '') {
                $categoriaIngreso = 'otros';
            }

            if ((int) $item->cantidad_aplicaciones === 0 && $otro === '' && $usoSalon === '') {
                $categoriaIngreso = 'expensas_no_registradas';
            }

            $this->ingresos[] = [
                'id' => $item->id,
                'fecha' => $item->fecha,
                'hora' => $item->hora,
                'fecha_hora' => $item->fecha_hora,
                'monto' => $monto,
                'depositante' => $item->depositante,
                'detalle' => $detalleBase,
                'numero_comprobante' => $item->numero_comprobante,
                'departamentos' => $departamentos,
                'meses' => $meses,
                'uso_salon' => $usoSalon,
                'otro' => $otro,
                'saldo' => $saldoAcumulado,
                'cantidad_aplicaciones' => (int) $item->cantidad_aplicaciones,
                'estado' => $item->estado,
                'categoria' => $categoriaIngreso,
            ];
        }

        $this->totalIngresosMes = round(collect($this->ingresos)->sum('monto'), 2);
        $this->saldoFinalIngresos = $saldoAcumulado;
    }

    public function normalizarFechaGasto($valor)
    {
        if (! $valor) {
            return null;
        }

        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $valor)) {
                return Carbon::parse($valor)->format('Y-m-d');
            }

            if (preg_match('/^\d{2}\/\d{2}\/\d{4}/', $valor)) {
                return Carbon::createFromFormat('d/m/Y', substr($valor, 0, 10))->format('Y-m-d');
            }

            return Carbon::parse($valor)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function normalizarHoraGasto($valor, $createdAt = null)
    {
        if ($valor && preg_match('/\d{2}:\d{2}/', $valor, $match)) {
            return $match[0].':00';
        }

        if ($createdAt) {
            try {
                return Carbon::parse($createdAt)->format('H:i:s');
            } catch (\Throwable $e) {
                return '00:00:00';
            }
        }

        return '00:00:00';
    }

    public function calcularResumenMes()
    {
        $ingresosExpensas = 0;
        $expensasNoRegistradas = 0;
        $alquilerSalon = 0;
        $otros = 0;

        foreach ($this->ingresos as $item) {
            $monto = round((float) ($item['monto'] ?? 0), 2);

            if (($item['categoria'] ?? '') === 'expensas') {
                $ingresosExpensas += $monto;
            }

            if (($item['categoria'] ?? '') === 'expensas_no_registradas') {
                $expensasNoRegistradas += $monto;
            }

            if (($item['categoria'] ?? '') === 'alquiler_salon') {
                $alquilerSalon += $monto;
            }

            if (($item['categoria'] ?? '') === 'otros') {
                $otros += $monto;
            }
        }

        $totalIngresosMes = round($ingresosExpensas + $expensasNoRegistradas + $alquilerSalon + $otros, 2);

        $saldoFinalMes = round($this->saldoAnterior + $totalIngresosMes - $this->totalEgresosMes, 2);

        $this->resumenMes = [
            'ingresos_expensas' => round($ingresosExpensas, 2),
            'expensas_no_registradas' => round($expensasNoRegistradas, 2),
            'alquiler_salon' => round($alquilerSalon, 2),
            'otros' => round($otros, 2),
            'total_ingresos_mes' => $totalIngresosMes,
            'total_egresos_mes' => round($this->totalEgresosMes, 2),
            'saldo_anterior' => round($this->saldoAnterior, 2),
            'saldo_final_mes' => $saldoFinalMes,
        ];
    }

    public function cargarEgresos()
    {
        $this->egresos = [];

        $fechaInicioMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $registros = $this->queryGastosEntre($fechaInicioMes, $fechaFinMes)
            ->select(
                'id',
                'fecha',
                'fechainicio',
                'fechapagado',
                'empresa',
                'tipo',
                'area',
                'pertence',
                'estado',
                'cantidad',
                'pagado',
                'created_at'
            )
            ->orderByRaw("
            COALESCE(
                STR_TO_DATE(NULLIF(fechapagado, ''), '%Y-%m-%d'),
                STR_TO_DATE(NULLIF(fechapagado, ''), '%d/%m/%Y'),
                STR_TO_DATE(NULLIF(fecha, ''), '%Y-%m-%d'),
                STR_TO_DATE(NULLIF(fecha, ''), '%d/%m/%Y'),
                created_at
            )
        ")
            ->orderBy('id')
            ->get();

        $total = 0;

        foreach ($registros as $item) {
            $fechaBase = $this->normalizarFechaGasto($item->fechainicio ?: $item->fecha ?: $item->created_at);
            $horaBase = $this->normalizarHoraGasto($item->fechainicio ?: $item->fecha ?: $item->created_at, $item->created_at);

            $detallePartes = [];

            if (! empty($item->empresa)) {
                $detallePartes[] = $item->empresa;
            }

            if (! empty($item->tipo)) {
                $detallePartes[] = $item->tipo;
            }

            if (! empty($item->area)) {
                $detallePartes[] = $item->area;
            }

            if (! empty($item->pertence)) {
                $detallePartes[] = $item->pertence;
            }

            $detalle = trim(implode(' - ', array_filter($detallePartes)));

            if ($detalle === '') {
                $detalle = 'Gasto registrado';
            }

            $monto = (float) ($item->pagado ?? 0);

            if ($monto <= 0) {
                $monto = (float) ($item->cantidad ?? 0);
            }

            $monto = round($monto, 2);
            $total = round($total + $monto, 2);

            $this->egresos[] = [
                'id' => $item->id,
                'fecha' => $fechaBase,
                'hora' => $horaBase,
                'detalle' => $detalle,
                'estado' => $item->estado,
                'monto' => $monto,
            ];
        }

        $this->totalEgresosMes = $total;
    }

    public function calcularTotalesGenerales()
    {
        $fechaInicioSistema = '2024-08-01';

        $fechaMesSeleccionado = Carbon::create(
            (int) $this->anio,
            (int) $this->mes,
            1
        )->endOfMonth()->toDateString();

        $this->totalIngresosAcumulado = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioSistema)
            ->whereDate('fecha', '<=', $fechaMesSeleccionado)
            ->sum('monto'), 2);

        $this->totalEgresosAcumulado = round((float) $this->queryGastosEntre(
            $fechaInicioSistema,
            $fechaMesSeleccionado
        )->sum('cantidad'), 2);

        $this->totalCuenta = round($this->totalIngresosAcumulado - $this->totalEgresosAcumulado, 2);

        $fechaInicioMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->startOfMonth()
            ->toDateString();

        $fechaFinMes = Carbon::create((int) $this->anio, (int) $this->mes, 1)
            ->endOfMonth()
            ->toDateString();

        $this->totalEgresosMes = round((float) $this->queryGastosEntre(
            $fechaInicioMes,
            $fechaFinMes
        )->sum('pagado'), 2);
    }

    public function calcularSaldoAnterior()
    {
        $fechaInicioSistema = '2024-08-01';

        $fechaMesSeleccionado = Carbon::create(
            (int) $this->anio,
            (int) $this->mes,
            1
        )->startOfMonth();

        $fechaFinAnterior = $fechaMesSeleccionado->copy()->subDay()->toDateString();

        if ($fechaFinAnterior < $fechaInicioSistema) {
            return 0;
        }

        $totalIngresosAnteriores = (float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioSistema)
            ->whereDate('fecha', '<=', $fechaFinAnterior)
            ->sum('monto');

        $totalGastosAnteriores = (float) $this->queryGastosEntre(
            $fechaInicioSistema,
            $fechaFinAnterior
        )->sum('pagado');

        return round($totalIngresosAnteriores - $totalGastosAnteriores, 2);
    }

    public function calcularSaldoAnteriorReal()
    {
        $fechaInicioSistema = '2024-08-01';

        $fechaMesSeleccionado = \Carbon\Carbon::create(
            (int) $this->anio,
            (int) $this->mes,
            1
        )->startOfMonth();

        $fechaFinAnterior = $fechaMesSeleccionado->copy()->subDay()->toDateString();

        if ($fechaFinAnterior < $fechaInicioSistema) {
            return 0;
        }

        $totalIngresosAnteriores = round((float) DB::table('ingresos_bancarios')
            ->whereDate('fecha', '>=', $fechaInicioSistema)
            ->whereDate('fecha', '<=', $fechaFinAnterior)
            ->sum('monto'), 2);

        $totalEgresosAnteriores = round((float) DB::table('gastos')
            ->whereRaw("
            COALESCE(
                STR_TO_DATE(NULLIF(fechainicio, ''), '%Y-%m-%d'),
                STR_TO_DATE(NULLIF(fechainicio, ''), '%d/%m/%Y')
            ) BETWEEN ? AND ?
        ", [$fechaInicioSistema, $fechaFinAnterior])
            ->sum('cantidad'), 2);

        return round($totalIngresosAnteriores - $totalEgresosAnteriores, 2);
    }

    public function queryGastosEntre($fechaInicio, $fechaFin)
    {
        return DB::table('gastos')
            ->where(function ($q) use ($fechaInicio, $fechaFin) {
                $q->whereRaw("
                    STR_TO_DATE(
                        COALESCE(NULLIF(fechainicio, ''), NULLIF(fecha, '')),
                        '%Y-%m-%d'
                    ) BETWEEN ? AND ?
                ", [$fechaInicio, $fechaFin])
                    ->orWhereRaw("
                    STR_TO_DATE(
                        COALESCE(NULLIF(fechainicio, ''), NULLIF(fecha, '')),
                        '%d/%m/%Y'
                    ) BETWEEN ? AND ?
                ", [$fechaInicio, $fechaFin]);
            });
    }

    public function formatearMesesAplicados($meses)
    {
        if (! $meses) {
            return '';
        }

        $partes = explode(',', $meses);
        $resultado = [];

        foreach ($partes as $parte) {
            $parte = trim($parte);

            if (! str_contains($parte, '/')) {
                continue;
            }

            [$mes, $anio] = explode('/', $parte);

            $resultado[] = $this->nombreMes((int) $mes).' '.$anio;
        }

        return implode(', ', array_unique($resultado));
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
        return view('livewire.tesoreria.informe-ingresos-egresos');
    }
}
