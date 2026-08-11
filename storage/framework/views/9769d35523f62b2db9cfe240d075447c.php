<div>
    <div class="card-body">

        <!-- 🔥 FILTROS PRO -->
        <div class="flex-wrap gap-3 mb-4 d-flex align-items-end">

            <div>
                <label class="fw-bold">Desde</label>
                <input type="date" class="form-control" wire:model="fechaInicioMes">
            </div>

            <div>
                <label class="fw-bold">Hasta</label>
                <input type="date" class="form-control" wire:model="fechaActual">
            </div>

            <div>
                <label class="fw-bold">Modo</label>
                <select class="form-select" wire:model="modo">
                    <option value="">Todos</option>
                    <option value="Qr">QR</option>
                    <option value="Efectivo">Efectivo</option>
                </select>
            </div>

            <div>
                <label class="fw-bold">Sucursal</label>
                <select class="form-select" wire:model="empresaseleccionada">
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <button class="gap-2 mt-2 shadow-sm btn btn-success d-flex align-items-center"
                    onclick="exportToExcel()">
                    <i class="mdi mdi-file-excel"></i>
                    Exportar
                </button>
            </div>

        </div>

        <!-- 🔥 PRE-CONSULTAS (CLAVE PARA RENDIMIENTO) -->
        <?php
            $pagos = DB::table('registropagos')
                ->where('sucursal', $empresaseleccionada)
                ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                ->get();

            $inventarios = DB::table('registroinventarios')
                ->where('sucursal', $empresaseleccionada)
                ->where('motivo', 'compra')
                ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                ->get();

            $gastos = DB::table('gastos')
                ->where('area', $empresaseleccionada)
                ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                ->get();

            $totalsumamonto = 0;
            $sumagasto = 0;
        ?>

        <!-- 🔥 TABLA -->
        <div class="table-responsive">
            <table class="table align-middle table-striped" id="miTabla-users">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>SUCURSAL</th>
                        <th>USUARIO</th>
                        <th>INGRESOS</th>
                        <th>GASTOS</th>
                        <th>CAJA</th>
                        <th>MODO</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $__currentLoopData = $internos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $total_monto = $pagos
                                ->where('iduser', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo', $modo))
                                ->sum('monto');

                            $total_inventario = $inventarios
                                ->where('iduser', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo', $modo))
                                ->sum('precio');

                            $gastoarea = $gastos
                                ->where('nameuser', $lista->name)
                                ->when($modo != '', fn($q) => $q->where('modo', $modo))
                                ->sum('cantidad');

                            $ingresos = $total_monto + $total_inventario;
                            $caja = $ingresos - $gastoarea;

                            $totalsumamonto += $ingresos;
                            $sumagasto += $gastoarea;
                        ?>

                        <tr>
                            <td><?php echo e($lista->id); ?></td>
                            <td><?php echo e($lista->sucursal); ?></td>
                            <td><?php echo e($lista->name); ?></td>

                            <td class="text-success fw-bold">
                                Bs <?php echo e(number_format($ingresos, 2)); ?>

                            </td>

                            <td class="text-danger">
                                Bs <?php echo e(number_format($gastoarea, 2)); ?>

                            </td>

                            <td class="fw-bold text-primary">
                                Bs <?php echo e(number_format($caja, 2)); ?>

                            </td>

                            <td>
                                <?php echo e($modo == '' ? 'Todo' : $modo); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- 🔥 TOTAL -->
                    <tr style="background:#0f172a; color:white; font-weight:bold;">
                        <td>TOTALES</td>
                        <td></td>
                        <td></td>

                        <td>Bs <?php echo e(number_format($totalsumamonto, 2)); ?></td>
                        <td>Bs <?php echo e(number_format($sumagasto, 2)); ?></td>
                        <td>Bs <?php echo e(number_format($totalsumamonto - $sumagasto, 2)); ?></td>
                        <td><?php echo e($modo == '' ? 'Todo' : $modo); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/tesoreria/pago-usuarios.blade.php ENDPATH**/ ?>