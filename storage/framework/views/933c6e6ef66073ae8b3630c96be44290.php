<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Auditoría General Tribeca</title>

    <style>
        @page {
            margin: 90px 34px 60px 34px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -68px;
            left: 0;
            right: 0;
            height: 58px;
            border-bottom: 2px solid #111827;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-title {
            font-size: 17px;
            font-weight: bold;
            color: #111827;
        }

        .header-subtitle {
            margin-top: 3px;
            font-size: 9px;
            color: #475569;
        }

        .header-right {
            text-align: right;
            font-size: 9px;
            color: #475569;
        }

        .footer {
            position: fixed;
            bottom: -38px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #cbd5e1;
            padding-top: 7px;
            font-size: 8px;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-right {
            text-align: right;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            color: #0f172a;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 15px;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #cbd5e1;
        }

        h3 {
            font-size: 12px;
            margin-bottom: 6px;
        }

        p {
            margin: 0 0 8px 0;
            line-height: 1.45;
            text-align: justify;
        }

        .page-break {
            page-break-after: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .cover {
            padding-top: 65px;
            text-align: center;
        }

        .cover-box {
            border: 2px solid #111827;
            padding: 28px 34px;
            border-radius: 10px;
        }

        .cover-kicker {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: .06em;
            margin-bottom: 12px;
        }

        .cover-title {
            font-size: 28px;
            font-weight: bold;
            color: #111827;
            line-height: 1.15;
            margin-bottom: 14px;
        }

        .cover-subtitle {
            font-size: 14px;
            font-weight: bold;
            color: #334155;
            margin-bottom: 22px;
        }

        .cover-period {
            display: inline-block;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 26px;
        }

        .cover-info {
            width: 72%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: left;
            font-size: 10px;
        }

        .cover-info td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 6px;
        }

        .cover-info .label {
            width: 34%;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
        }

        .cover-info .value {
            color: #111827;
            font-weight: bold;
        }

        .section {
            margin-bottom: 14px;
        }

        .note-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }

        .note-box strong {
            color: #0f172a;
        }

        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin-bottom: 12px;
        }

        .kpi {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            background: #ffffff;
        }

        .kpi-label {
            display: block;
            font-size: 7.5px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kpi-value {
            display: block;
            font-size: 14px;
            color: #111827;
            font-weight: bold;
        }

        .green {
            color: #047857 !important;
        }

        .red {
            color: #dc2626 !important;
        }

        .blue {
            color: #1d4ed8 !important;
        }

        .orange {
            color: #c2410c !important;
        }

        .dark {
            color: #111827 !important;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 12px;
        }

        table.data th {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 5px 4px;
            font-size: 7.2px;
            text-transform: uppercase;
            text-align: left;
        }

        table.data td {
            border: 1px solid #e5e7eb;
            padding: 5px 4px;
            vertical-align: top;
            font-size: 7.6px;
            line-height: 1.28;
            word-wrap: break-word;
        }

        table.data tfoot td {
            background: #f8fafc;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .muted {
            color: #94a3b8;
        }

        .small {
            font-size: 7px;
            color: #64748b;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 9px;
            font-size: 7px;
            font-weight: bold;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-dark {
            background: #e2e8f0;
            color: #0f172a;
        }

        .summary-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .summary-list td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            font-size: 9px;
        }

        .summary-list .label {
            width: 55%;
            color: #475569;
            font-weight: bold;
        }

        .summary-list .value {
            text-align: right;
            font-weight: bold;
            color: #111827;
        }

        .conclusion-box {
            border: 1px solid #111827;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 10px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 34px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            padding: 0 26px;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 1px solid #111827;
            padding-top: 6px;
            font-size: 9px;
            font-weight: bold;
        }

        .signature-sub {
            margin-top: 3px;
            font-size: 8px;
            color: #64748b;
        }

        .index-list {
            margin: 0;
            padding-left: 16px;
            line-height: 1.7;
            font-size: 10px;
        }

        .two-col {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .two-col td {
            width: 50%;
            vertical-align: top;
        }

        .mini-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            background: #ffffff;
        }

        .mini-box h4 {
            font-size: 10px;
            margin-bottom: 6px;
        }

        .mini-box p {
            font-size: 8.5px;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    <?php
        $ingresosSinComprobante = $data['ingresos_sin_comprobante'] ?? collect();
        $egresosSinComprobante = $data['egresos_sin_comprobante'] ?? collect();
        $departamentosResumen = collect($data['departamentos_resumen'] ?? []);
        $departamentosConIrregularidad = $departamentosResumen->where('tiene_irregularidad', true)->values();
        $departamentosSinIrregularidad = $departamentosResumen->where('tiene_irregularidad', false)->values();
        $irregularidades = collect($data['irregularidades'] ?? []);

        $textoRango = ($rango['texto_inicio'] ?? '') . ' a ' . ($rango['texto_fin'] ?? '');

        $totalIngresos = (float) ($data['total_ingresos'] ?? 0);
        $totalEgresos = (float) ($data['total_egresos'] ?? 0);
        $saldoFinal = (float) ($data['saldo_final'] ?? 0);
        $totalSalon = (float) ($data['total_alquiler_salon'] ?? 0);
        $totalOtros = (float) ($data['total_otros_ingresos'] ?? 0);
        $totalGestionAnterior = (float) ($data['total_gestion_anterior'] ?? 0);

        $totalDepartamentosRevisados = (int) ($data['total_departamentos_revisados'] ?? $departamentosResumen->count());
        $totalDeptosIrregulares =
            (int) ($data['departamentos_con_irregularidad'] ?? $departamentosConIrregularidad->count());
        $totalDeptosSinIrregularidad =
            (int) ($data['departamentos_sin_irregularidad'] ?? $departamentosSinIrregularidad->count());
    ?>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="header-title">Auditoría General del Sistema Tribeca</div>
                    <div class="header-subtitle">
                        Periodo auditado: <?php echo e($textoRango); ?>

                    </div>
                </td>
                <td class="header-right">
                    Generado: <?php echo e($fechaGeneracion); ?><br>
                    Sistema Tribeca · Digitbol
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td><?php echo e($footer); ?></td>
                <td class="footer-right">Documento interno de control y verificación administrativa</td>
            </tr>
        </table>
    </div>

    
    <div class="cover">
        <div class="cover-box">
            <div class="cover-kicker">Documento de auditoría y verificación digital</div>

            <div class="cover-title">
                Auditoría General del Sistema Tribeca
            </div>

            <div class="cover-subtitle">
                Auditoría y digitalización de registros financieros históricos
            </div>

            <div class="cover-period">
                Periodo auditado: <?php echo e($textoRango); ?>

            </div>

            <table class="cover-info">
                <tr>
                    <td class="label">Auditor / Responsable</td>
                    <td class="value"><?php echo e($auditor['nombre'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Carnet de identidad</td>
                    <td class="value"><?php echo e($auditor['carnet'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Cargo / Rol</td>
                    <td class="value"><?php echo e($auditor['cargo'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Fecha de realización</td>
                    <td class="value">
                        <?php if(!empty($auditor['fecha_realizacion'])): ?>
                            <?php echo e(\Carbon\Carbon::parse($auditor['fecha_realizacion'])->format('d/m/Y')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">Inicio del trabajo</td>
                    <td class="value">
                        <?php if(!empty($auditor['trabajo_inicio'])): ?>
                            <?php echo e(\Carbon\Carbon::parse($auditor['trabajo_inicio'])->format('d/m/Y')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">Fin del trabajo</td>
                    <td class="value">
                        <?php if(!empty($auditor['trabajo_fin'])): ?>
                            <?php echo e(\Carbon\Carbon::parse($auditor['trabajo_fin'])->format('d/m/Y')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>Índice del informe</h2>

        <ol class="index-list">
            <li>Datos generales de la auditoría</li>
            <li>Alcance y metodología aplicada</li>
            <li>Resumen financiero general</li>
            <li>Resumen de ingresos especiales</li>
            <li>Resumen de egresos y documentos sin comprobante</li>
            <li>Resumen por departamentos</li>
            <li>Departamentos con irregularidades o saldos pendientes</li>
            <li>Departamentos sin observaciones relevantes</li>
            <li>Hallazgos administrativos</li>
            <li>Conclusión y cierre del informe</li>
        </ol>
    </div>

    <div class="section">
        <h2>1. Datos generales de la auditoría</h2>

        <table class="summary-list">
            <tr>
                <td class="label">Responsable de auditoría</td>
                <td class="value"><?php echo e($auditor['nombre'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td class="label">Carnet de identidad</td>
                <td class="value"><?php echo e($auditor['carnet'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td class="label">Cargo / Rol</td>
                <td class="value"><?php echo e($auditor['cargo'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td class="label">Periodo auditado</td>
                <td class="value"><?php echo e($textoRango); ?></td>
            </tr>
            <tr>
                <td class="label">Rango exacto de fechas</td>
                <td class="value">
                    <?php echo e(\Carbon\Carbon::parse($rango['fecha_inicio'])->format('d/m/Y')); ?>

                    al
                    <?php echo e(\Carbon\Carbon::parse($rango['fecha_fin'])->format('d/m/Y')); ?>

                </td>
            </tr>
            <tr>
                <td class="label">Fecha de generación del documento</td>
                <td class="value"><?php echo e($fechaGeneracion); ?></td>
            </tr>
        </table>

        <div class="note-box">
            <p>
                El presente documento deja constancia de la revisión realizada sobre los registros financieros
                digitalizados en el Sistema Tribeca. La auditoría comprende ingresos bancarios, aplicaciones de pagos
                a expensas, saldos por departamento, egresos registrados, comprobantes disponibles, registros especiales
                y observaciones administrativas generadas dentro del periodo auditado.
            </p>
        </div>

        <?php if(!empty($auditor['observaciones'])): ?>
            <div class="note-box">
                <strong>Observaciones generales registradas por el auditor:</strong>
                <p><?php echo e($auditor['observaciones']); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>2. Alcance y metodología aplicada</h2>

        <p>
            La revisión fue realizada con base en la información registrada dentro del Sistema Tribeca,
            considerando como fecha inicial de auditoría el mes de <strong><?php echo e($rango['texto_inicio']); ?></strong>
            y como fecha final el mes de <strong><?php echo e($rango['texto_fin']); ?></strong>.
        </p>

        <p>
            Para la elaboración del informe se tomaron en cuenta las expensas generadas por departamento,
            los ingresos bancarios cargados al sistema, los pagos aplicados a cada mes, los descuentos por pronto pago,
            los registros asignados a gestiones anteriores, los ingresos por alquiler de salón, otros ingresos,
            los egresos registrados y los movimientos que requieren verificación documental.
        </p>

        <p>
            La metodología aplicada consistió en revisar la consistencia de los registros disponibles,
            agrupar los movimientos por periodo y departamento, comparar montos cobrados contra saldos pendientes,
            identificar pagos fuera de fecha, pagos parciales, registros sin comprobante y casos especiales que puedan
            requerir seguimiento administrativo.
        </p>

        <table class="two-col">
            <tr>
                <td>
                    <div class="mini-box">
                        <h4>Criterios revisados</h4>
                        <p>
                            Saldos pendientes, pagos aplicados, pagos fuera de fecha límite, descuentos de pronto pago,
                            registros no cobrables, pagos parciales, ingresos pendientes y comprobantes faltantes.
                        </p>
                    </div>
                </td>
                <td>
                    <div class="mini-box">
                        <h4>Objetivo del informe</h4>
                        <p>
                            Presentar un respaldo administrativo del estado financiero del edificio, útil para futuras
                            auditorías, revisiones contables y seguimiento de cobranza por departamento.
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="section avoid-break">
        <h2>3. Resumen financiero general</h2>

        <table class="kpi-table">
            <tr>
                <td class="kpi">
                    <span class="kpi-label">Total ingresos auditados</span>
                    <span class="kpi-value green">Bs <?php echo e(number_format($totalIngresos, 2)); ?></span>
                </td>

                <td class="kpi">
                    <span class="kpi-label">Total egresos auditados</span>
                    <span class="kpi-value red">Bs <?php echo e(number_format($totalEgresos, 2)); ?></span>
                </td>

                <td class="kpi">
                    <span class="kpi-label">Saldo neto del periodo</span>
                    <span class="kpi-value <?php echo e($saldoFinal >= 0 ? 'green' : 'red'); ?>">
                        Bs <?php echo e(number_format($saldoFinal, 2)); ?>

                    </span>
                </td>

                <td class="kpi">
                    <span class="kpi-label">Departamentos revisados</span>
                    <span class="kpi-value dark"><?php echo e($totalDepartamentosRevisados); ?></span>
                </td>
            </tr>
        </table>

        <table class="summary-list">
            <tr>
                <td class="label">Departamentos con irregularidad, deuda u observación</td>
                <td class="value red"><?php echo e($totalDeptosIrregulares); ?></td>
            </tr>
            <tr>
                <td class="label">Departamentos sin observaciones relevantes</td>
                <td class="value green"><?php echo e($totalDeptosSinIrregularidad); ?></td>
            </tr>
            <tr>
                <td class="label">Ingresos destinados o asociados a gestión anterior</td>
                <td class="value orange">Bs <?php echo e(number_format($totalGestionAnterior, 2)); ?></td>
            </tr>
            <tr>
                <td class="label">Ingresos por alquiler de salón</td>
                <td class="value blue">Bs <?php echo e(number_format($totalSalon, 2)); ?></td>
            </tr>
            <tr>
                <td class="label">Otros ingresos identificados</td>
                <td class="value dark">Bs <?php echo e(number_format($totalOtros, 2)); ?></td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>4. Resumen de ingresos especiales</h2>

        <p>
            Esta sección agrupa ingresos que no corresponden únicamente a expensas ordinarias del mes,
            incluyendo registros asociados a gestión anterior, alquiler de salón y otros ingresos identificados
            dentro del sistema.
        </p>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 45%;">Concepto</th>
                    <th style="width: 25%;" class="text-right">Monto</th>
                    <th style="width: 30%;">Criterio de identificación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ingresos asociados a gestión anterior</td>
                    <td class="text-right">Bs <?php echo e(number_format($totalGestionAnterior, 2)); ?></td>
                    <td>Registros sin departamento directo o con observación de gestión anterior</td>
                </tr>
                <tr>
                    <td>Ingresos por alquiler de salón</td>
                    <td class="text-right">Bs <?php echo e(number_format($totalSalon, 2)); ?></td>
                    <td>Tipo de aplicación, detalle u observación relacionada con salón</td>
                </tr>
                <tr>
                    <td>Otros ingresos</td>
                    <td class="text-right">Bs <?php echo e(number_format($totalOtros, 2)); ?></td>
                    <td>Intereses, efectivo/otros u otros registros clasificados</td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <div class="section">
        <h2>5. Documentos sin comprobante o con respaldo incompleto</h2>

        <h3>5.1 Ingresos sin comprobante</h3>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 10%;">Hora</th>
                    <th style="width: 30%;">Depositante</th>
                    <th style="width: 18%;">Comprobante</th>
                    <th style="width: 22%;">Detalle</th>
                    <th style="width: 10%;" class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $ingresosSinComprobante; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if(!empty($item->fecha)): ?>
                                <?php echo e(\Carbon\Carbon::parse($item->fecha)->format('d/m/Y')); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->hora ?? '-'); ?></td>
                        <td><?php echo e($item->depositante ?? '-'); ?></td>
                        <td><?php echo e($item->numero_comprobante ?? 'Sin comprobante'); ?></td>
                        <td><?php echo e($item->detalle ?? '-'); ?></td>
                        <td class="text-right">Bs <?php echo e(number_format((float) ($item->monto ?? 0), 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center muted">
                            No se detectaron ingresos sin comprobante dentro del periodo auditado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>5.2 Egresos sin comprobante</h3>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 14%;">Fecha</th>
                    <th style="width: 34%;">Detalle / Empresa</th>
                   
                    <th style="width: 14%;">Estado</th>
                    <th style="width: 10%;" class="text-right">Cantidad</th>

                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $egresosSinComprobante; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php
                                $fechaEgreso = $item->fechainicio ?? ($item->fecha ?? ($item->created_at ?? null));
                            ?>

                            <?php if($fechaEgreso): ?>
                                <?php echo e(\Carbon\Carbon::parse($fechaEgreso)->format('d/m/Y')); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->empresa ?? 'Gasto registrado'); ?></td>
                       
                        <td><?php echo e($item->estado ?? '-'); ?></td>
                        <td class="text-right">Bs <?php echo e(number_format((float) ($item->cantidad ?? 0), 2)); ?></td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center muted">
                            No se detectaron egresos sin comprobante dentro del periodo auditado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>6. Resumen por departamentos</h2>

        <p>
            La siguiente tabla consolida los departamentos revisados dentro del periodo auditado,
            mostrando deuda acumulada, meses pendientes, pagos fuera de fecha, pagos con descuento,
            pagos anticipados o fuera de mes y observaciones detectadas.
        </p>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 15%;">Departamento</th>
                    <th style="width: 9%;" class="text-right">Deuda</th>
                    <th style="width: 7%;" class="text-center">Meses deuda</th>
                    <th style="width: 7%;" class="text-center">Parciales</th>
                    <th style="width: 7%;" class="text-center">Pendientes</th>
                    <th style="width: 8%;" class="text-center">No cobrables</th>
                    <th style="width: 9%;" class="text-center">Fuera fecha</th>
                    <th style="width: 9%;" class="text-center">Con descuento</th>
                    <th style="width: 10%;" class="text-center">Desc. observ.</th>
                    <th style="width: 10%;" class="text-center">Fuera de mes</th>
                    <th style="width: 9%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $departamentosResumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($item['departamento']); ?></strong></td>

                        <td class="text-right">
                            Bs <?php echo e(number_format((float) ($item['total_deuda'] ?? 0), 2)); ?>

                        </td>

                        <td class="text-center"><?php echo e($item['meses_con_deuda'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['meses_parciales'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['meses_pendientes'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['meses_no_cobrables'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['pagos_fuera_fecha'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['pagos_con_descuento'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['descuentos_observados'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['pagos_anticipados_fuera_mes'] ?? 0); ?></td>

                        <td>
                            <?php if(!empty($item['tiene_irregularidad'])): ?>
                                <span class="badge badge-warning">Revisar</span>
                            <?php else: ?>
                                <span class="badge badge-success">Sin obs.</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" class="text-center muted">
                            No existen departamentos para el periodo auditado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>7. Departamentos con irregularidades, deuda u observaciones</h2>

        <p>
            Se consideran dentro de esta sección los departamentos que presentan saldo pendiente,
            pagos parciales, pagos fuera de fecha límite, descuentos observados, meses pendientes,
            pagos anticipados o registros que requieren verificación adicional.
        </p>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 18%;">Departamento</th>
                    <th style="width: 12%;" class="text-right">Deuda</th>
                    <th style="width: 12%;" class="text-center">Meses deuda</th>
                    <th style="width: 14%;" class="text-center">Pagos fuera fecha</th>
                    <th style="width: 14%;" class="text-center">Descuentos observados</th>
                    <th style="width: 14%;" class="text-center">Pagos fuera de mes</th>
                    <th style="width: 16%;">Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $departamentosConIrregularidad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($item['departamento']); ?></strong></td>
                        <td class="text-right">Bs <?php echo e(number_format((float) ($item['total_deuda'] ?? 0), 2)); ?></td>
                        <td class="text-center"><?php echo e($item['meses_con_deuda'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['pagos_fuera_fecha'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['descuentos_observados'] ?? 0); ?></td>
                        <td class="text-center"><?php echo e($item['pagos_anticipados_fuera_mes'] ?? 0); ?></td>
                        <td>
                            <?php if(($item['total_deuda'] ?? 0) > 0): ?>
                                Presenta saldo pendiente.
                            <?php elseif(($item['pagos_fuera_fecha'] ?? 0) > 0): ?>
                                Tiene pagos fuera de fecha límite.
                            <?php elseif(($item['descuentos_observados'] ?? 0) > 0): ?>
                                Requiere revisión de descuento.
                            <?php elseif(($item['pagos_anticipados_fuera_mes'] ?? 0) > 0): ?>
                                Presenta pagos aplicados fuera del mes correspondiente.
                            <?php else: ?>
                                Requiere verificación administrativa.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center muted">
                            No se detectaron departamentos con irregularidades dentro del periodo auditado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($irregularidades->count() > 0): ?>
        <div class="section">
            <h2>8. Irregularidades detalladas</h2>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width: 16%;">Departamento</th>
                        <th style="width: 14%;">Tipo</th>
                        <th style="width: 16%;">Periodo</th>
                        <th style="width: 34%;">Detalle</th>
                        <th style="width: 10%;" class="text-right">Monto</th>
                        <th style="width: 10%;">Nivel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $irregularidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item['departamento'] ?? '-'); ?></td>
                            <td><?php echo e($item['tipo'] ?? '-'); ?></td>
                            <td><?php echo e($item['periodo'] ?? '-'); ?></td>
                            <td><?php echo e($item['detalle'] ?? '-'); ?></td>
                            <td class="text-right">
                                Bs <?php echo e(number_format((float) ($item['monto'] ?? 0), 2)); ?>

                            </td>
                            <td>
                                <span class="badge badge-warning">
                                    <?php echo e($item['nivel'] ?? 'Revisión'); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>9. Departamentos sin observaciones relevantes</h2>

        <p>
            La siguiente lista corresponde a departamentos que, según los registros disponibles en el sistema,
            no presentan deuda pendiente ni observaciones críticas dentro del periodo auditado.
        </p>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 40%;">Departamento</th>
                    <th style="width: 20%;" class="text-right">Deuda</th>
                    <th style="width: 20%;" class="text-center">Meses con deuda</th>
                    <th style="width: 20%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $departamentosSinIrregularidad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($item['departamento']); ?></strong></td>
                        <td class="text-right">Bs <?php echo e(number_format((float) ($item['total_deuda'] ?? 0), 2)); ?></td>
                        <td class="text-center"><?php echo e($item['meses_con_deuda'] ?? 0); ?></td>
                        <td><span class="badge badge-success">Sin observación</span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center muted">
                            No se registraron departamentos sin observaciones relevantes para este periodo.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="section">
        <h2>10. Hallazgos administrativos</h2>

        <table class="summary-list">
            <tr>
                <td class="label">Departamentos revisados</td>
                <td class="value"><?php echo e($totalDepartamentosRevisados); ?></td>
            </tr>
            <tr>
                <td class="label">Departamentos con revisión recomendada</td>
                <td class="value red"><?php echo e($totalDeptosIrregulares); ?></td>
            </tr>
            <tr>
                <td class="label">Departamentos sin observaciones críticas</td>
                <td class="value green"><?php echo e($totalDeptosSinIrregularidad); ?></td>
            </tr>
            <tr>
                <td class="label">Cantidad de ingresos sin comprobante</td>
                <td class="value orange"><?php echo e($ingresosSinComprobante->count()); ?></td>
            </tr>
            <tr>
                <td class="label">Cantidad de egresos sin comprobante</td>
                <td class="value orange"><?php echo e($egresosSinComprobante->count()); ?></td>
            </tr>
        </table>

        <div class="note-box">
            <p>
                Los hallazgos aquí presentados fueron generados a partir de los datos actualmente disponibles
                en el sistema. Cualquier diferencia documental, comprobante físico no cargado o movimiento bancario
                pendiente de aplicación deberá ser contrastado con respaldo externo antes de considerarse como
                observación definitiva.
            </p>
        </div>
    </div>

    <div class="page-break"></div>

    
    <div class="section">
        <h2>11. Conclusión de auditoría</h2>

        <div class="conclusion-box">
            <p>
                Con base en la revisión realizada al periodo comprendido entre
                <strong><?php echo e($rango['texto_inicio']); ?></strong> y <strong><?php echo e($rango['texto_fin']); ?></strong>,
                se verificaron registros de ingresos, egresos, pagos aplicados a expensas, saldos pendientes,
                registros especiales y observaciones administrativas dentro del Sistema Tribeca.
            </p>

            <p>
                El sistema refleja un total de ingresos auditados de
                <strong>Bs <?php echo e(number_format($totalIngresos, 2)); ?></strong>,
                egresos auditados por
                <strong>Bs <?php echo e(number_format($totalEgresos, 2)); ?></strong>,
                y un saldo neto del periodo de
                <strong>Bs <?php echo e(number_format($saldoFinal, 2)); ?></strong>.
            </p>

            <p>
                Se revisaron <strong><?php echo e($totalDepartamentosRevisados); ?></strong> departamentos,
                de los cuales <strong><?php echo e($totalDeptosIrregulares); ?></strong> presentan deuda, irregularidad
                u observación administrativa, mientras que
                <strong><?php echo e($totalDeptosSinIrregularidad); ?></strong> no presentan observaciones relevantes
                según la información registrada en el sistema.
            </p>

            <p>
                La presente auditoría permite dejar respaldo de la digitalización y verificación de datos históricos,
                facilitando futuras revisiones contables, administrativas o de cobranza. Se recomienda mantener
                la actualización mensual de ingresos, egresos, comprobantes y observaciones para conservar la
                trazabilidad
                del sistema.
            </p>
        </div>
    </div>

    <div class="section">
        <h2>12. Cierre y conformidad</h2>

        <p>
            El presente informe fue generado como respaldo interno del proceso de auditoría y verificación digital.
            Su contenido se basa en los registros cargados al Sistema Tribeca hasta la fecha de generación indicada.
            El responsable que firma deja constancia de haber revisado los datos disponibles en el rango señalado.
        </p>

        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-line">
                        <?php echo e($auditor['nombre'] ?? 'Auditor / Responsable'); ?>

                    </div>
                    <div class="signature-sub">
                        C.I. <?php echo e($auditor['carnet'] ?? '-'); ?><br>
                        <?php echo e($auditor['cargo'] ?? 'Responsable de auditoría'); ?>

                    </div>
                </td>

                <td>
                    <div class="signature-line">
                        Administración Tribeca
                    </div>
                    <div class="signature-sub">
                        Sistema Tribeca · Digitbol<br>
                        Fecha: <?php echo e($fechaGeneracion); ?>

                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
<?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/pdf/auditoria-general-tribeca.blade.php ENDPATH**/ ?>