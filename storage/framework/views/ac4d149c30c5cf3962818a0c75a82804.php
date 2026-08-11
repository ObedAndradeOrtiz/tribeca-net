<div>
    <button class="ml-4 btn btn-primary" wire:click="$set('crear',true)"><span style="color: white; font-size: 24px;">Crear producto
        </span></button>
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
            <div class="py-2 text-lg font-medium text-gray-900">
                Registrar nuevo producto
            </div>
            <div class="mt-2 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de producto:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="nombre">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Descripcion:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="descripcion">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Cantidad:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="cantidad">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Precio (Bs.):</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1" wire:model.defer="precio">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Sucursal perteneciente:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="sucursal">
                            <option>Seleccionar sucursal</option>
                            <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($empresa->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Imagen del producto:</label>
                        <input class="form-control" type="file" wire:model.defer="image">
                    </div>

                    <?php if($image): ?>
                        <?php if($image->getClientOriginalExtension() === 'jpg' || $image->getClientOriginalExtension() === 'png'): ?>
                            <img class="mt-4" src="<?php echo e($image->temporaryUrl()); ?>" alt="">
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="<?php echo e(Auth::user()->name); ?>">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo" wire:loading.remove
                wire:target="guardartodo" style="background-color:green;">Registrar</label>
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
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/inventario/crear-producto.blade.php ENDPATH**/ ?>