<?php

namespace App\Http\Livewire\Tesoreria;

use App\Models\Gastos;
use App\Models\registrocaja;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Micaja extends Component
{
    public $total_monto_g;
    public $total_inventario_g;
    public $gastoarea_g;
    public $gastoarealista;
    public $total_monto_citas_g;
    public $total_monto_qr_g;
    public $total_monto_qr_lista_g;
    public $total_inventario_qr_g;
    public $total_monto;
    public $total_inventario;
    public $gastoarea;
    public $total_monto_citas;
    public $total_monto_qr;
    public $total_monto_qr_lista;
    public $total_inventario_qr;
    public $total_inventario_pago;
    public $total_inventario_pago_qr;
    public $openAreaGasto = false;
    public $fechaInicioMes;
    public $fechaActual;
    public $total_monto_cita_efectivo;
    public $total_monto_cita_qr;
    public $turnomanana = 0;
    public $turnotarde = 0;
    public $existecaja = false;
    public $opcion = 0;
    public $notificaciones;
    protected $listeners = ['render' => 'render', 'eliminar' => 'eliminar'];

    public function setOpcion($num)
    {
        $this->opcion = $num;
    }
    public function mount()
    {
        $this->fechaInicioMes = Carbon::now()->toDateString();
        $this->fechaActual = Carbon::now()->toDateString();
    }
    public function registrarcaja()
    {

        $now = new DateTime();
        $fecha = $now->format('Y-m-d'); // Formato de fecha: 2024-05-21
        $hora = $now->format('H:i:s'); // Formato de hora: 14:35:22

        //SUMA DE CITAS EN EFECTIVO
        $total_monto_cita_efectivo = DB::table('registropagos')
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        //SUMA DE PRODUCTOS VENDIDOS EN EFECTIVO
        $total_inventario_efectivo =
        DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->where('motivo', 'compra')
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
        DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->where('motivo', 'farmacia')
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        //GASTOS EN EFECTIVO DE CAJA
        $gastoarea_efectivo = DB::table('gastos')
            ->where('area', Auth::user()->sucursal)
            ->where('fechainicio', '<=', $this->fechaActual)
            ->where('fechainicio', '>=', $this->fechaInicioMes)
            ->where('pertence', 'Caja')
            ->sum('cantidad');
        //SUMA DE CITAS EN QR
        $total_monto_cita_qr = DB::table('registropagos')
          ->whereRaw('LOWER(modo) LIKE ?', ['%Qr%'])
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        //SUMA DE PRODUCTOS VENDIDOS EN QR
        $total_inventario_qr =
        DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->whereRaw('LOWER(modo) LIKE ?', ['%Qr%'])
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->where('motivo', 'compra')
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
        DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
          ->whereRaw('LOWER(modo) LIKE ?', ['%Qr%'])
            ->where('fecha', '<=', $fecha)
            ->where('fecha', '>=', $fecha)
            ->where('motivo', 'farmacia')
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $nuevo = new registrocaja();
        $nuevo->sucursal = Auth::user()->sucursal;
        $nuevo->idsucursal = Auth::user()->sesionsucursal;
        $nuevo->montoefectivo = $total_monto_cita_efectivo + $total_inventario_efectivo - $gastoarea_efectivo;
        $nuevo->montoqr = $total_monto_cita_qr + $total_inventario_qr;
        $nuevo->productosvendidos = 0;
        $nuevo->iduser = Auth::user()->id;
        $nuevo->responsable = Auth::user()->name;
        $nuevo->fecha = $fecha;
        $nuevo->hora = $hora;
        $nuevo->estado = 'Activo';
        $nuevo->save();

        $this->emit('alert', '¡Caja guardada satisfactoriamente!');
    }
    public function render()
    {
        $this->existecaja = registrocaja::where('iduser', Auth::user()->id)->where('fecha', $this->fechaActual)->exists();
        $this->turnotarde = DB::table('registropagos')
            ->where(function ($query) {
                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) = 14 AND SECOND(created_at) = 59")
                    ->orWhere(function ($query) {
                        $query->whereRaw("HOUR(created_at) > 14")
                            ->orWhere(function ($query) {
                                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) >= 14");
                            });
                    });
            })
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))')) +
        DB::table('registroinventarios')
            ->where(function ($query) {
                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) = 14 AND SECOND(created_at) = 59")
                    ->orWhere(function ($query) {
                        $query->whereRaw("HOUR(created_at) > 14")
                            ->orWhere(function ($query) {
                                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) >= 14");
                            });
                    });
            })
            ->where('sucursal', Auth::user()->sucursal)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->whereIn('motivo', ['compra', 'farmacia'])
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $this->turnomanana = DB::table('registropagos')
            ->where(function ($query) {
                $query->whereRaw("HOUR(created_at) = 0 AND MINUTE(created_at) = 0 AND SECOND(created_at) = 0")
                    ->orWhere(function ($query) {
                        $query->whereRaw("HOUR(created_at) < 14")
                            ->orWhere(function ($query) {
                                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) <= 14");
                            });
                    });
            })
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))')) +
        DB::table('registroinventarios')
            ->where(function ($query) {
                $query->whereRaw("HOUR(created_at) = 0 AND MINUTE(created_at) = 0 AND SECOND(created_at) = 0")
                    ->orWhere(function ($query) {
                        $query->whereRaw("HOUR(created_at) < 14")
                            ->orWhere(function ($query) {
                                $query->whereRaw("HOUR(created_at) = 14 AND MINUTE(created_at) <= 14");
                            });
                    });
            })
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->whereIn('motivo', ['compra', 'farmacia'])
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $this->total_monto_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

        $this->total_monto_cita_efectivo = DB::table('registropagos')
            ->where('modo', 'LIKE', '%Efectivo%')
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

        $this->total_monto_cita_qr = DB::table('registropagos')
            ->where('modo', 'LIKE', '%Qr%')
            ->where('sucursal', Auth::user()->sucursal)
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

        $this->total_inventario_g = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->whereIn('motivo', ['compra', 'farmacia'])
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));

        $this->gastoarea_g = DB::table('gastos')
            ->where('area', Auth::user()->sucursal)
            ->where('pertence', 'Caja')
            ->whereBetween('fechainicio', [$this->fechaInicioMes, $this->fechaActual])
            ->sum('cantidad');

        $this->gastoarealista = DB::table('gastos')
            ->where('area', Auth::user()->sucursal)
            ->where('pertence', 'Caja')
            ->whereBetween('fechainicio', [$this->fechaInicioMes, $this->fechaActual])
            ->get();

        $this->total_monto_citas_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->get();

        $this->total_monto_qr_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->where('modo', 'LIKE', '%qr%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

        $this->total_monto_qr_lista_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->where('modo', 'LIKE', '%qr%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->get();

        $this->total_inventario_qr_g = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->where('modo', 'LIKE', '%Qr%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->whereIn('motivo', ['compra', 'farmacia'])
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));

        $this->total_monto = DB::table('registropagos')
            ->where('iduser', Auth::user()->id)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

        $this->total_inventario = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->whereIn('motivo', ['compra', 'farmacia'])
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));

        $this->gastoarea = DB::table('gastos')
            ->where('modo', 'LIKE', '%Efectivo%')
            ->where('pertence', 'Caja')
            ->where('area', Auth::user()->sucursal)
            ->whereBetween('fechainicio', [$this->fechaInicioMes, $this->fechaActual])
            ->sum('cantidad');

        $this->total_monto_citas = DB::table('registropagos')
            ->where('iduser', Auth::user()->id)
            ->where('modo', 'LIKE', '%Efectivo%')
            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
            ->get();


      

$hoy = Carbon::today();

$this->notificaciones = \App\Models\Mantenimiento::get()->map(function ($m) use ($hoy) {

    $fecha = Carbon::parse($m->fecha_siguiente);
    $dias = $hoy->diffInDays($fecha, false); // puede ser negativo

    // 🔥 COLOR + MENSAJE
    if ($dias <= 2) {
        $m->color = 'danger'; // rojo
        $m->mensaje = '⚠️ URGENTE - mantenimiento inmediato';
    } elseif ($dias <= 5) {
        $m->color = 'warning'; // amarillo
        $m->mensaje = '⏳ Próximo mantenimiento';
    } elseif ($dias <= 15) {
        $m->color = 'success'; // verde
        $m->mensaje = '✔️ Programado';
    } else {
        $m->color = 'secondary';
        $m->mensaje = 'Sin urgencia';
    }

    $m->dias_restantes = $dias;

    return $m;
});

        return view('livewire.tesoreria.micaja');
    }
    public function actualizar()
    {
        $this->render();
    }
    public function eliminar($idgasto)
    {
        $misgastos = Gastos::find($idgasto);
        $misgastos->delete();

        $this->render();
    }
    public function imprimirResultado()
    {

        $descriptionWidth = 30;
        $recepcion = explode(' ', Auth::user()->name);

        $text = "REGISTRO DE PAGOS--------------------------------------------------------------------\n" . "Fecha: " . date('Y-m-d H:i:s') . "\nCaja: " . Auth::user()->sucursal . "\nRecepcionista: " . implode(' ', array_slice($recepcion, 0, 2)) . "\n-----------------------------------------------------------------------------" . str_pad("\nDESCRIPCIÓN", $descriptionWidth) . "" . "MONTO\n" .
            "PAGOS EN EFECTIVO AGENDADOS-------------------------------------------------\n";

        $costo = 0;
        $ingresoefectivo = 0;
        $ingresoqr = 0;
        $ingresototal = 0;
        $gastototal = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        $total_monto_citas = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->get();
        foreach ($total_monto_citas as $citas) {
            $costo += (float) $citas->monto;
            $ingresoefectivo += (float) $citas->monto;
            $cliente = User::find($citas->idcliente);
            if ($cliente) {
                $descripcion = substr($cliente->telefono . '-' . $cliente->name, 0, 27);
                $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
                $precio = 'Bs.' . $citas->monto;
                $text .= $descripcion . $precio . "\n";
            }
        }
        $text .= " -----------------------------------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $costo;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "PAGOS EN EFECTIVO PRODUCTOS-------------------------------------------------\n";
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        $total_monto_citas = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
            ->whereIn('motivo', ['compra', 'farmacia'])->get();
        foreach ($total_monto_citas as $citas) {
            $costo += (float) $citas->precio;
            $ingresoefectivo += (float) $citas->precio;
            $descripcion = substr($citas->cantidad . '-' . $citas->nombreproducto, 0, 27);
            $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
            $precio = 'Bs.' . $citas->precio;
            $text .= $descripcion . $precio . "\n";
        }
        $text .= " -----------------------------------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $costo;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "PAGOS EN QR AGENDADOS-------------------------------------------------\n";
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        $total_monto_citas = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
          ->whereRaw('LOWER(modo) LIKE ?', ['%Qr%'])
            ->get();
        foreach ($total_monto_citas as $citas) {
            $costo += (float) $citas->monto;
            $ingresoqr += (float) $citas->monto;
            $cliente = User::find($citas->idcliente);
            if ($cliente) {
                $descripcion = substr($cliente->telefono . '-' . $cliente->name, 0, 27);
                $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
                $precio = 'Bs.' . $citas->monto;
                $text .= $descripcion . $precio . "\n";
            }
        }
        $text .= " -----------------------------------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $costo;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";

        $text .= "PAGOS EN QR PRODUCTOS-------------------------------------------------\n";
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        $total_monto_citas = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
          ->whereRaw('LOWER(modo) LIKE ?', ['%Qr%'])
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
            ->whereIn('motivo', ['compra', 'farmacia'])->get();
        foreach ($total_monto_citas as $citas) {
            $costo += (float) $citas->precio;
            $ingresoqr += (float) $citas->precio;
            $descripcion = substr($citas->cantidad . '-' . $citas->nombreproducto, 0, 27);
            $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
            $precio = 'Bs.' . $citas->precio;
            $text .= $descripcion . $precio . "\n";
        }
        $text .= " -----------------------------------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $costo;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "INGRESO TOTAL EFECTIVO-------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $ingresoefectivo;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "INGRESO TOTAL QR-------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $ingresoqr;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $ingresototal = $ingresoefectivo + $ingresoqr;
        $text .= "INGRESO TOTAL SUC.-------------------------------------------------\n";
        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $ingresototal;
        $text .= $totalpago . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "GASTOS DE CAJA-------------------------------------------------\n";
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);
        $total_monto_citas = DB::table('gastos')
          ->whereRaw('LOWER(modo) LIKE ?', ['%Efectivo%'])
            ->where('area', Auth::user()->sucursal)
            ->where('fechainicio', '<=', $this->fechaActual)
            ->where('fechainicio', '>=', $this->fechaInicioMes)
            ->where('pertence', 'Caja')
            ->get();
        foreach ($total_monto_citas as $citas) {
            $costo += (float) $citas->cantidad;
            $gastototal += (float) $citas->cantidad;
            $descripcion = substr($citas->empresa, 0, 27);
            $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
            $precio = 'Bs.' . $citas->cantidad;
            $text .= $descripcion . $precio . "\n";
        }
        $text .= " -----------------------------------------------------------------------------\n";
        $text .= "CUADRE DE CAJA-------------------------------------------------\n";
        $totalpago = "TOTAL SUCURSAL";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $ingresototal - (float) $gastototal;
        $text .= $totalpago . $precio . "\n";
        $totalpago = "TOTAL EN CAJA";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $ingresoefectivo - (float) $gastototal;
        $text .= $totalpago . $precio . "\n";
        $text .= "




        FIRMA : -----------------------------------------------------------------------------


        -----------------------------------------------------------------------------\n";

        $data = [
            'id' => Auth::user()->sesionsucursal,
            'texto' => $text,
        ];
        $url = "http://127.0.0.1:5001/imprimirticket";
        $response = Http::post($url, $data);
        sleep(1);
    }
}
