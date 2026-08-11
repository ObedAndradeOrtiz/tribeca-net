<div class="py-5 px-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ki-outline ki-notification-bing text-warning me-2"></i>
                Notificaciones de mantenimiento
            </h4>
            <span class="text-muted small">
                Alertas según fechas programadas
            </span>
        </div>
    </div>

    <!-- LISTA -->
    <div class="d-flex flex-column gap-3" style="max-height: 500px; overflow-y:auto;">

        <?php $__empty_1 = true; $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="card shadow-sm border-0">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <!-- INFO -->
                    <div class="d-flex align-items-start gap-3">

                        <!-- ICONO -->
                        <div class="symbol symbol-45px">
                            <span class="symbol-label bg-light-<?php echo e($n->color); ?>">
                                <i class="ki-outline ki-notification-bing text-<?php echo e($n->color); ?> fs-2"></i>
                            </span>
                        </div>

                        <!-- TEXTO -->
                        <div>
                            <div class="fw-bold text-gray-800">
                                <?php echo e($n->nombre ?? 'Mantenimiento'); ?>

                            </div>

                            <div class="text-muted small">
                                <?php echo e($n->mensaje); ?>

                            </div>

                            <div class="text-muted small mt-1">
                                <i class="bi bi-calendar-event me-1"></i>
                                <?php echo e(\Carbon\Carbon::parse($n->fecha_siguiente)->format('d/m/Y')); ?>

                            </div>
                        </div>

                    </div>

                    <!-- BADGE -->
                    <div class="text-end">

                        <span class="badge badge-light-<?php echo e($n->color); ?> fw-bold px-4 py-2">
                            <?php echo e($n->dias_restantes); ?> días
                        </span>

                    </div>

                </div>

                <!-- BARRA INFERIOR -->
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-<?php echo e($n->color); ?>" style="width:
                        <?php echo e($n->dias_restantes <= 2 ? '100%' : ($n->dias_restantes <= 5 ? '70%' : '40%')); ?>">
                    </div>
                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <div class="text-center py-10">
                <i class="ki-outline ki-information-5 fs-3x text-muted mb-3"></i>
                <div class="text-muted fw-semibold">
                    No hay mantenimientos próximos
                </div>
            </div>

        <?php endif; ?>

    </div>

</div><?php /**PATH D:\2.TRIBECA\1.WEB\TRIBECA NET\resources\views/livewire/tesoreria/micaja.blade.php ENDPATH**/ ?>