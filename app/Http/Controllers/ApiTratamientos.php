<?php

namespace App\Http\Controllers;

use App\Models\Inmueble;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Models\Tratamiento;

class ApiTratamientos extends Controller
{
    public function index($sucursal)
    {
        $tratamientos = Productos::select('nombre', 'cantidad', 'precio')->where('sucursal', $sucursal)->where('estado', 'Activo')->get();

        return response()->json($tratamientos);
    }
    public function saldos($sucursal)
    {
        $productos = Productos::select('nombre', 'cantidad', 'precio')->where('sucursal', $sucursal)->where('estado', 'Activo')->where('cantidad', '>', 0)->get();

        return response()->json($productos);
    }
    public function inmuebles($sucursal)
    {
        $productoslist = Inmueble::select('sucursal', 'area', 'tipo', 'nombre', 'descripcion', 'estado', 'cantidad', 'precio', 'fecha')->where('sucursal', 'LIKE', '%' . $sucursal . '%')->get();
        return response()->json($productoslist);
    }
}
