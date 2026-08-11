<div>
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #52b1e5;

            border-radius: 50%;

            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Estilo para la tabla (solo para darle un aspecto visual, puedes personalizarlo según tus necesidades) */
    </style>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Inicio</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">HOTEL ROJAS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 0): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-Dashboard" wire:click="setOpcion(0)">Registrados(<?php echo e($agendados); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 1): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-Activity" wire:click="setOpcion(1)">Pagado(<?php echo e($confirmados); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 2): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-agendado" wire:click="setOpcion(2)">Pendientes
                            (<?php echo e($agendados - $confirmados); ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PANEL DE HOSPEDADOS: </h3>
                <div class="ml-4" style="border: 2px solid #32b4ff; border-radius: 5px;">
                    <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
                        placeholder="Buscar Clientes...">
                </div>
                <div class="card-options">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
                    <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i
                            class="fe fe-maximize"></i></a>
                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="flex-wrap d-flex">
                    <div style="margin-right: 1%; font-size: 1vw;">
                        <label>Sucursal: </label>
                        <select class="form-control" wire:model="areaseleccionada" style="font-size: 1vw;">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div style="margin-right: 1%;  font-size: 1vw;">
                        <label for="">Rango: </label>
                        <select class="form-control" wire:model="rangoseleccionado" style="font-size: 1vw;">
                            <option value="Diario">Diario</option>
                            <option value="Ayer">Ayer</option>
                            <option value="Semanal">Hace 5 días</option>
                            <option value="Mensual">Hace 30 días</option>
                            <option value="Todos">Todos</option>
                            <option value="Personalizado">Personalizado</option>
                        </select>
                    </div>
                    <div style="margin-right: 1%; font-size: 1vw;">
                        <label for="fecha-inicio">Desde:</label>
                        <input style="font-size: 1vw;" type="date" id="fecha-inicio" class="form-control"
                            wire:model="fechaInicioMes" <?php if(in_array($rangoseleccionado, ['Ayer', 'Diario', 'Semanal', 'Mensual', 'Todos'])): ?> readonly <?php endif; ?>>
                    </div>
                    <div style="margin-right: 1%; font-size: 1vw;">
                        <label for="fecha-actual">Hasta:</label>
                        <input style="font-size: 1vw;" type="date" id="fecha-actual" class="form-control"
                            wire:model="fechaActual" <?php if(in_array($rangoseleccionado, ['Ayer', 'Diario', 'Semanal', 'Mensual', 'Todos'])): ?> readonly <?php endif; ?>>
                    </div>
                    <div class="mt-4" style="display: flex">
                        <div>
                            
                        </div>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.crear-cliente')->html();
} elseif ($_instance->childHasBeenRendered('l3718529697-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3718529697-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3718529697-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3718529697-0');
} else {
    $response = \Livewire\Livewire::mount('clientes.crear-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('l3718529697-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
                <?php if($opcion == 0): ?>
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>CHECK</th>
                                    <th>NOMBRE</th>
                                    <th>CANT. PER</th>
                                    <th>HORA</th>
                                    <th>F.ENTRADA</th>
                                    <th>F.SALIDA</th>
                                    <th>HABITACION(ES)</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $llamadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $verificar = false;
                                        $haypago = false;
                                        $paguito = DB::table('registropagos')
                                            ->where('idoperativo', $lista->id)
                                            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                                            ->get();
                                        foreach ($paguito as $key => $value) {
                                            $haypago = true;
                                        }
                                        $mipagos = DB::table('pagos')
                                            ->where('idoperativo', $lista->id)
                                            ->get();
                                        foreach ($mipagos as $pago) {
                                            if ($pago->cantidad < $pago->pagado) {
                                                $verificar = true;
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <?php if($haypago): ?>
                                            <td>✅</td>
                                        <?php else: ?>
                                            <td>❌</td>
                                        <?php endif; ?>


                                        <td><?php echo e($lista->empresa); ?></td>
                                        <td><?php echo e($lista->cantidadaregistrar); ?></td>
                                        <?php
                                            \Carbon\Carbon::setLocale('es');

                                            $fecha = $lista->fecha;
                                            $fechaCarbon = \Carbon\Carbon::parse($fecha);
                                            $fecha_formateada = $fechaCarbon->isoFormat('dddd D [de] MMMM [del] YYYY');
                                        ?>
                                        <td><?php echo e($lista->hora); ?></td>
                                        <th><?php echo e($lista->fecha); ?></th>
                                        <th><?php echo e($lista->fechafin); ?></th>
                                        <?php
                                            $historial = DB::table('historial_clientes')
                                                ->where('idoperativo', $lista->id)
                                                ->get();
                                        ?>
                                        <td>

                                            <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($historia->nombretratamiento . '/'); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <div class="text-muted"><?php echo e($lista->area); ?></div>

                                        </td>
                                        <td>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($llamadas->links()); ?>

                    </div>
                <?php endif; ?>
                <?php if($opcion == 1): ?>
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>COMENTARIO</th>
                                    <th>HORA</th>
                                    <th>HABITACIONES(S)</th>
                                    <th>SUCURSAL</th>
                                    <th>PAGO REALIZADO</th>
                                    <th>ENTREGADO <br> POR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $llamadasasistidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($lista->empresa); ?></td>
                                        <td><?php echo e($lista->comentario); ?></td>
                                        <?php
                                            \Carbon\Carbon::setLocale('es');
                                            $fecha = $lista->fecha;
                                            $fechaCarbon = \Carbon\Carbon::parse($fecha);
                                            $fecha_formateada = $fechaCarbon->isoFormat('dddd D [de] MMMM [del] YYYY');
                                        ?>
                                        <td><?php echo e($lista->hora); ?></td>
                                        <?php
                                            $historial = DB::table('historial_clientes')
                                                ->where('idoperativo', $lista->id)
                                                ->get();
                                        ?>
                                        <td>
                                            <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($historia->nombretratamiento . '/'); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td><?php echo e($lista->area); ?></td>
                                        <?php
                                            $total_monto = DB::table('registropagos')
                                                ->where('idcliente', $lista->idempresa)
                                                ->where('estado', 'Activo')
                                                ->where('fecha', '<=', $fechaActual)
                                                ->where('fecha', '>=', $fechaInicioMes)
                                                ->get();
                                            $responsables = DB::table('registropagos')
                                                ->where('idcliente', $lista->idempresa)
                                                ->get();
                                        ?>
                                        <td>
                                            <?php $__currentLoopData = $total_monto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($monto->monto . '-' . $monto->modo); ?>

                                                <br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $responsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responsable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($responsable->responsable); ?>

                                                <br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($llamadasasistidas->links()); ?>

                    </div>
                <?php endif; ?>
                <?php if($opcion == 2): ?>
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>COMENTARIO</th>
                                    <th>HORA</th>
                                    <th>HABITACION(ES)</th>
                                    <th>SUCURSAL</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $llamadasnoasistidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($lista->empresa); ?></td>
                                        <td><?php echo e($lista->comentario); ?></td>
                                        <?php
                                            \Carbon\Carbon::setLocale('es');
                                            $fecha = $lista->fecha;
                                            $fechaCarbon = \Carbon\Carbon::parse($fecha);
                                            $fecha_formateada = $fechaCarbon->isoFormat('dddd D [de] MMMM [del] YYYY');
                                        ?>
                                        <td><?php echo e($lista->hora); ?></td>
                                        <?php
                                            $historial = DB::table('historial_clientes')
                                                ->where('idoperativo', $lista->id)
                                                ->get();
                                        ?>
                                        <td>
                                            <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($historia->nombretratamiento . '/'); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </td>
                                        <td><?php echo e($lista->area); ?></td>
                                        <td>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($llamadasnoasistidas->links()); ?>

                    </div>
                <?php endif; ?>
                <?php if($opcion == 3): ?>
                    <div style="margin-right: 1%; font-size: 1vw; display:flex;">
                        <label>Sucursal: </label>
                        <select class="form-control" wire:model.defer="areaseleccionadacalendario">
                            <option value="0">Sin seleccionar</option>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <button class="btn btn-warning" wire:click="actulizargrafico">Actualizar</button>

                    </div>
                    <iframe id="calendarioIframe" src="https://spamiora.ddns.net/calendario" frameborder="0"
                        style="height: 100vh; width:100%;"></iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        function handleKeyPress(event) {
            if (event.key === "Enter") {
                console.log("Se presionó Enter");
                Livewire.emitTo('mensajeria.ver-chats', 'enviar');
            }
        }
        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.sent', function() {
                document.getElementById('preloader').style.display = 'flex';
            });

            Livewire.hook('message.processed', function() {
                document.getElementById('preloader').style.display = 'none';
            });
        });
        Pusher.logToConsole = true;

        var pusher = new Pusher('6d4f547e6d802887f1dc', {
            cluster: 'sa1'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            Livewire.emitTo('recepcionista.lista-recepcion', 'render');
            Livewire.emitTo('calls-center.lista-call', 'render');
            Livewire.emitTo('mensajeria.chat-interno-cantidad', 'render');
            Livewire.emitTo('mensajeria.mis-chat-interno', 'render');
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/recepcionista/lista-recepcion.blade.php ENDPATH**/ ?>