<div>
    <div>
        <button class="ml-4 mr-4 btn btn-primary" wire:click="$set('crearcuenta',true)" wire:click.prevent.stop><span
                style="color: white;">REGISTRAR CAMPAÑA</span></button>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'crearcuenta','wire:click.prevent.stop' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'crearcuenta','wire:click.prevent.stop' => true]); ?>
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900">
                    NUEVA CAMPAÑA
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="">NOMBRE DE CAMPAÑA</label>
                            <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                                wire:model.defer="name">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="">COMENTARIO</label>
                            <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                                wire:model.defer="comentario">
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

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/crear-campana.blade.php ENDPATH**/ ?>