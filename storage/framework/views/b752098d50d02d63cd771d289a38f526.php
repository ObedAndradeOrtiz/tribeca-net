<div class="px-4">

    <div class="card shadow-sm">

        <!-- 🔥 HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-diagram-3 me-2"></i> Tipos de departamentos
                </h3>
                <span class="text-muted small">
                    Gestión de categorías de departamentos
                </span>
            </div>

            <!-- BOTÓN CREAR -->
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipos.crear-tipo')->html();
} elseif ($_instance->childHasBeenRendered('l689293125-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l689293125-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l689293125-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l689293125-0');
} else {
    $response = \Livewire\Livewire::mount('tipos.crear-tipo');
    $html = $response->html();
    $_instance->logRenderedChild('l689293125-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

        </div>

        <!-- 🔥 BODY -->
        <div class="card-body pt-0">

            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Tipo</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                <!-- TIPO -->
                                <td class="fw-semibold">
                                    <i class="bi bi-tag me-1 text-muted"></i>
                                    <?php echo e($lista->tipo); ?>

                                </td>

                                <!-- ACCIÓN -->
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
                                        wire:click="$emit('borrarTipoHabitacion',<?php echo e($lista->id); ?>)">
                                        <i class="bi bi-trash"></i>
                                        Eliminar
                                    </button>
                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay tipos registrados
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div><?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/livewire/tipos/lista-tipo.blade.php ENDPATH**/ ?>