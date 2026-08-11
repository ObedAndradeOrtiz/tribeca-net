<div class="d-flex gap-2 flex-wrap">

    <!-- ✏️ EDITAR -->
    <button class="btn btn-sm btn-light-primary d-flex align-items-center gap-1" wire:click="$set('openArea',true)">
        <i class="bi bi-pencil-square"></i>
        Editar
    </button>

    <!-- 🔴 ELIMINAR / 🟢 ACTIVAR -->
    <?php if($usuario->estado == 'Activo'): ?>
        <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
            wire:click="$emit('inactivarUser',<?php echo e($usuario->id); ?>)">
            <i class="bi bi-trash"></i>
            Desactivar
        </button>
    <?php else: ?>
        <button class="btn btn-sm btn-light-success d-flex align-items-center gap-1"
            wire:click="$emit('activarUser',<?php echo e($usuario->id); ?>)">
            <i class="bi bi-check-circle"></i>
            Activar
        </button>
    <?php endif; ?>

    <!-- ℹ️ INFO -->
    <button class="btn btn-sm btn-light-info d-flex align-items-center gap-1" wire:click="$set('openuser',true)">
        <i class="bi bi-info-circle"></i>
        Información
    </button>

    <!-- ================= MODAL EDITAR ================= -->
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

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Editar usuario
            </h4>
            <span class="text-muted small">
                <?php echo e($usuario->name); ?>

            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" wire:model.defer="usuario.name">
                </div>

                <!-- TEL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" wire:model.defer="usuario.telefono">
                </div>

                <!-- EMAIL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" wire:model.defer="usuario.email">
                </div>

                <!-- ROL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rol</label>
                    <select class="form-select" wire:model.defer="usuario.rol">
                        <option value="">Seleccionar rol</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option><?php echo e($rol->rol); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- FECHA -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fecha ingreso</label>
                    <input type="date" class="form-control" wire:model="usuario.fechainicio">
                </div>

                <!-- HORARIOS -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hora inicio</label>
                    <input type="time" class="form-control" wire:model.defer="usuario.horainicio">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hora fin</label>
                    <input type="time" class="form-control" wire:model.defer="usuario.horafin">
                </div>
                <div class="form-group">
                    <label class="form-label" for="">Foto de perfil:</label>
                    <input class="form-control" type="file" wire:model="image">
                    <img class="mt-4" src="<?php echo e(asset('storage/' . $usuario->path)); ?>" alt="">
                    <?php if($image): ?>
                        <?php if($image->getClientOriginalExtension() === 'jpg' || $image->getClientOriginalExtension() === 'png'): ?>
                            <img class="mt-4" src="<?php echo e($image->temporaryUrl()); ?>" alt=""
                                style="max-height: 250px;">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light" wire:click="$set('openArea',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2" wire:click="guardartodo">

                <i class="bi bi-check-circle"></i>
                Guardar cambios
            </button>

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

    <!-- ================= MODAL INFORMACIÓN ================= -->
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

        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-lines-fill me-2"></i>
                Información del usuario
            </h4>
            <span class="text-muted small">
                <?php echo e($usuario->name); ?>

            </span>
        </div>

        <div class="px-6 py-4">

            <div class="mb-3">
                <span class="fw-semibold text-muted">Horario:</span>
                <div class="fw-bold">
                    <?php echo e($usuario->horainicio); ?> - <?php echo e($usuario->horafin); ?>

                </div>
            </div>

            <div class="mb-3">
                <span class="fw-semibold text-muted">Teléfono:</span>
                <div class="fw-bold">
                    <?php echo e($usuario->telefono); ?>

                </div>
            </div>

            <div class="mb-3">
                <span class="fw-semibold text-muted">Email:</span>
                <div class="fw-bold">
                    <?php echo e($usuario->email); ?>

                </div>
            </div>

        </div>

        <div class="px-6 py-4 border-top text-end">
            <button class="btn btn-light" wire:click="$set('openuser',false)">
                Cerrar
            </button>
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
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/users/editar-user.blade.php ENDPATH**/ ?>