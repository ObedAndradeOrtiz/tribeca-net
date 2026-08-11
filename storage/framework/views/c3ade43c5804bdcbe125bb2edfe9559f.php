<div>
    <div class="d-flex">
        <a class="mr-2 btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="EDITAR USUARIO"
            data-original-title="Edit" wire:click="$set('openArea',true)">
            <span class="btn-inner">
                Editar
            </span>
        </a>
        <?php if($usuario->estado == 'Activo'): ?>
            <a class="mr-2 btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR USUARIO"
                data-original-title="Edit" wire:click="$emit('inactivarUser',<?php echo e($usuario->id); ?>)">
                <span class="btn-inner">
                    Eliminar
                </span>
            </a>
        <?php else: ?>
            <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                data-original-title="Edit" wire:click="$emit('activarUser',<?php echo e($usuario->id); ?>)">
                <span class="btn-inner">
                    Reactivar
                </span>
            </a>
        <?php endif; ?>
        <a class="mr-2 btn btn-sm btn-icon btn-primary d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="INFORMACIÓN DE USUARIOS" data-original-title="INFORMACIÓN DE USUARIOS"
            wire:click="$set('openuser',true)">

            Información
            <span class="ms-1" style="font-size: 8px;"></span>
        </a>
    </div>


    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Editar usuario <?php echo e($usuario->name); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de usuario</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="usuario.name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Telefono:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="usuario.telefono">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="">Email:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="usuario.email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Rol de usuario: </label>

                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="usuario.rol">
                            <option>Seleccionar rol</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($rol->rol); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de ingreso:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model="usuario.fechainicio">
                    </div>
                    <div class="form-group">

                        <label class="form-label" for="">Hora de inicio de turno:</label>
                        <input type="time" class="form-control" id="hora" name="hora"
                            wire:model.defer="usuario.horainicio">

                    </div>
                    <div class="form-group">

                        <label class="form-label" for="">Hora de fin de turno:</label>
                        <input type="time" class="form-control" id="hora" name="hora"
                            wire:model.defer="usuario.horafin">

                    </div>


                </form>
            </div>
            <div>
                
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo">Guardar</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openuser']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openuser']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                InformacióN de usuario <?php echo e($usuario->name); ?>

            </div>
            <div class="text-lg font-medium text-gray-900">
                Horario de trabajo: <?php echo e($usuario->horainicio . ' - ' . $usuario->horafin); ?>

            </div>
            <div class="text-lg font-medium text-gray-900">
                Número de usuario: <?php echo e($usuario->telefono); ?>

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
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/users/editar-user.blade.php ENDPATH**/ ?>