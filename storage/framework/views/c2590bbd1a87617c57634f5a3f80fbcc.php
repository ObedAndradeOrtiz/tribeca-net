<div>

    <div class="card">
        <div class="card-header">
            <h3>INFORMACION DEL CLIENTE: <?php echo e($operativo->empresa); ?></h3>
            <br>

            <div class="card-options">
                <label for="" class="btn btn-success" wire:click="$set('crear',true)">AGREGAR
                    INFORMACION</label>
                <label for="" class="ml-2 btn btn-warning" wire:click="imprimir">IMPRIMIR</label>
            </div>
        </div>
        <div class="card-body">
            <h3>TELEFONO: <?php echo e($operativo->telefono); ?></h3>
            <div class="table-responsive">
                <table class="table mb-0 table-striped text-nowrap">
                    <thead>
                        <th>INFORMACION</th>
                        <th>FECHA</th>

                        <th>ACCION</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $misfichas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($ficha->descripcion); ?>

                                </td>
                                <td>
                                    <?php echo e($ficha->fecha); ?>

                                </td>

                                <td>
                                    <div class="d-flex">
                                        <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                            data-original-title="Edit" wire:click="preeliminar(<?php echo e($ficha->id); ?>)">

                                            <span class="ms-1"
                                                style="font-size: 12px;  color:aliceblue;">ELIMINAR</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA INFORMACION
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">INFORMACION:</label>
                        <textarea rows="4" style="width: 100%" wire:model="tratamiento"></textarea>

                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="guardartodo">Guardar</button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'eliminar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'eliminar']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar esta informacion?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarinformacion">Si eliminar</label>
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
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/operativos/informacion-cliente.blade.php ENDPATH**/ ?>