<div class="mt-4 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-person-badge me-2"></i> Gestión de Personal
                </h3>
                <span class="text-muted small">
                    Administración de usuarios, roles y estados
                </span>
            </div>

            <!-- FILTROS -->
            <div class="d-flex align-items-center gap-3">

                <!-- ESTADO -->
                <div>
                    <label class="form-label fw-semibold mb-1">Estado</label>
                    <select wire:model="estadoUser" class="form-select form-select-sm">
                        <option value="todos">Todos</option>
                        <option value="Activo">Activos</option>
                        <option value="Inactivo">Inactivos</option>
                    </select>
                </div>

                <!-- ROL -->
                <div>
                    <label class="form-label fw-semibold mb-1">Cargo</label>
                    <select wire:model="rolseleccionado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->rol); ?>"><?php echo e($item->rol); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="card-body pt-0">

            <!-- 🔥 BUSCADOR + BOTÓN -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        placeholder="Buscar personal..."
                        wire:model.debounce.500ms="busqueda"
                        style="min-width: 260px;">
                </div>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.crear-user')->html();
} elseif ($_instance->childHasBeenRendered('l2618611975-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2618611975-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2618611975-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2618611975-0');
} else {
    $response = \Livewire\Livewire::mount('users.crear-user');
    $html = $response->html();
    $_instance->logRenderedChild('l2618611975-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            </div>

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <!-- NOMBRE + ROL -->
                                <td>
                                    <div class="fw-semibold">
                                        <i class="bi bi-person me-1 text-muted"></i>
                                        <?php echo e($lista->name); ?>

                                    </div>
                                    <div class="text-muted small">
                                        <?php echo e($lista->rol); ?>

                                    </div>
                                </td>

                                <!-- TEL -->
                                <td><?php echo e($lista->telefono); ?></td>

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

                                <!-- ACCIONES -->
                                <td>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.editar-user', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('users.editar-user', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay personal registrado
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- 🔥 PAGINACIÓN -->
            <div class="mt-4 d-flex justify-content-end">
                <?php echo e($users->links()); ?>

            </div>

        </div>

    </div>

</div><?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/users/lista-user.blade.php ENDPATH**/ ?>