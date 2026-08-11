<div>
    <button class="ml-4 btn btn-primary" wire:click="$set('crear',true)"><span
            style="color: white; font-size: 24px;">Nuevo</span></button>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'crear']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'crear']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Registrar usuario
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label" for="">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                                wire:model.defer="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="">Rol de usuario: </label>

                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="rol">
                            <option>Seleccionar rol</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($rol->rol); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="form-label" for="exampleInputdate">Fecha de ingreso:</label>
                            <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                                wire:model="fechainicio">
                        </div>
                        <div class="form-group col-md-4">

                            <label class="form-label " for="">Hora de inicio de turno:</label>
                            <input type="time" class="form-control" id="hora" name="hora"
                                wire:model.defer="horainicio">

                        </div>
                        <div class="form-group col-md-4">

                            <label class="form-label" for="">Hora de fin de turno:</label>
                            <input type="time" class="form-control" id="hora" name="hora"
                                wire:model.defer="horafin">

                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-12">

                            <label class="form-label" for="">Telefono:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="telefono">
                        </div>

                    </div>
                    <div class="form-group">

                        <label class="form-label" for="">Email:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="email">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="">Contraseña:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="password">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="">Confirmar contraseña:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="password2">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo" wire:loading.remove
                wire:target="guardartodo">Crear</label>
            <span class="" wire:loading wire:target="guardartodo">Guardando...</span>
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
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/users/crear-user.blade.php ENDPATH**/ ?>