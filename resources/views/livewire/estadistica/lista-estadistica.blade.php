<div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="col-md-12 px-3">
        <div class="card px-2 py-5">
            <div class="mt-2 d-flex">
                @if (Auth::user()->rol == 'Jefe Marketing y Publicidad')
                    <button type="button"
                        class="mr-4 {{ $botonRecepcion === 'citas' ? 'btn btn-warning' : 'btn btn-outline-primary' }}"
                        wire:click="$set('botonRecepcion','citas')" style="flex:1;">
                        <div style="display: flex;">
                            HOSPEDAJE
                        </div>
                    </button>
                    <button type="button"
                        class="mr-4 {{ $botonRecepcion === 'tratamientos' ? 'btn btn-warning' : 'btn btn-outline-primary' }}"
                        wire:click="$set('botonRecepcion','tratamientos')" style="flex:1;">
                        <div style="display: flex;">
                            PRODUCTOS
                        </div>
                    </button>
                @else
                    <button type="button"
                        class="mr-4 {{ $botonRecepcion === 'pagos' ? 'btn btn-warning' : 'btn btn-outline-primary' }}"
                        wire:click="$set('botonRecepcion','pagos')" style="flex:1;">
                        <div style="display: flex;">
                            INGRESOS / GASTOS
                        </div>
                    </button>
                    <button type="button"
                        class="mr-4 {{ $botonRecepcion === 'citas' ? 'btn btn-warning' : 'btn btn-outline-primary' }}"
                        wire:click="$set('botonRecepcion','citas')" style="flex:1;">
                        <div style="display: flex;">
                            HOSPEDAJE
                        </div>
                    </button>
                @endif
            </div>
            @if ($botonRecepcion == 'pagos')
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
                            data: @json($sumaingresosdia)
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
                            categories: @json($diasDelMes)

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
                            data: @json($totalesPorMes)
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
                            categories: @json($meses)

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
                                {{ array_sum($sumafarmacia) }}
                            </td>
                            <td>
                                {{ array_sum($sumaingresos) }}
                            </td>
                            <td>
                                {{ array_sum($sumafarmacia) + array_sum($sumaingresos) }}
                            </td>
                            @php
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
                            @endphp
                            <td>
                                {{ array_sum($sumafarmacia) / $dias_pasados }}
                            </td>
                            <td>
                                {{ array_sum($sumaingresos) / $dias_pasados }}
                            </td>
                            <td>
                                {{ (array_sum($sumafarmacia) + array_sum($sumaingresos)) / $dias_pasados }}
                            </td>
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($botonRecepcion == 'citas')
                <h3 class="mt-4">HOSPEDADOS</h3>
                <div id="chartsucursalesagendados">
                </div>
                <script>
                    var options = {
                        series: [{
                            name: 'AGENDADOS',
                            data: @json($agendadoslist)
                        }, {
                            name: 'HOSPEDADOS',
                            data: @json($confirmadoslist)
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
                            categories: @json($diasDelMes),
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

                                @php
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
                                @endphp
                                {{ $promedio }}
                            </td>
                            <td>
                                @php
                                    $suma = array_sum($confirmadoslist);

                                    // Obtén la cantidad de elementos en el array
                                    $cantidad = count($confirmadoslist);

                                    // Calcula el promedio
                                    $promedio = $suma / $diasPasados;
                                @endphp
                                {{ $promedio }}
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
                            data: @json($citasagendas)
                        }, {
                            name: 'HOSPEDADOS',
                            data: @json($confirmadossucu)
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
                            categories: @json($areaslist),
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
            @endif
        </div>
    </div>

</div>
