<div class="">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <?php
        $hoy = date('Y-m-d');
        $total_pagados = DB::table('pagos')->sum('cantidad');
        $total_pagados_facturado = DB::table('pagos')->where('estado', 'Inactivo')->sum('cantidad');
        if (Auth::user()->sesionsucursal == 0) {
            $total_monto_g = DB::table('registropagos')
                ->where('fecha', $hoy)
                ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
            $total_inventario_g =
                DB::table('registroinventarios')
                    ->where('fecha', $hoy)
                    ->where('motivo', 'compra')
                    ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                DB::table('registroinventarios')
                    ->where('fecha', $hoy)
                    ->where('motivo', 'farmacia')
                    ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
            $gastoarea_g = DB::table('gastos')
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('fecha', $hoy)
                ->sum('cantidad');
        } else {
            $total_monto_g = DB::table('registropagos')
                ->where('sucursal', Auth::user()->sucursal)
                ->where('fecha', $hoy)
                ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
            $total_inventario_g =
                DB::table('registroinventarios')
                    ->where('sucursal', Auth::user()->sucursal)
                    ->where('fecha', $hoy)
                    ->where('motivo', 'compra')
                    ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
                DB::table('registroinventarios')
                    ->where('sucursal', Auth::user()->sucursal)
                    ->where('fecha', $hoy)
                    ->where('motivo', 'farmacia')
                    ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
            $gastoarea_g = DB::table('gastos')
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('area', Auth::user()->sucursal)
                ->where('fecha', $hoy)
                ->sum('cantidad');
        }
        $total_monto_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])

            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $total_inventario_g =
            DB::table('registroinventarios')
                ->where('sucursal', Auth::user()->sucursal)
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'compra')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
            DB::table('registroinventarios')
                ->where('sucursal', Auth::user()->sucursal)
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'farmacia')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $gastoarea_g = DB::table('gastos')
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
            ->where('area', Auth::user()->sucursal)
            ->where('fechainicio', '<=', $fechaActual)
            ->where('fechainicio', '>=', $fechaInicioMes)
            ->where('pertence', 'Caja')
            ->sum('cantidad');
        $gastoarealista = DB::table('gastos')
            ->where('area', Auth::user()->sucursal)
            ->where('fechainicio', '<=', $fechaActual)
            ->where('fechainicio', '>=', $fechaInicioMes)
            ->paginate(10);
        $total_monto_citas_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
            ->paginate(10);
        $total_monto_qr_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $total_monto_qr_lista_g = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->paginate(10);
        $total_inventario_qr_g =
            DB::table('registroinventarios')
                ->where('sucursal', Auth::user()->sucursal)
                ->where('estado', 'Activo')
                ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'compra')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
            DB::table('registroinventarios')
                ->where('sucursal', Auth::user()->sucursal)
                ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'farmacia')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $total_monto = DB::table('registropagos')
            ->where('iduser', Auth::user()->id)
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])

            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $total_inventario =
            DB::table('registroinventarios')
                ->where('iduser', Auth::user()->id)
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'compra')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
            DB::table('registroinventarios')
                ->where('iduser', Auth::user()->id)
                ->where('sucursal', Auth::user()->sucursal)
                ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'farmacia')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $gastoarea = DB::table('gastos')
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
            ->where('pertence', 'Caja')
            ->where('iduser', Auth::user()->id)
            ->where('fechainicio', '<=', $fechaActual)
            ->where('fechainicio', '>=', $fechaInicioMes)
            ->sum('cantidad');
        $total_monto_citas = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
            ->paginate(10);
        $total_monto_qr = DB::table('registropagos')
            ->where('iduser', Auth::user()->id)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->sum(DB::raw('CAST(monto AS DECIMAL(10, 2))'));
        $total_monto_qr_lista = DB::table('registropagos')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->paginate(10);
        $total_inventario_qr =
            DB::table('registroinventarios')
                ->where('iduser', Auth::user()->id)
                ->where('estado', 'Activo')
                ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'compra')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))')) +
            DB::table('registroinventarios')
                ->where('sucursal', Auth::user()->sucursal)
                ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
                ->where('fecha', '<=', $fechaActual)
                ->where('fecha', '>=', $fechaInicioMes)
                ->where('motivo', 'farmacia')
                ->sum(DB::raw('CAST(precio AS DECIMAL(10, 2))'));
        $total_inventario_pago = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%efectivo%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('motivo', 'compra')
            ->paginate(10);
        $total_inventario_pago_farmacia = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('motivo', 'farmacia')
            ->paginate(10);
        $total_inventario_pago_qr = DB::table('registroinventarios')
            ->where('sucursal', Auth::user()->sucursal)
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(modo) LIKE ?', ['%qr%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('motivo', 'compra')
            ->paginate(10);
        $historial_caja = DB::table('registrocajas')
            ->where('estado', 'Activo')
            ->whereRaw('LOWER(iduser) LIKE ?', ['%' . $usuarioseleccionado . '%'])
            ->where('fecha', '<=', $fechaActual)
            ->where('fecha', '>=', $fechaInicioMes)
            ->paginate(10);
    ?>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Inicio</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">HOTEL ROJAS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 0): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-Dashboard" wire:click="setOpcion(0)">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 1): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-Activity" wire:click="setOpcion(1)">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 2): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-agendado" wire:click="setOpcion(2)">Hospedaje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 3): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-gastos" wire:click="setOpcion(3)">Gastos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 4): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-caja" wire:click="setOpcion(4)">Historial de caja</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-4 section-body">
        <div class="container-fluid">
            <div class="clearfix row row-deck">
            </div>
            <div class="tab-content">
                <div class="tab-pane fade <?php if($opcion == 0): ?> show active <?php endif; ?>" id="admin-Dashboard"
                    role="tabpanel">
                    <iframe id="calendarioIframe" src="/calendario" frameborder="0"
                        style="height: 50vh; width:100%;"></iframe>
                    <div class="clearfix row row-deck">
                        <div>
                        </div>
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Personal de turno: <?php echo e(Auth::user()->sucursal); ?></h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                                class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Hr entrada</th>
                                                    <th>Hr salida</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $personales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td> <?php echo e(explode(' ', $item->name)[0]); ?></td>
                                                        <td><?php echo e($item->horainicio); ?></td>
                                                        <td><?php echo e($item->horafin); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if($opcion == 1): ?> show active <?php endif; ?>" id="admin-Activity"
                    role="tabpanel">
                    <div style="display: flex;">
                        <div style="margin-right: 1%;">
                            <label for="fecha-inicio">Desde:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-inicio"
                                class="form-control" wire:model="fechaInicioMes">
                        </div>
                        <div style="margin-right: 1%;">
                            <label for="fecha-actual">Hasta:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-actual"
                                class="form-control" wire:model="fechaActual">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Venta de productos (Efectivo)</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                                class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SUCURSAL</th>
                                                    <th>MONTO</th>
                                                    <th>PRODUCTO</th>
                                                    <th>CANTIDAD</th>
                                                    <th>RESPONSABLE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                        <div class="py-2 ml-2">
                                            <?php echo e($total_inventario_pago->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Venta de productos (QR)</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SUCURSAL</th>
                                                    <th>MONTO</th>
                                                    <th>PRODUCTO</th>
                                                    <th>CANTIDAD</th>
                                                    <th>RESPONSABLE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                        <div class="py-2 ml-2">
                                            <?php echo e($total_inventario_pago_qr->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Venta Directa</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SUCURSAL</th>
                                                    <th>MONTO</th>
                                                    <th>PRODUCTO</th>
                                                    <th>CANTIDAD</th>
                                                    <th>MEDIO</th>
                                                    <th>RESPONSABLE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                <?php $__currentLoopData = $total_inventario_pago_farmacia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $pagado = $pagado + $lista->precio;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($lista->sucursal); ?></td>
                                                        <td><?php echo e($lista->precio); ?></td>
                                                        <td><?php echo e($lista->nombreproducto); ?></td>
                                                        <td><?php echo e($lista->cantidad); ?></td>
                                                        <td><?php echo e($lista->modo); ?></td>
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
                                                    <td></td>
                                                    <td style="color: white"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="py-2 ml-2">
                                            <?php echo e($total_inventario_pago_farmacia->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if($opcion == 2): ?> show active <?php endif; ?>" id="admin-agendado"
                    role="tabpanel">
                    <div style="display: flex;">
                        <div style="margin-right: 1%;">
                            <label for="fecha-inicio">Desde:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-inicio"
                                class="form-control" wire:model="fechaInicioMes">
                        </div>
                        <div style="margin-right: 1%;">
                            <label for="fecha-actual">Hasta:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-actual"
                                class="form-control" wire:model="fechaActual">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Ingreso de hospedaje (Efectivo)</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>ID</th>
                                                    <th>MONTO</th>
                                                    <th>RESPONSABLE</th>
                                                    <th>CLIENTE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                        <div class="py-2 ml-2">
                                            <?php echo e($total_monto_citas->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Ingreso de hospedaje (QR)</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>ID</th>
                                                    <th>MONTO</th>
                                                    <th>RESPONSABLE</th>
                                                    <th>CLIENTE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                        <div class="py-2 ml-2">
                                            <?php echo e($total_monto_qr_lista->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade <?php if($opcion == 3): ?> show active <?php endif; ?>" id="admin-gastos"
                    role="tabpanel">
                    <div style="display: flex;">
                        <div style="margin-right: 1%;">
                            <label for="fecha-inicio">Desde:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-inicio"
                                class="form-control" wire:model="fechaInicioMes">
                        </div>
                        <div style="margin-right: 1%;">
                            <label for="fecha-actual">Hasta:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-actual"
                                class="form-control" wire:model="fechaActual">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Gastos realizados (QR + EFECTIVO)</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
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
                                            <tbody>
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
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="ELIMINAR" data-original-title="Edit"
                                                                wire:click="$emit('eliminarGastoMicaja',<?php echo e($lista->id); ?>)">
                                                                <svg class="icon-20" width="20"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.4"
                                                                        d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                                        fill="currentColor"></path>
                                                                    <path
                                                                        d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                                <span class="ms-1"
                                                                    style="font-size: 8px;">ELIMINAR</span>
                                                            </a></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                        <div class="py-2 ml-2">
                                            <?php echo e($gastoarealista->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if($opcion == 4): ?> show active <?php endif; ?>" id="admin-caja"
                    role="tabpanel">
                    <div style="display: flex;">
                        <div style="margin-right: 1%;">
                            <label for="fecha-inicio">Desde:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-inicio"
                                class="form-control" wire:model="fechaInicioMes">
                        </div>
                        <div style="margin-right: 1%;">
                            <label for="fecha-actual">Hasta:</label>
                            <input style="width: 100px; font-size:10px;" type="date" id="fecha-actual"
                                class="form-control" wire:model="fechaActual">
                        </div>
                        <div style="margin-right: 1%; font-size: 10px;">
                            <label for="fecha-actual">Responsable:</label>
                            <select class="form-control" wire:model="usuarioseleccionado" style="font-size: 10px;">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Historial de caja</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse"
                                            data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-fullscreen"
                                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                                class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped text-nowrap">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>QR RECIBIDO</th>
                                                    <th>EFECTIVO EN CAJA</th>
                                                    <th>HORA</th>
                                                    <th>FECHA</th>
                                                    <th>SUCURSAL</th>
                                                    <th>RESPONSABLE</th>

                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                <?php $__currentLoopData = $historial_caja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($lista->montoqr); ?></td>
                                                        <td><?php echo e($lista->montoefectivo); ?></td>
                                                        <td><?php echo e($lista->hora); ?></td>
                                                        <td><?php echo e($lista->fecha); ?></td>
                                                        <td><?php echo e($lista->sucursal); ?></td>
                                                        <td><?php echo e($lista->responsable); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        <div class="py-2 ml-2">
                                            <?php echo e($historial_caja->links()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/panel-inicio/ver-panel.blade.php ENDPATH**/ ?>