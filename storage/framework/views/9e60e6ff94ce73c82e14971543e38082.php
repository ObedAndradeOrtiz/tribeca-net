<div>
    <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">
        
    </div>
    <div class="flex flex-row justify-between">
        <h3 class="ml-4" style="font-size: 18px;"><strong>LISTA DE PUBLICIDADES</strong> </h3>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.crear-publicidad')->html();
} elseif ($_instance->childHasBeenRendered('l1622829776-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1622829776-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1622829776-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1622829776-0');
} else {
    $response = \Livewire\Livewire::mount('marketing.crear-publicidad');
    $html = $response->html();
    $_instance->logRenderedChild('l1622829776-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
                    <tr data-id="<?php echo e($item->id); ?>" data-nombrecampana="<?php echo e($item->nombrecampana); ?>"
                        data-sucursal="<?php echo e($item->sucursal); ?>" data-nombrecuenta="<?php echo e($item->nombrecuenta); ?>"
                        data-fechainicio="<?php echo e($item->fechainicio); ?>" data-fechafin="<?php echo e($item->fechafin); ?>"
                        data-estado="<?php echo e($item->estado); ?>" data-motivo="<?php echo e($item->motivo); ?>">

                        <td class="clickable"><?php echo e($item->nombrecampana); ?></td>
                        <td class="clickable"><?php echo e($item->sucursal); ?></td>
                        <td class="clickable"><?php echo e($item->nombrecuenta); ?></td>
                        <td class="clickable"><?php echo e($item->fechainicio); ?></td>
                        <td class="clickable"><?php echo e($item->fechafin); ?></td>
                        <td class="clickable"><?php echo e($item->estado); ?></td>
                        <td class="clickable"><?php echo e($item->motivo); ?></td>
                        <td>
                            <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Eliminar" data-original-title="Eliminar"
                                wire:click="$emit('eliminarPublicidadTotal',<?php echo e($item->id); ?>)">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
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
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="detallePublicidadModal" tabindex="-1" aria-labelledby="detallePublicidadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallePublicidadModalLabel">Detalles de Publicidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/mark-publicidades.blade.php ENDPATH**/ ?>