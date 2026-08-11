<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }} - {{ $departamento }}</title>

    <style>
        @page {
            margin: 88px 28px 55px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8.5px;
            color: #111827;
            margin: 0;
        }

        .header {
            position: fixed;
            top: -66px;
            left: 0;
            right: 0;
            height: 58px;
            border-bottom: 2px solid #111827;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .title {
            font-size: 17px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 10px;
            color: #475569;
            margin-top: 3px;
        }

        .right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 7px;
            font-size: 8px;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kpis {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 10px;
        }

        .kpi {
            border: 1px solid #d1d5db;
            padding: 8px;
            border-radius: 8px;
        }

        .kpi span {
            display: block;
            font-size: 7.5px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }

        .kpi strong {
            display: block;
            margin-top: 4px;
            font-size: 13px;
            font-weight: bold;
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
            font-size: 7px;
            text-transform: uppercase;
            text-align: left;
        }

        table.report td {
            border: 1px solid #e5e7eb;
            padding: 5px 4px;
            vertical-align: top;
            font-size: 7.6px;
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

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: bold;
        }

        .badge-ok {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-neutral {
            background: #e0e7ff;
            color: #3730a3;
        }

        .pagos {
            margin-top: 3px;
        }

        .pago-item {
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }

        .pago-item:last-child {
            border-bottom: none;
        }

        .small {
            font-size: 7px;
            color: #64748b;
        }
    </style>
</head>

<body>

<div class="header">
    <table class="header-table">
        <tr>
            <td>
                <div class="title">{{ $titulo }}</div>
                <div class="subtitle">
                    Departamento: <strong>{{ $departamento }}</strong> · {{ $subtitulo }}
                </div>
            </td>
            <td class="right">
                Generado: {{ $fechaGeneracion }}<br>
                Sistema Tribeca · Digitbol
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    <table class="footer-table">
        <tr>
            <td>{{ $footer }}</td>
            <td class="right">Reporte interno de administración</td>
        </tr>
    </table>
</div>

<table class="kpis">
    <tr>
        <td class="kpi">
            <span>Total expensas</span>
            <strong class="dark">Bs {{ number_format($resumen['total_expensas'], 2) }}</strong>
        </td>

        <td class="kpi">
            <span>Total pagado</span>
            <strong class="green">Bs {{ number_format($resumen['total_pagado'], 2) }}</strong>
        </td>

        <td class="kpi">
            <span>Saldo pendiente</span>
            <strong class="red">Bs {{ number_format($resumen['total_saldo'], 2) }}</strong>
        </td>

        <td class="kpi">
            <span>Meses</span>
            <strong class="dark">{{ $resumen['cantidad_meses'] }}</strong>
        </td>

        <td class="kpi">
            <span>No cobrables</span>
            <strong class="dark">{{ $resumen['no_cobrables'] }}</strong>
        </td>
    </tr>
</table>

<table class="report">
    <thead>
        <tr>
            <th style="width: 8%;">Mes</th>
            <th style="width: 8%;" class="text-right">Expensa</th>
            <th style="width: 8%;" class="text-right">Desc.</th>
            <th style="width: 10%;">Límite desc.</th>
            <th style="width: 8%;" class="text-right">Pagado</th>
            <th style="width: 8%;" class="text-right">Saldo</th>
            <th style="width: 10%;">Estado</th>
            <th style="width: 30%;">Pagos aplicados</th>
            <th style="width: 10%;">Observación</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($expensas as $exp)
            <tr>
                <td>
                    <strong>{{ $exp['mes_nombre'] }}</strong><br>
                    <span class="small">{{ $exp['anio'] }}</span>
                </td>

                <td class="text-right">
                    Bs {{ number_format($exp['monto_expensa'], 2) }}
                </td>

                <td class="text-right">
                    @if ($exp['aplica_descuento'])
                        Bs {{ number_format($exp['monto_con_descuento'], 2) }}
                    @else
                        -
                    @endif
                </td>

                <td>
                    @if ($exp['fecha_limite_descuento'])
                        {{ \Carbon\Carbon::parse($exp['fecha_limite_descuento'])->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>

                <td class="text-right">
                    <strong class="green">Bs {{ number_format($exp['monto_pagado'], 2) }}</strong>
                </td>

                <td class="text-right">
                    <strong class="{{ $exp['saldo'] > 0 ? 'red' : 'green' }}">
                        Bs {{ number_format($exp['saldo'], 2) }}
                    </strong>
                </td>

                <td>
                    @php
                        $claseEstado = 'badge-danger';

                        if ($exp['estado'] === 'Pagado') {
                            $claseEstado = 'badge-ok';
                        } elseif ($exp['estado'] === 'Parcial') {
                            $claseEstado = 'badge-warning';
                        }

                        if (($exp['no_cobrar'] ?? 0) == 1) {
                            $claseEstado = 'badge-neutral';
                        }
                    @endphp

                    <span class="badge {{ $claseEstado }}">
                        {{ $exp['estado'] }}
                    </span>

                    @if (!empty($exp['tipo_estado']))
                        <br><span class="small">{{ $exp['tipo_estado'] }}</span>
                    @endif

                    @if (($exp['no_cobrar'] ?? 0) == 1)
                        <br><span class="small">No cobrable</span>
                    @endif
                </td>

                <td>
                    @if (count($exp['pagos']) > 0)
                        <div class="pagos">
                            @foreach ($exp['pagos'] as $pago)
                                <div class="pago-item">
                                    <strong>{{ $pago['depositante'] }}</strong><br>

                                    <span class="small">
                                        {{ \Carbon\Carbon::parse($pago['fecha'])->format('d/m/Y') }}
                                        {{ $pago['hora'] }}
                                        · Comp. {{ $pago['numero_comprobante'] ?: 'Sin comprobante' }}
                                    </span><br>

                                    <strong>Bs {{ number_format($pago['monto'], 2) }}</strong>

                                    @if (!empty($pago['estado_pago']))
                                        <span class="small"> · {{ $pago['estado_pago'] }}</span>
                                    @endif

                                    @if (!empty($pago['observacion']))
                                        <br><span class="small">{{ $pago['observacion'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="muted">Sin pagos</span>
                    @endif
                </td>

                <td>
                    @if (!empty($exp['motivo_no_cobro']))
                        {{ $exp['motivo_no_cobro'] }}
                    @elseif (!empty($exp['observacion']))
                        {{ $exp['observacion'] }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center;">
                    No existen expensas en este rango.
                </td>
            </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr>
            <td>Total</td>
            <td class="text-right">Bs {{ number_format($resumen['total_expensas'], 2) }}</td>
            <td></td>
            <td></td>
            <td class="text-right">Bs {{ number_format($resumen['total_pagado'], 2) }}</td>
            <td class="text-right">Bs {{ number_format($resumen['total_saldo'], 2) }}</td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>

</body>
</html>