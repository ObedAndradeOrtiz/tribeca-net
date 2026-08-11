<div>

    <!-- BOTÓN -->
    <button class="btn btn-primary d-flex align-items-center gap-2"
        wire:click="$set('crear',true)">
        <i class="bi bi-plus-circle fs-5"></i>
        <span>Registrar departamento</span>
    </button>

    <!-- MODAL -->
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
        
        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-building-add me-2"></i>
                Nuevo departamento
            </h4>
            <span class="text-muted small">
                Complete la información del departamento
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control"
                        wire:model.defer="nombre"
                        placeholder="Ej: Departamento 101">
                </div>

                <!-- TIPO -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo</label>
                    <select wire:model.defer="tipo" class="form-select">
                        <option value="">Seleccione tipo</option>
                        <?php
                            $tipos = DB::table('tipohabitacions')->where('estado', 'Activo')->get();
                        ?>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->tipo); ?>"><?php echo e($item->tipo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control"
                        rows="3"
                        wire:model.defer="descripcion"
                        placeholder="Descripción del departamento..."></textarea>
                </div>

                <!-- COSTO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Costo mensual</label>
                    <input type="number" class="form-control"
                        wire:model.defer="costo"
                        placeholder="Bs 0.00">
                </div>

                <!-- CAPACIDAD -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Metros (m²)</label>
                    <input type="number" class="form-control"
                        wire:model.defer="capacidad"
                        placeholder="Ej: 80">
                </div>

                <!-- ÁREA -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Área</label>
                    <select wire:model.defer="area" class="form-select">
                        <option value="">Seleccione área</option>
                        <?php
                            $areas = DB::table('areas')->where('estado', 'Activo')->get();
                        ?>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- USUARIO -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Registrado por</label>
                    <input type="text" class="form-control bg-light"
                        value="<?php echo e(Auth::user()->name); ?>"
                        disabled>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light"
                wire:click="$set('crear',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2"
                wire:click="guardartodo"
                wire:loading.remove
                wire:target="guardartodo">
                
                <i class="bi bi-check-circle"></i>
                Guardar
            </button>

            <span wire:loading wire:target="guardartodo" class="text-muted">
                Guardando...
            </span>

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

</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tratamientos/crear-tratamiento.blade.php ENDPATH**/ ?>