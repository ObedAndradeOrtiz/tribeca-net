<div>
    <a class="mt-1 mr-1 btn btn-sm btn-icon d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top"
        title="AGREGAR HOSPEDADO" data-original-title="Edit" wire:click="$set('crear',true)"
        style="background-color: rgb(0, 255, 34);">

        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z"
                fill="currentColor"></path>
        </svg>

    </a>
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
                NUEVO HOSPEDADO
            </div>
            <div class="mt-4 text-gray-600 ml-4text-sm">
                <form>
                    <div class=" form-group">
                        <label class="form-label" for="">Nombre:</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="name">
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Teléfono:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="telefono">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">CI:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="ci">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Edad:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="edad">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label" for="">Sexo:</label>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="sexo">
                                <option value='femenino'>Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label" for="">Ocupación:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="ocupacion">
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
</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/operativos/crear-hospedado.blade.php ENDPATH**/ ?>