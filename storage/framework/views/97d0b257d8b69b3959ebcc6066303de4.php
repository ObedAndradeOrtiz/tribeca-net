<div>

    <div class="px-6 py-4">

        <div class="text-lg font-medium text-gray-900">
            PANEL DE PAGOS: <?php echo e($operativo->empresa); ?>

        </div>
        <div>
            <button class="btn btn-danger" onclick="window.history.back();">Volver atras</button>
        </div>
        <div class="mt-4 text-sm text-gray-600">
            <form>
                <div class="form-group" style="margin-bottom: 35px;">

                    <div class="d-flex">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">HABITACION(ES):</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped text-nowrap">
                                        <thead>

                                            <th>HABITACION</th>
                                            <th>COSTO</th>
                                            <th>ACCION</th>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <label for=""><?php echo e($lista->nombretratamiento); ?></label>
                                                    </td>
                                                    <td>
                                                        (<?php echo e($lista->costo); ?>.Bs)
                                                    </td>
                                                    <td class="d-flex">
                                                        <button class="mr-1 btn btn-primary">Limpieza</button>
                                                        <button class="mr-1 btn btn-info">Mantenimiento</button>
                                                        <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="ELIMINAR" data-original-title="Edit"
                                                            wire:click="eliminarVista(<?php echo e($lista->id); ?>)">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.4"
                                                                    d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                                    fill="currentColor"></path>
                                                                <path
                                                                    d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                            <span style="color: white;">Eliminar</span>

                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">COBRANZA:</h3>
                                <div class="card-options">
                                    <label for="" class="btn btn-success"
                                        wire:click="guardaroperativo">GUARDAR</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped text-nowrap">
                                        <thead>
                                            <th>TOTAL A COBRAR</th>
                                            <th>TOTAL CANCELADO</th>
                                            <th>PENDIENTE</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        value=" <?php echo e($pagotratamientostotal); ?>"
                                                        wire:model="pagotratamientostotal">

                                                </td>
                                                <td>

                                                    <?php echo e($this->totalpagado); ?>

                                                </td>

                                                <td>
                                                    <?php echo e($this->deuda); ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">LISTA DE PAGOS:</h3>
                            <div class="card-options">
                                <a class="mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('crear',true)">

                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">CREAR PAGO</span>
                                </a>

                                <a class="mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('confirmarimprimir',true)">

                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">IMPRIMIR</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pagos.lista-pagos', ['idoperativo' => $operativo->id])->html();
} elseif ($_instance->childHasBeenRendered('l3596784518-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3596784518-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3596784518-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3596784518-0');
} else {
    $response = \Livewire\Livewire::mount('pagos.lista-pagos', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l3596784518-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </div>
                    </div>
            </form>
        </div>

    </div>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'confirmarimprimir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmarimprimir']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                SELECCIONAR COSMETOLOGA ENCARGADA:
            </div>
        </div>
        <div class="mt-2 form-group">
            <label class="form-label" for="">COSMETOLOGA:</label>
            <select name="type" class="selectpicker form-control" data-style="py-0" wire:model.defer="elegido">
                <option value="">Seleccionar operario</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="imprimir">Imprimir</button>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'eliminart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'eliminart']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar este tratamiento?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarTratamiento">Si eliminar</label>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'crear']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'crear']); ?>
        <div>
            <div class="form-group">
                <label class="form-label" for="">MONTO A PAGAR:</label>
                <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="cantidadpago">
            </div>
            <div class="form-group">
                <label for="form-label">SELECCIONE METODO DE PAGO</label>
                <select name="" id="" wire:model="mododepago">
                    <option value="Efectivo">
                        Efectivo
                    </option>
                    <option value="Qr">Qr</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                    value="<?php echo e(Auth::user()->name); ?>">
            </div>
            <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
                <button type="submit" style="background-color: green;" class="btn btn-success"
                    wire:click="guardartodo">Guardar</button>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>


</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/operativos/pagos-cliente.blade.php ENDPATH**/ ?>