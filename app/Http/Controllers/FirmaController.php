<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calls;
use App\Models\Operativos;
use App\Models\User;
use App\Models\Pagos;
use Carbon\Carbon;
class FirmaController extends Controller
{
    public function downloadFile($filePath)  
    {
      return response()->download('C:/xampp/htdocs/bbc-live/storage/app/public/pagos/M71xttCpNYaEjeAO7UTlHsPP1zNRhbV3R8HOCWdk.pdf');
    }
    public function guardarFirma(Request $request)
    {
        if ($request->has('imagen')) {
            $imagenBase64 = $request->input('imagen');
            $imagenDecodificada = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenBase64));
            $nombreArchivo = 'firma_'.$request->input('miid').'.jpg';
            $ruta = public_path('firmas').'\\' . $nombreArchivo;
            file_put_contents($ruta, $imagenDecodificada);
            $user=User::find($request->input('miid'));
            $user->firma=$ruta;
            $user->save();
            return response()->json(['message' => 'Imagen guardada correctamente '.$ruta]);
        } else {
            return response()->json(['message' => 'No se encontró ninguna imagen'], 400);
        }
    }
    public function crearfirma($id){
        $usuario=User::find($id);
        $pagos=Pagos::where('iduser',$usuario->id);
        $miid=$id;
        return view('firma', compact('usuario','pagos','miid'));
    }
    public function crearfirmauser($id){
        $usuario=User::find($id);
        $pagos=Pagos::where('iduser',$usuario->id);
        $miid=$id;
        return view('firma', compact('usuario','pagos','miid'));
    }
    public function contrato($id){
        $usuario=User::find($id);
        $pagos=Pagos::where('iduser',$usuario->id);
        $imagenPath = 'C:\inetpub\wwwroot\bbc-live\public\firmas\imagen.png';
        // Obtener el tipo de archivo de la imagen
        $tipoArchivo = pathinfo($imagenPath, PATHINFO_EXTENSION);
        // Leer el contenido binario de la imagen
        $imagenBinario = file_get_contents($imagenPath);
        // Codificar la imagen en base64
        $imagenBase64 = 'data:image/' . $tipoArchivo . ';base64,' . base64_encode($imagenBinario);
        $strings=array();
        $varid=$usuario->id;
        $pagos=Pagos::where('iduser',$usuario->id)->get();
        $area="";
        $primerafecha="";
        $num=0;
        foreach ($pagos as $pago) {
            Carbon::setLocale('es'); // Establecer el idioma en español
                   
            $fecha =Carbon::createFromFormat('Y-m-d', $pago->fechainicio)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY');// Crear una instancia de Carbon con la fecha
            if($num==0){
                $primerafecha=$fecha;
                $num=1;
            }    
            $fechaEscrita = $fecha;
            $nuevoString = $fechaEscrita; // Obtener el nuevo string para agregar al array
            array_push($strings, $nuevoString);  
            $area=$pago->area;      
            }
            return view('pdfview',compact('imagenBase64','varid','pagos','area','strings','usuario','primerafecha'));
    }
}
