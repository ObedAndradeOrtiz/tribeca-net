<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">LLAMADAS REALIZADAS/ AGENDADAS / ASITENCIA(DIARIO)</h4>
    <div style="height: 300px;">
        <canvas style="height: 100%; width: 100%;" id="densityCanvasllama"></canvas>
    </div>

    <script>
        var llamadas = {
            label: 'LLAMADAS',
            data: @json($llamadas),
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderColor: 'rgba(0, 99, 132, 1)',
        };
        var agendados = {
            label: 'AGENDADOS',
            data: @json($agendados),
            backgroundColor: 'rgba(99, 132, 0, 0.6)',
            borderColor: 'rgba(99, 132, 0, 1)',
        };

        var asistidos = {
            label: 'ASISTIDOS',
            data: @json($asistidos),
            backgroundColor: 'rgba(0, 0, 128, 0.6)', // Azul oscuro
            borderColor: 'rgba(0, 0, 128, 1)', // Azul brillante
        };
        var remarketing = {
            label: 'REMARKETING',
            data: @json($remarketing),
            backgroundColor: 'rgba(255, 165, 0, 0.6)', // Naranja oscuro
            borderColor: 'rgba(255, 165, 0, 1)', // Naranja brillante
        };

        var planetData = {
            labels: @json($areaslist),
            datasets: [llamadas, agendados, asistidos, remarketing]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvasllama");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>
    <h4 class="mt-4 ml-2">LLAMADAS REALIZADAS/ AGENDADAS / ASITENCIA(MES ACTUAL)</h4>
    <div style="height: 300px;">
        <canvas style="height: 100%; width: 100%;" id="densityCanvasllamames"></canvas>
    </div>
    <div class="table-responsive">

        <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>AGENDADOS <br> (POR <br> LLAMADAS)</th>
                    <th>AGENDADOS <br> (ACTIVOS)</th>
                    <th>AGENDADOS <br> (ELIMINADOS)</th>
                    <th>AGENDADOS <br> (ASISTIDOS)</th>
                    <th>INGRESO <br> (ASISTIDOS)</th>
                </tr>
            </thead>
            <tbody>
                <td>
                    @php
                        $promedio_1 = DB::table('calls')
                            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaActual])
                            ->where('estado', 'Pendiente')
                            ->count();
                    @endphp
                    {{ $promedio_1 }}
                </td>
                <td>
                    @php
                        $promedio_2 = DB::table('operativos')
                            ->join('calls', 'operativos.idllamada', '=', 'calls.id')
                            ->whereBetween('operativos.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->whereBetween('calls.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->count();
                    @endphp
                    {{ $promedio_2 }}
                </td>
                <td>
                    {{ $promedio_1 - $promedio_2 }}
                </td>
                <td>
                    @php
                        $promedio_3 = DB::table('operativos')
                            ->join('calls', 'operativos.idllamada', '=', 'calls.id')
                            ->whereBetween('operativos.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->whereBetween('calls.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                            ->count();
                    @endphp
                    {{ $promedio_3 . ' (' . ($promedio_3 * 100) / $promedio_2 . ')%' }}
                </td>
                <td>
                    @php
                        $promedio_4 = DB::table('operativos')
                            ->join('calls', 'operativos.idllamada', '=', 'calls.id')
                            ->whereBetween('operativos.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->whereBetween('calls.fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                            ->selectRaw('SUM(CAST(registropagos.monto AS DECIMAL(10, 2))) as total_monto')
                            ->value('total_monto');

                    @endphp
                    {{ $promedio_4 }}
                </td>
            </tbody>
        </table>
        {{-- <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>REMARKETING (UNA LLAMADA)</th>
                    <th> (ASISTIDOS)</th>
                    <th>INGRESO <br> (ASISTIDOS)</th>
                </tr>
            </thead>
            <tbody>
                <td>
                    @php
                        $registros = DB::table('registrollamadas')
                            ->whereBetween('fecha', [$this->fechaInicioMes, $this->fechaFinMes])
                            ->where('sucursal', '1')
                            ->distinct('registrollamadas.idllamada')
                            ->count();
                    @endphp
                    {{ $registros }}
                </td>
                <td>
                    @php

                        $cantidadCoincidencias = DB::table('operativos')
                            ->join('registrollamadas', 'operativos.idllamada', '=', 'registrollamadas.idllamada')
                            ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                            ->where('registrollamadas.sucursal', '1')
                            ->whereBetween('operativos.fecha', [$this->fechaInicioMes, $this->fechaActual])
                            ->distinct('registrollamadas.idllamada')
                            ->count();

                    @endphp
                    {{ $cantidadCoincidencias }}
                </td>
                <td>
                    @php

                        $pagostotal = DB::table('operativos')
                            ->join('registrollamadas', 'operativos.idllamada', '=', 'registrollamadas.idllamada')
                            ->join('registropagos', 'operativos.id', '=', 'registropagos.idoperativo')
                            ->where('registrollamadas.sucursal', '1')
                            ->whereBetween('operativos.fecha', [$this->fechaInicioMes, $this->fechaActual])
                            ->selectRaw('SUM(DISTINCT CAST(registropagos.monto AS DECIMAL(10, 2))) as total_monto')
                            ->value('total_monto');

                    @endphp
                    {{ $pagostotal }}
                </td>

            </tbody>
        </table> --}}
    </div>
    <script>
        var llamadas = {
            label: 'LLAMADAS',
            data: @json($mesllamadas),
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderColor: 'rgba(0, 99, 132, 1)',
        };
        var agendados = {
            label: 'AGENDADOS',
            data: @json($mesagendados),
            backgroundColor: 'rgba(99, 132, 0, 0.6)',
            borderColor: 'rgba(99, 132, 0, 1)',
        };

        var asistidos = {
            label: 'ASISTIDOS',
            data: @json($mesasistidos),
            backgroundColor: 'rgba(0, 0, 128, 0.6)', // Azul oscuro
            borderColor: 'rgba(0, 0, 128, 1)', // Azul brillante
        };
        var remarketing = {
            label: 'REMARKETING',
            data: @json($mesremarketing),
            backgroundColor: 'rgba(255, 165, 0, 0.6)', // Naranja oscuro
            borderColor: 'rgba(255, 165, 0, 1)', // Naranja brillante
        };

        var planetData = {
            labels: @json($areaslist),
            datasets: [llamadas, agendados, asistidos, remarketing]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvasllamames");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>
</div>
