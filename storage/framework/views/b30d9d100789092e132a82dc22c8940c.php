<div>
    <label for="" class="btn btn-success" style="width: 100%;" wire:click="$set('crear',true)">Agregar copropietario</label>

    <div class="table-responsive">
        <label>Persona principal: <?php echo e($this->operativo->empresa); ?></label>
        <table class="table mb-0 table-striped text-nowrap">
            <thead>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Ci</th>
            </thead>
            <th>Acción</th>
            <tbody>
                <?php $__currentLoopData = $hospedados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hospedado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($hospedado->nombre); ?>

                        </td>
                        <td>
                            <?php echo e($hospedado->edad); ?>

                        </td>
                        <td>
                            <?php echo e($hospedado->identificacion); ?>

                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="preeliminar(<?php echo e($hospedado->id); ?>)">

                                    <span class="ms-1" style="font-size: 12px;  color:aliceblue;">ELIMINAR</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </tbody>
        </table>
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
                Nuevo copropietario
            </div>
            <div class="mt-4 text-gray-600 ml-4text-sm">
                <form>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="">Nombre:</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="name">
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Identificación:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="ci">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Edad:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="edad">
                        </div>
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
                ¿Desea eliminar esta persona?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarinformacion">Sí, eliminar</label>
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
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/operativos/lista-hospedados.blade.php ENDPATH**/ ?>