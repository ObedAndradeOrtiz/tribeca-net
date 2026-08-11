<div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="col-md-12 px-3">
        <div class="card px-2 py-5">
            <div class="mt-2 d-flex">
                <?php if(Auth::user()->rol == 'Jefe Marketing y Publicidad'): ?>
                    <button type="button"
                        class="mr-4 <?php echo e($botonRecepcion === 'citas' ? 'btn btn-warning' : 'btn btn-outline-primary'); ?>"
                        wire:click="$set('botonRecepcion','citas')" style="flex:1;">
                        <div style="display: flex;">
                            HOSPEDAJE
                        </div>
                    </button>
                    <button type="button"
                        class="mr-4 <?php echo e($botonRecepcion === 'tratamientos' ? 'btn btn-warning' : 'btn btn-outline-primary'); ?>"
                        wire:click="$set('botonRecepcion','tratamientos')" style="flex:1;">
                        <div style="display: flex;">
                            PRODUCTOS
                        </div>
                    </button>
                <?php else: ?>
                    <button type="button"
                        class="mr-4 <?php echo e($botonRecepcion === 'pagos' ? 'btn btn-warning' : 'btn btn-outline-primary'); ?>"
                        wire:click="$set('botonRecepcion','pagos')" style="flex:1;">
                        <div style="display: flex;">
                            INGRESOS / GASTOS
                        </div>
                    </button>
                    <button type="button"
                        class="mr-4 <?php echo e($botonRecepcion === 'citas' ? 'btn btn-warning' : 'btn btn-outline-primary'); ?>"
                        wire:click="$set('botonRecepcion','citas')" style="flex:1;">
                        <div style="display: flex;">
                            HOSPEDAJE
                        </div>
                    </button>
                <?php endif; ?>
            </div>
            <?php if($botonRecepcion == 'pagos'): ?>
                <h3 class="mt-4">INGRESOS HOSPEDAJE/PRODUCTOS</h3>
                <div id="chartline">
                </div>
                <h3 class="mt-4">INGRESOS TOTAL</h3>
                <div id="chartsucursalesdia"></div>
                <script>
                    var options = {
                        series: [{
                            name: 'HOSPEDAJE/PRODUCTOS',
                            group: 'ingresos',
                            data: <?php echo json_encode($sumaingresosdia, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 450,
                            stacked: true,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
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
                <h3 class="mt-4">INGRESOS ANUAL</h3>
                <div id="chartingresoanual"></div>
                <script>
                    var options = {
                        series: [{
                            name: 'HOSPEDAJE/PRODUCTOS',
                            group: 'ingresos',
                            data: <?php echo json_encode($totalesPorMes, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 450,
                            stacked: true,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },

                        xaxis: {
                            categories: <?php echo json_encode($meses, 15, 512) ?>

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

                    var chart = new ApexCharts(document.querySelector("#chartingresoanual"), options);
                    chart.render();
                </script>
                <div class="table-responsive">

                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>INGRESO PRODUCTOS</th>
                                <th>INGRESO POR HOSPEDAJE</th>
                                <th>TOTAL</th>
                                <th>PROMEDIO INGRESO PRODUCTOS</th>
                                <th>PROMEDIO INGRESO HOSPEDAJE</th>
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
                                if ($dias_pasados == 0) {
                                    $dias_pasados = 1;
                                }
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
            <?php endif; ?>
            <?php if($botonRecepcion == 'citas'): ?>
                <h3 class="mt-4">HOSPEDADOS</h3>
                <div id="chartsucursalesagendados">
                </div>
                <script>
                    var options = {
                        series: [{
                            name: 'AGENDADOS',
                            data: <?php echo json_encode($agendadoslist, 15, 512) ?>
                        }, {
                            name: 'HOSPEDADOS',
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
                <div class="table-responsive">

                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>PROMEDIO AGENDADOS</th>
                                <th>PROMEDIO ASISTENCIA</th>


                            </tr>
                        </thead>
                        <tbody>
                            <td>

                                <?php
                                    $fechaInicial = date('Y-m-1');
                                    $fechaActual = date('Y-m-d');
                                    $datetimeInicial = new DateTime($fechaInicial);
                                    $datetimeActual = new DateTime($fechaActual);
                                    $diferencia = $datetimeInicial->diff($datetimeActual);
                                    $diasPasados = $diferencia->days;

                                    $suma = array_sum($agendadoslist);
                                    $cantidad = count($agendadoslist);
                                    // Calcula el promedio
                                    $promedio = $suma / $diasPasados;
                                ?>
                                <?php echo e($promedio); ?>

                            </td>
                            <td>
                                <?php
                                    $suma = array_sum($confirmadoslist);

                                    // Obtén la cantidad de elementos en el array
                                    $cantidad = count($confirmadoslist);

                                    // Calcula el promedio
                                    $promedio = $suma / $diasPasados;
                                ?>
                                <?php echo e($promedio); ?>

                            </td>
                        </tbody>
                    </table>
                </div>
                <h3 class="mt-4">HOSPEDADOS POR SUCURSAL</h3>
                <div id="chartsucursalesagendadossucu">
                </div>
                <script>
                    var options = {
                        series: [{
                            name: 'AGENDADOS',
                            data: <?php echo json_encode($citasagendas, 15, 512) ?>
                        }, {
                            name: 'HOSPEDADOS',
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
            <?php endif; ?>
        </div>
    </div>

</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/estadistica/lista-estadistica.blade.php ENDPATH**/ ?>