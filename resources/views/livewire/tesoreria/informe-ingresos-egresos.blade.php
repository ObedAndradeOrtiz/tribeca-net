<div>
    <div class="report-page">

        <div class="report-topbar">

            <div>
                <h2>Informe de ingresos y egresos</h2>
                <p>Control mensual para comparar sistema contra banca.</p>
            </div>

            <div class="report-actions d-flex gap-2">

                <button type="button" class="btn btn-success" wire:click="exportarExcel" wire:loading.attr="disabled"
                    wire:target="exportarExcel">

                    <span wire:loading.remove wire:target="exportarExcel">
                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Exportar Excel
                    </span>

                    <span wire:loading wire:target="exportarExcel">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Generando...
                    </span>
                </button>

                <button type="button" class="btn btn-dark" wire:click="exportarSql" wire:loading.attr="disabled"
                    wire:target="exportarSql">

                    <span wire:loading.remove wire:target="exportarSql">
                        <i class="bi bi-database-down me-1"></i>
                        Backup SQL
                    </span>

                    <span wire:loading wire:target="exportarSql">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Generando...
                    </span>
                </button>

                <button type="button" class="btn-report-secondary" wire:click="abrirModalImagenes"
                    wire:loading.attr="disabled" wire:target="abrirModalImagenes">
                    <span wire:loading.remove wire:target="abrirModalImagenes">
                        <i class="bi bi-images"></i>
                        Imagenes
                    </span>

                    <span wire:loading wire:target="abrirModalImagenes">
                        <i class="bi bi-hourglass-split"></i>
                        Revisando...
                    </span>
                </button>

                <button type="button" class="btn-report-pdf" wire:click="generarPdf" wire:loading.attr="disabled"
                    wire:target="generarPdf">

                    <span wire:loading.remove wire:target="generarPdf">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Generar PDF
                    </span>

                    <span wire:loading wire:target="generarPdf">
                        <i class="bi bi-hourglass-split"></i>
                        Generando reporte...
                    </span>
                </button>

            </div>

        </div>

        <div class="report-control-row">
            <div class="report-filters">
                <div class="filter-group">
                    <label>Año</label>
                    <select wire:model="anio">
                        @for ($y = 2024; $y <= 2028; $y++)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="filter-group">
                    <label>Mes</label>
                    <select wire:model="mes">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ $this->nombreMes($m) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="report-kpis compact">
                    <div class="report-kpi">
                        <span>Total ingresos</span>
                        <strong>Bs {{ number_format($totalIngresosAcumulado, 2) }}</strong>
                        <small>Desde agosto 2024 hasta {{ $this->nombreMes((int) $mes) }} {{ $anio }}</small>
                    </div>

                    <div class="report-kpi danger">
                        <span>Total egresos</span>
                        <strong>Bs {{ number_format($totalEgresosAcumulado, 2) }}</strong>
                        <small>Desde agosto 2024 hasta {{ $this->nombreMes((int) $mes) }} {{ $anio }}</small>
                    </div>

                    <div class="report-kpi dark">
                        <span>Total cuenta</span>
                        <strong>Bs {{ number_format($totalCuenta, 2) }}</strong>
                        <small>Ingresos menos egresos</small>
                    </div>
                </div>

            </div>

            <div wire:loading wire:target="anio,mes,cambiarTab,cargarTodo,cargarIngresos">
                <div class="report-loading-mini">
                    Generando reporte...
                </div>
            </div>
        </div>


        <div class="report-tabs">
            <button type="button" class="{{ $tabActiva === 'ingresos' ? 'active' : '' }}"
                wire:click="cambiarTab('ingresos')">
                Ingresos
            </button>

            <button type="button" class="{{ $tabActiva === 'egresos' ? 'active' : '' }}"
                wire:click="cambiarTab('egresos')">
                Egresos
            </button>

            <button type="button" class="{{ $tabActiva === 'resumen' ? 'active' : '' }}"
                wire:click="cambiarTab('resumen')">
                Resumen del mes
            </button>
        </div>

        @if ($tabActiva === 'ingresos')
            <div class="report-card">

                <div class="report-card-header compact">
                    <div>
                        <h4>Ingresos - {{ $this->nombreMes((int) $mes) }} {{ $anio }}</h4>
                        <span>Listado de depósitos bancarios con saldo acumulado del sistema.</span>
                    </div>

                    <div class="report-card-right">

                        <div class="report-card-total">
                            <span>Total ingresos del mes</span>
                            <strong>Bs {{ number_format($totalIngresosMes, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="report-table-wrap no-overflow" wire:loading.remove
                    wire:target="anio,mes,cambiarTab,cargarTodo,cargarIngresos">
                    <table class="report-table compact-table">
                        <thead>
                            <tr>
                                <th class="col-fecha">Fecha y hora</th>
                                <th class="col-monto text-end">Monto</th>
                                <th class="col-depositante">Depositante</th>
                                <th class="col-depto">Departamento(s)</th>
                                <th class="col-meses">Mes(es) / Descripción</th>
                                <th class="col-salon">Uso salón</th>
                                <th class="col-otro">Otro</th>
                                <th class="col-saldo text-end">Saldo</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($ingresos as $item)
                                <tr class="{{ $item['cantidad_aplicaciones'] === 0 ? 'row-unregistered' : '' }}">
                                    <td class="col-fecha">
                                        <strong>{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</strong>
                                        <span>{{ $item['hora'] }}</span>
                                    </td>

                                    <td class="col-monto text-end amount-cell">
                                        Bs {{ number_format($item['monto'], 2) }}
                                    </td>

                                    <td class="col-depositante">
                                        <strong>{{ $item['depositante'] }}</strong>

                                        @if (!empty($item['numero_comprobante']))
                                            <span>Comp. {{ $item['numero_comprobante'] }}</span>
                                        @endif

                                        @if ($item['cantidad_aplicaciones'] === 0)
                                            <small class="tag-warning">Sin registro</small>
                                        @endif
                                    </td>

                                    <td class="col-depto">
                                        @if ($item['departamentos'])
                                            {{ $item['departamentos'] }}
                                        @else
                                            <span class="muted">-</span>
                                        @endif
                                    </td>

                                    <td class="col-meses">
                                        @if ($item['meses'])
                                            {{ $item['meses'] }}
                                        @else
                                            <span class="muted">-</span>
                                        @endif
                                    </td>

                                    <td class="col-salon">
                                        @if ($item['uso_salon'])
                                            {{ $item['uso_salon'] }}
                                        @else
                                            <span class="muted">-</span>
                                        @endif
                                    </td>

                                    <td class="col-otro">
                                        @if ($item['otro'])
                                            {{ $item['otro'] }}
                                        @else
                                            <span class="muted">-</span>
                                        @endif
                                    </td>

                                    <td class="col-saldo text-end saldo-cell">
                                        Bs {{ number_format($item['saldo'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-report">
                                            No existen ingresos para este mes.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>
                                    <strong>Total mes</strong>
                                </td>
                                <td class="text-end">
                                    <strong>Bs {{ number_format($totalIngresosMes, 2) }}</strong>
                                </td>
                                <td colspan="5"></td>
                                <td class="text-end">
                                    <strong>Bs {{ number_format($saldoFinalIngresos, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div wire:loading wire:target="anio,mes,cambiarTab,cargarTodo,cargarIngresos">
                    <div class="report-loading">
                        Generando reporte...
                    </div>
                </div>

            </div>
        @endif

        @if ($tabActiva === 'egresos')
            <div class="report-card">

                <div class="report-card-header compact">
                    <div>
                        <h4>Egresos - {{ $this->nombreMes((int) $mes) }} {{ $anio }}</h4>
                        <span>Listado de gastos registrados en el sistema.</span>
                    </div>

                    <div class="report-card-right">


                        <div class="report-card-total danger">
                            <span>Total egresos del mes</span>
                            <strong>Bs {{ number_format($totalEgresosMes, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="report-table-wrap no-overflow" wire:loading.remove
                    wire:target="anio,mes,cambiarTab,cargarTodo,cargarEgresos">
                    <table class="report-table compact-table egresos-table">
                        <thead>
                            <tr>
                                <th style="width: 140px;">Fecha y hora</th>
                                <th>Detalle</th>
                                <th style="width: 140px;" class="text-end">Monto</th>
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

                                        <span>{{ $item['hora'] }}</span>
                                    </td>

                                    <td>
                                        <strong>{{ $item['detalle'] }}</strong>

                                        @if (!empty($item['estado']))
                                            <span>Estado: {{ $item['estado'] }}</span>
                                        @endif
                                    </td>

                                    <td class="text-end egreso-amount">
                                        Bs {{ number_format($item['monto'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-report">
                                            No existen egresos registrados para este mes.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <strong>Total egresos</strong>
                                </td>

                                <td class="text-end">
                                    <strong>Bs {{ number_format($totalEgresosMes, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div wire:loading wire:target="anio,mes,cambiarTab,cargarTodo,cargarEgresos">
                    <div class="report-loading">
                        Generando reporte...
                    </div>
                </div>

            </div>
        @endif

        @if ($tabActiva === 'resumen')
            <div class="report-card">

                <div class="report-card-header compact">
                    <div>
                        <h4>Resumen del mes - {{ $this->nombreMes((int) $mes) }} {{ $anio }}</h4>
                        <span>Resumen contable mensual de ingresos, egresos y saldo final.</span>
                    </div>

                    <div class="report-card-right">

                    </div>
                </div>

                <div class="summary-grid">

                    <div class="summary-box">
                        <span>Ingreso de expensas</span>
                        <strong>Bs {{ number_format($resumenMes['ingresos_expensas'], 2) }}</strong>
                    </div>

                    <div class="summary-box warning">
                        <span>Expensas no registradas</span>
                        <strong>Bs {{ number_format($resumenMes['expensas_no_registradas'], 2) }}</strong>
                    </div>

                    <div class="summary-box info">
                        <span>Alquiler de salón</span>
                        <strong>Bs {{ number_format($resumenMes['alquiler_salon'], 2) }}</strong>
                    </div>

                    <div class="summary-box neutral">
                        <span>Otros ingresos</span>
                        <strong>Bs {{ number_format($resumenMes['otros'], 2) }}</strong>
                    </div>

                </div>

                <div class="summary-balance">

                    <div class="balance-row">
                        <span>Saldo anterior</span>
                        <strong>Bs {{ number_format($resumenMes['saldo_anterior'], 2) }}</strong>
                    </div>

                    <div class="balance-row positive">
                        <span>Total ingresos del mes</span>
                        <strong>Bs {{ number_format($resumenMes['total_ingresos_mes'], 2) }}</strong>
                    </div>

                    <div class="balance-row negative">
                        <span>Total egresos del mes</span>
                        <strong>Bs {{ number_format($resumenMes['total_egresos_mes'], 2) }}</strong>
                    </div>

                    <div class="balance-row final">
                        <span>Saldo final del mes</span>
                        <strong>Bs {{ number_format($resumenMes['saldo_final_mes'], 2) }}</strong>
                    </div>

                </div>

            </div>
        @endif

        <x-modal wire:model="modalImagenes" maxWidth="xl">
            <div class="image-export-modal">
                <div class="image-export-header">
                    <div>
                        <span class="image-export-kicker">Comprobantes</span>
                        <h3>Descargar imagenes por fecha</h3>
                        <p>Selecciona un rango para crear un ZIP con los archivos encontrados.</p>
                    </div>

                    <button type="button" class="image-export-close" wire:click="cerrarModalImagenes">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="image-export-grid">
                    <div class="image-export-field">
                        <label>Desde</label>
                        <input type="date" wire:model.defer="imagenFechaInicio">
                    </div>

                    <div class="image-export-field">
                        <label>Hasta</label>
                        <input type="date" wire:model.defer="imagenFechaFin">
                    </div>

                    <div class="image-export-field">
                        <label>Tipo</label>
                        <select wire:model.defer="imagenTipo">
                            <option value="todos">Todos</option>
                            <option value="ingresos">Ingresos</option>
                            <option value="egresos">Egresos</option>
                            <option value="mantenimientos">Mantenimientos</option>
                        </select>
                    </div>
                </div>

                <div class="image-export-actions">
                    <button type="button" class="btn-report-secondary" wire:click="buscarImagenes"
                        wire:loading.attr="disabled" wire:target="buscarImagenes">
                        <i class="bi bi-search"></i>
                        Revisar archivos
                    </button>

                    <button type="button" class="btn btn-primary" wire:click="descargarImagenes"
                        wire:loading.attr="disabled" wire:target="descargarImagenes">
                        <span wire:loading.remove wire:target="descargarImagenes">
                            <i class="bi bi-file-earmark-zip"></i>
                            Descargar ZIP
                        </span>

                        <span wire:loading wire:target="descargarImagenes">
                            <i class="bi bi-hourglass-split"></i>
                            Creando ZIP...
                        </span>
                    </button>
                </div>

                <div class="image-export-summary">
                    <div>
                        <span>Archivos</span>
                        <strong>{{ $totalImagenesEncontradas }}</strong>
                    </div>

                    <div>
                        <span>Tamano aprox.</span>
                        <strong>{{ number_format($tamanoImagenesEncontradas / 1024 / 1024, 2) }} MB</strong>
                    </div>
                </div>

                <div class="image-export-list">
                    @forelse ($imagenesEncontradas as $archivo)
                        <div class="image-export-item">
                            <div>
                                <strong>{{ $archivo['nombre'] }}</strong>
                                <span>{{ $archivo['grupo'] }} - {{ $archivo['fecha'] }}</span>
                            </div>

                            <a href="{{ $archivo['url'] }}" target="_blank" rel="noopener">
                                Abrir
                            </a>
                        </div>
                    @empty
                        <div class="image-export-empty">
                            No hay archivos encontrados para el rango seleccionado.
                        </div>
                    @endforelse
                </div>

                @if ($totalImagenesEncontradas > count($imagenesEncontradas))
                    <p class="image-export-note">
                        Se muestran los primeros {{ count($imagenesEncontradas) }} archivos. El ZIP incluye todos los encontrados.
                    </p>
                @endif
            </div>
        </x-modal>

        <style>
            .report-card-total.danger {
                background: #fef2f2;
                border-color: #fecaca;
            }

            .report-card-total.danger span {
                color: #dc2626;
            }

            .report-card-total.danger strong {
                color: #b91c1c;
            }

            .egreso-amount {
                font-weight: 950;
                color: #dc2626 !important;
            }

            .image-export-modal {
                color: #111827;
            }

            .image-export-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                padding-bottom: 14px;
                border-bottom: 1px solid #e5e7eb;
            }

            .image-export-kicker {
                display: block;
                color: #64748b;
                font-size: 11px;
                font-weight: 950;
                text-transform: uppercase;
            }

            .image-export-header h3 {
                margin: 4px 0 4px;
                font-size: 22px;
                font-weight: 950;
                color: #111827;
            }

            .image-export-header p {
                margin: 0;
                color: #64748b;
                font-size: 13px;
                font-weight: 700;
            }

            .image-export-close {
                width: 38px;
                height: 38px;
                border: none;
                border-radius: 12px;
                background: #f1f5f9;
                color: #64748b;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .image-export-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
                margin-top: 16px;
            }

            .image-export-field label {
                display: block;
                margin-bottom: 6px;
                color: #64748b;
                font-size: 11px;
                font-weight: 950;
                text-transform: uppercase;
            }

            .image-export-field input,
            .image-export-field select {
                width: 100%;
                height: 44px;
                border: 1px solid #dbe3ef;
                border-radius: 12px;
                padding: 0 12px;
                color: #111827;
                font-size: 13px;
                font-weight: 850;
                outline: none;
            }

            .image-export-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 14px;
            }

            .image-export-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-top: 14px;
            }

            .image-export-summary div {
                border: 1px solid #dbeafe;
                border-radius: 14px;
                background: #eff6ff;
                padding: 12px;
            }

            .image-export-summary span {
                display: block;
                color: #2563eb;
                font-size: 11px;
                font-weight: 950;
                text-transform: uppercase;
            }

            .image-export-summary strong {
                display: block;
                margin-top: 4px;
                color: #1e3a8a;
                font-size: 18px;
                font-weight: 950;
            }

            .image-export-list {
                margin-top: 14px;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                overflow: hidden;
            }

            .image-export-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 10px 12px;
                border-bottom: 1px solid #e5e7eb;
            }

            .image-export-item:last-child {
                border-bottom: none;
            }

            .image-export-item strong {
                display: block;
                font-size: 12px;
                font-weight: 950;
                overflow-wrap: anywhere;
            }

            .image-export-item span {
                display: block;
                color: #64748b;
                font-size: 11px;
                font-weight: 800;
            }

            .image-export-item a {
                flex: 0 0 auto;
                border-radius: 10px;
                background: #f1f5f9;
                color: #334155;
                padding: 7px 10px;
                font-size: 12px;
                font-weight: 900;
                text-decoration: none;
            }

            .image-export-empty {
                padding: 18px;
                color: #64748b;
                font-weight: 850;
                text-align: center;
            }

            .image-export-note {
                margin: 10px 0 0;
                color: #64748b;
                font-size: 12px;
                font-weight: 800;
            }

            .summary-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
                padding: 16px;
            }

            .summary-box {
                border: 1px solid #bbf7d0;
                background: #f0fdf4;
                border-radius: 16px;
                padding: 14px;
            }

            .summary-box span {
                display: block;
                font-size: 11px;
                font-weight: 950;
                color: #16a34a;
                text-transform: uppercase;
            }

            .summary-box strong {
                display: block;
                margin-top: 6px;
                font-size: 20px;
                font-weight: 950;
                color: #047857;
            }

            .summary-box.warning {
                border-color: #fed7aa;
                background: #fff7ed;
            }

            .summary-box.warning span {
                color: #ea580c;
            }

            .summary-box.warning strong {
                color: #c2410c;
            }

            .summary-box.info {
                border-color: #bfdbfe;
                background: #eff6ff;
            }

            .summary-box.info span {
                color: #2563eb;
            }

            .summary-box.info strong {
                color: #1d4ed8;
            }

            .summary-box.neutral {
                border-color: #e5e7eb;
                background: #f8fafc;
            }

            .summary-box.neutral span {
                color: #64748b;
            }

            .summary-box.neutral strong {
                color: #334155;
            }

            .summary-balance {
                border-top: 1px solid #e5e7eb;
                padding: 16px;
                display: grid;
                gap: 8px;
            }

            .balance-row {
                display: flex;
                justify-content: space-between;
                gap: 16px;
                align-items: center;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                padding: 12px 14px;
                background: #ffffff;
            }

            .balance-row span {
                font-size: 13px;
                font-weight: 900;
                color: #64748b;
            }

            .balance-row strong {
                font-size: 18px;
                font-weight: 950;
                color: #0f172a;
            }

            .balance-row.positive strong {
                color: #047857;
            }

            .balance-row.negative strong {
                color: #dc2626;
            }

            .balance-row.final {
                background: #0f172a;
                border-color: #0f172a;
            }

            .balance-row.final span,
            .balance-row.final strong {
                color: #ffffff;
            }

            .balance-row.final strong {
                font-size: 22px;
            }

            @media (max-width: 1000px) {
                .summary-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 650px) {
                .summary-grid {
                    grid-template-columns: 1fr;
                }

                .balance-row {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }

            .report-page {
                display: grid;
                gap: 12px;
            }

            .report-topbar {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 18px;
                padding: 16px 20px;
                display: flex;
                justify-content: space-between;
                gap: 16px;
                align-items: center;
            }

            .report-topbar h2 {
                margin: 0;
                font-size: 22px;
                font-weight: 950;
                color: #0f172a;
            }

            .report-topbar p {
                margin: 4px 0 0;
                color: #64748b;
                font-size: 13px;
                font-weight: 700;
            }

            .report-actions {
                display: flex;
                gap: 8px;
                align-items: center;
            }

            .report-control-row {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 18px;
                padding: 14px 16px;
                display: flex;
                justify-content: space-between;
                gap: 12px;
                align-items: end;
            }

            .report-filters {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .filter-group {
                display: grid;
                gap: 5px;
            }

            .filter-group label {
                font-size: 11px;
                font-weight: 950;
                color: #64748b;
                text-transform: uppercase;
            }

            .filter-group select {
                min-width: 170px;
                height: 38px;
                border: 1px solid #d1d5db;
                border-radius: 12px;
                padding: 0 12px;
                font-size: 13px;
                font-weight: 900;
                color: #111827;
                outline: none;
                background: #ffffff;
            }

            .report-kpis.compact {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
            }

            .report-kpi {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 18px;
                padding: 14px 16px;
            }

            .report-kpi span {
                display: block;
                font-size: 11px;
                font-weight: 950;
                color: #64748b;
                text-transform: uppercase;
            }

            .report-kpi strong {
                display: block;
                margin-top: 5px;
                font-size: 21px;
                font-weight: 950;
                color: #047857;
            }

            .report-kpi small {
                display: block;
                margin-top: 3px;
                font-size: 10.5px;
                font-weight: 800;
                color: #94a3b8;
            }

            .report-kpi.danger strong {
                color: #dc2626;
            }

            .report-kpi.dark strong {
                color: #0f172a;
            }

            .report-tabs {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .report-tabs button {
                width: 100%;
                border: none;
                border-radius: 14px;
                padding: 14px 18px;
                background: #f1f5f9;
                color: #64748b;
                font-size: 14px;
                font-weight: 900;
                cursor: pointer;
                text-align: center;
                transition: .15s ease;
            }

            .report-tabs button.active {
                background: #0f172a;
                color: #ffffff;
            }

            .report-tabs button:hover {
                background: #e2e8f0;
            }

            .report-tabs button.active:hover {
                background: #0f172a;
            }

            @media (max-width: 650px) {
                .report-tabs {
                    grid-template-columns: 1fr;
                }
            }

            .report-card {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 18px;
                overflow: hidden;
            }

            .report-card-header.compact {
                display: flex;
                justify-content: space-between;
                gap: 14px;
                align-items: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e5e7eb;
            }

            .report-card-header h4 {
                margin: 0;
                font-size: 16px;
                font-weight: 950;
                color: #111827;
            }

            .report-card-header span {
                display: block;
                margin-top: 3px;
                font-size: 12px;
                color: #64748b;
                font-weight: 700;
            }

            .report-card-right {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 8px;
                flex-wrap: wrap;
            }

            .report-card-total {
                min-width: 175px;
                text-align: right;
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                border-radius: 14px;
                padding: 9px 12px;
            }

            .report-card-total span {
                margin: 0;
                font-size: 10px;
                font-weight: 950;
                color: #16a34a;
                text-transform: uppercase;
            }

            .report-card-total strong {
                display: block;
                margin-top: 3px;
                font-size: 17px;
                font-weight: 950;
                color: #047857;
            }

            .btn-report-pdf,
            .btn-report-secondary {
                border: none;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 900;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .btn-report-pdf {
                padding: 10px 14px;
                background: #fee2e2;
                color: #b91c1c;
            }

            .btn-report-secondary {
                padding: 8px 11px;
                background: #f1f5f9;
                color: #475569;
            }

            .report-table-wrap.no-overflow {
                width: 100%;
                overflow-x: visible;
            }

            .report-table.compact-table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
            }

            .report-table th {
                background: #f8fafc;
                color: #64748b;
                font-size: 10.5px;
                font-weight: 950;
                text-transform: uppercase;
                padding: 9px 8px;
                border-bottom: 1px solid #e5e7eb;
                text-align: left;
            }

            .report-table td {
                padding: 8px 8px;
                border-bottom: 1px solid #e5e7eb;
                vertical-align: top;
                font-size: 11.5px;
                color: #111827;
                line-height: 1.28;
                overflow-wrap: anywhere;
                word-break: normal;
            }

            .report-table td strong {
                display: block;
                font-weight: 900;
            }

            .report-table td span {
                display: block;
                margin-top: 2px;
                color: #64748b;
                font-weight: 700;
            }

            .report-table tfoot td {
                background: #f8fafc;
                font-size: 12px;
            }

            .col-fecha {
                width: 8.5%;
            }

            .col-monto {
                width: 8%;
            }

            .col-depositante {
                width: 19%;
            }

            .col-depto {
                width: 13%;
            }

            .col-meses {
                width: 16%;
            }

            .col-salon {
                width: 12%;
            }

            .col-otro {
                width: 12%;
            }

            .col-saldo {
                width: 11.5%;
            }

            .text-end {
                text-align: right !important;
            }

            .amount-cell {
                font-weight: 900;
                color: #0284c7 !important;
            }

            .saldo-cell {
                font-weight: 950;
                color: #047857 !important;
            }

            .muted {
                color: #94a3b8 !important;
                font-weight: 700;
            }

            .row-unregistered {
                background: #fff7ed;
            }

            .tag-warning {
                display: inline-flex;
                margin-top: 4px;
                padding: 3px 6px;
                border-radius: 999px;
                background: #ffedd5;
                color: #c2410c;
                font-size: 9.5px;
                font-weight: 950;
            }

            .empty-report {
                padding: 24px;
                color: #64748b;
                font-weight: 800;
                text-align: center;
            }

            .report-loading {
                margin: 14px;
                padding: 12px 14px;
                border-radius: 14px;
                background: #eff6ff;
                color: #1d4ed8;
                font-weight: 900;
                font-size: 13px;
            }

            .report-loading-mini {
                padding: 9px 12px;
                border-radius: 12px;
                background: #eff6ff;
                color: #1d4ed8;
                font-weight: 900;
                font-size: 12px;
                white-space: nowrap;
            }

            @media (max-width: 1100px) {
                .report-table-wrap.no-overflow {
                    overflow-x: auto;
                }

                .report-table.compact-table {
                    min-width: 1100px;
                }
            }

            @media (max-width: 900px) {

                .report-topbar,
                .report-control-row,
                .report-card-header.compact {
                    align-items: stretch;
                    flex-direction: column;
                }

                .report-kpis.compact {
                    grid-template-columns: 1fr;
                }

                .report-card-total {
                    width: 100%;
                    text-align: left;
                }

                .report-card-right {
                    justify-content: flex-start;
                }

                .report-actions {
                    flex-wrap: wrap;
                }

                .report-actions > button {
                    flex: 1 1 150px;
                    justify-content: center;
                }

                .image-export-grid,
                .image-export-summary {
                    grid-template-columns: 1fr;
                }

                .image-export-actions,
                .image-export-item {
                    align-items: stretch;
                    flex-direction: column;
                }

                .image-export-actions button,
                .image-export-item a {
                    justify-content: center;
                    text-align: center;
                    width: 100%;
                }
            }
        </style>
    </div>
</div>
