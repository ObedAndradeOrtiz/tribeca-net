<div class="">
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
                ->where('modo', 'ilike', '%Efectivo%')

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
                ->where('modo', 'ilike', '%Efectivo%')
                ->where('area', Auth::user()->sucursal)
                ->where('fecha', $hoy)
                ->sum('cantidad');
        }

    ?>
    <script>
        var miArray = <?php echo json_encode($pagados); ?>;

        var pagados = <?php echo json_encode($porpagar); ?>;
    </script>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1 ">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <div class="col-md-12 col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" data-aos="fade-up" data-aos-delay="1000">
                        <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                            <div class="header-title">
                                <?php if(Auth::user()->sesionsucursal == 0): ?>
                                    <h4 class="card-title">SUCURSAL: GENERAL</h4>
                                <?php else: ?>
                                    <h4 class="card-title">SUCURSAL: <?php echo e(Auth::user()->sucursal); ?></h4>
                                <?php endif; ?>
                                <?php if(Auth::user()->rol == 'Administrador'): ?>
                                    <h4 class="card-title"><?php echo e($total_monto_g + $total_inventario_g); ?> bs.
                                    </h4>
                                    <p class="mb-0">CAJA GENERAL</p>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="ml-4">
                                <div class="flex-wrap mt-3" style="display: flex;">
                                    <div id="chartx">

                                    </div>
                                    <script>
                                        var options = {
                                            series: [<?php echo json_encode($confirmados, 15, 512) ?>, <?php echo json_encode($restantes, 15, 512) ?>],
                                            chart: {
                                                width: 550,
                                                type: 'pie',
                                            },
                                            labels: ['ASISTIDOS', 'NO ASISTIDOS'],
                                            colors: ['#33FF74', '#FF5233'], // Colores para las dos opciones respectivamente
                                            responsive: [{
                                                breakpoint: 480,
                                                options: {
                                                    chart: {
                                                        width: 200
                                                    },
                                                    legend: {
                                                        position: 'left'
                                                    }
                                                }
                                            }]
                                        };
                                        var chartx = new ApexCharts(document.getElementById("chartx"),
                                            options);
                                        chartx.render();
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card" data-aos="fade-up" data-aos-delay="900">
                        <div class="card-body">
                            <div class="flex-wrap mb-4 d-flex align-itmes-center justify-content-between">
                                <div class="d-flex align-itmes-center me-0 me-md-4">
                                    <div>
                                        <div class="p-3 mb-2 rounded bg-soft-primary">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <?php
                                            $total_monto = DB::table('operativos')
                                                ->where('encargado', Auth::user()->name)
                                                ->count();
                                        ?>
                                        <h5><?php echo e($agendados); ?></h5>
                                        <small class="mb-0">Agendados realizados</small>
                                    </div>
                                </div>
                                <div class="d-flex align-itmes-center">
                                </div>


                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-delay="500">
                            <div class="text-center card-body d-flex justify-content-around">
                                <div>
                                    <h2 class="mb-2"><small>
                                            <?php echo e($confirmados); ?>


                                        </small></h2>
                                    <p class="mb-0 text-gray"> ASISTIDOS</p>
                                </div>
                                <hr class="hr-vertial">
                                <div>
                                    <h2 class="mb-2"><?php echo e($restantes); ?> </h2>
                                    <p class="mb-0 text-gray">NO ASISTIDOS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="600">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="mb-2 card-title">Proximas 5 Citas</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                    $operativos_count = DB::table('operativos')->where('estado', 'Pendiente')->count();
                                    $hoy = date('Y-m-d');
                                    $horaActual = date('H:i');
                                    $operativos = DB::table('operativos')
                                        ->where('estado', 'Pendiente')
                                        ->where('fecha', $hoy)
                                        ->where('hora', '>=', $horaActual)
                                        ->where('area', Auth::user()->sucursal)
                                        ->limit(5) // Limitar los resultados a 10 registros
                                        ->OrderBy('hora')
                                        ->get();
                                ?>
                                <?php if($operativos_count == 0): ?>
                                    <h6 style="color: gray">No hay citas siguientes</h6>
                                <?php else: ?>
                                    <?php $__currentLoopData = $operativos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operativo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2 d-flex profile-media align-items-top">
                                            <div class="mt-1 profile-dots-pills border-primary"></div>
                                            <div class="ms-4">
                                                <h6 class="mb-1 "><?php echo e($operativo->empresa); ?></h6>
                                                <span
                                                    class="mb-0"><?php echo e($operativo->fecha . ' ' . $operativo->hora); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/panel-inicio/ver-panel.blade.php ENDPATH**/ ?>