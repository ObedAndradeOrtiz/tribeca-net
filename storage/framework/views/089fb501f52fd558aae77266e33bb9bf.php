<div class="col-12">

    <?php if($lista == 'historial'): ?>

        <!-- 🔥 HEADER -->
        <div class="mb-4">
            <h5 class="fw-bold mb-1">
                <i class="bi bi-clock-history me-2"></i> Historial de egresos
            </h5>
            <span class="text-muted small">
                Consulta y control de gastos registrados
            </span>
        </div>

        <!-- 🔥 FILTROS PRO -->
        <div class="row g-3 mb-4 align-items-end">

            <div class="col-md-2">
                <label class="form-label fw-semibold">Desde</label>
                <input type="date" class="form-control" wire:model="fechaInicioMes">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Hasta</label>
                <input type="date" class="form-control" wire:model="fechaActual">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Área</label>
                <select class="form-select" wire:model="sucursal">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Modo</label>
                <select class="form-select" wire:model="modogeneral">
                    <option>Todos</option>
                    <option>QR</option>
                    <option>Efectivo</option>
                </select>
            </div>

        </div>

        <!-- 🔥 PRE-CONSULTA -->
        <?php
            $gastos = DB::table('gastos')
                ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                ->where('area', 'LIKE', '%' . $sucursal . '%')
                ->when($modogeneral != 'Todos', fn($q) => $q->where('modo', $modogeneral))
                ->get();

            $sumador = $gastos->sum('cantidad');
        ?>

        <!-- 🔥 TABLA PRO -->
        <div class="table-responsive">

            <table class="table table-row-bordered table-hover align-middle">

                <thead class="fw-bold text-muted bg-light">
                    <tr>
                        <th>Detalle</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Modo</th>
                        <th>Responsable</th>
                        <th>Área</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $__currentLoopData = $gastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <!-- DETALLE -->
                            <td class="text-truncate" style="max-width:200px;">
                                <?php echo e($item->empresa); ?>

                            </td>

                            <!-- TIPO -->
                            <td>
                                <span class="badge bg-light-primary text-dark">
                                    <?php echo e($item->tipo); ?>

                                </span>
                            </td>

                            <!-- MONTO -->
                            <td class="fw-bold text-danger">
                                Bs <?php echo e(number_format($item->cantidad, 2)); ?>

                            </td>

                            <!-- FECHA -->
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($item->fechainicio)->format('d/m/Y')); ?>

                            </td>

                            <!-- MODO -->
                            <td>
                                <span class="badge bg-light-secondary">
                                    <?php echo e($item->modo ?? $modogeneral); ?>

                                </span>
                            </td>

                            <!-- USUARIO -->
                            <td><?php echo e($item->nameuser); ?></td>

                            <!-- AREA -->
                            <td class="fw-semibold">
                                <i class="bi bi-building me-1 text-muted"></i>
                                <?php echo e($item->area); ?>

                            </td>
                            <td>
                                <?php if($item->rutaarchivo): ?>
                                    <button class="btn btn-sm btn-light-primary"
                                        wire:click="verImagen('<?php echo e($item->rutaarchivo); ?>')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- 🔥 TOTAL -->
                    <tr class="fw-bold bg-dark text-white">
                        <td>TOTALES</td>
                        <td></td>
                        <td>Bs <?php echo e(number_format($sumador, 2)); ?></td>
                        <td></td>
                        <td><?php echo e($modogeneral); ?></td>
                        <td></td>
                        <td></td>
                         <td></td>
                    </tr>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

    <?php if($imagenModal): ?>
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.7)">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Comprobante</h5>
                        <button class="btn-close" wire:click="$set('imagenModal', null)"></button>
                    </div>

                    <div class="modal-body text-center">
                        <img src="<?php echo e(asset('storage/' . $imagenModal)); ?>" class="img-fluid rounded shadow">
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>


</div>
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/tesoreria/egreso-interno.blade.php ENDPATH**/ ?>