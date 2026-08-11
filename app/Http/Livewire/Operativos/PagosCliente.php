<?php

namespace App\Http\Livewire\Operativos;

use App\Models\Areas;
use App\Models\HistorialCliente;
use App\Models\Operativos;
use App\Models\Pagos;
use App\Models\registroinventario;
use App\Models\registropago;
use App\Models\Tratamiento;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Hospedados;
use function Termwind\render;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class PagosCliente extends Component
{
    use WithPagination;
    public $operativo;
    public $confirmarimprimir = false;
    public $mododepago = "Efectivo";
    public $elegido;
    public $openArea = false;
    public $openArea2 = false;
    public $openArea3 = false;
    public $openArea4 = false;
    public $nombre;
    public $telefono;
    public $cantidad;
    public $fecha = "";
    public $hora = "";
    public $minuto = "";
    public $openArea5 = false;
    public $user;
    public $tratamientos;
    public $editar = false;
    public $tratamientosSeleccionados = [];
    public $tratamientosSeleccionadosvacios = [];
    public $cantidadpago = 0;
    public $cantidadpagototal;
    public $cuotasmanual = 1;
    public $cuota1 = 0;
    public $cuota2;
    public $cuota3;
    public $cuota4;
    public $haycuota = false;
    public $deuda = 0;
    public $todoslospagos;
    public $pagototal = 0;
    public $mistratamientos;
    public $agreagar = false;
    public $mistratamientospara;
    public $tratamientosSeleccionadosnuevos = [];
    public $busquedatratamiento = "";
    public $pagonuevo = 0;
    public $total = 0;
    public $valores = [];
    public $primerafecha;
    public $pagos = 'uno';
    public $ffff = false;
    public $mostrarbotones = false;
    public $comentariollamada;
    public $pagoefectivo = 0;
    public $pagoqr = 0;
    public $pagotratamientostotal = 0;
    public $descuentotratamientos = 0;
    public $info = false;
    public $idtratamientoseleccionado;
    public $totalpagado = 0;
    public $eliminart = false;
    public $crearpagoproducto = false;
    public $preciosugerido = 0;
    public $productoseleccionado;
    public $habitacionseleccionado;
    public $crearhabitacion = false;
    public $miscompras;
    protected $rules = [
        'operativo.fecha' => 'sometimes|required',
        'operativo.area' => 'sometimes|required',
        'operativo.telefono' => 'sometimes|required',
        'operativo.empresa' => 'sometimes|required',
        'operativo.comentario' => 'sometimes|required',
        'operativo.responsable' => 'sometimes|required',
        'operativo.estado' => 'sometimes|required',
        'operativo.encargado' => 'sometimes|required',
        'pagototal' => 'sometimes|required',
        'cuota1' => 'sometimes|required',
        'cantidadpago' => 'sometimes|required',
        'hora' => 'sometimes|required',
        'minuto' => 'sometimes|required',
    ];
    protected $listeners = ['render' => 'render'];
    public function mount($idoperativo)
    {
        $this->loadOperativoData($idoperativo);
    }

    public function loadOperativoData($idoperativo)
    {
        $this->operativo = Operativos::find($idoperativo);
        $this->total = DB::table('pagos')
            ->where('idoperativo', $this->operativo->id)
            ->sum('cantidad');
        $this->primerafecha = $this->operativo->fecha;
        // $pago = Pagos::where('idoperativo', $this->operativo->id)->first();
        // if ($pago) {
        //     $this->pagotratamientostotal = $pago->cantidad;
        // }
    }

    public function actualizarOperativo($idoperativo)
    {
        $this->loadOperativoData($idoperativo);
    }
    public function render()
    {
        $pago = Pagos::where('idoperativo', $this->operativo->id)->first();
        if ($pago) {
            $this->haycuota = true;
        }
        $this->deuda = DB::table('registropagos')
            ->where('idoperativo', $this->operativo->id)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $this->tratamientos = HistorialCliente::where('idoperativo', $this->operativo->id)->get();
        $this->miscompras = DB::table('registroinventarios')
            ->select('registroinventarios.estado', 'registroinventarios.nombreproducto', 'registroinventarios.id', 'registroinventarios.precio', 'registroinventarios.fecha', 'registroinventarios.modo')
            ->join('historial_clientes', 'registroinventarios.idcliente', '=', 'historial_clientes.idtratamiento')
            ->where('historial_clientes.idoperativo', $this->operativo->id)
            ->where('registroinventarios.motivo', 'compra')
            ->get();

        $this->totalpagado = registropago::where('idoperativo', $this->operativo->id)->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))')) + DB::table('registroinventarios')
            ->select('registroinventarios.estado', 'registroinventarios.nombreproducto', 'registroinventarios.id', 'registroinventarios.precio', 'registroinventarios.fecha', 'registroinventarios.modo')
            ->join('historial_clientes', 'registroinventarios.idcliente', '=', 'historial_clientes.idtratamiento')
            ->where('historial_clientes.idoperativo', $this->operativo->id)
            ->where('registroinventarios.motivo', 'compra')
            ->where('registroinventarios.estado', 'Pagado')
            ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $this->mistratamientospara = Tratamiento::where('estado', 'Activo')->where('nombre', 'LIKE', '%' . $this->busquedatratamiento . '%')->orderBy('nombre', 'asc')->get();
        $this->todoslospagos = Pagos::where('idoperativo', $this->operativo->id)->where('estado', 'Pendiente')->count();
        $this->mistratamientos = HistorialCliente::where('estado', 'Inactivo')->where('idoperativo', $this->operativo->id)->get();
        if ($this->pagotratamientostotal == "") {
            $this->deuda = 0;
        } else {
            $this->deuda = $this->pagotratamientostotal - $this->totalpagado;
        }
        // foreach ($this->tratamientos as $pagos) {
        //     $fecha_dada = new \DateTime($pagos->fecha);

        //     // Fecha actual
        //     $fecha_hoy = new \DateTime();

        //     // Calcular la diferencia
        //     $diferencia = $fecha_hoy->diff($fecha_dada);
        //     if ($this->pagotratamientostotal != "") {
        //         $this->pagotratamientostotal = $this->pagotratamientostotal + ($pagos->costo * $diferencia->days);
        //     }

        // }
        $areas = Areas::where('estado', 'Activo')->orderBy('id', 'desc')->get();
        $users = User::where('estado', 'Activo')->where('rol', '!=', 'Cliente')->orderBy('name', 'asc')->get();
        return view('livewire.operativos.pagos-cliente', compact('areas', 'users'));
    }
    public function habilitarhabitacion(){
        $this->operativo->ingreso=0;
        $this->operativo->save();
    }
    public function desocuparhabitacion()
    {
        $this->operativo->fechafin=Carbon::now()->toDateString();
        $this->operativo->ingreso=1;
        $this->operativo->save();
    }
    public function guardaroperativo()
    {
        if (Pagos::where('idoperativo', $this->operativo->id)->first()) {
        } else {

            $pago = new Pagos;
            $pago->estado = 'Pendiente';
            $pago->area = $this->operativo->area;
            $pago->iduser = $this->operativo->idempresa;
            $pago->fecha = Carbon::now()->toDateString();
            $pago->cantidad = $this->cantidadpago;
            $pago->pagado = 0;
            $pago->idoperativo = $this->operativo->id;
            $pago->save();
        }
        $pago = Pagos::where('idoperativo', $this->operativo->id)->first();
        $pago->cantidad = $this->pagotratamientostotal;
        $pago->save();
        $this->emit('alert', '¡Pago editado!');
    }
    public function guardartodo()
    {
        if (Pagos::where('idoperativo', $this->operativo->id)->first()) {
        } else {

            $pago = new Pagos;
            $pago->estado = 'Pendiente';
            $pago->area = $this->operativo->area;
            $pago->iduser = $this->operativo->idempresa;
            $pago->fecha = Carbon::now()->toDateString();
            $pago->cantidad = $this->cantidadpago;
            $pago->pagado = 0;
            $pago->idoperativo = $this->operativo->id;
            $pago->save();
        }
        $operativo = $this->operativo;
        $registro = new registropago;
        $sucursal = Areas::where('area', $operativo->area)->first();
        $registro->idsucursal = $sucursal->id;
        $registro->sucursal = $sucursal->area;
        $registro->idoperativo = $this->operativo->id;
        $registro->nombrecliente = $this->operativo->empresa;
        $registro->monto = $this->cantidadpago;
        $registro->iduser = Auth::user()->id;
        $registro->responsable = Auth::user()->name;
        $registro->idcliente = $this->operativo->idempresa;
        $registro->idcosmetologa = $this->habitacionseleccionado;
        $registro->fecha = date('Y-m-d');
        $registro->modo = $this->mododepago;
        $registro->motivo = "operativo";
        $registro->estado = 'Activo';
        $registro->save();
        $this->crearhabitacion = false;
        $this->emitTo('pagos.lista-pagos', 'render');
        $this->render();
    }
    public function guardartodoinventario()
    {
        $registro = registroinventario::find($this->productoseleccionado);
        $registro->estado = 'Pagado';
        $registro->precio = $this->cantidadpago;
        $registro->modo = $this->mododepago;
        $registro->save();
        $this->crear = false;
        $this->render();
    }
    public function eliminarVista($idtratamiento)
    {
        $this->idtratamientoseleccionado = $idtratamiento;
        $this->eliminart = true;
    }
    public function eliminarTratamiento()
    {
        $tratamientohistorial = HistorialCliente::find($this->idtratamientoseleccionado);
        $tratamientohistorial->delete();
        $this->eliminart = false;
        $this->render();
        $this->emitTo('pagos.lista-pagos', 'render');
    }
    public function imprimir()
    {

        sleep(1);

        $this->emit('alert', '¡Accion realizada!');
    }
    public function imprimircita()
    {
        $descriptionWidth = 30;
        $cosmetologa = User::find($this->elegido);
        $recepcion = explode(' ', Auth::user()->name);
        $cosmetologa = explode(' ', $cosmetologa->name);
        $area = Areas::find(Auth::user()->sesionsucursal);

        $text = "Ticket #: " . $area->ticket . "\nFecha: " . date('Y-m-d H:i:s') . "\nCaja: " . $this->operativo->area . "\nCliente: " . $this->operativo->empresa . "\nRecepcionista: " . implode(' ', array_slice($recepcion, 0, 2)) . "\nCosmetóloga:" . implode(' ', array_slice($cosmetologa, 0, 2)) . "\n-----------------------------------------------------------------------------" . str_pad("\nDESCRIPCIÓN", $descriptionWidth) . "" . "PRECIO\n-----------------------------------------------------------------------------\n";

        $historiales = DB::table('historial_clientes')
            ->where('idoperativo', $this->operativo->id)
            ->get();
        $this->tratamientosSeleccionadosvacios = array_filter($this->tratamientosSeleccionadosvacios, function ($value) {
            return !empty($value);
        });
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        foreach ($historiales as $tratamiento) {
            $costo += $tratamiento->costo;
            $descripcion = substr($tratamiento->nombretratamiento, 0, 20);
            $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
            $precio = 'Bs.' . $tratamiento->costo;
            $text .= $descripcion . $precio . "\n";
        }

        $deudapago = Pagos::where('idoperativo', $this->operativo->id)->first();
        $text .= " -----------------------------------------------------------------------------\n";

        $subtotal = "Subtotal";
        $subtotal = substr($subtotal, 0, 20);
        $subtotal = str_pad($subtotal, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . $costo;
        $text .= $subtotal . $precio . "\n";

        $descuento = "Descuento";
        $descuento = substr($descuento, 0, 20);
        $descuento = str_pad($descuento, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $costo - (float) $deudapago->cantidad;
        $text .= $descuento . $precio . "\n";

        $totalpago = "Total";
        $totalpago = substr($totalpago, 0, 20);
        $totalpago = str_pad($totalpago, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . (float) $deudapago->cantidad;
        $text .= $totalpago . $precio . "\n";
        $pagosrealizados = DB::table('registropagos')
            ->where('idoperativo', $this->operativo->id)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $pagoenqr = "Pago(s) realizado(s)";
        $pagoenqr = substr($pagoenqr, 0, 20);
        $pagoenqr = str_pad($pagoenqr, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . $pagosrealizados;
        $text .= $pagoenqr . $precio . "\n";

        $pendiente = "Cobro pendiente";
        $pendiente = substr($pendiente, 0, 20);
        $pendiente = str_pad($pendiente, $pricePosition - 1, ' ', STR_PAD_RIGHT);
        $precio = 'Bs.' . $this->deuda;
        $text .= $pendiente . $precio . "\n";
        $text .= " -----------------------------------------------------------------------------\n";
        $data = [
            'id' => Auth::user()->sesionsucursal,
            'texto' => $text,
        ];
        $url = "http://127.0.0.1:5001/imprimirticket";
        $response = Http::post($url, $data);
    }
    public function imprimircitaCosmetologa()
    {
        $descriptionWidth = 30;
        $cosmetologa = User::find($this->elegido);
        $recepcion = explode(' ', Auth::user()->name);
        $cosmetologa = explode(' ', $cosmetologa->name);
        $area = Areas::find(Auth::user()->sesionsucursal);
        $text = "Ticket #: " . $area->ticket . "\nFecha: " . date('Y-m-d H:i:s') . "\nCaja: " . $this->operativo->area . "\nCliente: " . $this->operativo->empresa . "\nRecepcionista: " . implode(' ', array_slice($recepcion, 0, 2)) . "\nCosmetóloga:" . implode(' ', array_slice($cosmetologa, 0, 2)) . "\n-----------------------------------------------------------------------------" . str_pad("\nDESCRIPCIÓN", $descriptionWidth) . "" . "PRECIO\n-----------------------------------------------------------------------------\n";
        $historiales = DB::table('historial_clientes')
            ->where('idoperativo', $this->operativo->id)
            ->get();
        $this->tratamientosSeleccionadosvacios = array_filter($this->tratamientosSeleccionadosvacios, function ($value) {
            return !empty($value);
        });
        $costo = 0;
        $lineWidth = 44;
        $pricePosition = intval($lineWidth * 0.7);

        foreach ($historiales as $tratamiento) {
            $costo += $tratamiento->costo;
            $descripcion = substr($tratamiento->nombretratamiento, 0, 20);
            $descripcion = str_pad($descripcion, $pricePosition - 1, ' ', STR_PAD_RIGHT);
            $precio = 'Bs.' . $tratamiento->costo;
            $text .= $descripcion . $precio . "\n";
        }

        $text .= "
        COSMETOLOGA:


        FIRMA:------------------------------------------------------------------------

        -----------------------------------------------------------------------------\n";
        $data = [
            'id' => Auth::user()->sesionsucursal,
            'texto' => $text,
        ];
        $url = "http://127.0.0.1:5001/imprimirticket";
        $response = Http::post($url, $data);
    }
}
