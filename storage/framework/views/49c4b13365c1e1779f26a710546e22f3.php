<div>
    <div class="dashboard-page">

        <div class="dashboard-header">
            <div>
                <span class="dashboard-kicker">Panel administrativo</span>
                <h2>Resumen general de Tribeca</h2>
                <p>
                    Vista rápida para cobranza, regularización bancaria y control mensual.
                </p>
            </div>

            <div class="dashboard-filters">
                <div class="dash-filter">
                    <label>Año</label>
                    <select wire:model="anio">
                        <?php for($y = 2024; $y <= 2028; $y++): ?>
                            <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="dash-filter">
                    <label>Mes</label>
                    <select wire:model="mes">
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>"><?php echo e($this->nombreMes($m)); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="anio,mes,cargarPanel">
            <div class="dashboard-loading">
                Actualizando panel...
            </div>
        </div>

        <div class="dashboard-kpi-grid" wire:loading.remove wire:target="anio,mes,cargarPanel">

            <div class="dashboard-kpi danger">
                <div class="kpi-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <span>Deudores hasta la fecha</span>
                    <strong><?php echo e($totalDeudores); ?></strong>
                    <small>Total deuda: Bs <?php echo e(number_format($totalDeuda, 2)); ?></small>
                </div>
            </div>

            <div class="dashboard-kpi success">
                <div class="kpi-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <span>Ingresos del mes</span>
                    <strong>Bs <?php echo e(number_format($totalIngresosMes, 2)); ?></strong>
                    <small><?php echo e($this->nombreMes((int) $mes)); ?> <?php echo e($anio); ?></small>
                </div>
            </div>

            <div class="dashboard-kpi warning">
                <div class="kpi-icon">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <span>Egresos del mes</span>
                    <strong>Bs <?php echo e(number_format($totalEgresosMes, 2)); ?></strong>
                    <small><?php echo e($this->nombreMes((int) $mes)); ?> <?php echo e($anio); ?></small>
                </div>
            </div>

            <div class="dashboard-kpi dark">
                <div class="kpi-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <span>Saldo del mes</span>
                    <strong>Bs <?php echo e(number_format($saldoMes, 2)); ?></strong>
                    <small>Ingresos menos egresos</small>
                </div>
            </div>

            <div class="dashboard-kpi info">
                <div class="kpi-icon">
                    <i class="bi bi-bank"></i>
                </div>
                <div>
                    <span>Ingresos pendientes</span>
                    <strong><?php echo e($ingresosPendientes); ?></strong>
                    <small>Bs <?php echo e(number_format($montoIngresosPendientes, 2)); ?> por revisar</small>
                </div>
            </div>

        </div>

        <div class="dashboard-main-grid" wire:loading.remove wire:target="anio,mes,cargarPanel">

            <div class="dashboard-card large">
                <div class="card-head">
                    <div>
                        <h4>Lista priorizada de deudores</h4>
                        <p>Departamentos con saldo pendiente hasta <?php echo e($this->nombreMes((int) $mes)); ?>

                            <?php echo e($anio); ?>.</p>
                    </div>

                    <span class="card-badge danger">
                        <?php echo e(count($deudores)); ?> visibles
                    </span>
                </div>

                <div class="debt-table-wrap">
                    <table class="debt-table">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Meses</th>
                                <th>Primer mes</th>
                                <th class="text-end">Deuda</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $deudores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($item['departamento']); ?></strong>
                                    </td>

                                    <td>
                                        <?php echo e($item['meses_deuda']); ?>

                                    </td>

                                    <td>
                                        <?php if($item['primer_mes_deuda']): ?>
                                            <?php echo e(\Carbon\Carbon::parse($item['primer_mes_deuda'])->format('m/Y')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-end debt-amount">
                                        Bs <?php echo e(number_format($item['total_deuda'], 2)); ?>

                                    </td>

                                    <td>
                                        <span class="priority priority-<?php echo e(strtolower($item['prioridad'])); ?>">
                                            <?php echo e($item['prioridad']); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-dashboard">
                                            No existen deudores hasta la fecha seleccionada.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-side">

                <div class="dashboard-card">
                    <div class="card-head simple">
                        <div>
                            <h4>Alertas administrativas</h4>
                            <p>Indicadores para tomar acción.</p>
                        </div>
                    </div>

                    <div class="alert-list">
                        <?php $__currentLoopData = $anuncios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="admin-alert <?php echo e($item['tipo']); ?>">
                                <strong><?php echo e($item['titulo']); ?></strong>
                                <span><?php echo e($item['detalle']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-head simple">
                        <div>
                            <h4>Departamentos para verificar</h4>
                            <p>Pagos parciales, no cobrables o casos especiales.</p>
                        </div>
                    </div>

                    <div class="verify-list">
                        <?php $__empty_1 = true; $__currentLoopData = $departamentosVerificar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="verify-item <?php echo e($item['nivel']); ?>">
                                <div>
                                    <strong><?php echo e($item['departamento']); ?></strong>
                                    <span><?php echo e($item['tipo']); ?> · <?php echo e($item['mes']); ?></span>
                                    <small><?php echo e($item['detalle']); ?></small>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-dashboard">
                                No hay departamentos marcados para verificar.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="dashboard-bottom-grid" wire:loading.remove wire:target="anio,mes,cargarPanel">

            <div class="dashboard-card">
                <div class="card-head">
                    <div>
                        <h4>Ingresos bancarios pendientes</h4>
                        <p>Depósitos del mes que aún requieren regularización.</p>
                    </div>

                    <span class="card-badge warning">
                        Bs <?php echo e(number_format($montoIngresosPendientes, 2)); ?>

                    </span>
                </div>

                <div class="pending-income-list">
                    <?php $__empty_1 = true; $__currentLoopData = $ultimosIngresosPendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="pending-income-item">
                            <div>
                                <strong><?php echo e($item['depositante']); ?></strong>
                                <span>
                                    <?php echo e(\Carbon\Carbon::parse($item['fecha'])->format('d/m/Y')); ?>

                                    <?php echo e($item['hora']); ?>

                                    · Comp. <?php echo e($item['numero_comprobante'] ?: 'Sin comprobante'); ?>

                                </span>
                            </div>

                            <div class="pending-income-amount">
                                Bs <?php echo e(number_format($item['saldo_pendiente'], 2)); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="empty-dashboard">
                            No hay ingresos pendientes para este mes.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-head simple">
                    <div>
                        <h4>Recomendaciones de acción</h4>
                        <p>Orden sugerido para el trabajo administrativo diario.</p>
                    </div>
                </div>

                <div class="task-list">
                    <div class="task-item">
                        <span>1</span>
                        <div>
                            <strong>Regularizar ingresos pendientes</strong>
                            <small>Aplicar depósitos bancarios antes de llamar a deudores.</small>
                        </div>
                    </div>

                    <div class="task-item">
                        <span>2</span>
                        <div>
                            <strong>Contactar prioridad alta</strong>
                            <small>Revisar primero departamentos con más meses o mayor deuda.</small>
                        </div>
                    </div>

                    <div class="task-item">
                        <span>3</span>
                        <div>
                            <strong>Verificar casos especiales</strong>
                            <small>Pagos parciales, no cobrables y observaciones administrativas.</small>
                        </div>
                    </div>

                    <div class="task-item">
                        <span>4</span>
                        <div>
                            <strong>Comparar ingresos y egresos</strong>
                            <small>Validar si el mes mantiene saldo positivo.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <style>
        .dashboard-page {
            display: grid;
            gap: 14px;
        }

        .dashboard-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .dashboard-kicker {
            display: inline-flex;
            margin-bottom: 6px;
            font-size: 11px;
            font-weight: 950;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 950;
            color: #0f172a;
        }

        .dashboard-header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .dashboard-filters {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .dash-filter {
            display: grid;
            gap: 5px;
        }

        .dash-filter label {
            font-size: 11px;
            color: #64748b;
            font-weight: 950;
            text-transform: uppercase;
        }

        .dash-filter select {
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

        .dashboard-loading {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 900;
        }

        .dashboard-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .dashboard-kpi {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-height: 112px;
        }

        .kpi-icon {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .dashboard-kpi span {
            display: block;
            font-size: 10.5px;
            font-weight: 950;
            color: #64748b;
            text-transform: uppercase;
        }

        .dashboard-kpi strong {
            display: block;
            margin-top: 6px;
            font-size: 20px;
            font-weight: 950;
            color: #0f172a;
            line-height: 1.1;
        }

        .dashboard-kpi small {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 800;
        }

        .dashboard-kpi.danger .kpi-icon {
            background: #fee2e2;
            color: #b91c1c;
        }

        .dashboard-kpi.danger strong {
            color: #b91c1c;
        }

        .dashboard-kpi.success .kpi-icon {
            background: #dcfce7;
            color: #047857;
        }

        .dashboard-kpi.success strong {
            color: #047857;
        }

        .dashboard-kpi.warning .kpi-icon {
            background: #fef3c7;
            color: #b45309;
        }

        .dashboard-kpi.warning strong {
            color: #b45309;
        }

        .dashboard-kpi.dark .kpi-icon {
            background: #e2e8f0;
            color: #0f172a;
        }

        .dashboard-kpi.info .kpi-icon {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .dashboard-kpi.info strong {
            color: #1d4ed8;
        }

        .dashboard-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(340px, .75fr);
            gap: 14px;
        }

        .dashboard-bottom-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(340px, .75fr);
            gap: 14px;
        }

        .dashboard-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .dashboard-card.large {
            min-height: 430px;
        }

        .dashboard-side {
            display: grid;
            gap: 14px;
        }

        .card-head {
            padding: 15px 16px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .card-head.simple {
            display: block;
        }

        .card-head h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 950;
            color: #0f172a;
        }

        .card-head p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .card-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .card-badge.danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .card-badge.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .debt-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .debt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .debt-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 10.5px;
            font-weight: 950;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .debt-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            color: #111827;
            vertical-align: middle;
        }

        .debt-table td strong {
            font-weight: 950;
        }

        .text-end {
            text-align: right;
        }

        .debt-amount {
            font-weight: 950;
            color: #b91c1c;
        }

        .priority {
            display: inline-flex;
            border-radius: 999px;
            padding: 4px 8px;
            font-size: 10.5px;
            font-weight: 950;
        }

        .priority-alta {
            background: #fee2e2;
            color: #b91c1c;
        }

        .priority-media {
            background: #fef3c7;
            color: #92400e;
        }

        .priority-baja {
            background: #dcfce7;
            color: #15803d;
        }

        .alert-list,
        .verify-list,
        .pending-income-list,
        .task-list {
            padding: 12px;
            display: grid;
            gap: 9px;
        }

        .admin-alert {
            border-radius: 15px;
            padding: 11px 12px;
            border: 1px solid #e5e7eb;
        }

        .admin-alert strong {
            display: block;
            font-size: 13px;
            font-weight: 950;
        }

        .admin-alert span {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.35;
        }

        .admin-alert.danger {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .admin-alert.warning {
            background: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }

        .admin-alert.success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .verify-item {
            border-radius: 15px;
            padding: 11px 12px;
            border: 1px solid #e5e7eb;
        }

        .verify-item strong {
            display: block;
            font-size: 13px;
            font-weight: 950;
            color: #0f172a;
        }

        .verify-item span {
            display: block;
            margin-top: 3px;
            font-size: 11.5px;
            font-weight: 900;
            color: #64748b;
        }

        .verify-item small {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
        }

        .verify-item.warning {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .verify-item.info {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .pending-income-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            padding: 10px 12px;
        }

        .pending-income-item strong {
            display: block;
            font-size: 13px;
            font-weight: 950;
            color: #0f172a;
        }

        .pending-income-item span {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
        }

        .pending-income-amount {
            flex-shrink: 0;
            color: #b45309;
            font-size: 13px;
            font-weight: 950;
        }

        .task-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            padding: 11px;
        }

        .task-item>span {
            width: 26px;
            height: 26px;
            border-radius: 10px;
            background: #0f172a;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 950;
            flex-shrink: 0;
        }

        .task-item strong {
            display: block;
            font-size: 13px;
            font-weight: 950;
            color: #0f172a;
        }

        .task-item small {
            display: block;
            margin-top: 3px;
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            line-height: 1.35;
        }

        .empty-dashboard {
            padding: 18px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        @media (max-width: 1300px) {
            .dashboard-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .dashboard-main-grid,
            .dashboard-bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 850px) {
            .dashboard-header {
                align-items: stretch;
                flex-direction: column;
            }

            .dashboard-filters {
                width: 100%;
            }

            .dash-filter {
                flex: 1;
            }

            .dash-filter select {
                width: 100%;
            }

            .dashboard-kpi-grid {
                grid-template-columns: 1fr;
            }

            .pending-income-item {
                align-items: flex-start;
                flex-direction: column;
            }

            .pending-income-amount {
                width: 100%;
                text-align: left;
            }
        }

        @media (max-width: 560px) {
            .dashboard-header h2 {
                font-size: 20px;
            }

            .dashboard-card,
            .dashboard-header,
            .dashboard-kpi {
                border-radius: 16px;
            }

            .debt-table {
                min-width: 620px;
            }
        }
    </style>
</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tesoreria/panel-inicial.blade.php ENDPATH**/ ?>