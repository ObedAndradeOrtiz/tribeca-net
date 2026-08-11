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
                <h3>
                    PANEL DE LLAMADAS
                </h3>

            </div>
            <div class="mt-4 ml-4 col-lg-3 col-md-6">

                <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
                    <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
                        placeholder="Buscar llamadas...">
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>LLAMADAS: <span class="counter"><?php echo e($realizadas); ?></span></span>
                    </div>


                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>AGENDADOS: <span class="counter"><?php echo e($agendadas); ?></span></span>
                    </div>

                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>MIS LLAMADAS: <span class="counter"><?php echo e($misllamadas); ?></span></span>
                    </div>

                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>MIS AGENDADOS: <span class="counter"><?php echo e($misagendados); ?></span></span>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="flex-wrap d-flex">
                <div style="margin-right: 1%; font-size: 1vw;">
                    <label>Lista de: </label>
                    <select class="form-control" wire:model="actividad">
                        <option value="llamadas">POR AGENDAR</option>
                        <option value="Pendiente">AGENDADOS</option>

                    </select>
                </div>
                <div style="margin-right: 1%; font-size: 1vw;">
                    <label>Sucursal: </label>
                    <select class="form-control" wire:model="areaseleccionada">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="margin-right: 1%; font-size: 1vw;">
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
                    <input type="date" id="fecha-inicio" class="form-control" wire:model="fechaInicioMes"
                        <?php if(in_array($rangoseleccionado, ['Ayer', 'Diario', 'Semanal', 'Mensual', 'Todos'])): ?> readonly <?php endif; ?>>
                </div>
                <div style="margin-right: 1%; font-size: 1vw;">
                    <label for="fecha-actual">Hasta:</label>
                    <input type="date" id="fecha-actual" class="form-control" wire:model="fechaActual"
                        <?php if(in_array($rangoseleccionado, ['Ayer', 'Diario', 'Semanal', 'Mensual', 'Todos'])): ?> readonly <?php endif; ?>>
                </div>
                <div class="mt-4 d-flex">
                    <div>
                        <button class="btn btn-warning d-flex" wire:click="$set('crear',true)">
                            <span class="mr-2" style="color: white; font-size: 15px;">EXPORTAR A TXT</span>
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.4109 2.76862L16.4119 3.51824C19.1665 3.73413 20.9862 5.61119 20.9891 8.48975L21 16.9155C21.0039 20.054 19.0322 21.985 15.8718 21.99L8.15188 22C5.01119 22.004 3.01482 20.027 3.01087 16.8795L3.00001 8.55272C2.99606 5.65517 4.75153 3.78311 7.50617 3.53024L7.50518 2.78061C7.5042 2.34083 7.83001 2.01 8.26444 2.01C8.69886 2.009 9.02468 2.33883 9.02567 2.77861L9.02666 3.47826L14.8914 3.47027L14.8904 2.77062C14.8894 2.33084 15.2152 2.001 15.6497 2C16.0742 1.999 16.4099 2.32884 16.4109 2.76862ZM4.52148 8.86157L19.4696 8.84158V8.49175C19.4272 6.34283 18.349 5.21539 16.4138 5.04748L16.4148 5.81709C16.4148 6.24688 16.0801 6.5877 15.6556 6.5877C15.2212 6.5887 14.8943 6.24887 14.8943 5.81909L14.8934 5.0095L9.02863 5.01749L9.02962 5.82609C9.02962 6.25687 8.70479 6.5967 8.27036 6.5967C7.83594 6.5977 7.50913 6.25887 7.50913 5.82809L7.50815 5.05847C5.58286 5.25137 4.51753 6.38281 4.52049 8.55072L4.52148 8.86157ZM15.2399 13.4043V13.4153C15.2498 13.8751 15.625 14.2239 16.0801 14.2139C16.5244 14.2029 16.8789 13.8221 16.869 13.3623C16.8483 12.9225 16.4918 12.5637 16.0485 12.5647C15.5944 12.5747 15.2389 12.9445 15.2399 13.4043ZM16.0554 17.892C15.6013 17.882 15.235 17.5032 15.234 17.0435C15.2241 16.5837 15.5884 16.2029 16.0426 16.1919H16.0525C16.5165 16.1919 16.8927 16.5707 16.8927 17.0405C16.8937 17.5102 16.5185 17.891 16.0554 17.892ZM11.1721 13.4203C11.1919 13.8801 11.568 14.2389 12.0222 14.2189C12.4665 14.1979 12.821 13.8181 12.8012 13.3583C12.7903 12.9085 12.425 12.5587 11.9807 12.5597C11.5266 12.5797 11.1711 12.9605 11.1721 13.4203ZM12.0262 17.8471C11.572 17.8671 11.1968 17.5082 11.1761 17.0485C11.1761 16.5887 11.5305 16.2089 11.9847 16.1879C12.429 16.1869 12.7953 16.5367 12.8052 16.9855C12.8259 17.4463 12.4705 17.8261 12.0262 17.8471ZM7.10433 13.4553C7.12408 13.915 7.50025 14.2749 7.95442 14.2539C8.39872 14.2339 8.75317 13.8531 8.73243 13.3933C8.72256 12.9435 8.35725 12.5937 7.91196 12.5947C7.45779 12.6147 7.10334 12.9955 7.10433 13.4553ZM7.95837 17.8521C7.5042 17.8731 7.12901 17.5132 7.10828 17.0535C7.10729 16.5937 7.46273 16.2129 7.9169 16.1929C8.3612 16.1919 8.7275 16.5417 8.73737 16.9915C8.7581 17.4513 8.40365 17.8321 7.95837 17.8521Z"
                                    fill="currentColor"></path>
                            </svg></button>
                    </div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.crear-call')->html();
} elseif ($_instance->childHasBeenRendered('l1490681511-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1490681511-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1490681511-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1490681511-0');
} else {
    $response = \Livewire\Livewire::mount('calls-center.crear-call');
    $html = $response->html();
    $_instance->logRenderedChild('l1490681511-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <div class="mt-4">
                <table>
                    <thead style="font-size: 1vw;">
                        <tr style="background-color: gray; color:white;">


                            <th># LLAMADAS</th>
                            <th>SUCURSAL</th>
                            <th>NOMBRE</th>
                            <th>TELEFONO</th>
                            <th>COMENTARIO</th>
                            <th>FECHA</th>
                            <th style="min-width: 100px">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 1vw;">
                        <style>
                            td {
                                max-width: 200px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }
                        </style>
                        <?php $__currentLoopData = $llamadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>


                                <td><?php echo e($lista->cantidad); ?></td>
                                <td><?php echo e($lista->area); ?></td>
                                <td><?php echo e($lista->empresa); ?></td>
                                <td><?php echo e($lista->telefono); ?></td>
                                <td><?php echo e($lista->comentario); ?></td>
                                <?php
                                    // Configuración de idioma español para Carbon
                                    \Carbon\Carbon::setLocale('es');

                                    $fecha = $lista->fecha;
                                    $fechaCarbon = \Carbon\Carbon::parse($fecha);
                                    $fecha_formateada = $fechaCarbon->isoFormat('dddd D [de] MMMM [del] YYYY');
                                ?>
                                <td><?php echo e($fecha_formateada); ?></td>
                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.editar-call', ['llamada' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('calls-center.editar-call', ['llamada' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($llamadas->links()); ?>

            </div>
        </div>
    </div>
    <style>
        .fixed-bottom {
            position: fixed;
            bottom: 0;
            right: 0;
            margin-top: 5%;
            background-color: #f0f0f0;
            padding: 10px;
            display: flex;
            align-items: flex-end;

        }
    </style>
    <div class="fixed-bottom">
    </div>
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/calls-center/lista-call.blade.php ENDPATH**/ ?>