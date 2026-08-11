<div>

    <!-- BOTONES -->
    <div class="d-flex gap-2">

        <!-- EDITAR -->
        <button class="btn btn-sm btn-light-primary d-flex align-items-center gap-1"
            wire:click="$set('editar',true)">
            <i class="bi bi-pencil-square"></i>
            Editar
        </button>

        <!-- ELIMINAR -->
        <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
            wire:click="inactivarTratamiento">
            <i class="bi bi-trash"></i>
            Eliminar
        </button>

    </div>

    <!-- MODAL -->
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

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Editar departamento
            </h4>
            <span class="text-muted small">
                Modifique la información del departamento
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text"
                        class="form-control"
                        wire:model.defer="tratamiento.nombre">
                </div>

                <!-- TIPO -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo</label>
                    <select wire:model.defer="tratamiento.TIPO" class="form-select">
                        <option value="">Seleccione</option>
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
                        wire:model.defer="tratamiento.descripcion"></textarea>
                </div>

                <!-- COSTO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Costo mensual</label>
                    <input type="number"
                        class="form-control"
                        wire:model.defer="tratamiento.costo">
                </div>

                <!-- CAPACIDAD -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Metros (m²)</label>
                    <input type="number"
                        class="form-control"
                        wire:model.defer="tratamiento.capacidad">
                </div>

                <!-- ÁREA -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Área</label>
                    <select wire:model.defer="tratamiento.sucursal" class="form-select">
                        <option value="">Seleccione</option>
                        <?php
                            $areas = DB::table('areas')->where('estado', 'Activo')->get();
                        ?>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light"
                wire:click="$set('editar',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2"
                wire:click="guardartodo"
                wire:loading.remove
                wire:target="guardartodo">

                <i class="bi bi-check-circle"></i>
                Guardar cambios
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

</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tratamientos/vista-tratamiento.blade.php ENDPATH**/ ?>