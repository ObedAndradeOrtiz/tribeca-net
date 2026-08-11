<div>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hope-ui.min.css?v=2.0.0')); ?>" />
    <style>
        .boton-container {
            display: flex;
        }

        .boton {
            padding: 10px 20px;
            font-size: 16px;
            width: 30%;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        @media screen and (max-width: 600px) {
            .boton {
                font-size: 9px;
                width: 30%;
            }
        }

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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <div class="card">
        <div class="row">
            <div class="mt-4 ml-4 col-lg-3 col-md-6">
                <div class="card">
                    <h3>PANEL DE RECEPCIÓN</h3>

                </div>
            </div>
            <div class="mt-2 col-lg-3 col-md-6">
                <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
                    <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
                        placeholder="Buscar Clientes...">
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>AGENDADOS</span>
                    </div>
                    <div>
                        <span class="counter"><?php echo e($agendados); ?></span>
                    </div>

                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>ASISTIDOS</span>
                    </div>
                    <div>
                        <span class="counter"><?php echo e($confirmados); ?></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body" style="margin-top: -35px;">

            <div class="flex-wrap d-flex">
                <div style="margin-right: 1%; font-size: 1vw;">
                    <label for="">Lista de: </label>
                    <select class="form-control" wire:model="botonagenda" style="font-size: 1vw; ">
                        <option value="Agendados">Agendados</option>
                        <option value="Asistidos">Asisitidos </option>
                        <option value="NoAsistidos">No Asisitidos</option>

                    </select>
                </div>
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
                        <button class="ml-4 btn btn-warning d-flex" wire:click='copiarConsultaAlPortapapeles'
                            style="font-size: 1vw;">
                            <span class="mr-2" style="color: white; font-size: 12px;">Exportar a TXT</span>
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.crear-cliente')->html();
} elseif ($_instance->childHasBeenRendered('l992190440-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l992190440-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l992190440-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l992190440-0');
} else {
    $response = \Livewire\Livewire::mount('clientes.crear-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('l992190440-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <?php if($botonagenda == 'Agendados'): ?>
                <div class="mt-4 table-responsive">
                    <table id="mitablaregistros1">
                        <thead>
                            <tr style="background-color: gray; color:white;">
                                <th>ASISTIDO</th>
                                <th>NOMBRE</th>
                                <th>HORA</th>
                                <th>TRATAMIENTO</th>
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
            <?php if($botonagenda == 'Asistidos'): ?>
                <div>
                    <table>
                        <thead>
                            <tr style="background-color: gray; color:white;">


                                <th>NOMBRE</th>
                                <th>COMENTARIO</th>
                                <th>HORA</th>
                                <th>TRATAMIENTO</th>
                                <th>SUCURSAL</th>
                                <th>PAGO REALIZADO</th>
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
                                            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                                    ?>
                                    <td>
                                        <?php echo e($total_monto); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($llamadasasistidas->links()); ?>

                </div>
            <?php endif; ?>
            <?php if($botonagenda == 'NoAsistidos'): ?>
                <div>
                    <table>
                        <thead>
                            <tr style="background-color: gray; color:white;">


                                <th>NOMBRE</th>
                                <th>COMENTARIO</th>
                                <th>HORA</th>
                                <th>TRATAMIENTO</th>
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
        </div>
    </div>
    <style>
        /* Estilo para resaltar el botón de la página actual */
        .current-page {
            background-color: blue;
            color: white;
        }
    </style>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('paginaCambiada', function(pagina) {
                document.querySelectorAll('.pagination li').forEach(function(elemento) {
                    elemento.classList.remove('current-page');
                });
                document.querySelector('.pagination li[data-page="' + pagina + '"]').classList.add(
                    'current-page');
            });
        });
    </script>
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        function handleKeyPress(event) {
            if (event.key === "Enter") {
                // Lógica para ejecutar el evento cuando se presiona Enter
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/recepcionista/lista-recepcion.blade.php ENDPATH**/ ?>