<div>

    <!-- 🔥 TARJETAS SUPERIORES -->
    <div class="mb-4 row">

        <div class="col-md-6">
            <div class="shadow-sm card border-bottom border-info">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4 class="text-info fw-bold"><?php echo e(number_format($total_si_pagado,2)); ?> Bs.</h4>
                        <span>Ingreso departamentos</span>
                    </div>
                    <i class="mdi mdi-home-city fs-2 text-info"></i>
                </div>
            </div>
        </div>

        <?php
            $gastosgenerales = DB::table('gastos')
                ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                ->sum('cantidad');
        ?>

        <div class="col-md-6">
            <div class="shadow-sm card border-bottom border-danger">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4 class="text-danger fw-bold"><?php echo e(number_format($gastosgenerales,2)); ?> Bs.</h4>
                        <span>Gasto total</span>
                    </div>
                    <i class="mdi mdi-cash-minus fs-2 text-danger"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- 🔥 FILTROS -->
    <div class="flex-wrap gap-3 card-header d-flex align-items-end">

        <div>
            <label class="fw-bold">Desde</label>
            <input type="date" class="form-control" wire:model="fechaInicioMes">
        </div>

        <div>
            <label class="fw-bold">Hasta</label>
            <input type="date" class="form-control" wire:model="fechaActual">
        </div>

        <div>
            <button class="mt-2 btn btn-success" onclick="exportToExcel()">
                <i class="mdi mdi-file-excel"></i> Exportar
            </button>
        </div>

    </div>

    <!-- 🔥 PRE-CONSULTAS (CLAVE) -->
    <?php
        $pagos = DB::table('registropagos')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->get();

        $inventarios = DB::table('registroinventarios')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->whereIn('motivo', ['compra','farmacia'])
            ->get();

        $gastos = DB::table('gastos')
            ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
            ->get();

        $totalsumamonto = 0;
        $totalsumainv = 0;
        $totalgastos = 0;
    ?>

    <!-- 🔥 TABLA -->
    <div class="card-body">
        <div class="table-responsive">

            <table id="mitabla-ps" class="table align-middle table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>SUCURSAL</th>
                        <th>COPROPIETARIOS</th>
                        <th>INGRESO</th>
                        <th>GASTO</th>
                        <th>RESTANTE</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $total_monto = $pagos
                                ->where('idsucursal', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo',$modo))
                                ->sum('monto');

                            $total_inventario = $inventarios
                                ->where('idsucursal', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo',$modo))
                                ->sum('precio');

                            $gastoarea = $gastos
                                ->where('idarea', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo',$modo))
                                ->sum('cantidad');

                            $total_clientes = $pagos
                                ->where('idsucursal', $lista->id)
                                ->when($modo != '', fn($q) => $q->where('modo',$modo))
                                ->pluck('idoperativo')
                                ->unique()
                                ->count();

                            $ingreso = $total_monto + $total_inventario;
                            $restante = $ingreso - $gastoarea;

                            $totalsumamonto += $total_monto;
                            $totalsumainv += $total_inventario;
                            $totalgastos += $gastoarea;
                        ?>

                        <tr>
                            <td><?php echo e($lista->area); ?></td>

                            <td class="fw-bold">
                                <?php echo e($total_clientes); ?>

                            </td>

                            <td class="text-success fw-bold">
                                Bs <?php echo e(number_format($ingreso,2)); ?>

                            </td>

                            <td class="text-danger">
                                Bs <?php echo e(number_format($gastoarea,2)); ?>

                            </td>

                            <td class="text-primary fw-bold">
                                Bs <?php echo e(number_format($restante,2)); ?>

                            </td>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- 🔥 TOTAL -->
                    <?php
                        $total_clientes = $pagos
                            ->when($modo != '', fn($q) => $q->where('modo',$modo))
                            ->pluck('idoperativo')
                            ->unique()
                            ->count();
                    ?>

                    <tr style="background:#0f172a; color:white; font-weight:bold;">
                        <td>TOTALES</td>
                        <td><?php echo e($total_clientes); ?></td>
                        <td>Bs <?php echo e(number_format($totalsumamonto + $totalsumainv,2)); ?></td>
                        <td>Bs <?php echo e(number_format($totalgastos,2)); ?></td>
                        <td>Bs <?php echo e(number_format(($totalsumamonto + $totalsumainv) - $totalgastos,2)); ?></td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>

    <!-- 🔥 EXPORT EXCEL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            var table = document.getElementById("mitabla-ps");
            var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(wb, "reporte-sucursales.xlsx");
        }
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/tesoreria/pago-sucursal.blade.php ENDPATH**/ ?>