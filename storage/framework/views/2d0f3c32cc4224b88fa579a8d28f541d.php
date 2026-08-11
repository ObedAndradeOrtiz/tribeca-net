<div>
    <button class="ml-4 btn btn-primary d-flex" wire:click="$set('crear',true)">
        <span class="mr-2" style="color: white; font-size: 15px;">NUEVO NÚMERO</span>
        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M14.4183 5.49C13.9422 5.40206 13.505 5.70586 13.4144 6.17054C13.3238 6.63522 13.6285 7.08891 14.0916 7.17984C15.4859 7.45166 16.5624 8.53092 16.8353 9.92995V9.93095C16.913 10.3337 17.2675 10.6265 17.6759 10.6265C17.7306 10.6265 17.7854 10.6215 17.8412 10.6115C18.3043 10.5186 18.609 10.0659 18.5184 9.60018C18.1111 7.51062 16.5027 5.89672 14.4183 5.49Z"
                fill="currentColor"></path>
            <path
                d="M14.3558 2.00793C14.1328 1.97595 13.9087 2.04191 13.7304 2.18381C13.5472 2.32771 13.4326 2.53557 13.4078 2.76841C13.355 3.23908 13.6946 3.66479 14.1646 3.71776C17.4063 4.07951 19.9259 6.60477 20.2904 9.85654C20.3392 10.2922 20.7047 10.621 21.1409 10.621C21.1738 10.621 21.2057 10.619 21.2385 10.615C21.4666 10.59 21.6698 10.4771 21.8132 10.2972C21.9556 10.1174 22.0203 9.89351 21.9944 9.66467C21.5403 5.60746 18.4002 2.45862 14.3558 2.00793Z"
                fill="currentColor"></path>
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.0317 12.9724C15.0208 16.9604 15.9258 12.3467 18.4656 14.8848C20.9143 17.3328 22.3216 17.8232 19.2192 20.9247C18.8306 21.237 16.3616 24.9943 7.6846 16.3197C-0.993478 7.644 2.76158 5.17244 3.07397 4.78395C6.18387 1.67385 6.66586 3.08938 9.11449 5.53733C11.6544 8.0765 7.04266 8.98441 11.0317 12.9724Z"
                fill="currentColor"></path>
        </svg> </button>
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
        <div class="px-6 py-2">
            <div class="text-lg font-medium text-gray-900">
                REGISTRAR NUEVA LLAMADA
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>

                    <div class="mt-2 form-group col-md-12">

                        <label class="form-label" for="cname">Seleccionar Sucursal:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="areaseleccionada">
                            <option>Seleccionar area</option>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($area->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php $__errorArgs = ['areaseleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No selecciono ningun area</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group col-md-12">

                        <label class="form-label" for="cname">Selecciona medio de ingreso:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="modo">
                            <option value="">Seleccione medio</option>
                            <option value="Facebook">Facebook</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Google">Google Maps</option>
                            <option value="Otro">Otro</option>


                        </select>
                    </div>
                    <?php $__errorArgs = ['modo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick"> No selecciono medio</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group">

                        <label class="form-label" for="">Nombre de Cliente:</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="empresa">
                    </div>
                    <?php $__errorArgs = ['empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Nombre requerido</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">Carnet de identidad:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="ci">
                    </div>
                    <div class="mt-2 form-group">

                        <label class="form-label" for="">Telefono principal:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="telefono">
                    </div>
                    <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Telefono requerido</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de llamada:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model.defer="fecha">
                    </div>
                    <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Fecha requerida</label>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mt-2 form-group">

                        <label class="form-label" for="">Agrear comentario (opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="comentario">
                    </div>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="<?php echo e(Auth::user()->name); ?>">
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/calls-center/crear-call.blade.php ENDPATH**/ ?>