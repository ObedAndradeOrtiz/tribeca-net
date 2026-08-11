<?php

namespace App\Http\Livewire\Inventario;

use App\Models\Areas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class CargaMasiva extends Component
{
    use WithFileUploads;
    public $sucursal;
    public $areas;
    public $crear = false;
    protected $listeners = ['crearCambiado' => 'cambiarCrearFalse', 'datosRecibidos' => 'datosRecibidos'];
    public function datosRecibidos($data)
    {
        $this->areas = Areas::where('estado', 'Activo')->get();
        $htmlTable = $data['tablaHTML'];
        $sucursalData = $data['sucursal'];
        $dom = new \DOMDocument();
        $dom->loadHTML($htmlTable);
        $filas = $dom->getElementsByTagName('tr');

        for ($i = 1; $i < $filas->length; $i++) {
            $datosFila = $filas->item($i)->getElementsByTagName('td');
            $nombre = $datosFila->item(0)->nodeValue;
            $cantidad = $datosFila->item(1)->nodeValue;
            $precio = $datosFila->item(2)->nodeValue;
            $sucursal =  $sucursalData;
            if ($nombre !== null && $nombre !== '' && $cantidad !== null && $cantidad !== '' && $precio !== null && $precio !== '') {
                $producto = Productos::where('nombre', 'LIKE', '%' . $nombre . '%')
                    ->where('sucursal', $sucursal)
                    ->first();
                if ($producto) {
                    foreach ($this->areas as $area) {
                        $producto = Productos::where('nombre', 'LIKE', '%' . $nombre)
                            ->where('sucursal',   $area->area)
                            ->first();
                        if ($producto) {
                            if ($area->area == $sucursal) {
                                $producto->cantidad = $cantidad;
                                $producto->precio = $precio;
                                $producto->save();
                            }
                        } else {
                            $producto = new Productos;
                            $producto->nombre = $nombre;
                            $producto->precio = $precio;
                            $producto->estado = 'Activo';
                            $producto->sucursal = $area->area;
                            $producto->cantidad = 0;
                            $producto->save();
                        }
                    }
                } else {
                    foreach ($this->areas as $area) {
                        $producto = Productos::where('nombre', 'LIKE', '%' . $nombre)
                            ->where('sucursal',  $area->area)
                            ->first();
                        if ($producto) {
                        } else {
                            $producto = new Productos;
                            $producto->nombre = $nombre;
                            $producto->precio = $precio;
                            $producto->estado = 'Activo';
                            $producto->sucursal =  $area->area;
                            if ($area->area == $sucursal) {
                                $producto->cantidad = $cantidad;
                            } else {
                                $producto->cantidad = 0;
                            }
                            $producto->save();
                        }
                    }
                }
            }
        }


        $this->crear = false;
        $this->emitTo('inventario.lista-inventario', 'render');
        $this->emit('alert', '¡Inventario actuliazado!');
    }

    public function render()
    {
        $this->areas = Areas::where('estado', 'Activo')->get();
        return view('livewire.inventario.carga-masiva');
    }
}
