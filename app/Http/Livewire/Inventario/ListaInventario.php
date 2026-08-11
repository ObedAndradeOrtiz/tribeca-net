<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;
use App\Models\Productos;
use App\Models\Areas;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ListaInventario extends Component
{
    use WithPagination;
    public $productos;
    public $actividad = 'Activo';
    public $sucursal = "";
    public $areas;
    protected $listeners = ['render' => 'render', 'handleExcelData' => 'handleExcelData'];
    public $excelFile;
    use WithFileUploads;
    public $excelData;
    public $file;
    public $busqueda;
    public $fecha;
    public $vistaproductos;

    public function enviar()
    {
        $this->emit('alert', '¡Inventario actulizado satisfactoriamente!');
    }

    public function render()
    {
        $this->fecha = date('Y-m-d');

        $this->areas = Areas::where('estado', 'Activo')->get();
        if ($this->sucursal == "Todas") {
            if ($this->vistaproductos == "") {
                $productoslist = Productos::where('estado', $this->actividad)->where('nombre', 'LIKE', '%' . $this->busqueda . '%')->orderBy('nombre')->paginate(5);
            } else {
                $productoslist = Productos::where('estado', $this->actividad)->where('cantidad', '>', 0)->where('nombre', 'LIKE', '%' . $this->busqueda . '%')->orderBy('nombre')->paginate(5);
            }
        } else {
            if ($this->vistaproductos == "") {
                $productoslist = Productos::where('estado', $this->actividad)->where('sucursal',  'LIKE', '%' .  $this->sucursal . '%')->where('nombre', 'LIKE', '%' . $this->busqueda . '%')->orderBy('nombre')->paginate(5);
            } else {
                $productoslist = Productos::where('estado', $this->actividad)->where('sucursal',  'LIKE', '%' .  $this->sucursal . '%')->where('cantidad', '>', 0)->where('nombre', 'LIKE', '%' . $this->busqueda . '%')->orderBy('nombre')->paginate(5);
            }
        }

        return view('livewire.inventario.lista-inventario', compact('productoslist'));
    }
}