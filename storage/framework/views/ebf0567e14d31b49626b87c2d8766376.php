<div>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            PANEL DE PAGOS: <?php echo e($operativo->empresa); ?>

        </div>
        <div>
            <div>
                <button class="btn btn-danger" onclick="window.history.back();">Volver atrás</button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">HABITACION(ES):</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <th>HABITACION</th>
                                        <th>DIAS</th>
                                        <th>COSTO</th>
                                        <th>TOTAL</th>

                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <label for=""><?php echo e($lista->nombretratamiento); ?></label>
                                                </td>
                                                <td>
                                                    <?php
                                                        $fecha_dada = new DateTime($lista->fecha);

                                                        // Fecha actual
                                                        $fecha_hoy = new DateTime();

                                                        // Calcular la diferencia
                                                        $diferencia = $fecha_hoy->diff($fecha_dada);
                                                    ?>
                                                    <?php echo e($diferencia->days); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($lista->costo); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($lista->costo * $diferencia->days); ?>

                                                    (.Bs)
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $operativo->id])->html();
} elseif ($_instance->childHasBeenRendered('l2899046476-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2899046476-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2899046476-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2899046476-0');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l2899046476-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-6">
                    <div class="card-header">
                        <h3 class="card-title">COBRANZA:</h3>
                        <div class="card-options">
                            <label for="" class="btn btn-success" wire:click="guardaroperativo">GUARDAR</label>
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
                <div class="card col-md-6">
                    <div class="card-header">
                        <h3 class="card-title">LISTA DE PAGOS:</h3>
                        <div class="card-options">
                            <a class="mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                data-original-title="Edit" wire:click="$set('crear',true)">

                                <span class="ms-1" style="font-size: 12px; color:aliceblue;">CREAR
                                    PAGO</span>
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
} elseif ($_instance->childHasBeenRendered('l2899046476-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2899046476-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2899046476-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2899046476-1');
} else {
    $response = \Livewire\Livewire::mount('pagos.lista-pagos', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l2899046476-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>

            </div>


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
                Confirmación de imnpresión
            </div>
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
                ¿Desea eliminar esta habitación?
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
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/operativos/pagos-cliente.blade.php ENDPATH**/ ?>