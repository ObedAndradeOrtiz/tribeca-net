<div>

    <button class="mb-2 mr-4 btn btn-primary justify-content-end" wire:click="$set('creartarjeta',true)"
        wire:click.prevent.stop><span style="color: white;">NUEVA TARJETA</span></button>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'creartarjeta','wire:click.prevent.stop' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'creartarjeta','wire:click.prevent.stop' => true]); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA TARJETA
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">NOMBRE DE TARJETA</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="name">
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No coloco nombre</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-group">
                        <label class="form-label" for="">NUMERO DE TARJETA</label>
                        <input type="number" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="numero">
                    </div>
                    <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No se coloco numero</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">DUEÑO DE TARJETA:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="elegido">
                            <option value="">Seleccionar operario</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php $__errorArgs = ['elegido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No selecciono ningun dueño</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-group">
                        <label class="form-label" for="">SALDO INCIAL</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="saldo">
                    </div>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">BANCO:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="banco">
                            <option value="" disabled selected>Selecciona un banco</option>
                            <option value="BMSC">(BMSC) Banco Mercantil Santa Cruz</option>
                            <option value="BCB">(BCB) Banco de Crédito de Bolivia</option>
                            <option value="BU">(BU) Banco Unión</option>
                            <option value="BNB">(BNB) Banco Nacional de Bolivia</option>
                            <option value="BG">(BG) Banco Ganadero</option>
                            <option value="BCP">(BCP) Banco Central del Peru</option>
                            <option value="BEC">(BEC) Banco Economico</option>
                            <option value="BS">(BS) Banco Sol</option>
                            <option value="BVS">(BVS) Banco Visa</option>
                        </select>

                    </div>
                    <?php $__errorArgs = ['banco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No selecciono ningun banco</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/crear-tarjeta.blade.php ENDPATH**/ ?>