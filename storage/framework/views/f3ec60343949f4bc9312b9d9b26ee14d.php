<div class="mt-4 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-people me-2"></i> Copropietarios
                </h3>
                <span class="text-muted small">
                    Gestión de propietarios y departamentos
                </span>
            </div>

            <!-- BUSCADOR -->
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                <input type="text" class="form-control ps-10"
                    placeholder="Buscar por nombre, departamento o teléfono..." wire:model.debounce.500ms="busqueda"
                    style="min-width: 260px;">
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body pt-0">

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Teléfono</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <?php if($lista->estado == $actividad): ?>
                                <?php
                                    // 🔥 obtener ocupaciones del usuario
                                    $misDeptos = $ocupaciones->where('user_id', $lista->id);

                                    $cantidadDeptos = $misDeptos->count();
                                ?>

                                <tr>

                                    <!-- ID -->
                                    <td class="text-muted">
                                        #<?php echo e($lista->id); ?>

                                    </td>

                                    <!-- NOMBRE + EDAD -->
                                    <td class="fw-semibold">
                                        <i class="bi bi-person me-1 text-muted"></i>
                                        <?php echo e($lista->name); ?>


                                        <div class="text-muted small">
                                            Edad: <?php echo e($lista->edad ?? '-'); ?>

                                        </div>
                                    </td>

                                    <!-- DEPARTAMENTOS -->
                                    <td>

                                        <!-- CANTIDAD -->
                                        <span class="badge bg-primary mb-1">
                                            <?php echo e($cantidadDeptos); ?> Deptos
                                        </span>

                                        <!-- LISTADO -->
                                        <div class="small text-muted">

                                            <?php $__currentLoopData = $misDeptos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $depto = \App\Models\Tratamiento::find($d->tratamiento_id);
                                                ?>

                                                <div>
                                                    • <?php echo e($depto->nombre ?? '---'); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>

                                    </td>

                                    <!-- TEL -->
                                    <td>
                                        <i class="bi bi-telephone me-1 text-muted"></i>
                                        <?php echo e($lista->telefono ?? '-'); ?>

                                    </td>

                                    <!-- ACCIONES -->
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.editar-cliente', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('clientes.editar-cliente', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>

                                </tr>
                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay copropietarios registrados
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

</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/clientes/lista-clientes.blade.php ENDPATH**/ ?>