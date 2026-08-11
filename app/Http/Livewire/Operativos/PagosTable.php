<?php

namespace App\Http\Livewire\Operativos;

use App\Models\Pagos;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PagosTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'textoDictadoRecibido' => 'recibirTextoDictado',
        'textoDictadoTemporal' => 'recibirTextoTemporal',
    ];

    // =========================
    // MODAL VOZ
    // =========================
    public $modalVoz = false;

    public $textoVoz = '';

    public $vozFechaPago;       // Fecha real del abono/deposito

    public $vozHoraPago;        // Hora real del abono/deposito

    public $vozDepositante;

    public $vozMonto;

    public $vozDepartamento;

    public $vozMesPago;         // Formato YYYY-MM para input type month

    public $vozFechaInicioPago; // Formato YYYY-MM-01 para buscar en fechainicio

    public $vozPagoId = null;

    public $vozMensaje = null;

    // =========================
    // MODAL EDITAR PAGO
    // =========================
    public $comprobante;

    public $modal = false;

    public $pagoEditar;

    public $busquedaBeneficiario = '';

    public $sugerencias = [];

    // =========================
    // FILTROS
    // =========================
    public $busqueda = '';

    public $filtroTratamiento = '';

    public $filtroMes = '';

    public $filtroAnio = '';

    public $filtroEstado = '';

    public $vista = 'pagos';

    // =========================
    // ALQUILERES
    // =========================
    public $crear = false;

    public $editar = false;

    public $fechacorrespondiente;

    public $fechadepago;

    public $montopago;

    public $estadodepago;

    public $departamentodealquiler;

    public $areas;

    public $vozPagoEstadoDetectado = null;

    public $vozPagoYaPagado = false;

    public $vozMesesDepartamento = [];

    public $meses = [
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

    public function mount()
    {
        $this->filtroAnio = date('Y');
    }

    // =========================
    // RESET PAGINACIÓN FILTROS
    // =========================
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingFiltroTratamiento()
    {
        $this->resetPage();
    }

    public function updatingFiltroMes()
    {
        $this->resetPage();
    }

    public function updatingFiltroAnio()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    // =========================
    // MODAL VOZ
    // =========================
    public function abrirModalVoz()
    {
        $this->reset([
            'textoVoz',
            'vozFechaPago',
            'vozHoraPago',
            'vozDepositante',
            'vozMonto',
            'vozDepartamento',
            'vozMesPago',
            'vozFechaInicioPago',
            'vozPagoId',
            'vozMensaje',
            'vozPagoEstadoDetectado',
            'vozPagoYaPagado',
            'vozMesesDepartamento',
        ]);
        $this->modalVoz = true;
    }

    public function recibirTextoTemporal($texto)
    {
        $this->textoVoz = $texto;
    }

    public function recibirTextoDictado($texto)
    {
        $this->textoVoz = $texto;
        $this->procesarTextoVoz();
    }

    public function updatedVozDepartamento()
    {
        $this->buscarPagoVoz();
    }

    public function updatedVozMesPago()
    {
        if ($this->vozMesPago) {
            $this->vozFechaInicioPago = $this->vozMesPago.'-01';
        } else {
            $this->vozFechaInicioPago = null;
        }

        $this->buscarPagoVoz();
    }

    public function procesarTextoVoz()
    {
        $textoOriginal = trim($this->textoVoz);

        if (! $textoOriginal) {
            $this->vozMensaje = 'No hay texto para procesar.';

            return;
        }

        $textoNormal = Str::ascii(Str::lower($textoOriginal));

        // Fecha real del abono/deposito
        $this->vozFechaPago = $this->detectarFechaAbono($textoNormal);

        // Hora real del abono/deposito
        $this->vozHoraPago = $this->detectarHora($textoNormal);

        // Monto pagado
        $this->vozMonto = $this->detectarMonto($textoNormal);

        // Departamento/oficina
        $this->vozDepartamento = $this->detectarDepartamento($textoNormal);

        // Depositante
        $this->vozDepositante = $this->detectarDepositante($textoOriginal);

        // Mes al que pertenece el pago
        $fechaInicioPago = $this->detectarMesPago($textoNormal, $this->vozFechaPago);

        if ($fechaInicioPago) {
            $this->vozFechaInicioPago = $fechaInicioPago;
            $this->vozMesPago = Carbon::parse($fechaInicioPago)->format('Y-m');
        } else {
            $this->vozFechaInicioPago = null;
            $this->vozMesPago = null;
        }

        $this->buscarPagoVoz();
    }

    private function detectarFechaAbono($textoNormal)
    {
        $fechaPago = null;

        $mesesTexto = $this->mesesTexto();
        $diasTexto = $this->diasTexto();

        // 2024-09-01
        if (preg_match('/\b(\d{4})-(\d{1,2})-(\d{1,2})\b/', $textoNormal, $m)) {
            return Carbon::createFromDate((int) $m[1], (int) $m[2], (int) $m[3])->format('Y-m-d');
        }

        // 01/09/2024 o 01-09-2024
        if (preg_match('/\b(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})\b/', $textoNormal, $m)) {
            return Carbon::createFromDate((int) $m[3], (int) $m[2], (int) $m[1])->format('Y-m-d');
        }

        // 1 de septiembre 2024
        foreach ($mesesTexto as $nombreMes => $numeroMes) {
            if (preg_match('/\b(\d{1,2})\s*(de)?\s*'.$nombreMes.'\s*(de)?\s*(\d{4})?\b/', $textoNormal, $m)) {
                $dia = (int) $m[1];
                $anio = ! empty($m[4]) ? (int) $m[4] : (int) date('Y');

                return Carbon::createFromDate($anio, $numeroMes, $dia)->format('Y-m-d');
            }
        }

        // uno de septiembre 2024 / primer septiembre 2024
        foreach ($mesesTexto as $nombreMes => $numeroMes) {
            foreach ($diasTexto as $diaTexto => $diaNumero) {
                $diaTextoNormal = Str::ascii(Str::lower($diaTexto));

                if (preg_match('/\b'.preg_quote($diaTextoNormal, '/').'\s*(de)?\s*'.$nombreMes.'\s*(de)?\s*(\d{4})?\b/', $textoNormal, $m)) {
                    $anio = ! empty($m[3]) ? (int) $m[3] : (int) date('Y');

                    return Carbon::createFromDate($anio, $numeroMes, $diaNumero)->format('Y-m-d');
                }
            }
        }

        return date('Y-m-d');
    }

    private function detectarMesPago($textoNormal, $fechaAbono = null)
    {
        $mesesTexto = $this->mesesTexto();

        $patrones = [
            'mes de pago',
            'mes pago',
            'mes correspondiente',
            'correspondiente',
            'corresponde',
            'expensa de',
            'expensas de',
            'pago del mes de',
            'pago mes',
            'pago de mes',
            'periodo',
            'periodo de',
        ];

        foreach ($patrones as $patron) {
            foreach ($mesesTexto as $nombreMes => $numeroMes) {
                $regex = '/\b'.preg_quote($patron, '/').'\s+'.$nombreMes.'\s*(de|del)?\s*(\d{4})?\b/';

                if (preg_match($regex, $textoNormal, $m)) {
                    $anio = ! empty($m[2])
                        ? (int) $m[2]
                        : ($fechaAbono ? (int) Carbon::parse($fechaAbono)->format('Y') : (int) date('Y'));

                    return Carbon::createFromDate($anio, $numeroMes, 1)->format('Y-m-d');
                }
            }
        }

        // Caso adicional:
        // "deposito enero 2026 ... departamento 6g ... agosto 2025"
        // Si detecta más de un mes con año, toma el segundo como mes de pago.
        preg_match_all('/\b(enero|febrero|marzo|abril|mayo|junio|julio|agosto|septiembre|setiembre|octubre|noviembre|diciembre)\s*(de|del)?\s*(\d{4})\b/', $textoNormal, $coincidencias, PREG_SET_ORDER);

        if (count($coincidencias) >= 2) {
            $ultimo = end($coincidencias);

            $mesNombre = $ultimo[1];
            $anio = (int) $ultimo[3];
            $numeroMes = $mesesTexto[$mesNombre] ?? null;

            if ($numeroMes) {
                return Carbon::createFromDate($anio, $numeroMes, 1)->format('Y-m-d');
            }
        }

        return null;
    }

    private function detectarHora($textoNormal)
    {
        // 16:45 o 16.45
        if (preg_match('/\b(\d{1,2})[:\.](\d{2})\b/', $textoNormal, $m)) {
            $hora = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $minuto = str_pad($m[2], 2, '0', STR_PAD_LEFT);

            if ((int) $hora <= 23 && (int) $minuto <= 59) {
                return $hora.':'.$minuto;
            }
        }

        // hora 1645
        if (preg_match('/\bhora\s+(\d{3,4})\b/', $textoNormal, $m)) {
            $numeroHora = str_pad($m[1], 4, '0', STR_PAD_LEFT);

            $hora = substr($numeroHora, 0, 2);
            $minuto = substr($numeroHora, 2, 2);

            if ((int) $hora <= 23 && (int) $minuto <= 59) {
                return $hora.':'.$minuto;
            }
        }

        // hora 16 45
        if (preg_match('/\bhora\s+(\d{1,2})\s+(\d{2})\b/', $textoNormal, $m)) {
            $hora = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $minuto = str_pad($m[2], 2, '0', STR_PAD_LEFT);

            if ((int) $hora <= 23 && (int) $minuto <= 59) {
                return $hora.':'.$minuto;
            }
        }

        // Directo 1645, evitando años
        if (preg_match_all('/\b(\d{3,4})\b/', $textoNormal, $coincidencias)) {
            foreach ($coincidencias[1] as $numero) {
                if (preg_match('/^(2024|2025|2026|2027|2028|2029|2030)$/', $numero)) {
                    continue;
                }

                $numeroHora = str_pad($numero, 4, '0', STR_PAD_LEFT);

                $hora = substr($numeroHora, 0, 2);
                $minuto = substr($numeroHora, 2, 2);

                if ((int) $hora <= 23 && (int) $minuto <= 59) {
                    return $hora.':'.$minuto;
                }
            }
        }

        return date('H:i');
    }

    private function detectarMonto($textoNormal)
    {
        if (preg_match('/(?:monto|pago|pagado|cancelo|canceló|deposito|depositó|bs|bolivianos)\s*(\d+(?:[.,]\d{1,2})?)/iu', $textoNormal, $m)) {
            return str_replace(',', '.', $m[1]);
        }

        if (preg_match('/\b(\d+(?:[.,]\d{1,2})?)\s*(?:bs|bolivianos)\b/iu', $textoNormal, $m)) {
            return str_replace(',', '.', $m[1]);
        }

        return null;
    }

    private function detectarDepartamento($textoNormal)
    {
        $tratamientos = Tratamiento::query()
            ->whereNotNull('nombre')
            ->where('nombre', '!=', '')
            ->get();

        $normalizarCodigo = function ($valor) {
            return preg_replace('/[^a-z0-9]/', '', Str::ascii(Str::lower($valor)));
        };

        $textoCompacto = $normalizarCodigo($textoNormal);

        // =========================
        // 1. Buscar código directo después de:
        // departamento, depto, dpto, oficina, local
        // Ejemplo:
        // departamento 12j mes de pago abril 2024
        // Solo toma: 12j
        // =========================
        $codigoDetectado = null;

        if (preg_match('/\b(?:departamento|depto|dpto|oficina|local)\s+([a-z0-9]+)\b/i', $textoNormal, $m)) {
            $codigoDetectado = $normalizarCodigo($m[1]);
        }

        if ($codigoDetectado) {
            foreach ($tratamientos as $tratamiento) {
                $nombreOriginal = $tratamiento->nombre;
                $nombreCompacto = $normalizarCodigo($nombreOriginal);

                // Ejemplos:
                // 12j coincide con 12j
                // 12j coincide con dpto12j
                // 12j coincide con departamento12j
                // 12j coincide con oficina12j
                if (
                    $nombreCompacto === $codigoDetectado ||
                    str_ends_with($nombreCompacto, $codigoDetectado) ||
                    str_contains($nombreCompacto, $codigoDetectado)
                ) {
                    return $nombreOriginal;
                }
            }
        }

        // =========================
        // 2. Buscar nombres completos compactados
        // Ejemplo:
        // texto contiene dpto12j
        // tratamiento es DPTO 12J
        // =========================
        foreach ($tratamientos as $tratamiento) {
            $nombreOriginal = $tratamiento->nombre;
            $nombreNormal = Str::ascii(Str::lower($nombreOriginal));
            $nombreCompacto = $normalizarCodigo($nombreOriginal);

            if ($nombreNormal && str_contains($textoNormal, $nombreNormal)) {
                return $nombreOriginal;
            }

            if ($nombreCompacto && str_contains($textoCompacto, $nombreCompacto)) {
                return $nombreOriginal;
            }
        }

        // =========================
        // 3. Último intento:
        // buscar patrones sueltos tipo 12j, 6g, 1a
        // =========================
        if (preg_match_all('/\b(\d{1,3}\s*[a-z])\b/i', $textoNormal, $coincidencias)) {
            foreach ($coincidencias[1] as $codigoTexto) {
                $codigo = $normalizarCodigo($codigoTexto);

                foreach ($tratamientos as $tratamiento) {
                    $nombreOriginal = $tratamiento->nombre;
                    $nombreCompacto = $normalizarCodigo($nombreOriginal);

                    if (
                        $nombreCompacto === $codigo ||
                        str_ends_with($nombreCompacto, $codigo) ||
                        str_contains($nombreCompacto, $codigo)
                    ) {
                        return $nombreOriginal;
                    }
                }
            }
        }

        return null;
    }

    private function detectarDepositante($textoOriginal)
    {
        if (preg_match('/(?:depositante|responsable|cliente)\s+([a-záéíóúñ\s]+?)(?=\s+(?:monto|pago|pagado|bs|bolivianos|departamento|depto|dpto|oficina|local|fecha|hora|mes|corresponde|correspondiente|periodo|expensa)|$)/iu', $textoOriginal, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    private function buscarPagoVoz()
    {
        $this->vozPagoId = null;
        $this->vozPagoEstadoDetectado = null;
        $this->vozPagoYaPagado = false;
        $this->vozMesesDepartamento = [];

        if (! $this->vozDepartamento) {
            $this->vozMensaje = 'Falta detectar o seleccionar el departamento/oficina.';

            return;
        }

        // Cargar historial/resumen del departamento aunque todavía no haya mes seleccionado
        $this->cargarMesesDepartamento();

        if (! $this->vozFechaInicioPago) {
            $this->vozMensaje = 'Falta detectar o seleccionar el mes del pago.';

            return;
        }

        $pagoExistente = Pagos::query()
            ->where('empresa', $this->vozDepartamento)
            ->whereDate('fechainicio', $this->vozFechaInicioPago)
            ->where(function ($q) {
                $q->where('modo', '!=', 'alquiler')
                    ->orWhereNull('modo');
            })
            ->first();

        if (! $pagoExistente) {
            $this->vozMensaje = 'No existe pago para ese departamento y mes. No se creará nada.';

            return;
        }

        $this->vozPagoEstadoDetectado = $pagoExistente->estado;

        if ($pagoExistente->pagado > 0 || in_array($pagoExistente->estado, ['Pagado', 'Atrasado', 'Adelantado'])) {
            $this->vozPagoYaPagado = true;

            $this->vozMensaje =
                'Este mes ya tiene pago registrado: '.
                Carbon::parse($pagoExistente->fechainicio)->format('m/Y').
                ' | Estado: '.$pagoExistente->estado.
                ' | Pagado: Bs '.number_format($pagoExistente->pagado, 2, '.', '').
                ' | Depositante: '.($pagoExistente->namebeneficiario ?: 'SIN DATOS');

            return;
        }

        $this->vozPagoId = $pagoExistente->id;
        $this->vozPagoYaPagado = false;

        $this->vozMensaje =
            'Pago pendiente encontrado para '.
            Carbon::parse($pagoExistente->fechainicio)->format('m/Y').
            '. Se puede actualizar este mes.';
    }

    private function cargarMesesDepartamento()
    {
        if (! $this->vozDepartamento) {
            $this->vozMesesDepartamento = [];

            return;
        }

        $fechaBase = $this->vozFechaInicioPago
            ? Carbon::parse($this->vozFechaInicioPago)->startOfMonth()
            : Carbon::now()->startOfMonth();

        $desde = $fechaBase->copy()->subMonths(3)->format('Y-m-d');
        $hasta = $fechaBase->copy()->addMonths(6)->format('Y-m-d');

        $this->vozMesesDepartamento = Pagos::query()
            ->where('empresa', $this->vozDepartamento)
            ->whereBetween('fechainicio', [$desde, $hasta])
            ->where(function ($q) {
                $q->where('modo', '!=', 'alquiler')
                    ->orWhereNull('modo');
            })
            ->orderBy('fechainicio', 'asc')
            ->get()
            ->map(function ($pago) {
                return [
                    'id' => $pago->id,
                    'mes' => Carbon::parse($pago->fechainicio)->format('m/Y'),
                    'fecha_inicio' => Carbon::parse($pago->fechainicio)->format('Y-m-d'),
                    'estado' => $pago->estado,
                    'pagado' => $pago->pagado ?? 0,
                    'depositante' => $pago->namebeneficiario ?: 'SIN DATOS',
                    'fecha_pagado' => $pago->fechapagado
                        ? Carbon::parse($pago->fechapagado)->format('d/m/Y H:i')
                        : 'SIN DATOS',
                ];
            })
            ->toArray();
    }

    public function guardarPagoVoz()
    {
        if (! $this->vozDepartamento) {
            $this->emit('alert', 'Debe seleccionar un departamento u oficina.');

            return;
        }

        if (! $this->vozFechaPago) {
            $this->emit('alert', 'Debe seleccionar la fecha del abono.');

            return;
        }

        if (! $this->vozHoraPago) {
            $this->emit('alert', 'Debe seleccionar la hora del abono.');

            return;
        }

        if (! $this->vozMonto) {
            $this->emit('alert', 'Debe ingresar el monto pagado.');

            return;
        }

        if (! $this->vozFechaInicioPago) {
            $this->emit('alert', 'Debe seleccionar el mes del pago.');

            return;
        }

        $pago = Pagos::query()
            ->where('empresa', $this->vozDepartamento)
            ->whereDate('fechainicio', $this->vozFechaInicioPago)
            ->where(function ($q) {
                $q->where('modo', '!=', 'alquiler')
                    ->orWhereNull('modo');
            })
            ->first();

        if (! $pago) {
            $this->emit('alert', 'No existe el pago de ese mes. No se creó ningún registro.');
            $this->vozMensaje = 'No existe pago para ese departamento y mes. No se creará nada.';

            return;
        }

        if ($pago->pagado > 0 || in_array($pago->estado, ['Pagado', 'Atrasado', 'Adelantado'])) {
            $this->emit('alert', 'Este mes ya tiene pago registrado. No se sobrescribió.');
            $this->vozMensaje = 'Este mes ya tiene pago registrado. Selecciona otro mes pendiente.';

            return;
        }

        $fechaPagado = $this->vozFechaPago.' '.$this->vozHoraPago.':00';

        $pago->pagado = $this->vozMonto;
        $pago->fechapagado = $fechaPagado;
        $pago->namebeneficiario = mb_strtoupper(trim($this->vozDepositante), 'UTF-8');
        $pago->estado = 'Pagado';
        $pago->iduser = Auth::id();
        $pago->nameuser = Auth::user()->name ?? null;
        $pago->save();

        $this->modalVoz = false;

        $this->reset([
            'textoVoz',
            'vozFechaPago',
            'vozHoraPago',
            'vozDepositante',
            'vozMonto',
            'vozDepartamento',
            'vozMesPago',
            'vozFechaInicioPago',
            'vozPagoId',
            'vozMensaje',
        ]);

        $this->emit('alert', 'Pago registrado correctamente.');
    }

    private function mesesTexto()
    {
        return [
            'enero' => 1,
            'febrero' => 2,
            'marzo' => 3,
            'abril' => 4,
            'mayo' => 5,
            'junio' => 6,
            'julio' => 7,
            'agosto' => 8,
            'septiembre' => 9,
            'setiembre' => 9,
            'octubre' => 10,
            'noviembre' => 11,
            'diciembre' => 12,
        ];
    }

    private function diasTexto()
    {
        return [
            'uno' => 1,
            'un' => 1,
            'primer' => 1,
            'primero' => 1,
            'dos' => 2,
            'tres' => 3,
            'cuatro' => 4,
            'cinco' => 5,
            'seis' => 6,
            'siete' => 7,
            'ocho' => 8,
            'nueve' => 9,
            'diez' => 10,
            'once' => 11,
            'doce' => 12,
            'trece' => 13,
            'catorce' => 14,
            'quince' => 15,
            'dieciseis' => 16,
            'dieciséis' => 16,
            'diecisiete' => 17,
            'dieciocho' => 18,
            'diecinueve' => 19,
            'veinte' => 20,
            'veintiuno' => 21,
            'veintidos' => 22,
            'veintidós' => 22,
            'veintitres' => 23,
            'veintitrés' => 23,
            'veinticuatro' => 24,
            'veinticinco' => 25,
            'veintiseis' => 26,
            'veintiséis' => 26,
            'veintisiete' => 27,
            'veintiocho' => 28,
            'veintinueve' => 29,
            'treinta' => 30,
            'treinta y uno' => 31,
        ];
    }

    // =========================
    // GENERAR PAGOS FALTANTES
    // =========================
    public function generarPagosFaltantes()
    {
        $fechaInicio = Carbon::create(2024, 1, 1)->startOfMonth();
        $fechaFin = Carbon::now()->startOfMonth();

        $creados = 0;

        DB::transaction(function () use ($fechaInicio, $fechaFin, &$creados) {
            $tratamientos = Tratamiento::query()
                ->whereNotNull('nombre')
                ->where('nombre', '!=', '')
                ->get();

            foreach ($tratamientos as $tratamiento) {
                $fechaActual = $fechaInicio->copy();

                while ($fechaActual->lte($fechaFin)) {
                    $existePago = Pagos::query()
                        ->where('empresa', $tratamiento->nombre)
                        ->whereDate('fechainicio', $fechaActual->format('Y-m-d'))
                        ->where(function ($q) {
                            $q->where('modo', '!=', 'alquiler')
                                ->orWhereNull('modo');
                        })
                        ->exists();

                    if (! $existePago) {
                        Pagos::create([
                            'empresa' => $tratamiento->nombre,
                            'fechainicio' => $fechaActual->format('Y-m-d'),
                            'cantidad' => $tratamiento->costo ?? 0,
                            'pagado' => 0,
                            'estado' => 'Pendiente',
                            'iduser' => Auth::id(),
                            'nameuser' => Auth::user()->name ?? null,
                            'modo' => null,
                        ]);

                        $creados++;
                    }

                    $fechaActual->addMonth();
                }
            }
        });

        $this->emit('alert', 'Pagos faltantes generados: '.$creados);
    }

    // =========================
    // BENEFICIARIOS
    // =========================
    public function updatedBusquedaBeneficiario()
    {
        $this->sugerencias = DB::table('pagos')
            ->select('namebeneficiario')
            ->whereNotNull('namebeneficiario')
            ->where('namebeneficiario', 'like', '%'.$this->busquedaBeneficiario.'%')
            ->distinct()
            ->limit(5)
            ->pluck('namebeneficiario')
            ->toArray();
    }

    public function seleccionarBeneficiario($nombre)
    {
        $nombre = mb_strtoupper(trim($nombre), 'UTF-8');

        $this->pagoEditar['namebeneficiario'] = $nombre;
        $this->busquedaBeneficiario = $nombre;
        $this->sugerencias = [];
    }

    // =========================
    // RENDER
    // =========================
    public function render()
    {
        $pagos = Pagos::query()
            ->when($this->busqueda, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('empresa', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('numero', 'like', '%'.$this->busqueda.'%');
                });
            })
            ->when($this->filtroTratamiento, fn ($q) => $q->where('empresa', $this->filtroTratamiento))
            ->when($this->filtroEstado, fn ($q) => $q->where('estado', $this->filtroEstado))
            ->when($this->filtroMes, fn ($q) => $q->whereMonth('fechainicio', $this->filtroMes))
            ->when($this->filtroAnio, fn ($q) => $q->whereYear('fechainicio', $this->filtroAnio))
            ->where(function ($q) {
                $q->where('modo', '!=', 'alquiler')
                    ->orWhereNull('modo');
            })
            ->orderBy('fechainicio', 'desc')
            ->paginate(20);

        $alquileres = Pagos::query()
            ->when($this->busqueda, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('empresa', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('numero', 'like', '%'.$this->busqueda.'%')
                        ->orWhere('namebeneficiario', 'like', '%'.$this->busqueda.'%');
                });
            })
            ->when($this->filtroTratamiento, fn ($q) => $q->where('namebeneficiario', $this->filtroTratamiento))
            ->when($this->filtroEstado, fn ($q) => $q->where('estado', $this->filtroEstado))
            ->when($this->filtroMes, fn ($q) => $q->whereMonth('fechainicio', $this->filtroMes))
            ->when($this->filtroAnio, fn ($q) => $q->whereYear('fechainicio', $this->filtroAnio))
            ->where('modo', 'alquiler')
            ->orderBy('fechainicio', 'desc')
            ->paginate(20);

        $deudas = DB::table('pagos')
            ->when($this->filtroAnio, fn ($q) => $q->whereYear('fechainicio', $this->filtroAnio))
            ->get()
            ->groupBy(function ($item) {
                return $item->empresa.'-'.date('m', strtotime($item->fechainicio));
            });

        $tratamientos = Tratamiento::orderBy('nombre', 'asc')->get();

        return view('livewire.operativos.pagos-table', compact(
            'pagos',
            'tratamientos',
            'deudas',
            'alquileres'
        ));
    }

    // =========================
    // EDITAR PAGO NORMAL
    // =========================
    public function editar($id)
    {
        if (! $id) {
            $this->emit('alert', 'No existe pago para editar.');

            return;
        }

        $this->pagoEditar = Pagos::findOrFail($id)->toArray();
        $this->busquedaBeneficiario = $this->pagoEditar['namebeneficiario'] ?? '';

        $this->modal = true;
    }

    public function guardar()
    {
        $pago = Pagos::find($this->pagoEditar['id']);

        if (! $pago) {
            $this->emit('alert', 'No se encontró el pago.');

            return;
        }

        if ($this->comprobante) {
            $image = $this->comprobante->store('public/comprobantes');
            $image = 'comprobantes/'.basename($image);
            $pago->path = $image;
        }

        $this->pagoEditar['nameuser'] = Auth::user()->name;
        $this->pagoEditar['iduser'] = Auth::user()->id;
        $this->pagoEditar['namebeneficiario'] = mb_strtoupper(trim($this->busquedaBeneficiario), 'UTF-8');

        $pago->update($this->pagoEditar);

        $this->comprobante = null;
        $this->busquedaBeneficiario = null;

        $this->emit('alert', '¡Pago editado!');
        $this->modal = false;
    }

    // =========================
    // ALQUILERES
    // =========================
    public function editaralquiler($id)
    {
        $this->pagoEditar = Pagos::findOrFail($id)->toArray();
        $this->busquedaBeneficiario = $this->pagoEditar['namebeneficiario'] ?? '';
        $this->editar = true;
    }

    public function guardaringreso()
    {
        $pago = new Pagos();

        if ($this->comprobante) {
            $image = $this->comprobante->store('public/comprobantes');
            $image = 'comprobantes/'.basename($image);
            $pago->path = $image;
        }

        $pago->namebeneficiario = mb_strtoupper(trim($this->departamentodealquiler), 'UTF-8');
        $pago->fechainicio = $this->fechacorrespondiente;
        $pago->pagado = $this->montopago;
        $pago->fechapagado = $this->fechadepago;
        $pago->estado = $this->estadodepago;
        $pago->modo = 'alquiler';
        $pago->iduser = Auth::id();
        $pago->nameuser = Auth::user()->name ?? null;
        $pago->save();

        $this->comprobante = null;
        $this->busquedaBeneficiario = null;

        $this->emit('alert', '¡Pago creado!');
        $this->modal = false;
    }
}
