<div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Contenido de tu página -->
    <style>
        .chart {
            width: 350px;
            /* Ancho deseado */
            height: 150px;
            /* Altura deseada */
        }
    </style>
    <?php
        $totalconfirmados = 0;
        $totalasistidos = 0;
    ?>

    <div class="flex-wrap mt-3 mb-2" style="display: flex;">
        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $hoy = date('Y-m-d');
                $agendados = DB::table('operativos')
                    ->where('area', 'ilike', '%' . $item->area)
                    ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                    ->where('estado', 'Pendiente')
                    ->count();
                $confirmados = DB::table('registropagos')
                    ->where('sucursal', 'ilike', '%' . $item->area)
                    ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                    ->distinct('idoperativo')
                    ->count();
                $totalconfirmados = $totalconfirmados + $agendados;
                $totalasistidos = $totalasistidos + $confirmados;
            ?>
            <div class="chart" id="chart<?php echo e($index); ?>">
                <h3><?php echo e($item->area); ?></h3>
            </div>
            <script>
                var options<?php echo e($index); ?> = {
                    series: [<?php echo json_encode($confirmados, 15, 512) ?>, <?php echo json_encode($agendados, 15, 512) ?>],
                    chart: {
                        width: 380,
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
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var chart<?php echo e($index); ?> = new ApexCharts(document.getElementById("chart<?php echo e($index); ?>"),
                    options<?php echo e($index); ?>);
                chart<?php echo e($index); ?>.render();
            </script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="ml-4">
        <div class="flex-wrap mt-3" style="display: flex;">
            <div id="chartx">
                <h3>TOTAL PACIENTES</h3>
            </div>
            <script>
                var options = {
                    series: [<?php echo json_encode($totalasistidos, 15, 512) ?>, <?php echo json_encode($totalconfirmados, 15, 512) ?>],
                    chart: {
                        width: 380,
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
    <div class="table-responsive">

        <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>CITAS ASISTIDAS</th>
                    <th>CITAS NO ASISTIDAS</th>
                    <th>TOTAL</th>
                    <th>PROMEDIO DE ASISTENCIA DIARIA</th>
                </tr>
            </thead>
            <tbody>
                <td>
                    <?php echo e($totalasistidos); ?>

                </td>
                <td>
                    <?php echo e($totalconfirmados); ?>

                </td>
                <td>
                    <?php echo e($totalasistidos + $totalconfirmados); ?>

                </td>
                <?php
                    $primer_dia_mes_actual = date('Y-m-01');

                    // Obtener la fecha actual
                    $fecha_actual = date('Y-m-d');

                    // Calcular la diferencia en segundos entre las dos fechas
                    $diferencia_segundos = strtotime($fecha_actual) - strtotime($primer_dia_mes_actual);

                    // Convertir la diferencia de segundos a días
                    $dias_pasados = floor($diferencia_segundos / (60 * 60 * 24));
                ?>
                <td>
                    <?php echo e($totalasistidos / $dias_pasados); ?>

                </td>
            </tbody>
        </table>
    </div>
    <h3 class="mt-4">INGRESOS CITAS/PRODUCTOS</h3>
    <div id="chartline">
    </div>
    <script>
        var options = {
            series: [{
                name: 'CITAS',
                group: 'ingresos',
                data: <?php echo json_encode($sumaingresos, 15, 512) ?>
            }, {
                name: 'PRODUCTOS',
                group: 'ingresos',
                data: <?php echo json_encode($sumafarmacia, 15, 512) ?>
            }, ],
            chart: {
                type: 'bar',
                height: 450,
                stacked: true,
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            plotOptions: {
                bar: {
                    horizontal: false
                }
            },
            xaxis: {
                categories: <?php echo json_encode($areaslist, 15, 512) ?>

            },
            fill: {
                opacity: 1
            },
            colors: ['#80c7fd', '#008FFB', '#80f1cb', '#00E396'],

            legend: {
                position: 'top',
                horizontalAlign: 'left'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartline"), options);
        chart.render();
    </script>
    <div class="table-responsive">

        <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>INGRESO PRODUCTOS</th>
                    <th>INGRESO POR CITAS</th>
                    <th>TOTAL</th>
                    <th>PROMEDIO INGRESO PRODUCTOS</th>
                    <th>PROMEDIO INGRESO CITAS</th>
                    <th>PROMEDIO INGRESO</th>
                </tr>
            </thead>
            <tbody>
                <td>
                    <?php echo e(array_sum($sumafarmacia)); ?>

                </td>
                <td>
                    <?php echo e(array_sum($sumaingresos)); ?>

                </td>
                <td>
                    <?php echo e(array_sum($sumafarmacia) + array_sum($sumaingresos)); ?>

                </td>
                <?php
                    $primer_dia_mes_actual = date('Y-m-01');

                    // Obtener la fecha actual
                    $fecha_actual = date('Y-m-d');

                    // Calcular la diferencia en segundos entre las dos fechas
                    $diferencia_segundos = strtotime($fecha_actual) - strtotime($primer_dia_mes_actual);

                    // Convertir la diferencia de segundos a días
                    $dias_pasados = floor($diferencia_segundos / (60 * 60 * 24));
                ?>
                <td>
                    <?php echo e(array_sum($sumafarmacia) / $dias_pasados); ?>

                </td>
                <td>
                    <?php echo e(array_sum($sumaingresos) / $dias_pasados); ?>

                </td>
                <td>
                    <?php echo e((array_sum($sumafarmacia) + array_sum($sumaingresos)) / $dias_pasados); ?>

                </td>
            </tbody>
        </table>
    </div>
    <div id="chartsucursales">
    </div>
    <script>
        var options = {
            series: <?php echo json_encode($areasmes, 15, 512) ?>,
            chart: {
                type: 'bar',
                height: 450
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($diasDelMes, 15, 512) ?>,
            },
            yaxis: {
                title: {
                    text: 'Ingreso en Bs.'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Ingreso: " + val + "Bs."
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartsucursales"), options);
        chart.render();
    </script>
    <div id="chartsucursalesdia"></div>
    <script>
        var options = {
            series: [{
                name: 'CITAS/PRODUCTOS',
                group: 'ingresos',
                data: <?php echo json_encode($sumaingresosdia, 15, 512) ?>
            }],
            chart: {
                type: 'bar',
                height: 450,
                stacked: true,
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            plotOptions: {
                bar: {
                    horizontal: false
                }
            },
            xaxis: {
                categories: <?php echo json_encode($diasDelMes, 15, 512) ?>

            },
            fill: {
                opacity: 1
            },
            colors: ['#80c7fd', '#008FFB', '#80f1cb', '#00E396'],

            legend: {
                position: 'top',
                horizontalAlign: 'left'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartsucursalesdia"), options);
        chart.render();
    </script>

    <h3 class="mt-4">AGENDADOS/ASISTIDOS</h3>
    <div id="chartsucursalesagendados">
    </div>
    <script>
        var options = {
            series: [{
                name: 'AGENDADOS',
                data: <?php echo json_encode($agendadoslist, 15, 512) ?>
            }, {
                name: 'ASISTIDOS',
                data: <?php echo json_encode($confirmadoslist, 15, 512) ?>
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($diasDelMes, 15, 512) ?>,
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartsucursalesagendados"), options);
        chart.render();
    </script>


    <h3 class="mt-4">AGENDADOS POR SUCURSAL</h3>
    <div id="chartsucursalesagendadossucu">
    </div>
    <script>
        var options = {
            series: [{
                name: 'AGENDADOS',
                data: <?php echo json_encode($citasagendas, 15, 512) ?>
            }, {
                name: 'ASISTIDOS',
                data: <?php echo json_encode($confirmadossucu, 15, 512) ?>
            }],

            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($areaslist, 15, 512) ?>,
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chartsucursalesagendadossucu"), options);
        chart.render();
    </script>
    <h3 class="mt-4">AGENDADOS/ASISTIDOS POR USUARIOS</h3>
    <div id="chartsucursalesagendadosuser">
    </div>
    <script>
        var options = {
            series: [{
                name: 'AGENDADOS',
                data: <?php echo json_encode($agendadoslistuser, 15, 512) ?>
            }, {
                name: 'ASISTIDOS',
                data: <?php echo json_encode($confirmadoslistuser, 15, 512) ?>
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($usuarioslist, 15, 512) ?>,
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartsucursalesagendadosuser"), options);
        chart.render();
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/estadistica/resumen.blade.php ENDPATH**/ ?>