<div>
    <div>
        <a class="mr-2 btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
            data-original-title="Edit" wire:click="$set('editar',true)">
            <span class="btn-inner">
                
                EDITAR
            </span>
        </a>
        <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
            data-original-title="Edit" wire:click="inactivarTratamiento">
            <span class="btn-inner">
                
                ELIMINAR
            </span>
        </a>

        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'editar']); ?>
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900">
                    Editar habitación
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <form>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="">Nombre de tratamiento</label>
                                <input type="text" class="form-control" id="exampleInputDisabled1"
                                    wire:model.defer="tratamiento.nombre">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="">Tipo de departamento:</label>
                                <div>
                                    <select name="" id="" wire:model.defer="tratamiento.TIPO" style="width: 100%;">
                                        <?php
                                            $tipos = DB::table('tipohabitacions')->where('estado', 'Activo') -> get();
                                        ?>
                                         <option value="">Seleccione</option>
                                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->tipo); ?>"><?php echo e($item->tipo); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="">Descripcion:</label>
                            <input style="width: 100%;" type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="tratamiento.descripcion">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="form-label" for="">Costo:</label>
                                <input type="text" class="form-control" id="exampleInputDisabled1"
                                    wire:model.defer="tratamiento.costo">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="">Capacidad recomendada:</label>
                                <input type="text" class="form-control" id="exampleInputDisabled1"
                                    wire:model.defer="tratamiento.capacidad">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="">Area:</label>
                                <div>
                                    <select name="" id="" wire:model.defer="tratamiento.sucursal" style="width: 100%;">
                                        <?php
                                            $tipos = DB::table('areas')->where('estado', 'Activo') -> get();
                                        ?>
                                        <option value="">Seleccione</option>
                                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                    </form>
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
    </div>

</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/tratamientos/vista-tratamiento.blade.php ENDPATH**/ ?>