<div class="px-4">
    <div class="card">
        <div class="card-body">
            <div class="header-title">
                <h4 class="card-title">Tipo de habitaciones</h4>
            </div>

            <div class="px-4 card-body">
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>Tipo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($lista->tipo); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-icon btn-danger"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                        data-original-title="Edit"
                                        wire:click="$emit('borrarTipoHabitacion',<?php echo e($lista->id); ?>)">
                                        <span class="" style="font-size: 12px;">ELIMINAR</span>
                                    </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipos.crear-tipo')->html();
} elseif ($_instance->childHasBeenRendered('l1913802253-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1913802253-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1913802253-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1913802253-0');
} else {
    $response = \Livewire\Livewire::mount('tipos.crear-tipo');
    $html = $response->html();
    $_instance->logRenderedChild('l1913802253-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/tipos/lista-tipo.blade.php ENDPATH**/ ?>