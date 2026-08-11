<div>

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-box-seam me-2"></i> Gestión de Inmuebles
                </h3>
                <span class="text-muted small">
                    Control de activos, bienes y equipamiento
                </span>
            </div>

            <!-- BUSCADOR + BOTÓN -->
            <div class="d-flex align-items-center gap-2">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        wire:model.debounce.500ms="busqueda"
                        placeholder="Buscar inmueble...">
                </div>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.crear-inmuebles')->html();
} elseif ($_instance->childHasBeenRendered('l313004150-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l313004150-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l313004150-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l313004150-0');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.crear-inmuebles');
    $html = $response->html();
    $_instance->logRenderedChild('l313004150-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            </div>

        </div>

        <!-- 🔥 FILTRO -->
        <div class="card-body pt-0">

            <div class="row mb-4">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Área común</label>
                    <select wire:model="sucursal" class="form-select">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

            </div>

            <!-- 🔥 TABLA -->
            <div class="table-responsive" wire:loading.lazy>

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Área común</th>
                            <th>Área uso</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $productoslist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                <!-- AREA -->
                                <td class="fw-semibold">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    <?php echo e($lista->sucursal); ?>

                                </td>

                                <!-- AREA USO -->
                                <td><?php echo e($lista->area); ?></td>

                                <!-- TIPO -->
                                <td>
                                    <span class="badge bg-light-primary text-dark">
                                        <?php echo e($lista->tipo); ?>

                                    </span>
                                </td>

                                <!-- NOMBRE -->
                                <td class="fw-semibold">
                                    <?php echo e($lista->nombre); ?>

                                </td>

                                <!-- DETALLE -->
                                <td style="max-width:200px;" class="text-truncate">
                                    <?php echo e($lista->descripcion); ?>

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

                                <!-- CANTIDAD -->
                                <td>
                                    <span class="badge bg-light-dark">
                                        <?php echo e($lista->cantidad); ?>

                                    </span>
                                </td>

                                <!-- PRECIO -->
                                <td class="fw-bold text-success">
                                    Bs <?php echo e(number_format($lista->precio,2)); ?>

                                </td>

                                <!-- FECHA -->
                                <td>
                                    <?php echo e(\Carbon\Carbon::parse($lista->fecha)->format('d/m/Y')); ?>

                                </td>

                                <!-- ACCIONES -->
                                <td class="text-end">
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.editar-inmuebles', ['producto' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('inmuebles.editar-inmuebles', ['producto' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay inmuebles registrados
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- 🔥 PAGINACIÓN -->
            <div class="mt-4 d-flex justify-content-end">
                <?php echo e($productoslist->links()); ?>

            </div>

        </div>

    </div>

</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/inmuebles/lista-inmuebles.blade.php ENDPATH**/ ?>