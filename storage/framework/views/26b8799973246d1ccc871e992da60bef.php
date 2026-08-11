<div class="px-4 py-5 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-building me-2"></i> Gestión de Áreas Comunes
                </h3>
                <span class="text-muted small">
                    Administración de áreas, responsables y estados
                </span>
            </div>

            <!-- BUSCADOR + BOTÓN -->
            <div class="d-flex align-items-center gap-2">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        wire:model.debounce.500ms="busqueda"
                        placeholder="Buscar área...">
                </div>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.crear-area')->html();
} elseif ($_instance->childHasBeenRendered('l2306629481-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2306629481-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2306629481-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2306629481-0');
} else {
    $response = \Livewire\Livewire::mount('area.crear-area');
    $html = $response->html();
    $_instance->logRenderedChild('l2306629481-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            </div>

        </div>

        <!-- 🔥 TABS -->
        <div class="card-body pt-0">

            <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 
                        <?php echo e($actividad === 'Activo' ? 'active' : ''); ?>"
                        wire:click="$set('actividad','Activo')">

                        <i class="bi bi-check-circle"></i>
                        Activos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 
                        <?php echo e($actividad === 'Inactivo' ? 'active' : ''); ?>"
                        wire:click="$set('actividad','Inactivo')">

                        <i class="bi bi-x-circle"></i>
                        Inactivos
                    </a>
                </li>

            </ul>

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Área común</th>
                            <th>Teléfono</th>
                            <th>#Ticket</th>
                            <th>Estado</th>
                            <th>Creador</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                <!-- AREA -->
                                <td class="fw-semibold">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    <?php echo e($lista->area); ?>

                                </td>

                                <!-- TEL -->
                                <td><?php echo e($lista->telefono); ?></td>

                                <!-- TICKET -->
                                <td>
                                    <span class="badge bg-light-dark">
                                        <?php echo e($lista->ticket); ?>

                                    </span>
                                </td>

                                <!-- ESTADO -->
                                <td>
                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'badge',
                                        'bg-success' => $lista->estado == 'Activo',
                                        'bg-danger' => $lista->estado != 'Activo',
                                    ]); ?>">
                                        <?php echo e($lista->estado); ?>

                                    </span>
                                </td>

                                <!-- RESPONSABLE -->
                                <td><?php echo e($lista->responsable); ?></td>

                                <!-- ACCIONES -->
                                <td>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.editar-area', ['area' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('area.editar-area', ['area' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay áreas registradas
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div><?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/area/list-area.blade.php ENDPATH**/ ?>