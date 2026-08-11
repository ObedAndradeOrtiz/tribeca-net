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
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/tesoreria/pago-sucursal.blade.php ENDPATH**/ ?>