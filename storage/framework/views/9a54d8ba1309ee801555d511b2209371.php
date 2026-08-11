<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <style>
        .fixed-button-y {

            right: 0px;
            bottom: 23%;
            padding: 15px;
            background-color: rgb(255, 0, 0);
            color: white;
            border: none;
            border-radius: 5%;
            /* Hace que el botón sea redondo */
            cursor: pointer;
            z-index: 9999;
            width: 150px;
            margin: 1%;
            height: 25px;
            /* Asegura que el botón esté delante de otros elementos */
        }

        @media (max-width: 900px) {
            .fixed-button-y {
                width: 50px;
            }

            .fixed-button-y span {
                display: none;
                /* Oculta la palabra "REGISTRO" */
            }
        }
    </style>
    <button class="fixed-button-y" style="display: flex; align-items: center;" wire:click="$set('openAreaGasto',true)"><i
            class="icon">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10.7044 3.51898C10.034 3.51898 9.46373 3.9848 9.30365 4.61265H14.6863C14.5263 3.9848 13.956 3.51898 13.2856 3.51898H10.7044ZM16.2071 4.61264H18.1881C20.2891 4.61264 22 6.34428 22 8.47085C22 8.47085 21.94 9.3711 21.92 10.6248C21.918 10.724 21.8699 10.8212 21.7909 10.88C21.3097 11.2354 20.8694 11.5291 20.8294 11.5493C19.1686 12.6632 17.2386 13.447 15.1826 13.8369C15.0485 13.8632 14.9165 13.7934 14.8484 13.6739C14.2721 12.6754 13.1956 12.0253 11.995 12.0253C10.8024 12.0253 9.71586 12.6683 9.12256 13.6678C9.05353 13.7853 8.92346 13.8531 8.7904 13.8278C6.75138 13.4369 4.82141 12.6541 3.17059 11.5594L2.21011 10.8911C2.13007 10.8405 2.08004 10.7493 2.08004 10.6481C2.05003 10.1316 2 8.47085 2 8.47085C2 6.34428 3.71086 4.61264 5.81191 4.61264H7.78289C7.97299 3.1443 9.2036 2 10.7044 2H13.2856C14.7864 2 16.017 3.1443 16.2071 4.61264ZM21.6598 12.8152L21.6198 12.8355C19.5988 14.1924 17.1676 15.0937 14.6163 15.4684C14.2561 15.519 13.8959 15.2861 13.7959 14.9216C13.5758 14.0912 12.8654 13.5443 12.015 13.5443H12.005H11.985C11.1346 13.5443 10.4242 14.0912 10.2041 14.9216C10.1041 15.2861 9.74387 15.519 9.38369 15.4684C6.83242 15.0937 4.4012 14.1924 2.38019 12.8355C2.37019 12.8254 2.27014 12.7646 2.1901 12.8152C2.10005 12.8659 2.10005 12.9874 2.10005 12.9874L2.17009 18.1519C2.17009 20.2785 3.87094 22 5.97199 22H18.018C20.1191 22 21.8199 20.2785 21.8199 18.1519L21.9 12.9874C21.9 12.9874 21.9 12.8659 21.8099 12.8152C21.7599 12.7849 21.6999 12.795 21.6598 12.8152ZM12.7454 17.0583C12.7454 17.4836 12.4152 17.8177 11.995 17.8177C11.5848 17.8177 11.2446 17.4836 11.2446 17.0583V15.7519C11.2446 15.3367 11.5848 14.9924 11.995 14.9924C12.4152 14.9924 12.7454 15.3367 12.7454 15.7519V17.0583Z"
                    fill="currentColor"></path>
            </svg>
        </i><span style="margin-left: 5px;">CAJA</span></button>
    <style>
        .boton {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .boton:hover {
            background-color: #0056b3;
        }
    </style>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'openAreaGasto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'openAreaGasto']); ?>
        <div class="px-6 py-4">
            <div class="">
                <h6>SUCURSAL: <?php echo e(Auth::user()->sucursal); ?></h6>
            </div>
            <div class="mb-4 text-lg font-medium text-gray-900">
                <h6>MI CAJA: <?php echo e(Auth::user()->name); ?></h6>
            </div>

            <div>
                <div class="" style="display: flex; font-size: 0.8vw;">
                    <label for="fecha-inicio mr-2">Desde:</label>
                    <input style="font-size: 0.8vw;" class="mr-2" type="date" id="fecha-inicio"
                        wire:model="fechaInicioMes">
                    <label for="fecha-actual mr-2">Hasta:</label>
                    <input style="font-size: 0.8vw;" class="mr2" type="date" id="fecha-actual"
                        wire:model="fechaActual">
                    
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <?php
                        $total_monto_g = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));

                        $total_inventario_g =
                            DB::table('registroinventarios')
                                ->where('sucursal', Auth::user()->sucursal)
                                ->where('modo', 'ilike', '%Efectivo%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'compra')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                            DB::table('registroinventarios')
                                ->where('sucursal', Auth::user()->sucursal)
                                ->where('modo', 'ilike', '%Efectivo%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'farmacia')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));

                        $gastoarea_g = DB::table('gastos')
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->where('area', Auth::user()->sucursal)
                            ->where('fechainicio', '<=', $fechaActual)
                            ->where('fechainicio', '>=', $fechaInicioMes)
                            ->where('pertence', 'Caja')
                            ->sum('cantidad');
                        $gastoarealista = DB::table('gastos')
                            ->where('area', Auth::user()->sucursal)
                            ->where('fechainicio', '<=', $fechaActual)
                            ->where('fechainicio', '>=', $fechaInicioMes)
                            ->where('pertence', 'Caja')
                            ->get();
                        $total_monto_citas_g = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->get();
                        $total_monto_qr_g = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%qr%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                        $total_monto_qr_lista_g = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%qr%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->get();
                        $total_inventario_qr_g =
                            DB::table('registroinventarios')
                                ->where('sucursal', Auth::user()->sucursal)
                                ->where('estado', 'Activo')
                                ->where('modo', 'ilike', '%Qr%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'compra')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                            DB::table('registroinventarios')
                                ->where('sucursal', Auth::user()->sucursal)
                                ->where('modo', 'ilike', '%Qr%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'farmacia')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
                        $total_monto = DB::table('registropagos')
                            ->where('iduser', Auth::user()->id)
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                        $total_inventario =
                            DB::table('registroinventarios')
                                ->where('iduser', Auth::user()->id)
                                ->where('modo', 'ilike', '%Efectivo%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'compra')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                            DB::table('registroinventarios')
                                ->where('iduser', Auth::user()->id)
                                ->where('sucursal', Auth::user()->sucursal)
                                ->where('modo', 'ilike', '%Efectivo%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'farmacia')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
                        $gastoarea = DB::table('gastos')
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->where('pertence', 'Caja')
                            ->where('iduser', Auth::user()->id)
                            ->where('fechainicio', '<=', $fechaActual)
                            ->where('fechainicio', '>=', $fechaInicioMes)
                            ->sum('cantidad');
                        $total_monto_citas = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->get();
                        $total_monto_qr = DB::table('registropagos')
                            ->where('iduser', Auth::user()->id)
                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%qr%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
                        $total_monto_qr_lista = DB::table('registropagos')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%qr%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->get();
                        $total_inventario_qr =
                            DB::table('registroinventarios')
                                ->where('iduser', Auth::user()->id)
                                ->where('estado', 'Activo')
                                ->where('modo', 'ilike', '%Qr%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'compra')

                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                            DB::table('registroinventarios')
                                ->where('sucursal', Auth::user()->sucursal)

                                ->where('modo', 'ilike', '%Qr%')
                                ->where('fecha', '<=', $fechaActual)
                                ->where('fecha', '>=', $fechaInicioMes)
                                ->where('motivo', 'farmacia')
                                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
                        $total_inventario_pago = DB::table('registroinventarios')
                            ->where('sucursal', Auth::user()->sucursal)
                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%Efectivo%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->where('motivo', 'compra')

                            ->get();
                        $total_inventario_pago_qr = DB::table('registroinventarios')
                            ->where('sucursal', Auth::user()->sucursal)

                            ->where('estado', 'Activo')
                            ->where('modo', 'ilike', '%QR%')
                            ->where('fecha', '<=', $fechaActual)
                            ->where('fecha', '>=', $fechaInicioMes)
                            ->where('motivo', 'compra')

                            ->get();

                    ?>
                    <div class="table-responsive">

                        <table id="user-list-table" class="table table-striped" role="grid"
                            data-bs-toggle="data-table">
                            <thead>
                                <th>INGRESO CAJA GENERAL</th>
                                <th>TOTALES</th>
                                <th>MIS INGRESOS TOTAL</th>
                                <th>TOTALES
                                </th>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>INGRESO EFEC: </td>
                                    <td>
                                        <?php echo e($total_monto_g + $total_inventario_g); ?>

                                    </td>
                                    <td>
                                        INGRESO EFEC:
                                    </td>
                                    <td>
                                        <?php echo e($total_monto + $total_inventario); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        INGRESO QR:
                                    </td>
                                    <td><?php echo e($total_monto_qr_g + $total_inventario_qr_g); ?></td>

                                    <td>
                                        INGRESO QR:
                                    </td>
                                    <td>
                                        <?php echo e($total_monto_qr + $total_inventario_qr); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        TOTAL QR+EFEC:
                                    </td>
                                    <td>
                                        <?php echo e($total_monto_g + $total_inventario_g + $total_monto_qr_g + $total_inventario_qr_g); ?>

                                    </td>
                                    <td>
                                        TOTAL QR+EFEC:
                                    </td>
                                    <td>
                                        <?php echo e($total_monto + $total_inventario + $total_monto_qr + $total_inventario_qr); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        GASTOS EFEC:
                                    </td>
                                    <td>
                                        <?php echo e($gastoarea_g); ?>

                                    </td>
                                    <td>
                                        GASTOS EFEC:
                                    </td>
                                    <td>
                                        <?php echo e($gastoarea); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        CAJA(EFEC - GASTO):
                                    </td>
                                    <td>
                                        <?php echo e($total_monto_g + $total_inventario_g - $gastoarea_g); ?>

                                    </td>
                                    <td>
                                        CAJA(EFEC):
                                    </td>
                                    <td>
                                        <?php echo e($total_monto + $total_inventario - $gastoarea); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        (EFEC. + QR - GASTO ):

                                    </td>
                                    <td>
                                        <?php echo e($total_monto_g + $total_inventario_g + $total_monto_qr_g + $total_inventario_qr_g - $gastoarea_g); ?>

                                    </td>
                                    <td>
                                        (EFEC. + QR - GASTO ):

                                    </td>
                                    <td>
                                        <?php echo e($total_monto + $total_inventario + $total_monto_qr + $total_inventario_qr - $gastoarea); ?>

                                    </td>
                                </tr>

                            </tbody>

                        </table>
                        <div>


                            <div class="mb-1">
                                <h6></h6>
                            </div>



                        </div>
                        <div class="ml-4">
                            <div class="mb-1">
                                <h6></h6>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>




                    <div>
                        <h6>PAGOS POR CONSULTA EN EFEC.</h6>
                    </div>
                    <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead style="font-size: 0.8vw;">
                            <tr class="ligth">
                                <th>ID</th>

                                <th>MONTO</th>
                                <th>RESPONSABLE</th>
                                <th>CLIENTE</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.8vw;">
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php
                                $pagado = 0;
                            ?>
                            <?php $__currentLoopData = $total_monto_citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $pagado = $pagado + $lista->monto;
                                ?>
                                <tr>
                                    <td><?php echo e($lista->id); ?></td>
                                    <td><?php echo e($lista->monto); ?></td>
                                    <td><?php echo e($lista->responsable); ?></td>
                                    <td><?php echo e($lista->nombrecliente); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-gray">
                                <td style="color: white">Total</td>

                                <td style="color: white"><?php echo e($pagado); ?></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <h6>PAGOS POR CONSULTA EN QR</h6>
                    </div>
                    <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead style="font-size: 0.8vw;">
                            <tr class="ligth">
                                <th>ID</th>
                                <th>MONTO</th>
                                <th>RESPONSABLE</th>
                                <th>CLIENTE</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.8vw;">
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php
                                $pagado = 0;
                            ?>
                            <?php $__currentLoopData = $total_monto_qr_lista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $pagado = $pagado + $lista->monto;
                                ?>
                                <tr>
                                    <td><?php echo e($lista->id); ?></td>

                                    <td><?php echo e($lista->monto); ?></td>
                                    <td><?php echo e($lista->responsable); ?></td>
                                    <td><?php echo e($lista->nombrecliente); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-gray">
                                <td style="color: white">Total</td>

                                <td style="color: white"><?php echo e($pagado); ?></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <h6>PRODUCTOS VENDIDOS EN EFECTIVO</h6>
                    </div>
                    <table id="tabla3" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead style="font-size: 0.8vw;">
                            <tr class="ligth">
                                <th>SUCURSAL</th>
                                <th>MONTO</th>

                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>RESPONSABLE</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.8vw;">
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php
                                $pagado = 0;
                            ?>
                            <?php $__currentLoopData = $total_inventario_pago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $pagado = $pagado + $lista->precio;
                                ?>
                                <tr>
                                    <td><?php echo e($lista->sucursal); ?></td>
                                    <td><?php echo e($lista->precio); ?></td>

                                    <td><?php echo e($lista->nombreproducto); ?></td>
                                    <td><?php echo e($lista->cantidad); ?></td>
                                    <?php
                                        $responsable = DB::table('users')
                                            ->where('id', $lista->iduser)
                                            ->pluck('name')
                                            ->first();
                                    ?>
                                    <td><?php echo e($responsable); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-gray">
                                <td style="color: white">Total</td>
                                <td style="color: white"><?php echo e($pagado); ?></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <h6>PRODUCTOS VENDIDOS POR QR</h6>
                    </div>
                    <table id="tabla3" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead style="font-size: 0.8vw;">
                            <tr class="ligth">
                                <th>SUCURSAL</th>
                                <th>MONTO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>RESPONSABLE</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.8vw;">
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php
                                $pagado = 0;
                            ?>
                            <?php $__currentLoopData = $total_inventario_pago_qr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $pagado = $pagado + $lista->precio;
                                ?>
                                <tr>
                                    <td><?php echo e($lista->sucursal); ?></td>
                                    <td><?php echo e($lista->precio); ?></td>

                                    <td><?php echo e($lista->nombreproducto); ?></td>
                                    <td><?php echo e($lista->cantidad); ?></td>
                                    <?php
                                        $responsable = DB::table('users')
                                            ->where('id', $lista->iduser)
                                            ->pluck('name')
                                            ->first();
                                    ?>
                                    <td><?php echo e($responsable); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-gray">
                                <td style="color: white">Total</td>
                                <td style="color: white"><?php echo e($pagado); ?></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <h6>GASTOS REALIZADOS</h6>
                    </div>
                    <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead style="font-size: 0.8vw;">
                            <tr class="ligth">
                                <th>MOTIVO</th>
                                <th>MONTO</th>
                                <th>TIPO</th>
                                <th>MODO</th>
                                <th>RESPONSABLE</th>
                                <th>SUCURSAL</th>
                                <th>ACCION</th>

                            </tr>
                        </thead>
                        <tbody style="font-size: 0.8vw;">
                            <style>
                                td {
                                    max-width: 200px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                            </style>
                            <?php
                                $pagado = 0;
                            ?>
                            <?php if($gastoarealista): ?>
                                <?php $__currentLoopData = $gastoarealista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $pagado = $pagado + $lista->cantidad;
                                    ?>
                                    <tr>
                                        <td><?php echo e($lista->empresa); ?></td>
                                        <td><?php echo e($lista->cantidad); ?></td>
                                        <td><?php echo e($lista->tipo); ?></td>
                                        <td><?php echo e($lista->modo); ?></td>
                                        <td><?php echo e($lista->nameuser); ?></td>
                                        <td><?php echo e($lista->area); ?></td>
                                        <td><a class="mt-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                                data-original-title="Edit"
                                                wire:click="$emit('eliminarGastoMicaja',<?php echo e($lista->id); ?>)">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.4"
                                                        d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <span class="ms-1" style="font-size: 8px;">ELIMINAR</span>
                                            </a></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <tr class="bg-gray">
                                <td style="color: white">Total</td>
                                <td style="color: white"><?php echo e($pagado); ?></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                                <td style="color: white"></td>
                                <td></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
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
    <script>
        function exportToExcel() {
            // Obtener los datos de las tres tablas
            const data1 = getDataFromTable('tabla1');
            const data2 = getDataFromTable('tabla2');
            const data3 = getDataFromTable('tabla3');
            // Unir los datos de las tres tablas en una sola matriz de datos
            const combinedData = data1.concat(data2, data3);
            // Crear una tabla HTML para almacenar los datos combinados
            const combinedTable = document.createElement('table');
            combinedTable.setAttribute('id', 'combinedTable');
            // Agregar filas a la tabla combinada
            combinedData.forEach(rowData => {
                const row = combinedTable.insertRow();
                rowData.forEach(cellData => {
                    const cell = row.insertCell();
                    cell.textContent = cellData;
                });
            });

            // Exportar la tabla combinada a Excel
            const wb = XLSX.utils.table_to_book(combinedTable, {
                sheet: 'Sheet1'
            });
            const wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                type: 'binary'
            });
            const buf = new ArrayBuffer(wbout.length);
            const view = new Uint8Array(buf);
            for (let i = 0; i < wbout.length; i++) view[i] = wbout.charCodeAt(i) & 0xFF;
            const blob = new Blob([buf], {
                type: 'application/octet-stream'
            });
            saveAs(blob, 'tabla_excel.xlsx');
        }

        function getDataFromTable(tableId) {
            const table = document.getElementById(tableId);
            const data = [];
            // Obtener los datos de cada fila de la tabla
            table.querySelectorAll('tr').forEach(row => {
                const rowData = [];
                row.querySelectorAll('td').forEach(cell => {
                    rowData.push(cell.textContent);
                });
                data.push(rowData);
            });
            return data;
        }
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/tesoreria/micaja.blade.php ENDPATH**/ ?>