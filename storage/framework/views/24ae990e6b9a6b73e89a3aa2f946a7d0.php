<div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
    <div class="col-md-12">
        <div class="card">
            <div class="mt-2 ml-4 mr-4 d-flex">
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
                <?php
                    $index = 0;
                ?>
                






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
                <script>
                    var options = {
                        series: [{
                            name: 'HOSPEDAJE',
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

                <div style="display:flex;">
                    <div style="width: 50%;">
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    document.getElementById('myButton').click();
                                }, 1);
                            });
                        </script>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-diario')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-0');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                    <div style="width: 50%;">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-gasto-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-1');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-gasto-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
                <div style="display:flex;">
                    <div style="width: 50%;">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-2');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                    <div style="width: 50%;">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-mensual')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-3');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-mensual');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.ingresodinamico')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-4');
} else {
    $response = \Livewire\Livewire::mount('estadistica.ingresodinamico');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.mes-general')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-5');
} else {
    $response = \Livewire\Livewire::mount('estadistica.mes-general');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
            <?php if($botonRecepcion == 'citas'): ?>
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
                <h3 class="mt-4">AGENDADOS/ASISTIDOS POR SUCURSAL</h3>
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
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-6');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-semanal-agendados')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-7');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
            <?php if($botonRecepcion == 'llamadas'): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-diario')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-8');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-9');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-10');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos')->html();
} elseif ($_instance->childHasBeenRendered('l2044213162-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l2044213162-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2044213162-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2044213162-11');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos');
    $html = $response->html();
    $_instance->logRenderedChild('l2044213162-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
            <?php if($botonRecepcion == 'tratamientos'): ?>
                <h3 class="mt-4">TOP TRATAMIENTOS(MES ACTUAL)</h3>
                <div id="charttratamientos"></div>
                <script>
                    var options = {
                        series: [{
                            data: <?php echo json_encode($cantidades, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 800
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: <?php echo json_encode($nombretratamientos, 15, 512) ?>
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#charttratamientos"), options);
                    chart.render();
                </script>
                <h3 class="mt-4">TOP 10 PRODUCTOS MAS VENDIDOS(MES ACTUAL)</h3>
                <div id="chartproductos"></div>
                <style>
                    .apexcharts-xaxis-label {
                        font-size: 10px;
                        /* Ajusta el tamaño de la letra aquí */
                        font-family: 'Helvetica, Arial, sans-serif';
                        font-weight: bold;
                    }
                </style>
                <script>
                    var options = {
                        series: [{
                            data: <?php echo json_encode($cantidadesproductos, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 800
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: <?php echo json_encode($nombreproductos, 15, 512) ?>,
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#chartproductos"), options);
                    chart.render();
                </script>
                <h3 class="mt-4">TOP VENDODORAS DEL MES(CANTIDAD DE VENTAS)</h3>
                <div id="chartproductosvendidos"></div>
                <script>
                    var options = {
                        series: [{
                            data: <?php echo json_encode($cantidadvendido, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: <?php echo json_encode($nombrevendedoras, 15, 512) ?>,
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#chartproductosvendidos"), options);
                    chart.render();
                </script>
                <h3 class="mt-4">TOP VENDEDORAS (MAYOR INGRESO)DEL MES</h3>
                <div id="chartproductosvendidosingreso"></div>
                <script>
                    var options = {
                        series: [{
                            data: <?php echo json_encode($cantidadmasvendido, 15, 512) ?>
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: <?php echo json_encode($nombremasobtenido, 15, 512) ?>,
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#chartproductosvendidosingreso"), options);
                    chart.render();
                </script>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/estadistica/lista-estadistica.blade.php ENDPATH**/ ?>