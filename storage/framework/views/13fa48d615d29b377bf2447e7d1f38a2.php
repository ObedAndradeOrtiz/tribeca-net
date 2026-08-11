<div>
    <div class="row">
        <div class="col-md-3">
            <div class="card ">
                <div class="row">
                    <div class="flex-wrap">
                        <div class="mt-2 ml-2 mr-4">
                            <div class="d-flex">
                                <h3 style="font-size: 24px;">PANEL DE MARKETING</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-wrap mt-2 ml-2 mr-4" style="display: flex; overflow-y:hidden;">
                    <div class="form-group" style="margin-right: 5%;">
                        <label>Tipo de lista: </label>
                        <select wire:model="botonRecepcion">
                            <option value="transacciones">TRANSACCIONES CAJA</option>
                            <option value="tarjetas">LISTA DE TARJETAS</option>
                            <option value="cuentas">LISTA DE CUENTAS COMERCIALES</option>
                            <option value="publicidades">LISTA DE PUBLICIDADES</option>
                            <option value="campañas">LISTA DE CAMPAÑAS</option>
                            <option value="mensajes">LISTA DE MSJ RECIB</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">

                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>

                            <th>
                                SALDO <br> DISTRIBUIDO
                            </th>
                            <th>
                                SALDO <br> TARJETA <br> PRINCIPAL
                            </th>
                            <th>
                                SALDO <br> TOTAL
                            </th>

                        </thead>
                        <tbody>
                            <tr>


                                <td>
                                    <?php echo e($saldotarjetas); ?>

                                </td>
                                <td>
                                    <?php echo e($sumasaldomi); ?>

                                </td>
                                <td>
                                    <?php echo e($sumasaldo); ?>

                                </td>

                            </tr>
                            <tr>
                                <td><strong>GASTO TOTAL</strong> </td>
                                <td></td>
                                <td> <?php echo e($saldodistribuido); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <th>MSJ HOY</th>
                            <th>MSJ TOTAL</th>
                            <th>PROM</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    0
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <th><strong>PUBLICIDADES ACTIVAS</strong> </th>
                            <th><?php echo e($publicidadActivas); ?></th>

                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <button class="btn btn-success" style="width: 100%;">AGREGAR NRO. MENSAJES</button>
                </div>
                <div class="mt-3 mb-4">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.crear-transaccion')->html();
} elseif ($_instance->childHasBeenRendered('l572186674-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l572186674-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l572186674-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l572186674-0');
} else {
    $response = \Livewire\Livewire::mount('marketing.crear-transaccion');
    $html = $response->html();
    $_instance->logRenderedChild('l572186674-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>


            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="text-sm text-gray-600">
                    <form>
                        <?php if($botonRecepcion == 'transacciones'): ?>
                            <div class="mb-2 ml-4">
                                <h2 style="font-size: 18px;"><strong>TRASACCIONES REALIZADOS EN CAJA DE
                                        MARKETING</strong> </h2>
                            </div>
                            <div>
                                <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">

                                    <div class="mb-2 mr-1">
                                        <div>
                                            <label for="fecha-inicio">Desde:</label>
                                        </div>

                                        <input type="date" id="fecha-inicio" wire:model="fechaInicioMes">
                                    </div>
                                    <div class="ml-1 mr-1">
                                        <div>
                                            <label for="fecha-actual">Hasta:</label>
                                        </div>
                                        <input type="date" id="fecha-actual" wire:model="fechaActual">
                                    </div>
                                    <div class="form-group" style="margin-right: 1%;">
                                        <div>
                                            <label>TARJETA: </label>
                                        </div>
                                        <div><select wire:model="tarjetaseleccionada">
                                                <option value="">Todas</option>
                                                <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select></div>

                                    </div>
                                    <div class="form-group" style="margin-right: 1%;">
                                        <div>
                                            <label>MOVIMIENTO: </label>
                                        </div>
                                        <div><select wire:model="tipode">
                                                <option value="">Todos</option>
                                                <option value="envio">EMISORA</option>
                                                <option value="recibo">RECEPTORA</option>
                                            </select></div>

                                    </div>




                                </div>


                                
                                <div class="mb-2 ml-4">
                                    <label for="">Se estan mostrando: <?php echo e($registrotransaccionestotal); ?>

                                        transacciones.</label>
                                </div>
                                <div class="table-responsive">
                                    <table id="mitablaregistros1" class="table table-striped" role="grid"
                                        data-bs-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>TRANSACCION</th>
                                                <th>MONTO</th>
                                                <th>TARJETA <br> EMISORA</th>
                                                <th>TARJETA <br> RECEPTORA</th>
                                                <th>CUENTA <br> COMERCIAL</th>
                                                <th>FECHA</th>
                                                <th>CODIGO</th>
                                                <th>RESPONSABLE</th>
                                                <th>ACCIÓN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $registrotransacciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item->motivo); ?></td>
                                                    <td><?php echo e($item->monto); ?></td>
                                                    <td><?php echo e($item->tarjetaprincipal); ?></td>
                                                    <td><?php echo e($item->tarjeta); ?></td>
                                                    <td><?php echo e($item->nombrecuenta); ?></td>
                                                    <td><?php echo e($item->fecha); ?></td>
                                                    <td><?php echo e($item->codigo); ?></td>
                                                    <td><?php echo e($item->responsable); ?></td>

                                                    <td>
                                                        <a class="btn btn-sm btn-icon btn-danger"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit" data-original-title="Edit"
                                                            wire:click="$emit('eliminarTransaccion',<?php echo e($item->id); ?>)">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.4"
                                                                        d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                                        fill="currentColor"></path>
                                                                    <path
                                                                        d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <div class="px-6 py-3">
                                        <?php echo e($registrotransacciones->links()); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($botonRecepcion == 'tarjetas'): ?>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.mark-tarjetas')->html();
} elseif ($_instance->childHasBeenRendered('l572186674-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l572186674-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l572186674-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l572186674-1');
} else {
    $response = \Livewire\Livewire::mount('marketing.mark-tarjetas');
    $html = $response->html();
    $_instance->logRenderedChild('l572186674-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php endif; ?>
                        <?php if($botonRecepcion == 'cuentas'): ?>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.mark-comerciales')->html();
} elseif ($_instance->childHasBeenRendered('l572186674-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l572186674-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l572186674-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l572186674-2');
} else {
    $response = \Livewire\Livewire::mount('marketing.mark-comerciales');
    $html = $response->html();
    $_instance->logRenderedChild('l572186674-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php endif; ?>
                        <?php if($botonRecepcion == 'publicidades'): ?>
                            <div>
                                <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h3 class="ml-4" style="font-size: 18px;"><strong>LISTA DE PUBLICIDADES</strong>
                                    </h3>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.crear-publicidad')->html();
} elseif ($_instance->childHasBeenRendered('l572186674-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l572186674-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l572186674-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l572186674-3');
} else {
    $response = \Livewire\Livewire::mount('marketing.crear-publicidad');
    $html = $response->html();
    $_instance->logRenderedChild('l572186674-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped" role="grid" data-bs-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>TIPO</th>
                                                <th>SUCURSAL</th>
                                                <th>CUENTA COMERCIAL</th>
                                                <th>FECHA INICIO</th>
                                                <th>FECHA FIN</th>
                                                <th>ESTADO</th>
                                                <th>COMENTARIO</th>
                                                <th>ACCIÓN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $tot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr data-id="<?php echo e($item->id); ?>"
                                                    data-nombrecampana="<?php echo e($item->nombrecampana); ?>"
                                                    data-sucursal="<?php echo e($item->sucursal); ?>"
                                                    data-nombrecuenta="<?php echo e($item->nombrecuenta); ?>"
                                                    data-fechainicio="<?php echo e($item->fechainicio); ?>"
                                                    data-fechafin="<?php echo e($item->fechafin); ?>"
                                                    data-estado="<?php echo e($item->estado); ?>"
                                                    data-motivo="<?php echo e($item->motivo); ?>">

                                                    <td class="clickable"><?php echo e($item->nombrecampana); ?></td>
                                                    <td class="clickable"><?php echo e($item->sucursal); ?></td>
                                                    <td class="clickable"><?php echo e($item->nombrecuenta); ?></td>
                                                    <td class="clickable"><?php echo e($item->fechainicio); ?></td>
                                                    <td class="clickable"><?php echo e($item->fechafin); ?></td>
                                                    <td class="clickable"><?php echo e($item->estado); ?></td>
                                                    <td class="clickable"><?php echo e($item->motivo); ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn btn-sm btn-icon btn-danger"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Eliminar" data-original-title="Eliminar"
                                                                wire:click="$emit('eliminarPublicidadTotal',<?php echo e($item->id); ?>)">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.4"
                                                                            d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                                            fill="currentColor"></path>
                                                                        <path
                                                                            d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                                            fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.editar-publicidad', ['idpublicidad' => $item->id])->html();
} elseif ($_instance->childHasBeenRendered($item->id)) {
    $componentId = $_instance->getRenderedChildComponentId($item->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($item->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($item->id);
} else {
    $response = \Livewire\Livewire::mount('marketing.editar-publicidad', ['idpublicidad' => $item->id]);
    $html = $response->html();
    $_instance->logRenderedChild($item->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                        </div>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <div class="px-6 py-3">
                                        <?php echo e($tot->links()); ?>

                                    </div>

                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="detallePublicidadModal" tabindex="-1"
                                    aria-labelledby="detallePublicidadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detallePublicidadModalLabel">Detalles de
                                                    Publicidad</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="detallePublicidad">
                                                <!-- Aquí se mostrarán los detalles de la publicidad seleccionada -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    const detallesPublicidadModal = document.getElementById('detallePublicidadModal');
                                    const detallePublicidad = document.getElementById('detallePublicidad');


                                    const tdClickables = document.querySelectorAll('.clickable');
                                    tdClickables.forEach(td => {
                                        td.addEventListener('click', function() {

                                            const tr = this.parentElement;
                                            const id = tr.getAttribute('data-id');
                                            const nombrecampana = tr.getAttribute('data-nombrecampana');
                                            const sucursal = tr.getAttribute('data-sucursal');
                                            const nombrecuenta = tr.getAttribute('data-nombrecuenta');
                                            const fechainicio = tr.getAttribute('data-fechainicio');
                                            const fechafin = tr.getAttribute('data-fechafin');
                                            const estado = tr.getAttribute('data-estado');
                                            const motivo = tr.getAttribute('data-motivo');
                                            detallePublicidad.innerHTML = `

                                                <p>Nombre de Campaña: ${nombrecampana}</p>
                                                <p>Sucursal: ${sucursal}</p>
                                                <p>Nombre de Cuenta: ${nombrecuenta}</p>
                                                <p>Fecha de Inicio: ${fechainicio}</p>
                                                <p>Fecha de Fin: ${fechafin}</p>
                                                <p>Estado: ${estado}</p>
                                                <p>Comentario: ${motivo}</p>
                                            `;
                                            var modal = new bootstrap.Modal(detallesPublicidadModal);
                                            modal.show();
                                        });
                                    });
                                </script>




                            </div>
                        <?php endif; ?>
                        <?php if($botonRecepcion == 'campañas'): ?>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.mark-campanas')->html();
} elseif ($_instance->childHasBeenRendered('l572186674-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l572186674-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l572186674-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l572186674-5');
} else {
    $response = \Livewire\Livewire::mount('marketing.mark-campanas');
    $html = $response->html();
    $_instance->logRenderedChild('l572186674-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/marketing.blade.php ENDPATH**/ ?>