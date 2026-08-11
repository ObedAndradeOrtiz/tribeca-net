<?php

namespace App\Http\Livewire\Residentes;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

    public $anioFiltro = '';

    public $mesFiltro = '';

    public $departamentoAbierto = '';

    public function mount()
    {
        abort_unless(Auth::check() && Auth::user()->rol === 'residente', 403);

        $this->nombre = Auth::user()->name;
        $this->ci = Auth::user()->ci;
        $this->departamentosSolicitados = $this->solicitudesActuales();
        $this->anioFiltro = (string) now()->year;
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

    public function alternarDepartamento($departamentoNombre)
    {
        $this->departamentoAbierto = $this->departamentoAbierto === $departamentoNombre ? '' : $departamentoNombre;
    }

    public function resumenDepartamento($departamentoNombre)
    {
        $expensas = DB::table('expensas')
            ->where('departamento_nombre', $departamentoNombre)
            ->where('fecha_mes', '>=', '2024-08-01')
            ->when($this->anioFiltro !== '', fn ($q) => $q->where('anio', (int) $this->anioFiltro))
            ->when($this->mesFiltro !== '', fn ($q) => $q->where('mes', (int) $this->mesFiltro));

        $pagos = DB::table('ingresos_bancarios_aplicaciones as iba')
            ->join('ingresos_bancarios as ib', 'ib.id', '=', 'iba.ingreso_bancario_id')
            ->where('iba.departamento_nombre', $departamentoNombre)
            ->where('iba.estado', '!=', 'Anulado')
            ->when($this->anioFiltro !== '', fn ($q) => $q->where('iba.anio_pago', (int) $this->anioFiltro))
            ->when($this->mesFiltro !== '', fn ($q) => $q->where('iba.mes_pago', (int) $this->mesFiltro))
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

        $estados = (clone $expensas)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $saldo = round((float) (clone $expensas)->sum('saldo'), 2);
        $estadoResumen = 'Pagado';

        if ($saldo > 0) {
            $estadoResumen = ((int) ($estados['Parcial'] ?? 0)) > 0 ? 'Parcial' : 'Pendiente';
        }

        return [
            'total_expensas' => round((float) (clone $expensas)->sum('monto_expensa'), 2),
            'total_pagado' => round((float) (clone $expensas)->sum('monto_pagado'), 2),
            'saldo' => $saldo,
            'estado' => $estadoResumen,
            'pagos' => $pagos,
        ];
    }

    public function getAniosDisponiblesProperty()
    {
        return DB::table('expensas')
            ->select('anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');
    }

    public function generarPdfDepartamento($departamentoNombre, $tipo = 'anual')
    {
        abort_unless($this->usuarioPuedeVerDepartamento($departamentoNombre), 403);

        $departamentoNombre = trim($departamentoNombre);

        if ($tipo === 'total') {
            $desde = '2024-08-01';
            $hasta = now()->endOfMonth()->toDateString();
            $titulo = 'Reporte completo de departamento';
            $subtitulo = 'Desde agosto 2024 hasta '.now()->format('d/m/Y');
            $nombreArchivo = 'reporte-completo-'.$this->limpiarNombreArchivo($departamentoNombre).'.pdf';
        } else {
            $anio = $this->anioFiltro !== '' ? (int) $this->anioFiltro : (int) now()->year;
            $desde = Carbon::create($anio, 1, 1)->startOfMonth()->toDateString();
            $hasta = Carbon::create($anio, 12, 1)->endOfMonth()->toDateString();
            $titulo = 'Reporte anual de departamento';
            $subtitulo = 'Gestion '.$anio;
            $nombreArchivo = 'reporte-'.$this->limpiarNombreArchivo($departamentoNombre).'-'.$anio.'.pdf';
        }

        $data = $this->prepararReporteDepartamento($departamentoNombre, $desde, $hasta);

        $pdf = Pdf::loadView('pdf.reporte-departamento', [
            'titulo' => $titulo,
            'subtitulo' => $subtitulo,
            'departamento' => $departamentoNombre,
            'desde' => $desde,
            'hasta' => $hasta,
            'expensas' => $data['expensas'],
            'resumen' => $data['resumen'],
            'footer' => 'Sistema Tribeca - Digitbol',
            'fechaGeneracion' => now()->format('d/m/Y H:i'),
        ])->setPaper('letter', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    protected function usuarioPuedeVerDepartamento($departamentoNombre)
    {
        return DB::table('resident_department_access')
            ->where('user_id', Auth::id())
            ->where('status', 'Aprobado')
            ->where('departamento_nombre', $departamentoNombre)
            ->exists();
    }

    protected function prepararReporteDepartamento($departamentoNombre, $desde, $hasta)
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
                    'iba.monto',
                    'iba.estado_pago',
                    'iba.observacion',
                    'ib.fecha',
                    'ib.hora',
                    'ib.fecha_hora',
                    'ib.depositante',
                    'ib.numero_comprobante'
                )
                ->orderBy('ib.fecha')
                ->orderBy('ib.hora')
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
                'pagos' => $pagos->map(fn ($pago) => [
                    'fecha' => $pago->fecha,
                    'hora' => $pago->hora,
                    'fecha_hora' => $pago->fecha_hora,
                    'depositante' => $pago->depositante,
                    'numero_comprobante' => $pago->numero_comprobante,
                    'monto' => round((float) $pago->monto, 2),
                    'estado_pago' => $pago->estado_pago,
                    'observacion' => $pago->observacion,
                ])->toArray(),
            ];
        }

        $coleccion = collect($resultado);

        return [
            'expensas' => $resultado,
            'resumen' => [
                'total_expensas' => round($coleccion->sum('monto_expensa'), 2),
                'total_pagado' => round($coleccion->sum('monto_pagado'), 2),
                'total_saldo' => round($coleccion->sum('saldo'), 2),
                'cantidad_meses' => $coleccion->count(),
                'pagadas' => $coleccion->where('estado', 'Pagado')->count(),
                'parciales' => $coleccion->where('estado', 'Parcial')->count(),
                'pendientes' => $coleccion->where('estado', 'Pendiente')->count(),
                'no_cobrables' => $coleccion->where('no_cobrar', 1)->count(),
            ],
        ];
    }

    protected function nombreMes($mes)
    {
        return [
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
        ][$mes] ?? $mes;
    }

    protected function limpiarNombreArchivo($texto)
    {
        $texto = strtoupper(trim($texto));
        $texto = preg_replace('/[^A-Z0-9]+/', '-', $texto);

        return strtolower(trim($texto, '-'));
    }

    public function render()
    {
        return view('livewire.residentes.panel-residente');
    }
}
