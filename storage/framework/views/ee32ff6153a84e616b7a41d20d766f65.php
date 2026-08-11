<div>
    <div class="flex flex-row row ">
        <div class="col-lg-3 col-md-6" style="flex: 1;">
            <div class="border-4 card border-bottom border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class=""><?php echo e($total_ingresado); ?>Bs.</h4>
                        </div>
                        <div>
                            <span>Ingreso productos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6" style="flex: 1;">
            <div class="border-4 card border-bottom border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class=""><?php echo e($total_si_pagado); ?> Bs.</h4>
                        </div>
                        <div>
                            <span>Ingreso hospedaje</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $empresasdeuda = DB::table('empresas')->where('estado', 'Activo')->get();
            $deuda = 0;
            $montoprevisto = 0;
            $gastosgenerales = DB::table('gastos')
                ->where('fechainicio', '<=', $fechaActual)
                ->where('fechainicio', '>=', $fechaInicioMes)
                ->sum('cantidad');
        ?>

        <div class="col-lg-3 col-md-6" style="flex: 1;">
            <div class="border-4 card border-bottom border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4><?php echo e($gastosgenerales); ?> Bs.</h4>
                        </div>
                        <div>
                            <span>Gasto total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-header d-flex" style="display: flex;">
        <div class="">
            <label for="fecha-inicio mr-2">Desde:</label>
            <input class="mr-2 shadow-none form-select form-select-smmt-5" type="date" id="fecha-inicio"
                wire:model="fechaInicioMes">
        </div>
        <div>
            <label for="fecha-actual mr-2">Hasta:</label>
            <input class="shadow-none mr2 form-select form-select-smmt-5" type="date" id="fecha-actual"
                wire:model="fechaActual">
        </div>

        <div>
            <label>Modo: </label>
            <select class="shadow-none form-select form-select-smmt-5" wire:model="modo">
                <option value="">Todos</option>
                <option value="Qr">QR</option>

                <option value="Efectivo">Efectivo</option>
            </select>
        </div>
        <div>
            <button class="mt-3 ml-2 btn btn-success" onclick="exportToExcel()"
                style="display: flex; align-item:center;"><svg class="icon-32" width="32" viewBox="0 0 24 24"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4"
                        d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
                        fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z"
                        fill="currentColor"></path>
                </svg> <span>Exportar a Excel</span></button>
        </div>
    </div>
    

    
    <div class="card-body">
        <div class="table-responsive">
            <table id="mitabla-ps" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>CLIENTES</th>
                        <th>INGR. HOSPEDAJE</th>
                        <th>INGR. PRODUCTO</th>
                        <th>TOTAL</th>
                        <th>GASTO</th>
                        <th>RESTANTE</th>
                        <th>MODO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($lista->area); ?></td>
                            <?php
                                $total_monto = DB::table('registropagos')
                                    ->where('idsucursal', $lista->id)
                                    ->where('modo', 'LIKE', '%' . $modo . '%')
                                    ->where('fecha', '<=', $fechaActual)
                                    ->where('fecha', '>=', $fechaInicioMes)
                                    ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                                $total_inventario =
                                    DB::table('registroinventarios')
                                        ->where('idsucursal', $lista->id)
                                        ->where('modo', 'LIKE', '%' . $modo . '%')
                                        ->where('fecha', '<=', $fechaActual)
                                        ->where('fecha', '>=', $fechaInicioMes)
                                        ->where('motivo', 'compra')
                                        ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                                    DB::table('registroinventarios')
                                        ->where('idsucursal', $lista->id)
                                        ->where('modo', 'LIKE', '%' . $modo . '%')
                                        ->where('fecha', '<=', $fechaActual)
                                        ->where('fecha', '>=', $fechaInicioMes)
                                        ->where('motivo', 'farmacia')
                                        ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
                                $gastoarea = DB::table('gastos')
                                    ->where('idarea', $lista->id)
                                    ->where('modo', 'LIKE', '%' . $modo . '%')
                                    ->where('fechainicio', '<=', $fechaActual)
                                    ->where('fechainicio', '>=', $fechaInicioMes)
                                    ->sum(DB::raw('CAST(cantidad AS DECIMAL(10, 2))'));
                                $total_clientes = DB::table('registropagos')
                                    ->where('idsucursal', $lista->id)
                                    ->where('modo', 'LIKE', '%' . $modo . '%')
                                    ->where('fecha', '<=', $fechaActual)
                                    ->where('fecha', '>=', $fechaInicioMes)
                                    ->distinct('idoperativo')
                                    ->count();
                                $totalgastos = $totalgastos + $gastoarea;
                                $totalsumamonto = $totalsumamonto + $total_monto;
                                $totalsumainv = $totalsumainv + $total_inventario;

                            ?>
                            <td><?php echo e($total_clientes); ?></td>
                            <td><?php echo e(number_format($total_monto, 2, ',', '.')); ?></td>
                            <td><?php echo e(number_format($total_inventario, 2, ',', '.')); ?></td>
                            <td><?php echo e(number_format($total_inventario + $total_monto, 2, ',', '.')); ?></td>

                            <td><?php echo e(number_format($gastoarea, 2, ',', '.')); ?></td>
                            <td><?php echo e(number_format($total_monto + $total_inventario - $gastoarea, 2, ',', '.')); ?></td>
                            <td><?php echo e($modo); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray">
                        <td style="color: white">TOTALES</td>

                        <?php
                            $total_clientes = DB::table('registropagos')
                                ->where('modo', 'LIKE', '%' . $modo . '%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->distinct('idoperativo')
                                ->count();
                        ?>
                        <td style="color: white"><?php echo e($total_clientes); ?></td>
                        <td style="color: white"><?php echo e(number_format($totalsumamonto, 2, ',', '.')); ?></td>
                        <td style="color: white"><?php echo e(number_format($totalsumainv, 2, ',', '.')); ?></td>
                        <td style="color: white"><?php echo e(number_format($totalsumamonto + $totalsumainv, 2, ',', '.')); ?></td>
                        <td style="color: white"><?php echo e(number_format($totalgastos, 2, ',', '.')); ?></td>
                        <td style="color: white">
                            <?php echo e(number_format($totalsumainv + $totalsumamonto - $totalgastos, 2, ',', '.')); ?></td>
                        <td style="color: white"><?php echo e($modo); ?></td>
                    </tr>
                </tbody>
            </table>
            <h1><strong>INGRESOS Y GASTOS GENERAL (MES ACTUAL)</strong></h1>
            <table id="mitabla-ps" class="table mt-2 table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>CLIENTES</th>
                        <th>INGR. CONSULTA</th>
                        <th>INGR. PRODUCTO</th>
                        <th>TOTAL</th>
                        <th>GASTO</th>
                        <th>RESTANTE</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>TODAS</td>
                        <?php
                            $total_monto_i = DB::table('registropagos')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                            $total_inventario_i = DB::table('registroinventarios')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->whereIn('motivo', ['compra', 'farmacia'])
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
                            $gastoarea_i = DB::table('gastos')
                                ->where('fechainicio', '<=', $fechaActual)
                                ->where('fechainicio', '>=', $fechaInicioMes)
                                ->sum(DB::raw('CAST(cantidad AS DECIMAL(10, 2))'));
                            $total_clientes_i = DB::table('registropagos')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->distinct('idoperativo')
                                ->count();
                            $saldodis = DB::table('transacciones')
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('fecha', '<=', $fechaActual)
                                ->whereIn('idmotivo', [3, 4, 7])
                                ->get();
                            $saldodistribuido = 0;
                            foreach ($saldodis as $item) {
                                $saldodistribuido += (float) $item->montouso;
                            }

                        ?>
                        <td><?php echo e($total_clientes_i); ?></td>
                        <td><?php echo e(number_format($total_monto_i, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($total_inventario_i, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($total_inventario_i + $total_monto_i, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($gastoarea_i + $saldodistribuido, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($total_monto_i + $total_inventario_i - $gastoarea_i - $saldodistribuido, 2, ',', '.')); ?>

                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
        <style>
            .verticalBarGraph {
                border-bottom: 1px solid #FFF;
                height: 200px;
                margin: 0;
                padding: 0;
                position: relative;
            }

            .verticalBarGraph li {
                border: 1px solid #555;
                border-bottom: none;
                bottom: 0;
                list-style: none;
                margin: 0;
                padding: 0;
                position: absolute;
                text-align: center;
                width: 39px;
            }

            .barGraph {
                background: url(images/horizontal_grid_line_50_pixel.png) bottom left;
                border-bottom: 3px solid #333;
                font: 9px Helvetica, Geneva, sans-serif;
                height: 200px;
                margin: 1em 0;
                padding: 0;
                position: relative;
            }

            .barGraph li {
                background: #666 url(images/bar_50_percent_highlight.png) repeat-y top right;
                border: 1px solid #555;
                border-bottom: none;
                bottom: 0;
                color: #FFF;
                margin: 0;
                padding: 0 0 0 0;
                position: absolute;
                list-style: none;
                text-align: center;
                width: 39px;
            }

            .barGraph li.p1 {
                background-color: #666666
            }

            .barGraph li.p2 {
                background-color: #888888
            }

            .barGraph li.p3 {
                background-color: #AAAAAA
            }
        </style>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            // Obtener el elemento de la tabla
            var table = document.getElementById("mitabla-ps");

            // Crear un libro de Excel
            var wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });

            // Guardar el libro de Excel en un archivo
            XLSX.writeFile(wb, "pagos-sucursales.xlsx");
        }
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/tesoreria/pago-sucursal.blade.php ENDPATH**/ ?>