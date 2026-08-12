<?php

namespace App\Http\Livewire\Tesoreria;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

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

    public $modalImagenes = false;

    public $imagenFechaInicio;

    public $imagenFechaFin;

    public $imagenTipo = 'todos';

    public $imagenesEncontradas = [];

    public $totalImagenesEncontradas = 0;

    public $tamanoImagenesEncontradas = 0;

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
        $database = DB::connection()->getDatabaseName();

        $nombreArchivo = 'TRIBECA_SOHO_BACKUP_'.date('Y-m-d_H-i-s').'.sql';

        return response()->streamDownload(function () use ($database) {

            echo "-- ==============================================\n";
            echo "-- BACKUP BASE DE DATOS TRIBECA SOHO\n";
            echo "-- Base de datos: {$database}\n";
            echo '-- Fecha: '.date('Y-m-d H:i:s')."\n";
            echo "-- ==============================================\n\n";

            echo "SET FOREIGN_KEY_CHECKS=0;\n";
            echo "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n";
            echo "SET NAMES utf8mb4;\n\n";

            /*
            |--------------------------------------------------------------------------
            | OBTENER TODAS LAS TABLAS
            |--------------------------------------------------------------------------
            */

            $tablas = DB::select("
            SELECT TABLE_NAME
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            AND TABLE_TYPE = 'BASE TABLE'
            ORDER BY TABLE_NAME
        ", [$database]);

            foreach ($tablas as $tablaInfo) {

                $tabla = $tablaInfo->TABLE_NAME;

                /*
                |--------------------------------------------------------------------------
                | SEGURIDAD DEL NOMBRE DE LA TABLA
                |--------------------------------------------------------------------------
                */

                $tablaSegura = str_replace('`', '``', $tabla);

                echo "\n";
                echo "-- ==============================================\n";
                echo "-- TABLA: `{$tablaSegura}`\n";
                echo "-- ==============================================\n\n";

                /*
                |--------------------------------------------------------------------------
                | ELIMINAR TABLA SI YA EXISTE
                |--------------------------------------------------------------------------
                */

                echo "DROP TABLE IF EXISTS `{$tablaSegura}`;\n\n";

                /*
                |--------------------------------------------------------------------------
                | CREATE TABLE
                |--------------------------------------------------------------------------
                */

                $resultadoCreate = DB::select(
                    "SHOW CREATE TABLE `{$tablaSegura}`"
                );

                if (! empty($resultadoCreate)) {

                    $createArray = (array) $resultadoCreate[0];

                    /*
                     * SHOW CREATE TABLE devuelve:
                     *
                     * [
                     *   'Table' => 'users',
                     *   'Create Table' => 'CREATE TABLE ...'
                     * ]
                     */

                    $valores = array_values($createArray);

                    if (isset($valores[1])) {
                        echo $valores[1].";\n\n";
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | DATOS
                |--------------------------------------------------------------------------
                */

                $columnas = DB::select(
                    "SHOW COLUMNS FROM `{$tablaSegura}`"
                );

                if (empty($columnas)) {
                    continue;
                }

                $nombresColumnas = [];

                foreach ($columnas as $columna) {
                    $nombresColumnas[] = $columna->Field;
                }

                /*
                |--------------------------------------------------------------------------
                | LEER REGISTROS POR BLOQUES
                |--------------------------------------------------------------------------
                |
                | Evitamos cargar una tabla completa a memoria.
                |
                */

                DB::table($tabla)
                    ->orderBy($nombresColumnas[0])
                    ->chunk(500, function ($registros) use (
                        $tablaSegura,
                        $nombresColumnas
                    ) {

                        foreach ($registros as $registro) {

                            $registro = (array) $registro;

                            $valoresSql = [];

                            foreach ($nombresColumnas as $columna) {

                                $valor = $registro[$columna] ?? null;

                                /*
                                |--------------------------------------------------------------------------
                                | NULL
                                |--------------------------------------------------------------------------
                                */

                                if ($valor === null) {

                                    $valoresSql[] = 'NULL';

                                    continue;
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | ESCAPAR VALORES
                                |--------------------------------------------------------------------------
                                */

                                $valoresSql[] = DB::connection()
                                    ->getPdo()
                                    ->quote((string) $valor);
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | COLUMNAS
                            |--------------------------------------------------------------------------
                            */

                            $columnasSql = array_map(function ($columna) {

                                $columna = str_replace('`', '``', $columna);

                                return "`{$columna}`";

                            }, $nombresColumnas);

                            /*
                            |--------------------------------------------------------------------------
                            | INSERT
                            |--------------------------------------------------------------------------
                            */

                            echo "INSERT INTO `{$tablaSegura}` (";
                            echo implode(', ', $columnasSql);
                            echo ') VALUES (';
                            echo implode(', ', $valoresSql);
                            echo ");\n";
                        }
                    });

                echo "\n";
            }

            echo "\nSET FOREIGN_KEY_CHECKS=1;\n";

            echo "\n";
            echo "-- ==============================================\n";
            echo "-- FIN DEL BACKUP\n";
            echo "-- ==============================================\n";

        }, $nombreArchivo, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="'.$nombreArchivo.'"',
        ]);
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

    public function abrirModalImagenes()
    {
        $fecha = Carbon::create((int) $this->anio, (int) $this->mes, 1);

        $this->imagenFechaInicio = $fecha->copy()->startOfMonth()->toDateString();
        $this->imagenFechaFin = $fecha->copy()->endOfMonth()->toDateString();
        $this->imagenTipo = 'todos';
        $this->imagenesEncontradas = [];
        $this->totalImagenesEncontradas = 0;
        $this->tamanoImagenesEncontradas = 0;
        $this->modalImagenes = true;

        $this->buscarImagenes();
    }

    public function cerrarModalImagenes()
    {
        $this->modalImagenes = false;
    }

    public function buscarImagenes()
    {
        $archivos = $this->recolectarImagenesPorFecha();

        $this->totalImagenesEncontradas = count($archivos);
        $this->tamanoImagenesEncontradas = array_sum(array_column($archivos, 'size'));
        $this->imagenesEncontradas = array_map(function ($archivo) {
            return [
                'grupo' => $archivo['grupo'],
                'fecha' => $archivo['fecha'],
                'nombre' => $archivo['nombre'],
                'url' => $archivo['url'],
            ];
        }, array_slice($archivos, 0, 30));
    }

    public function descargarImagenes()
    {
        $archivos = $this->recolectarImagenesPorFecha();

        if (empty($archivos)) {
            $this->emit('error', 'No se encontraron imagenes para descargar.');

            return null;
        }

        if (! class_exists(ZipArchive::class)) {
            $this->emit('error', 'El servidor no tiene habilitada la extension ZIP de PHP.');

            return null;
        }

        $fechaInicio = Carbon::parse($this->imagenFechaInicio)->format('Ymd');
        $fechaFin = Carbon::parse($this->imagenFechaFin)->format('Ymd');
        $nombreZip = "TRIBECA_IMAGENES_{$fechaInicio}_{$fechaFin}_".now()->format('His').'.zip';
        $carpetaExport = Storage::disk('public')->path('exports');

        if (! is_dir($carpetaExport)) {
            mkdir($carpetaExport, 0755, true);
        }

        $this->limpiarZipsExportados();

        $rutaRelativaZip = 'exports/'.$nombreZip;
        $rutaZip = Storage::disk('public')->path($rutaRelativaZip);
        $zip = new ZipArchive;

        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->emit('error', 'No se pudo crear el archivo ZIP.');

            return null;
        }

        foreach ($archivos as $archivo) {
            $zip->addFile($archivo['absolute_path'], $archivo['zip_path']);
        }

        $zip->close();

        return redirect()->to('/storage/'.$rutaRelativaZip);
    }

    protected function limpiarZipsExportados()
    {
        $exports = Storage::disk('public')->files('exports');
        $limite = now()->subDays(2)->timestamp;

        foreach ($exports as $archivo) {
            if (! str_ends_with($archivo, '.zip')) {
                continue;
            }

            if (Storage::disk('public')->lastModified($archivo) < $limite) {
                Storage::disk('public')->delete($archivo);
            }
        }
    }

    protected function recolectarImagenesPorFecha()
    {
        $inicio = $this->imagenFechaInicio ?: now()->startOfMonth()->toDateString();
        $fin = $this->imagenFechaFin ?: now()->endOfMonth()->toDateString();

        try {
            $inicio = Carbon::parse($inicio)->startOfDay()->toDateString();
            $fin = Carbon::parse($fin)->endOfDay()->toDateString();
        } catch (\Throwable $e) {
            $this->emit('error', 'Selecciona un rango de fechas valido.');

            return [];
        }

        if ($inicio > $fin) {
            [$inicio, $fin] = [$fin, $inicio];
        }

        $tipo = $this->imagenTipo ?: 'todos';
        $archivos = [];

        if (in_array($tipo, ['todos', 'ingresos'], true)) {
            $pagos = DB::table('pagos')
                ->whereNotNull('path')
                ->where('path', '!=', '')
                ->where(function ($q) use ($inicio, $fin) {
                    $q->whereRaw("
                        STR_TO_DATE(
                            COALESCE(NULLIF(fechapagado, ''), NULLIF(fechainicio, ''), NULLIF(fecha, '')),
                            '%Y-%m-%d'
                        ) BETWEEN ? AND ?
                    ", [$inicio, $fin])
                        ->orWhereRaw("
                        STR_TO_DATE(
                            COALESCE(NULLIF(fechapagado, ''), NULLIF(fechainicio, ''), NULLIF(fecha, '')),
                            '%d/%m/%Y'
                        ) BETWEEN ? AND ?
                    ", [$inicio, $fin]);
                })
                ->select('id', 'path', 'namebeneficiario', 'fechapagado', 'fechainicio', 'fecha')
                ->orderBy('id')
                ->get();

            foreach ($pagos as $pago) {
                $this->agregarArchivoZip($archivos, 'ingresos', $pago->id, $pago->path, $pago->namebeneficiario, $pago->fechapagado ?: $pago->fechainicio ?: $pago->fecha);
            }
        }

        if (in_array($tipo, ['todos', 'egresos'], true)) {
            $gastos = DB::table('gastos')
                ->whereNotNull('rutaarchivo')
                ->where('rutaarchivo', '!=', '')
                ->where(function ($q) use ($inicio, $fin) {
                    $q->whereRaw("
                        STR_TO_DATE(
                            COALESCE(NULLIF(fechainicio, ''), NULLIF(fechapagado, ''), NULLIF(fecha, '')),
                            '%Y-%m-%d'
                        ) BETWEEN ? AND ?
                    ", [$inicio, $fin])
                        ->orWhereRaw("
                        STR_TO_DATE(
                            COALESCE(NULLIF(fechainicio, ''), NULLIF(fechapagado, ''), NULLIF(fecha, '')),
                            '%d/%m/%Y'
                        ) BETWEEN ? AND ?
                    ", [$inicio, $fin]);
                })
                ->select('id', 'rutaarchivo', 'empresa', 'fechainicio', 'fechapagado', 'fecha')
                ->orderBy('id')
                ->get();

            foreach ($gastos as $gasto) {
                $this->agregarArchivoZip($archivos, 'egresos', $gasto->id, $gasto->rutaarchivo, $gasto->empresa, $gasto->fechainicio ?: $gasto->fechapagado ?: $gasto->fecha);
            }
        }

        if (in_array($tipo, ['todos', 'mantenimientos'], true)) {
            $mantenimientos = DB::table('mantenimientos')
                ->whereNotNull('comprobante')
                ->where('comprobante', '!=', '')
                ->whereDate('fecha', '>=', $inicio)
                ->whereDate('fecha', '<=', $fin)
                ->select('id', 'comprobante', 'descripcion', 'fecha')
                ->orderBy('fecha')
                ->orderBy('id')
                ->get();

            foreach ($mantenimientos as $mantenimiento) {
                $this->agregarArchivoZip($archivos, 'mantenimientos', $mantenimiento->id, $mantenimiento->comprobante, $mantenimiento->descripcion, $mantenimiento->fecha);
            }
        }

        return $archivos;
    }

    protected function agregarArchivoZip(&$archivos, $grupo, $id, $ruta, $detalle = null, $fecha = null)
    {
        $ruta = trim((string) $ruta);

        if ($ruta === '') {
            return;
        }

        $ruta = ltrim(str_replace('\\', '/', $ruta), '/');
        $absolutePath = Storage::disk('public')->path($ruta);

        if (! is_file($absolutePath)) {
            return;
        }

        $extension = pathinfo($absolutePath, PATHINFO_EXTENSION) ?: 'archivo';
        $fechaArchivo = $this->fechaArchivoZip($fecha);
        $detalle = $this->limpiarNombreArchivo($detalle ?: $grupo);
        $nombre = "{$fechaArchivo}_{$grupo}_{$id}_{$detalle}.{$extension}";

        $archivos[] = [
            'grupo' => ucfirst($grupo),
            'id' => $id,
            'fecha' => $fechaArchivo,
            'nombre' => $nombre,
            'ruta' => $ruta,
            'url' => '/storage/'.$ruta,
            'size' => filesize($absolutePath),
            'absolute_path' => $absolutePath,
            'zip_path' => $grupo.'/'.$nombre,
        ];
    }

    protected function fechaArchivoZip($fecha)
    {
        try {
            return Carbon::parse($fecha)->format('Y-m-d');
        } catch (\Throwable $e) {
            return 'sin-fecha';
        }
    }

    protected function limpiarNombreArchivo($valor)
    {
        $valor = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) $valor);
        $valor = preg_replace('/[^A-Za-z0-9_-]+/', '-', $valor);
        $valor = trim($valor, '-');

        return substr($valor ?: 'archivo', 0, 45);
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
