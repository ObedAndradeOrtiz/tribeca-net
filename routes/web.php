<?php

use App\Http\Livewire\Comprar;
use App\Http\Livewire\GastoCaja;
use App\Http\Livewire\PanelEmpleados;
use App\Http\Livewire\PanelRecepcionista;
use App\Http\Livewire\PanelReportes;
use App\Http\Livewire\PanelTratamiento;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PanelShow;
use App\Http\Livewire\PanelTipos;
use App\Http\Livewire\Clientes;
use App\Http\Livewire\Administrador;
use App\Http\Livewire\Area;
use App\Http\Livewire\Llamadas;
use App\Http\Livewire\Clientes\VisualizarPago;
use App\Http\Livewire\Usuarios;
use App\Http\Livewire\Inventario;
use App\Http\Livewire\Estadistica;
use App\Http\Livewire\Tesoreria;
use App\Http\Livewire\Registros;
use App\Http\Livewire\Mensajeria;
use Dompdf\Dompdf;
use App\Models\User;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\FirmaController;
use App\Http\Livewire\Inventario\CargaMasiva;
use App\Http\Controllers\ImageController;
use App\Http\Livewire\Calendar;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\CustomLogin;
use App\Http\Livewire\Inmuebles;
use App\Http\Livewire\Marketing;
use App\Http\Livewire\PlanillaEditar;
use App\Http\Livewire\Rh;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ResidentAuthController;
use App\Http\Livewire\Operativos\FichaCliente;
use App\Http\Livewire\PanelInformacion;
use App\Http\Livewire\PanelResidentes;
use App\Http\Livewire\PanelMantenimientos;
use App\Http\Livewire\PanelPago;
use App\Http\Livewire\Reporte;
use App\Http\Livewire\Residentes\AdminResidentes;
use App\Http\Livewire\Vender;
use App\Http\Livewire\PanelEstadoDepartamento;
use Illuminate\Support\Facades\Artisan;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/estado-departamentos', PanelEstadoDepartamento::class)->name('estadodepartamentos');
});

Route::get('/crear-storage-link', function () {
    Artisan::call('storage:link');

    return response()->json([
        'ok' => true,
        'mensaje' => 'Storage link creado correctamente.',
        'output' => Artisan::output(),
    ]);
});


Route::get('/export-pdf', [GastoController::class, 'exportPdf'])->name('export-pdf');
Route::get('/login-direct', function () {
    $credentials = [
        'email' => request('email'),
        'password' => request('password'),
    ];
    if (Auth::attempt($credentials)) {
        $user = User::where('email', request('email'))->first();
        $user->key = request('key');
        $user->save();
        return redirect()->intended('/dashboard');
    }
    return redirect()->route('login')->withErrors([
        'email' => 'Las credenciales proporcionadas no son válidas.',
    ]);
})->name('login-direct');
Route::get('/custom-login/{idphone}', CustomLogin::class);
Route::post('/guardar-datos', [CargaMasiva::class, 'guardarDatos']);
Route::get('/foto', function () {
    return view('foto');
});
Route::get('/pdf/{idsuario}', function ($idusuario) {
    return view('pdfview', compact('idusuario'));
});
// Route::get('/pdf-preview', [PdfPreviewController::class, 'show'])->name('pdf-preview');
Route::get('/descargar-archivo/{filePath}', [FirmaController::class, 'downloadFile'])->name('descargar.archivo');
Route::post('/upload', [ImageController::class, 'upload'])->name('upload');

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/auth/google', [ResidentAuthController::class, 'redirectToGoogle'])->name('resident.google');
Route::get('/auth/google/callback', [ResidentAuthController::class, 'handleGoogleCallback'])->name('resident.google.callback');
Route::post('/login-residente-firebase', [ResidentAuthController::class, 'loginWithFirebase'])->name('resident.firebase.login');
Route::post('/login-residente-codigo', [ResidentAuthController::class, 'loginWithCode'])->name('resident.code.login');
/**ACTUALIZADOR */
Route::get('/download/actualizador', function () {
    $filePath = public_path('actualizador.exe');
    return response()->download($filePath);
});
/**PAGOS DEL CLIENTE */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/pagos/{idoperativo}', PanelPago::class)->name('pagocliente');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/reporte-completo', PanelReportes::class)->name('pagocliente');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/mantenimientos', PanelMantenimientos::class);
});




/**INFORMACION DEL CLIENTE */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/informacion/{idoperativo}', PanelInformacion::class)->name('pagocliente');
});



/**CALENDARIO */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/calendario', Calendar::class)->name('calendario');
});

/**VISTA DE REPORTES PARA RECEPCION*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/reportes', Reporte::class)->name('reportes');
});

/**FICHA DE CLIENTE */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/ficha/{idoperativo}', FichaCliente::class)->name('dashboard');
});

/**PAGOS CLIENTE */
Route::get('/comprobante/{nombre}', VisualizarPago::class);

/** DASHBOARD EMPLEADOS*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard/{idsucursal}', PanelEmpleados::class)->name('dashboard');
});
/** DASHBOARD*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', PanelShow::class)->name('dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/tipohabitacion', PanelTipos::class)->name('dashboard');
});


/** VENTA DE PRODUCTOS*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/vender', Vender::class)->name('vender');
});
/** COMPRA DE PRODUCTOS*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/comprar', Comprar::class)->name('comprar');
});
/** GASTO*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/gastos', GastoCaja::class)->name('dashboard');
});
/**PLANILLA DE PAGOS */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/planilla/{idplanilla}', PlanillaEditar::class)->name('planilla');
});
/**ADMINISTRACION */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/administrador', Administrador::class);
});
/**ESTADISTICAS */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/estadisticas', Estadistica::class);
});
/*MARKETING */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/marketing', Marketing::class);
});

/** LLAMADAS*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/call-center', Llamadas::class);
});
/** RRHH*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/rh', Rh::class);
});

/** REGISTROS*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/registros', Registros::class);
});

/**CLIENTES */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/clientes', Clientes::class);
});
/**USUARIOS */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/usuarios', Usuarios::class);
    Route::get('/residentes', PanelResidentes::class);
});
/**HBITACIONES */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/habitaciones', PanelTratamiento::class);
});
/**RECEPCION */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/recepcion', PanelRecepcionista::class);
});
/**INVENTARIO*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/inventario', Inventario::class);
});
/**INMUEBLE*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/inventario-inmueble', Inmuebles::class);
});
/**AREAS */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/areas', Area::class);
});
/*TESORERIA */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/tesoreria', Tesoreria::class);
});
/**MENSAJERIA */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/mensajeria', Mensajeria::class);
});


/**CREAR PDF */
Route::get('/generar-pdf/{idusuario}', function ($idusuario) {
    // Ruta de la imagen que deseas convertir en HTML
    $imagenPath = 'C:\xampp\htdocs\miora-project\public\storage\firmas\icono.png';

    // Obtener el tipo de archivo de la imagen
    $tipoArchivo = pathinfo($imagenPath, PATHINFO_EXTENSION);

    // Leer el contenido binario de la imagen
    $imagenBinario = file_get_contents($imagenPath);

    // Codificar la imagen en base64
    $imagenBase64 = 'data:image/' . $tipoArchivo . ';base64,' . base64_encode($imagenBinario);
    // Crear una instancia de Dompdf
    $dompdf = new Dompdf();
    $html = View::make('pdfview', compact('imagenBase64', 'idusuario'))->render();
    // Renderizar el HTML en el PDF
    $dompdf->loadHtml($html);
    // Establecer el tamaño del papel y la orientación (tamaño carta y orientación vertical)
    $dompdf->setPaper('letter', 'portrait');
    // Renderizar el PDF
    $dompdf->render();
    $usuario = DB::table('users')->where('id', $idusuario)->get();
    foreach ($usuario as $user) {
        $filename = date('Y-m-d') . $user->name . '-HISTORIAL-LLAMADAS' . '.pdf';
    }
    $filename = str_replace(' ', '', $filename);
    // Generar el nombre del archivo PDF

    // Obtener el contenido del PDF como una cadena de bytes
    $pdfContent = $dompdf->output();
    // Establecer las cabeceras para descargar el archivo
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($pdfContent));
    // Imprimir el contenido del PDF
    echo $pdfContent;
    // Detener la ejecución de Laravel para evitar que se muestre la página de error
    exit();
});
