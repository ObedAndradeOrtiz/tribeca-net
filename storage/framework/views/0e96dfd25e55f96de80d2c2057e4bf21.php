<div>
    
    <div class="stats-page">

        <div class="stats-header">
            <div>
                <span class="stats-kicker">Panel estadístico</span>
                <h2>Estadísticas de auditoría financiera</h2>
                <p>
                    Indicadores visuales de ingresos, egresos, saldos, deudores e irregularidades del Sistema Tribeca.
                </p>
            </div>

            <div class="stats-filters">
                <div class="stats-filter">
                    <label>Año</label>
                    <select wire:model="anio">
                        <?php for($y = 2024; $y <= 2030; $y++): ?>
                            <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="stats-filter">
                    <label>Mes</label>
                    <select wire:model="mes">
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>"><?php echo e($this->nombreMes($m)); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="anio,mes,cargarEstadisticas">
            <div class="stats-loading">
                Actualizando estadísticas...
            </div>
        </div>

        <div class="stats-kpi-grid" wire:loading.remove wire:target="anio,mes,cargarEstadisticas">

            <div class="stats-kpi success">
                <span>Ingresos del mes</span>
                <strong>Bs <?php echo e(number_format($totalIngresosMes, 2)); ?></strong>
                <small><?php echo e($this->nombreMes((int) $mes)); ?> <?php echo e($anio); ?></small>
            </div>

            <div class="stats-kpi danger">
                <span>Egresos del mes</span>
                <strong>Bs <?php echo e(number_format($totalEgresosMes, 2)); ?></strong>
                <small><?php echo e($this->nombreMes((int) $mes)); ?> <?php echo e($anio); ?></small>
            </div>

            <div class="stats-kpi dark">
                <span>Saldo del mes</span>
                <strong>Bs <?php echo e(number_format($saldoMes, 2)); ?></strong>
                <small>Ingresos menos egresos</small>
            </div>

            <div class="stats-kpi warning">
                <span>Deuda total</span>
                <strong>Bs <?php echo e(number_format($totalDeuda, 2)); ?></strong>
                <small><?php echo e($cantidadDeudores); ?> departamentos deudores</small>
            </div>

            <div class="stats-kpi info">
                <span>Ingresos pendientes</span>
                <strong>Bs <?php echo e(number_format($montoIngresosPendientes, 2)); ?></strong>
                <small><?php echo e($ingresosPendientes); ?> movimientos pendientes</small>
            </div>

            <div class="stats-kpi orange">
                <span>Egresos sin comprobante</span>
                <strong>Bs <?php echo e(number_format($montoEgresosSinComprobante, 2)); ?></strong>
                <small><?php echo e($egresosSinComprobante); ?> registros sin archivo</small>
            </div>

        </div>

        <div class="stats-chart-grid" wire:ignore wire:loading.remove wire:target="anio,mes,cargarEstadisticas">

            <div class="stats-card wide">
                <div class="stats-card-head">
                    <div>
                        <h4>Ingresos vs egresos por mes</h4>
                        <p>Comparativo mensual de la gestión <?php echo e($anio); ?>.</p>
                    </div>
                </div>
                <div class="chart-box tall">
                    <canvas id="chartSaldoMensual"></canvas>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Comparativo del mes</h4>
                        <p><?php echo e($this->nombreMes((int) $mes)); ?> <?php echo e($anio); ?></p>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartComparativoMes"></canvas>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Ingresos especiales</h4>
                        <p>Expensas, gestión anterior, salón y otros ingresos.</p>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartIngresosEspeciales"></canvas>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Estado de departamentos</h4>
                        <p>Pagados, parciales, pendientes y no cobrables.</p>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartEstadoDepartamentos"></canvas>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Irregularidades detectadas</h4>
                        <p>Registros que requieren revisión administrativa.</p>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartIrregularidades"></canvas>
                </div>
            </div>

            <div class="stats-card wide">
                <div class="stats-card-head">
                    <div>
                        <h4>Top deudores por departamento</h4>
                        <p>Departamentos con mayor deuda acumulada hasta la fecha seleccionada.</p>
                    </div>
                </div>
                <div class="chart-box tall">
                    <canvas id="chartTopDeudores"></canvas>
                </div>
            </div>

        </div>

        <div class="stats-bottom-grid" wire:loading.remove wire:target="anio,mes,cargarEstadisticas">

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Resumen anual</h4>
                        <p>Totales generales de la gestión <?php echo e($anio); ?>.</p>
                    </div>
                </div>

                <div class="stats-number-list">
                    <div>
                        <span>Ingresos gestión</span>
                        <strong class="green">Bs <?php echo e(number_format($totalIngresosAnio, 2)); ?></strong>
                    </div>

                    <div>
                        <span>Egresos gestión</span>
                        <strong class="red">Bs <?php echo e(number_format($totalEgresosAnio, 2)); ?></strong>
                    </div>

                    <div>
                        <span>Saldo gestión</span>
                        <strong class="<?php echo e($saldoAnio >= 0 ? 'green' : 'red'); ?>">
                            Bs <?php echo e(number_format($saldoAnio, 2)); ?>

                        </strong>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Resumen histórico</h4>
                        <p>Desde agosto 2024 hasta la fecha actual.</p>
                    </div>
                </div>

                <div class="stats-number-list">
                    <div>
                        <span>Ingresos históricos</span>
                        <strong class="green">Bs <?php echo e(number_format($totalIngresosGeneral, 2)); ?></strong>
                    </div>

                    <div>
                        <span>Egresos históricos</span>
                        <strong class="red">Bs <?php echo e(number_format($totalEgresosGeneral, 2)); ?></strong>
                    </div>

                    <div>
                        <span>Saldo histórico</span>
                        <strong class="<?php echo e($saldoGeneral >= 0 ? 'green' : 'red'); ?>">
                            Bs <?php echo e(number_format($saldoGeneral, 2)); ?>

                        </strong>
                    </div>
                </div>
            </div>

        </div>

        <div class="stats-table-grid" wire:loading.remove wire:target="anio,mes,cargarEstadisticas">

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Top deudores</h4>
                        <p>Lista rápida para cobranza.</p>
                    </div>
                </div>

                <div class="stats-table-wrap">
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Meses</th>
                                <th class="text-end">Deuda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topDeudores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($item['departamento']); ?></strong></td>
                                    <td><?php echo e($item['meses_deuda']); ?></td>
                                    <td class="text-end red">
                                        Bs <?php echo e(number_format($item['total_deuda'], 2)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="empty-stats">
                                        No existen deudores hasta la fecha seleccionada.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-head">
                    <div>
                        <h4>Departamentos con revisión</h4>
                        <p>Deuda, pagos parciales, pendientes o no cobrables.</p>
                    </div>
                </div>

                <div class="stats-table-wrap">
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th class="text-end">Deuda</th>
                                <th>P</th>
                                <th>Pen.</th>
                                <th>No cob.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $departamentosIrregulares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($item['departamento']); ?></strong></td>
                                    <td class="text-end red">
                                        Bs <?php echo e(number_format($item['deuda'], 2)); ?>

                                    </td>
                                    <td><?php echo e($item['parciales']); ?></td>
                                    <td><?php echo e($item['pendientes']); ?></td>
                                    <td><?php echo e($item['no_cobrables']); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="empty-stats">
                                        No existen departamentos con revisión.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartSaldoMensual = null;
        let chartComparativoMes = null;
        let chartIngresosEspeciales = null;
        let chartEstadoDepartamentos = null;
        let chartIrregularidades = null;
        let chartTopDeudores = null;

        function moneyLabel(value) {
            return 'Bs ' + Number(value || 0).toLocaleString('es-BO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function destroyChart(chart) {
            if (chart) {
                chart.destroy();
            }
        }

        function renderEstadisticas(data) {
            destroyChart(chartSaldoMensual);
            destroyChart(chartComparativoMes);
            destroyChart(chartIngresosEspeciales);
            destroyChart(chartEstadoDepartamentos);
            destroyChart(chartIrregularidades);
            destroyChart(chartTopDeudores);

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw || 0;
                                return context.dataset.label + ': ' + moneyLabel(value);
                            }
                        }
                    }
                }
            };

            const saldoCanvas = document.getElementById('chartSaldoMensual');
            if (saldoCanvas) {
                chartSaldoMensual = new Chart(saldoCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.saldoMensual.labels,
                        datasets: [{
                                label: 'Ingresos',
                                data: data.saldoMensual.ingresos
                            },
                            {
                                label: 'Egresos',
                                data: data.saldoMensual.egresos
                            },
                            {
                                label: 'Saldo',
                                data: data.saldoMensual.saldos,
                                type: 'line',
                                tension: .35
                            }
                        ]
                    },
                    options: {
                        ...commonOptions,
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value) {
                                        return 'Bs ' + Number(value).toLocaleString('es-BO');
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const comparativoCanvas = document.getElementById('chartComparativoMes');
            if (comparativoCanvas) {
                chartComparativoMes = new Chart(comparativoCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.comparativoMes.labels,
                        datasets: [{
                            label: 'Monto',
                            data: data.comparativoMes.data
                        }]
                    },
                    options: commonOptions
                });
            }

            const ingresosEspecialesCanvas = document.getElementById('chartIngresosEspeciales');
            if (ingresosEspecialesCanvas) {
                chartIngresosEspeciales = new Chart(ingresosEspecialesCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: data.ingresosEspeciales.labels,
                        datasets: [{
                            label: 'Monto',
                            data: data.ingresosEspeciales.data
                        }]
                    },
                    options: commonOptions
                });
            }

            const estadoCanvas = document.getElementById('chartEstadoDepartamentos');
            if (estadoCanvas) {
                chartEstadoDepartamentos = new Chart(estadoCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: data.estadoDepartamentos.labels,
                        datasets: [{
                            label: 'Departamentos',
                            data: data.estadoDepartamentos.data
                        }]
                    },
                    options: {
                        ...commonOptions,
                        plugins: {
                            ...commonOptions.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const irregularidadesCanvas = document.getElementById('chartIrregularidades');
            if (irregularidadesCanvas) {
                chartIrregularidades = new Chart(irregularidadesCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.irregularidades.labels,
                        datasets: [{
                            label: 'Cantidad',
                            data: data.irregularidades.data
                        }]
                    },
                    options: {
                        ...commonOptions,
                        plugins: {
                            ...commonOptions.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const topDeudoresCanvas = document.getElementById('chartTopDeudores');
            if (topDeudoresCanvas) {
                chartTopDeudores = new Chart(topDeudoresCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.topDeudores.labels,
                        datasets: [{
                            label: 'Deuda',
                            data: data.topDeudores.data
                        }]
                    },
                    options: {
                        ...commonOptions,
                        indexAxis: 'y',
                        scales: {
                            x: {
                                ticks: {
                                    callback: function(value) {
                                        return 'Bs ' + Number(value).toLocaleString('es-BO');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        document.addEventListener('livewire:load', function() {
            renderEstadisticas({
                ingresosMensuales: <?php echo json_encode($chartIngresosMensuales, 15, 512) ?>,
                egresosMensuales: <?php echo json_encode($chartEgresosMensuales, 15, 512) ?>,
                saldoMensual: <?php echo json_encode($chartSaldoMensual, 15, 512) ?>,
                comparativoMes: <?php echo json_encode($chartComparativoMes, 15, 512) ?>,
                ingresosEspeciales: <?php echo json_encode($chartIngresosEspeciales, 15, 512) ?>,
                estadoDepartamentos: <?php echo json_encode($chartEstadoDepartamentos, 15, 512) ?>,
                topDeudores: <?php echo json_encode($chartTopDeudores, 15, 512) ?>,
                irregularidades: <?php echo json_encode($chartIrregularidades, 15, 512) ?>,
            });

            Livewire.on('estadisticasActualizadas', function(data) {
                setTimeout(function() {
                    renderEstadisticas(data);
                }, 150);
            });
        });
    </script>
    <style>
        .stats-page {
            display: grid;
            gap: 14px;
        }

        .stats-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .stats-kicker {
            display: inline-flex;
            margin-bottom: 6px;
            font-size: 11px;
            font-weight: 950;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .stats-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 950;
            color: #0f172a;
        }

        .stats-header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .stats-filters {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stats-filter {
            display: grid;
            gap: 5px;
        }

        .stats-filter label {
            font-size: 11px;
            color: #64748b;
            font-weight: 950;
            text-transform: uppercase;
        }

        .stats-filter select {
            height: 38px;
            min-width: 150px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 0 12px;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            font-weight: 900;
            outline: none;
        }

        .stats-loading {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 900;
        }

        .stats-kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 12px;
        }

        .stats-kpi {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 15px;
            min-height: 105px;
        }

        .stats-kpi span {
            display: block;
            font-size: 10.5px;
            font-weight: 950;
            color: #64748b;
            text-transform: uppercase;
        }

        .stats-kpi strong {
            display: block;
            margin-top: 7px;
            font-size: 19px;
            font-weight: 950;
            color: #0f172a;
            line-height: 1.12;
        }

        .stats-kpi small {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 800;
        }

        .stats-kpi.success strong,
        .green {
            color: #047857 !important;
        }

        .stats-kpi.danger strong,
        .red {
            color: #dc2626 !important;
        }

        .stats-kpi.warning strong {
            color: #b45309 !important;
        }

        .stats-kpi.info strong {
            color: #1d4ed8 !important;
        }

        .stats-kpi.orange strong {
            color: #c2410c !important;
        }

        .stats-chart-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .stats-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .stats-card.wide {
            grid-column: span 2;
        }

        .stats-card-head {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .stats-card-head h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 950;
            color: #0f172a;
        }

        .stats-card-head p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .chart-box {
            height: 310px;
            padding: 14px;
        }

        .chart-box.tall {
            height: 380px;
        }

        .stats-bottom-grid,
        .stats-table-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .stats-number-list {
            padding: 14px;
            display: grid;
            gap: 10px;
        }

        .stats-number-list div {
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .stats-number-list span {
            font-size: 12px;
            font-weight: 900;
            color: #64748b;
        }

        .stats-number-list strong {
            font-size: 15px;
            font-weight: 950;
            color: #0f172a;
            text-align: right;
        }

        .stats-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 10.5px;
            font-weight: 950;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .stats-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            color: #111827;
            vertical-align: middle;
        }

        .stats-table td strong {
            font-weight: 950;
        }

        .text-end {
            text-align: right;
        }

        .empty-stats {
            text-align: center;
            color: #64748b;
            font-weight: 800;
            padding: 18px !important;
        }

        @media (max-width: 1400px) {
            .stats-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1050px) {

            .stats-chart-grid,
            .stats-bottom-grid,
            .stats-table-grid {
                grid-template-columns: 1fr;
            }

            .stats-card.wide {
                grid-column: span 1;
            }
        }

        @media (max-width: 760px) {
            .stats-header {
                align-items: stretch;
                flex-direction: column;
            }

            .stats-filters {
                width: 100%;
            }

            .stats-filter {
                flex: 1;
            }

            .stats-filter select {
                width: 100%;
            }

            .stats-kpi-grid {
                grid-template-columns: 1fr;
            }

            .chart-box,
            .chart-box.tall {
                height: 330px;
            }

            .stats-number-list div {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats-number-list strong {
                text-align: left;
            }
        }

        @media (max-width: 520px) {
            .stats-header h2 {
                font-size: 20px;
            }

            .stats-card,
            .stats-header,
            .stats-kpi {
                border-radius: 16px;
            }

            .stats-table {
                min-width: 620px;
            }
        }
    </style>
</div>
<?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/livewire/tesoreria/estadisticas-auditoria.blade.php ENDPATH**/ ?>