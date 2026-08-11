<div>

    <!-- 🔥 FILTROS -->
    <div class="row g-3 mb-4 align-items-end">

        <div class="col-md-2">
            <label class="form-label fw-semibold">Área</label>
            <select id="areaseleccionada" wire:model="areaseleccionada" class="form-select">
                <option value="">Todas</option>
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Desde</label>
            <input type="date" id="fecha-inicio" wire:model="fechaInicioMes" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Hasta</label>
            <input type="date" id="fecha-actual" wire:model="fechaActual" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Responsable</label>
            <select id="usuarioseleccionado" wire:model="usuarioseleccionado" class="form-select">
                <option value="">Todos</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lista->name); ?>"><?php echo e($lista->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Tipo gasto</label>
            <select id="tipogasto" wire:model="tipogasto" class="form-select">
                <option value="">Todos</option>
                <option value="AGUA POTABLE">Agua</option>
                <option value="LUZ ELECTRICA">Luz</option>
                <option value="INTERNET/TEL">Internet</option>
                <option value="MANTENIMIENTO">Mantenimiento</option>
                <option value="SUELDO">Sueldo</option>
                <option value="OTRO">Otro</option>
            </select>
        </div>

        <!-- EXPORT -->
        <div class="col-md-2 d-flex gap-2">
            <button id="export-btn" class="btn btn-success w-100 d-flex align-items-center gap-1">
                <i class="bi bi-file-earmark-excel"></i>
                Excel
            </button>

            <button id="export-pdf" class="btn btn-danger w-100 d-flex align-items-center gap-1">
                <i class="bi bi-file-earmark-pdf"></i>
                PDF
            </button>
        </div>

    </div>

    <!-- 🔥 TITULO -->
    <div class="mb-3">
        <h5 class="fw-bold">
            <i class="bi bi-cash-stack me-2"></i> Gastos realizados
        </h5>
    </div>

    <!-- 🔥 TABLA -->
    <div class="table-responsive">

        <table id="data-table" class="table table-row-bordered table-hover align-middle">

            <thead class="fw-bold text-muted bg-light">
                <tr>
                    <th>Motivo</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>Modo</th>
                    <th>Responsable</th>
                    <th>Área</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>

            <tbody>

                <?php $pagado = 0; ?>

                <?php $__currentLoopData = $gastoarealista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $pagado += $lista->cantidad; ?>

                    <tr>

                        <!-- MOTIVO -->
                        <td class="text-truncate" style="max-width:200px;">
                            <?php echo e($lista->empresa); ?>

                        </td>

                        <!-- FECHA -->
                        <td>
                            <?php echo e(\Carbon\Carbon::parse($lista->fechainicio)->format('d/m/Y')); ?>

                        </td>

                        <!-- MONTO -->
                        <td class="fw-bold text-danger">
                            Bs <?php echo e(number_format($lista->cantidad,2)); ?>

                        </td>

                        <!-- TIPO -->
                        <td>
                            <span class="badge bg-light-primary text-dark">
                                <?php echo e($lista->tipo); ?>

                            </span>
                        </td>

                        <!-- MODO -->
                        <td>
                            <span class="badge bg-light-secondary">
                                <?php echo e($lista->modo); ?>

                            </span>
                        </td>

                        <!-- RESPONSABLE -->
                        <td><?php echo e($lista->nameuser); ?></td>

                        <!-- AREA -->
                        <td class="fw-semibold">
                            <i class="bi bi-building me-1 text-muted"></i>
                            <?php echo e($lista->area); ?>

                        </td>

                        <!-- ACCIÓN -->
                        <td class="text-end">
                            <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
                                wire:click="$emit('eliminarGasto',<?php echo e($lista->id); ?>)">
                                <i class="bi bi-trash"></i>
                                Eliminar
                            </button>
                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- TOTAL -->
                <tr class="fw-bold bg-dark text-white">
                    <td>Total</td>
                    <td></td>
                    <td>Bs <?php echo e(number_format($pagado,2)); ?></td>
                    <td colspan="4"></td>
                    <td></td>
                </tr>

            </tbody>

        </table>

    </div>

</div><?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/registros/reg-gastos.blade.php ENDPATH**/ ?>