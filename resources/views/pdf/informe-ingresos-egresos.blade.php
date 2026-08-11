<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }} - {{ $nombreMes }} {{ $anio }}</title>

    <style>
        @page {
            margin: 90px 28px 55px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin: 0;
        }

        .header-subtitle {
            font-size: 10px;
            color: #475569;
            margin-top: 4px;
        }

        .header-right {
            text-align: right;
            font-size: 10px;
            color: #475569;
        }

        .footer {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            height: 28px;
            border-top: 1px solid #cbd5e1;
            padding-top: 7px;
            font-size: 9px;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-right {
            text-align: right;
        }

        .kpi-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .kpi {
            border: 1px solid #d1d5db;
            padding: 8px;
            border-radius: 6px;
        }

        .kpi-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }

        .kpi-value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 3px;
        }

        .green {
            color: #047857;
        }

        .red {
            color: #dc2626;
        }

        .dark {
            color: #111827;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.report th {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 5px 4px;
            font-size: 7.8px;
            text-transform: uppercase;
            text-align: left;
        }

        table.report td {
            border: 1px solid #e5e7eb;
            padding: 5px 4px;
            vertical-align: top;
            font-size: 8px;
            line-height: 1.25;
            word-wrap: break-word;
        }

        table.report tfoot td {
            background: #f8fafc;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .muted {
            color: #94a3b8;
        }

        .small {
            font-size: 7.5px;
            color: #64748b;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 10px;
            background: #ffedd5;
            color: #c2410c;
            font-size: 7px;
            font-weight: bold;
            margin-top: 2px;
        }

        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-bottom: 12px;
        }

        .summary-box {
            border: 1px solid #d1d5db;
            padding: 12px;
            border-radius: 8px;
        }

        .summary-label {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 6px;
        }

        .balance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .balance-table td {
            border: 1px solid #d1d5db;
            padding: 10px;
            font-size: 11px;
        }

        .balance-table .label {
            font-weight: bold;
            color: #475569;
        }

        .balance-table .value {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }

        .final-row td {
            background: #111827;
            color: #ffffff;
        }
    </style>
</head>

<body>

<div class="header">
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">{{ $titulo }}</div>
                <div class="header-subtitle">
                    {{ $nombreMes }} {{ $anio }} · Sistema Tribeca
                </div>
            </td>
            <td class="header-right">
                Generado: {{ $fechaGeneracion }}<br>
                Digitbol · Esrom Obed Andrade Ortiz
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    <table class="footer-table">
        <tr>
            <td>{{ $footer }}</td>
            <td class="footer-right">Página <script type="text/php">
                if (isset($pdf)) {
                    echo $PAGE_NUM . " de " . $PAGE_COUNT;
                }
            </script></td>
        </tr>
    </table>
</div>

@if ($tabActiva === 'ingresos')

    <table class="kpi-row">
        <tr>
            <td class="kpi">
                <div class="kpi-label">Total ingresos del mes</div>
                <div class="kpi-value green">Bs {{ number_format($totalIngresosMes, 2) }}</div>
            </td>
            <td style="width: 8px;"></td>
            <td class="kpi">
                <div class="kpi-label">Saldo anterior</div>
                <div class="kpi-value dark">Bs {{ number_format($saldoAnterior, 2) }}</div>
            </td>
            <td style="width: 8px;"></td>
            <td class="kpi">
                <div class="kpi-label">Saldo con ingresos</div>
                <div class="kpi-value green">Bs {{ number_format($saldoFinalIngresos, 2) }}</div>
            </td>
        </tr>
    </table>

    <table class="report">
        <thead>
            <tr>
                <th style="width: 8%;">Fecha y hora</th>
                <th style="width: 8%;" class="text-right">Monto</th>
                <th style="width: 19%;">Depositante</th>
                <th style="width: 13%;">Departamento(s)</th>
                <th style="width: 18%;">Mes(es) / Descripción</th>
                <th style="width: 11%;">Uso salón</th>
                <th style="width: 11%;">Otro</th>
                <th style="width: 12%;" class="text-right">Saldo</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($ingresos as $item)
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</strong><br>
                        <span class="small">{{ $item['hora'] }}</span>
                    </td>

                    <td class="text-right">
                        <strong>Bs {{ number_format($item['monto'], 2) }}</strong>
                    </td>

                    <td>
                        <strong>{{ $item['depositante'] }}</strong><br>
                        <span class="small">Comp. {{ $item['numero_comprobante'] }}</span>

                        @if (($item['cantidad_aplicaciones'] ?? 0) === 0)
                            <br><span class="badge">Sin registro</span>
                        @endif
                    </td>

                    <td>{{ $item['departamentos'] ?: '-' }}</td>
                    <td>{{ $item['meses'] ?: '-' }}</td>
                    <td>{{ $item['uso_salon'] ?: '-' }}</td>
                    <td>{{ $item['otro'] ?: '-' }}</td>

                    <td class="text-right">
                        <strong>Bs {{ number_format($item['saldo'], 2) }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No existen ingresos para este mes.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td>Total</td>
                <td class="text-right">Bs {{ number_format($totalIngresosMes, 2) }}</td>
                <td colspan="5"></td>
                <td class="text-right">Bs {{ number_format($saldoFinalIngresos, 2) }}</td>
            </tr>
        </tfoot>
    </table>

@endif

@if ($tabActiva === 'egresos')

    <table class="kpi-row">
        <tr>
            <td class="kpi">
                <div class="kpi-label">Total egresos del mes</div>
                <div class="kpi-value red">Bs {{ number_format($totalEgresosMes, 2) }}</div>
            </td>
            <td style="width: 8px;"></td>
            <td class="kpi">
                <div class="kpi-label">Mes</div>
                <div class="kpi-value dark">{{ $nombreMes }} {{ $anio }}</div>
            </td>
        </tr>
    </table>

    <table class="report">
        <thead>
            <tr>
                <th style="width: 14%;">Fecha y hora</th>
                <th>Detalle</th>
                <th style="width: 14%;" class="text-right">Monto</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($egresos as $item)
                <tr>
                    <td>
                        @if ($item['fecha'])
                            <strong>{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</strong>
                        @else
                            <strong>Sin fecha</strong>
                        @endif
                        <br>
                        <span class="small">{{ $item['hora'] }}</span>
                    </td>

                    <td>
                        <strong>{{ $item['detalle'] }}</strong>

                        @if (!empty($item['estado']))
                            <br><span class="small">Estado: {{ $item['estado'] }}</span>
                        @endif
                    </td>

                    <td class="text-right">
                        <strong>Bs {{ number_format($item['monto'], 2) }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">No existen egresos registrados para este mes.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">Total egresos</td>
                <td class="text-right">Bs {{ number_format($totalEgresosMes, 2) }}</td>
            </tr>
        </tfoot>
    </table>

@endif

@if ($tabActiva === 'resumen')

    <table class="summary-grid">
        <tr>
            <td class="summary-box">
                <div class="summary-label">Ingreso de expensas</div>
                <div class="summary-value green">Bs {{ number_format($resumenMes['ingresos_expensas'], 2) }}</div>
            </td>

            <td class="summary-box">
                <div class="summary-label">Expensas no registradas</div>
                <div class="summary-value red">Bs {{ number_format($resumenMes['expensas_no_registradas'], 2) }}</div>
            </td>
        </tr>

        <tr>
            <td class="summary-box">
                <div class="summary-label">Alquiler de salón</div>
                <div class="summary-value dark">Bs {{ number_format($resumenMes['alquiler_salon'], 2) }}</div>
            </td>

            <td class="summary-box">
                <div class="summary-label">Otros ingresos</div>
                <div class="summary-value dark">Bs {{ number_format($resumenMes['otros'], 2) }}</div>
            </td>
        </tr>
    </table>

    <table class="balance-table">
        <tr>
            <td class="label">Saldo anterior</td>
            <td class="value">Bs {{ number_format($resumenMes['saldo_anterior'], 2) }}</td>
        </tr>

        <tr>
            <td class="label">Total ingresos del mes</td>
            <td class="value green">Bs {{ number_format($resumenMes['total_ingresos_mes'], 2) }}</td>
        </tr>

        <tr>
            <td class="label">Total egresos del mes</td>
            <td class="value red">Bs {{ number_format($resumenMes['total_egresos_mes'], 2) }}</td>
        </tr>

        <tr class="final-row">
            <td class="label">Saldo final del mes</td>
            <td class="value">Bs {{ number_format($resumenMes['saldo_final_mes'], 2) }}</td>
        </tr>
    </table>

@endif

</body>
</html>