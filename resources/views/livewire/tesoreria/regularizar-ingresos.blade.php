<div class="regularizacion-page">

    <div class="reg-header">
        <div>
            <div class="reg-kicker">Tesorería / Conciliación</div>
            <h3 class="reg-title">Regularización de ingresos bancarios</h3>
            <p class="reg-subtitle">
                Administra ingresos del banco y distribúyelos entre expensas, adelantos, gestión anterior u otros
                ingresos.
            </p>
        </div>

        <div class="reg-header-actions">
            <div class="reg-header-summary">
                <div class="summary-box">
                    <span>Gestión</span>
                    <strong>{{ $anio }}</strong>
                </div>

                <div class="summary-box">
                    <span>Estado</span>
                    <strong>{{ $estado }}</strong>
                </div>
            </div>
            <button type="button" class="btn-report-debt" wire:click="abrirReporteDeudas">
                <i class="bi bi-file-earmark-text"></i>
                Reporte deudas
            </button>
            <button type="button" class="btn-report-debt" wire:click="descargarPlantillaIngresos">
                <i class="bi bi-file-earmark-excel"></i>
                Plantilla Excel
            </button>
            <button type="button" class="btn-report-debt" wire:click="abrirImportarIngresos">
                <i class="bi bi-upload"></i>
                Subir Excel
            </button>
            <button type="button" class="btn-new-income" wire:click="abrirCrearIngreso">
                Nuevo ingreso
            </button>
        </div>
    </div>

    <div class="reg-filter-card">
        <div class="row g-3 align-items-end">

            <div class="col-xl-2 col-md-3">
                <label class="reg-label">Año</label>
                <select class="reg-control" wire:model="anio">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>

            <div class="col-xl-2 col-md-3">
                <label class="reg-label">Mes</label>
                <select class="reg-control" wire:model="mes">
                    <option value="">Todos</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            <div class="col-xl-3 col-md-3">
                <label class="reg-label">Estado</label>
                <select class="reg-control" wire:model="estado">
                    <option value="Todos">Todos</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aplicado parcial">Aplicado parcial</option>
                    <option value="Aplicado completo">Aplicado completo</option>
                    <option value="No identificado">No identificado</option>
                    <option value="Revisar">Revisar</option>
                </select>
            </div>

            <div class="col-xl-5 col-md-12">
                <label class="reg-label">Buscar ingreso</label>
                <div class="reg-search">
                    <i class="bi bi-search"></i>
                    <input type="text" wire:model.debounce.500ms="busqueda"
                        placeholder="Buscar por depositante, comprobante o detalle">
                </div>
            </div>

        </div>
    </div>

    <div class="reg-table-card">
        <div class="reg-table-header">
            <div>
                <h5>Ingresos bancarios</h5>
                <span>Listado de movimientos importados desde extractos bancarios.</span>
            </div>

            <div class="reg-total-box">
                <span>{{ $labelTotalIngresos }}</span>
                <strong>Bs {{ number_format($totalIngresosFiltrado, 2) }}</strong>

                @if ($anio && $mes)
                    <small>{{ $this->nombreMes((int) $mes) }} {{ $anio }}</small>
                @elseif ($anio)
                    <small>Gestión {{ $anio }}</small>
                @else
                    <small>Todos los registros</small>
                @endif
            </div>
        </div>

        <div class="reg-table-wrap">
            <table class="reg-table">
                <thead>
                    <tr>
                        <th class="col-fecha">Fecha</th>
                        <th class="col-depositante">Depositante</th>
                        <th class="col-sugerencia">Departamento sugerido</th>

                        <th class="col-monto text-end">Monto</th>
                        <th class="col-monto text-end">Aplicado</th>
                        <th class="col-monto text-end">Saldo</th>
                        <th class="col-estado">Estado</th>
                        <th class="col-accion text-end">Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($ingresos as $item)
                        <tr wire:key="ingreso-{{ $item->id }}">
                            <td data-label="Fecha">
                                <div class="date-main">
                                    {{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}
                                </div>
                                <div class="date-sub">
                                    {{ $item->hora }}
                                </div>
                            </td>

                            <td data-label="Depositante">
                                <div class="person-main">
                                    {{ $item->depositante ?: 'SIN DEPOSITANTE' }}
                                </div>
                                <div class="person-sub">
                                    {{ $item->detalle ?: 'Sin detalle registrado' }}
                                </div>
                            </td>

                            <td data-label="Departamento sugerido">

                                {{-- NUEVAS SUGERENCIAS MÚLTIPLES --}}
                                @if (!empty($item->sugerencias_multiples))
                                    <div class="suggestion-stack">

                                        @foreach ($item->sugerencias_multiples as $sugerencia)
                                            <div class="suggest-box-mini suggest-box-multiple">

                                                <div class="suggest-mini-top">
                                                    <div class="suggest-mini-icon">
                                                        <i class="bi bi-building"></i>
                                                    </div>

                                                    <div class="suggest-mini-info">
                                                        <div class="suggest-mini-title">
                                                            {{ $sugerencia['departamento'] }}
                                                        </div>

                                                        <div class="suggest-mini-meta">
                                                            {{ $sugerencia['origen'] ?? 'Sugerencia' }}
                                                            · {{ $sugerencia['mes'] ?? '' }}
                                                            {{ $sugerencia['anio'] ?? '' }}
                                                            · Bs {{ number_format($sugerencia['saldo_real'] ?? 0, 2) }}

                                                            @if (($sugerencia['tipo_estado'] ?? null) === 'Descuento pronto pago')
                                                                · Con descuento
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="suggest-mini-actions">

                                                    {{-- Abrir modal usando este departamento --}}
                                                    <button type="button" class="btn-suggest-mini btn-suggest-review"
                                                        title="Abrir y cargar esta sugerencia"
                                                        wire:click="usarSugerenciaDepartamento({{ $item->id }}, @js($sugerencia['departamento']))">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    {{-- Pagar automático directo usando este departamento --}}
                                                    <button type="button" class="btn-suggest-mini btn-suggest-pay"
                                                        title="Pagar automáticamente a este departamento"
                                                        wire:click="pagarAutomaticoSugerencia({{ $item->id }}, @js($sugerencia['departamento']))">
                                                        <i class="bi bi-check2-circle"></i>
                                                    </button>

                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    {{-- RESPALDO: SUGERENCIA ANTERIOR --}}
                                @elseif ($item->sugerencia_departamento)
                                    <div class="suggest-box-mini">
                                        <div class="suggest-mini-top">
                                            <div class="suggest-mini-icon">
                                                <i class="bi bi-building"></i>
                                            </div>

                                            <div class="suggest-mini-info">
                                                <div class="suggest-mini-title">
                                                    {{ $item->sugerencia_departamento['departamento'] }}
                                                </div>

                                                <div class="suggest-mini-meta">
                                                    {{ $item->sugerencia_departamento['origen'] }}
                                                    · {{ $item->sugerencia_departamento['confianza'] }}
                                                    · {{ $item->sugerencia_departamento['cantidad'] }} vez/veces
                                                </div>
                                            </div>
                                        </div>

                                        <div class="suggest-mini-actions">
                                            <button type="button" class="btn-suggest-mini btn-suggest-review"
                                                title="Abrir y cargar sugerencia"
                                                wire:click="usarSugerencia({{ $item->id }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <button type="button" class="btn-suggest-mini btn-suggest-pay"
                                                title="Pagar automáticamente"
                                                wire:click="pagarAutomaticoSugerencia({{ $item->id }})">
                                                <i class="bi bi-check2-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <span class="suggest-empty">
                                        Sin sugerencia
                                    </span>
                                @endif

                            </td>



                            <td data-label="Monto" class="text-end">
                                <span class="amount-main">
                                    Bs {{ number_format($item->monto, 2) }}
                                </span>
                            </td>

                            <td data-label="Aplicado" class="text-end">
                                <span class="amount-applied">
                                    Bs {{ number_format($item->monto_aplicado, 2) }}
                                </span>
                            </td>

                            <td data-label="Saldo" class="text-end">
                                <span class="{{ $item->saldo_pendiente > 0 ? 'amount-pending' : 'amount-ok' }}">
                                    Bs {{ number_format($item->saldo_pendiente, 2) }}
                                </span>
                            </td>

                            <td data-label="Estado">
                                @if ($item->estado == 'Aplicado completo')
                                    <span class="status-pill status-ok">Aplicado completo</span>
                                @elseif ($item->estado == 'Aplicado parcial')
                                    <span class="status-pill status-warning">Aplicado parcial</span>
                                @elseif ($item->estado == 'Pendiente')
                                    <span class="status-pill status-pending">Pendiente</span>
                                @elseif ($item->estado == 'No identificado')
                                    <span class="status-pill status-muted">No identificado</span>
                                @else
                                    <span class="status-pill status-muted">{{ $item->estado }}</span>
                                @endif
                            </td>

                            <td data-label="Acción" class="text-end">
                                <div class="income-actions">

                                    <button type="button" class="btn-regularizar-icon" title="Regularizar ingreso"
                                        wire:click="abrirRegularizar({{ $item->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" class="btn-ingreso-delete"
                                        title="Eliminar ingreso bancario"
                                        onclick="confirm('¿Eliminar este ingreso bancario? Esta acción no se puede deshacer.') || event.stopImmediatePropagation()"
                                        wire:click="eliminarIngresoBancario({{ $item->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h6>No hay ingresos para mostrar</h6>
                                    <p>Cambia los filtros o carga nuevos ingresos bancarios.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="reg-pagination">
            {{ $ingresos->links() }}
        </div>
    </div>
    @if ($modalReporteDeudas)
        <div class="reg-modal-backdrop">
            <div class="reg-modal-panel modal-report-debt">

                <div class="reg-modal-header">
                    <div>
                        <div class="reg-kicker">Reporte de deudas</div>
                        <h4>Departamentos con deuda</h4>
                        <p>
                            Lista de departamentos con meses pendientes según el criterio seleccionado.
                        </p>
                    </div>

                    <button type="button" class="reg-modal-close" wire:click="$set('modalReporteDeudas', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="reg-modal-body">

                    <div class="report-filter-bar">
                        <div>
                            <label class="reg-label">Año del reporte</label>
                            <select class="reg-control" wire:model="anioReporteDeudas"
                                wire:change="generarReporteDeudas">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>

                        <div class="report-info-box">
                            <span>Criterio</span>
                            <strong>{{ $criterioReporteDeudas }}</strong>
                        </div>

                        <div class="report-total-box">
                            <span>Departamentos</span>
                            <strong>{{ $totalDepartamentosDeudores }}</strong>
                        </div>

                        <div class="report-total-box">
                            <span>Total deuda</span>
                            <strong>Bs {{ number_format($totalDeudaReporte, 2) }}</strong>
                        </div>
                    </div>

                    <div class="report-actions">
                        <button type="button" class="btn-line" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                            Imprimir
                        </button>
                    </div>

                    <div class="report-table-wrap">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th style="width: 220px;">Departamento</th>
                                    <th>Meses adeudados</th>
                                    <th style="width: 120px;" class="text-center">Cantidad</th>
                                    <th style="width: 150px;" class="text-end">Total deuda</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($reporteDeudas as $fila)
                                    <tr>
                                        <td>
                                            <div class="report-dept">
                                                {{ $fila['departamento'] }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="debt-months-list">
                                                @foreach ($fila['meses'] as $mes)
                                                    <div class="debt-month-item">
                                                        <div>
                                                            <strong>{{ $mes['mes'] }}</strong>
                                                            <span>
                                                                Expensa Bs
                                                                {{ number_format($mes['monto_expensa'], 2) }}
                                                                · Pagado Bs
                                                                {{ number_format($mes['monto_pagado'], 2) }}
                                                            </span>
                                                        </div>

                                                        <div class="debt-month-balance">
                                                            Bs {{ number_format($mes['saldo'], 2) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="count-pill">
                                                {{ $fila['cantidad_meses'] }}
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <strong class="text-danger">
                                                Bs {{ number_format($fila['total_deuda'], 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="bi bi-check-circle"></i>
                                                </div>
                                                <h6>No hay deudas para mostrar</h6>
                                                <p>No se encontraron departamentos con deuda bajo este criterio.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    @endif
    @if ($modalRegularizar)
        <div class="reg-modal-backdrop">
            <div class="reg-modal-panel">

                <div class="reg-modal-header">
                    <div>
                        <div class="reg-kicker">Regularización manual</div>
                        <h4>Distribuir ingreso bancario</h4>
                        <p>
                            Divide el depósito entre uno o varios departamentos, meses o aplicaciones especiales.
                        </p>
                    </div>

                    <button type="button" class="reg-modal-close" wire:click="$set('modalRegularizar', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="reg-modal-body">

                    <div class="income-strip">
                        <div class="income-item wide">
                            <span>Depositante</span>
                            <strong>{{ $ingresoDepositante ?: 'SIN DEPOSITANTE' }}</strong>
                        </div>

                        <div class="income-item">
                            <span>Fecha</span>
                            <strong>
                                {{ \Carbon\Carbon::parse($ingresoFecha)->format('d/m/Y') }}
                                {{ $ingresoHora }}
                            </strong>
                        </div>

                        <div class="income-item">
                            <span>Comprobante</span>
                            <strong>{{ $ingresoComprobante }}</strong>
                        </div>

                        <div class="income-item">
                            <span>Monto recibido</span>
                            <strong>Bs {{ number_format($ingresoMonto, 2) }}</strong>
                        </div>

                        <div class="income-item">
                            <span>Aplicado</span>
                            <strong class="text-primary">
                                Bs {{ number_format($ingresoAplicado, 2) }}
                            </strong>
                        </div>

                        <div class="income-item">
                            <span>Saldo</span>
                            <strong class="{{ $ingresoSaldo > 0 ? 'text-danger' : 'text-success' }}">
                                Bs {{ number_format($ingresoSaldo, 2) }}
                            </strong>
                        </div>
                    </div>

                    <div class="reg-workspace">

                        <div class="reg-left-panel">

                            <div class="section-card">
                                <div class="section-head">
                                    <div>
                                        <h5>Seleccionar departamento</h5>
                                        <span>Busca el departamento u oficina para ver sus meses pendientes.</span>
                                    </div>
                                </div>

                                <div class="section-body">
                                    <div class="dept-filter-grid">
                                        <div>
                                            <label class="reg-label">Año de expensas</label>
                                            <select class="reg-control" wire:model="anioExpensas"
                                                wire:change="cambiarAnioExpensas">
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="reg-label">Departamento / oficina</label>
                                            <select class="reg-control" wire:model="departamentoSeleccionado"
                                                wire:change="buscarDepartamento">
                                                <option value="">Seleccione departamento...</option>
                                                @foreach ($this->departamentos as $dep)
                                                    <option value="{{ $dep->nombre }}">
                                                        {{ $dep->nombre }} - Bs {{ number_format($dep->costo, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if ($departamentoSeleccionado)
                                        <div class="dept-title">
                                            <span>Estado de cuenta</span>
                                            <strong>{{ $departamentoSeleccionado }}</strong>
                                        </div>

                                        @if (count($expensasDepartamento) > 0)
                                            <div class="mini-table-wrap">
                                                <table class="mini-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Mes</th>
                                                            <th class="text-end">Expensa</th>
                                                            <th class="text-end">Pagado</th>
                                                            <th class="text-end">Saldo</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($expensasDepartamento as $exp)
                                                            <tr wire:key="expensa-{{ $exp['id'] }}">
                                                                <td>
                                                                    <div class="mini-main">
                                                                        {{ \Carbon\Carbon::parse($exp['fecha_mes'])->translatedFormat('F Y') }}
                                                                    </div>
                                                                    <div class="mini-sub">
                                                                        {{ $exp['estado'] }}
                                                                    </div>
                                                                </td>

                                                                <td class="text-end">
                                                                    <div class="fw-bold">
                                                                        Bs
                                                                        {{ number_format($exp['monto_expensa'], 2) }}
                                                                    </div>

                                                                    @if (!empty($exp['aplica_descuento']) && $exp['aplica_descuento'] == 1)
                                                                        <div class="discount-note">
                                                                            Con descuento: Bs
                                                                            {{ number_format($exp['monto_con_descuento'], 2) }}
                                                                            <br>
                                                                            Hasta
                                                                            {{ \Carbon\Carbon::parse($exp['fecha_limite_descuento'])->format('d/m/Y') }}
                                                                        </div>
                                                                    @endif
                                                                </td>

                                                                <td class="text-end">
                                                                    Bs {{ number_format($exp['monto_pagado'], 2) }}
                                                                </td>

                                                                <td class="text-end">
                                                                    <strong
                                                                        class="{{ $exp['saldo'] > 0 ? 'text-danger' : 'text-success' }}">
                                                                        Bs {{ number_format($exp['saldo'], 2) }}
                                                                    </strong>
                                                                </td>

                                                                <td class="text-end">
                                                                    <button type="button" class="btn-add-mini"
                                                                        wire:click="agregarLineaExpensa({{ $exp['id'] }})">
                                                                        Agregar
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="hint-box">
                                                <i class="bi bi-exclamation-circle"></i>
                                                No se encontraron expensas para este departamento. Revisa que el nombre
                                                coincida con la tabla de expensas.
                                            </div>
                                        @endif
                                    @else
                                        <div class="hint-box">
                                            <i class="bi bi-info-circle"></i>
                                            Selecciona un departamento para ver los meses generados y agregar pagos.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="section-card">
                                <div class="section-head">
                                    <div>
                                        <h5>Aplicación especial</h5>
                                        <span>Usa esta opción para gestión anterior, alquiler salón u otros
                                            ingresos.</span>
                                    </div>
                                </div>

                                <div class="section-body">
                                    <div class="special-grid">
                                        <div>
                                            <label class="reg-label">Tipo</label>
                                            <select class="reg-control" wire:model.defer="tipoAplicacionEspecial">
                                                <option value="">Seleccione...</option>
                                                <option value="Gestion anterior">Gestión anterior</option>
                                                <option value="Alquiler salon">Alquiler salón</option>
                                                <option value="Otro ingreso">Otro ingreso</option>
                                                <option value="No identificado">No identificado</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="reg-label">Monto</label>
                                            <input type="number" step="0.01" class="reg-control"
                                                wire:model.defer="montoEspecial" placeholder="0.00">
                                        </div>

                                        <div>
                                            <label class="reg-label">Observación</label>
                                            <input type="text" class="reg-control"
                                                wire:model.defer="observacionEspecial" placeholder="Detalle opcional">
                                        </div>

                                        <div class="d-flex align-items-end">
                                            <button type="button" class="btn-special-add"
                                                wire:click="agregarEspecial">
                                                Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="reg-right-panel">

                            <div class="section-card">
                                <div class="section-head actions-head">
                                    <div>
                                        <h5>Aplicaciones a guardar</h5>
                                        <span>Detalle de cómo se distribuirá este ingreso.</span>
                                    </div>

                                    <button type="button" class="btn-line" wire:click="agregarLineaLibre">
                                        Línea manual
                                    </button>
                                </div>

                                <div class="section-body p-0">
                                    <div class="mini-table-wrap">
                                        <table class="mini-table">
                                            <thead>
                                                <tr>
                                                    <th>Destino</th>
                                                    <th style="width: 160px;">Estado</th>
                                                    <th style="width: 120px;" class="text-end">Monto</th>
                                                    <th style="width: 220px;">Observación</th>
                                                    <th style="width: 90px;"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($lineas as $index => $linea)
                                                    <tr wire:key="linea-{{ $index }}">
                                                        <td>
                                                            <div class="mini-main">
                                                                {{ $linea['departamento_nombre'] ?? $linea['tipo'] }}
                                                            </div>

                                                            @if (!empty($linea['fecha_mes']))
                                                                <div class="mini-sub">
                                                                    {{ $exp['estado'] }}

                                                                    @if (!empty($exp['tipo_estado']))
                                                                        · {{ $exp['tipo_estado'] }}
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="mini-sub">
                                                                    {{ $linea['tipo'] }}
                                                                </div>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <select class="reg-control compact"
                                                                wire:model.defer="lineas.{{ $index }}.estado_pago">
                                                                <option value="Pagado">Pagado</option>
                                                                <option value="Adelantado">Adelantado</option>
                                                                <option value="Atrasado">Atrasado</option>
                                                                <option value="Parcial">Parcial</option>
                                                                <option value="Gestion anterior">Gestión anterior
                                                                </option>
                                                                <option value="Alquiler salon">Alquiler salón</option>
                                                                <option value="Otro ingreso">Otro ingreso</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number" step="0.01"
                                                                class="reg-control compact text-end"
                                                                wire:model.defer="lineas.{{ $index }}.monto">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="reg-control compact"
                                                                wire:model.defer="lineas.{{ $index }}.observacion"
                                                                placeholder="Observación">
                                                        </td>

                                                        <td class="text-end">
                                                            <button type="button" class="btn-remove"
                                                                wire:click="quitarLinea({{ $index }})">
                                                                Quitar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="empty-inside">
                                                                Todavía no agregaste aplicaciones.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="section-footer">
                                    <button type="button" class="btn-save" wire:click="guardarRegularizacion"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="guardarRegularizacion">
                                            Guardar regularización
                                        </span>
                                        <span wire:loading wire:target="guardarRegularizacion">
                                            Guardando...
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="section-card">
                                <div class="section-head">
                                    <div>
                                        <h5>Aplicaciones actuales</h5>
                                        <span>Movimientos ya guardados para este ingreso.</span>
                                    </div>
                                </div>

                                <div class="section-body p-0">
                                    <div class="mini-table-wrap">
                                        <table class="mini-table">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Departamento</th>
                                                    <th>Mes</th>
                                                    <th class="text-end">Monto</th>
                                                    <th>Estado</th>
                                                    <th>Observación</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($this->aplicacionesActuales as $app)
                                                    <tr wire:key="app-{{ $app->id }}"
                                                        class="{{ $app->estado == 'Anulado' ? 'row-muted' : '' }}">
                                                        <td>{{ $app->tipo_aplicacion }}</td>
                                                        <td>{{ $app->departamento_nombre ?: '—' }}</td>
                                                        <td>
                                                            @if ($app->fecha_inicio_pago)
                                                                {{ \Carbon\Carbon::parse($app->fecha_inicio_pago)->format('m/Y') }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <strong>Bs {{ number_format($app->monto, 2) }}</strong>
                                                        </td>
                                                        <td>
                                                            @if ($app->estado == 'Anulado')
                                                                <span class="status-pill status-muted">Anulado</span>
                                                            @else
                                                                <span
                                                                    class="status-pill status-ok">{{ $app->estado }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!empty($app->observacion))
                                                                <div class="obs-pill">
                                                                    {{ $app->observacion }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            @if ($app->estado != 'Anulado')
                                                                <button type="button" class="btn-remove"
                                                                    wire:click="anularAplicacion({{ $app->id }})">
                                                                    Anular
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7">
                                                            <div class="empty-inside">
                                                                Sin aplicaciones guardadas.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    @endif

    @if ($modalCrearIngreso)
        <div class="reg-modal-backdrop">
            <div class="reg-modal-panel modal-create-income">

                <div class="reg-modal-header">
                    <div>
                        <div class="reg-kicker">Registro manual</div>
                        <h4>Nuevo ingreso bancario</h4>
                        <p>
                            Registra manualmente un ingreso que no fue importado desde el extracto bancario.
                        </p>
                    </div>

                    <button type="button" class="reg-modal-close" wire:click="$set('modalCrearIngreso', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="reg-modal-body">
                    <div class="form-grid-income">

                        <div>
                            <label class="reg-label">Fecha</label>
                            <input type="date" class="reg-control" wire:model.defer="nuevoFecha">
                            @error('nuevoFecha')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label class="reg-label">Hora</label>
                            <input type="time" class="reg-control" wire:model.defer="nuevoHora">
                            @error('nuevoHora')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label class="reg-label">Comprobante</label>
                            <input type="text" class="reg-control" wire:model.defer="nuevoComprobante"
                                placeholder="Ej: 3NB9331659">
                            @error('nuevoComprobante')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label class="reg-label">Monto</label>
                            <input type="number" step="0.01" class="reg-control" wire:model.defer="nuevoMonto"
                                placeholder="0.00">
                            @error('nuevoMonto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="span-2">
                            <label class="reg-label">Depositante</label>
                            <input type="text" class="reg-control" wire:model.defer="nuevoDepositante"
                                placeholder="Nombre del depositante">
                            @error('nuevoDepositante')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label class="reg-label">Tipo de ingreso</label>
                            <select class="reg-control" wire:model.defer="nuevoTipoIngreso">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Expensa">Expensa</option>
                                <option value="Gestion anterior">Gestión anterior</option>
                                <option value="Alquiler salon">Alquiler salón</option>
                                <option value="Otro ingreso">Otro ingreso</option>
                                <option value="No identificado">No identificado</option>
                                <option value="Traspaso">Traspaso</option>
                            </select>
                            @error('nuevoTipoIngreso')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="span-2">
                            <label class="reg-label">Detalle</label>
                            <input type="text" class="reg-control" wire:model.defer="nuevoDetalle"
                                placeholder="Detalle del movimiento">
                            @error('nuevoDetalle')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="span-2">
                            <label class="reg-label">Observación</label>
                            <textarea class="reg-control textarea-control" wire:model.defer="nuevoObservacion" placeholder="Observación interna"></textarea>
                            @error('nuevoObservacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="section-footer">
                    <button type="button" class="btn-line" wire:click="$set('modalCrearIngreso', false)">
                        Cancelar
                    </button>

                    <button type="button" class="btn-save" wire:click="guardarIngresoBancario"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="guardarIngresoBancario">
                            Guardar ingreso
                        </span>
                        <span wire:loading wire:target="guardarIngresoBancario">
                            Guardando...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    @if ($modalResultadoPagoAutomatico)
        <div class="auto-pay-modal-backdrop">
            <div class="auto-pay-modal">

                <div class="auto-pay-header">
                    <div>
                        <div class="auto-pay-kicker">Pago automático aplicado</div>
                        <h4>{{ $resultadoPagoAutomatico['departamento'] ?? '' }}</h4>
                        <p>
                            {{ $resultadoPagoAutomatico['depositante'] ?? '' }}
                            ·
                            {{ !empty($resultadoPagoAutomatico['fecha']) ? \Carbon\Carbon::parse($resultadoPagoAutomatico['fecha'])->format('d/m/Y') : '' }}
                            {{ $resultadoPagoAutomatico['hora'] ?? '' }}
                            · Comp. {{ $resultadoPagoAutomatico['comprobante'] ?? 'Sin comprobante' }}
                        </p>
                    </div>

                    <button type="button" class="auto-pay-close"
                        wire:click="$set('modalResultadoPagoAutomatico', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="auto-pay-summary">
                    <div>
                        <span>Monto ingreso</span>
                        <strong>Bs {{ number_format($resultadoPagoAutomatico['monto_ingreso'] ?? 0, 2) }}</strong>
                    </div>

                    <div>
                        <span>Total aplicado</span>
                        <strong class="text-primary">Bs
                            {{ number_format($resultadoPagoAutomatico['total_aplicado'] ?? 0, 2) }}</strong>
                    </div>

                    <div>
                        <span>Saldo restante</span>
                        <strong
                            class="{{ ($resultadoPagoAutomatico['saldo_restante'] ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                            Bs {{ number_format($resultadoPagoAutomatico['saldo_restante'] ?? 0, 2) }}
                        </strong>
                    </div>
                </div>

                <div class="auto-pay-body">
                    <div class="auto-pay-title">
                        Meses aplicados automáticamente
                    </div>

                    @if (!empty($resultadoPagoAutomatico['detalle']))
                        <div class="auto-pay-list">
                            @foreach ($resultadoPagoAutomatico['detalle'] as $item)
                                <div class="auto-pay-item">
                                    <div class="auto-pay-month">
                                        <strong>{{ $item['mes'] }} {{ $item['anio'] }}</strong>

                                        <span>
                                            Expensa Bs {{ number_format($item['monto_expensa'], 2) }}
                                            · Objetivo Bs {{ number_format($item['monto_objetivo'], 2) }}
                                        </span>

                                        @if ($item['tipo_estado'] === 'Descuento pronto pago')
                                            <small class="discount-ok">
                                                Descuento pronto pago
                                            </small>
                                        @elseif ($item['estado_expensa'] === 'Parcial')
                                            <small class="partial-ok">
                                                Pago parcial / adelanto
                                            </small>
                                        @else
                                            <small class="normal-ok">
                                                Pago normal
                                            </small>
                                        @endif
                                    </div>

                                    <div class="auto-pay-amounts">
                                        <div>
                                            <span>Aplicado</span>
                                            <strong>Bs {{ number_format($item['monto_aplicado'], 2) }}</strong>
                                        </div>

                                        <div>
                                            <span>Pagado total</span>
                                            <strong>Bs {{ number_format($item['nuevo_pagado'], 2) }}</strong>
                                        </div>

                                        <div>
                                            <span>Saldo mes</span>
                                            <strong
                                                class="{{ $item['nuevo_saldo'] > 0 ? 'text-danger' : 'text-success' }}">
                                                Bs {{ number_format($item['nuevo_saldo'], 2) }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="auto-pay-state">
                                        <span
                                            class="{{ $item['estado_expensa'] === 'Pagado' ? 'state-paid' : 'state-partial' }}">
                                            {{ $item['estado_expensa'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="auto-pay-empty">
                            No se aplicó ningún mes. Revisa si el departamento tiene expensas pendientes.
                        </div>
                    @endif
                </div>

                <div class="auto-pay-footer">
                    <button type="button" class="btn-auto-pay-ok"
                        wire:click="$set('modalResultadoPagoAutomatico', false)">
                        Entendido
                    </button>
                </div>

            </div>
        </div>
    @endif

    @if ($modalImportarIngresos)
        <div class="excel-modal-backdrop">
            <div class="excel-modal-panel">
                <div class="excel-modal-head">
                    <div>
                        <span>Importacion Excel</span>
                        <h4>Cargar ingresos bancarios</h4>
                        <p>Primero se valida todo el archivo. Si hay errores, no se guarda ningun dato.</p>
                    </div>

                    <button type="button" wire:click="$set('modalImportarIngresos', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <label class="excel-upload-box">
                    <i class="bi bi-file-earmark-excel"></i>
                    <span>
                        <strong>Archivo Excel</strong>
                        <small>Usa la plantilla descargada para evitar errores.</small>
                        <input type="file" wire:model="archivoImportacion" accept=".xlsx,.xls,.csv">
                        @error('archivoImportacion') <small>{{ $message }}</small> @enderror
                    </span>
                </label>

                <div class="excel-modal-actions">
                    <button type="button" class="secondary" wire:click="$set('modalImportarIngresos', false)">
                        Cancelar
                    </button>
                    <button type="button" class="primary" wire:click="validarImportacionIngresos" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="validarImportacionIngresos">Paso 1: revisar archivo</span>
                        <span wire:loading wire:target="validarImportacionIngresos">Revisando...</span>
                    </button>
                </div>

                @if ($importacionErrores)
                    <div class="import-box error">
                        <strong>Errores encontrados</strong>
                        @foreach ($importacionErrores as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                @if ($importacionValida)
                    <div class="import-box ok">
                        <strong>Archivo listo para subir</strong>
                        <span>Ingresos: {{ $importacionResumen['ingresos'] ?? 0 }}</span>
                        <span>Aplicaciones: {{ $importacionResumen['aplicaciones'] ?? 0 }}</span>
                        <span>Total ingresos: Bs {{ number_format($importacionResumen['monto_total'] ?? 0, 2) }}</span>
                        <span>Total a aplicar: Bs {{ number_format($importacionResumen['monto_aplicar'] ?? 0, 2) }}</span>
                    </div>

                    <div class="import-preview">
                        @foreach ($importacionPreview as $item)
                            <div>
                                <strong>{{ $item['tipo_aplicacion'] }}{{ !empty($item['departamento']) ? ' - '.$item['departamento'] : '' }}</strong>
                                <span>
                                    @if (!empty($item['meses']))
                                        {{ implode(', ', $item['meses']) }}/{{ $item['anio'] }} -
                                    @endif
                                    Bs {{ number_format($item['monto'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="excel-modal-actions">
                        <button type="button" class="primary" wire:click="confirmarImportacionIngresos" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="confirmarImportacionIngresos">Paso 2: subir y aplicar</span>
                            <span wire:loading wire:target="confirmarImportacionIngresos">Subiendo...</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <style>
        .excel-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1060;
            background: rgba(15, 23, 42, .58);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            overflow-y: auto;
        }

        .excel-modal-panel {
            width: min(760px, 100%);
            max-height: 90vh;
            overflow-y: auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .28);
            padding: 18px;
        }

        .excel-modal-head {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            border-bottom: 1px solid #edf1f5;
            padding-bottom: 14px;
        }

        .excel-modal-head span {
            display: block;
            color: #1266f1;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .excel-modal-head h4 {
            margin: 3px 0 4px;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
        }

        .excel-modal-head p {
            margin: 0;
            color: #607086;
            font-weight: 700;
            line-height: 1.45;
        }

        .excel-modal-head button {
            flex: 0 0 auto;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 8px;
            background: #eef2f7;
            color: #344256;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .excel-upload-box {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            border: 1px dashed #b9c7db;
            border-radius: 8px;
            padding: 14px;
            margin-top: 14px;
            background: #f8fafc;
        }

        .excel-upload-box > i {
            font-size: 24px;
            color: #0f7c55;
        }

        .excel-upload-box span {
            display: grid;
            gap: 6px;
            width: 100%;
        }

        .excel-upload-box strong {
            color: #172033;
            font-weight: 900;
        }

        .excel-upload-box small {
            color: #607086;
            font-weight: 750;
        }

        .excel-upload-box input {
            width: 100%;
            margin-top: 4px;
        }

        .excel-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 14px;
        }

        .excel-modal-actions button {
            min-height: 42px;
            border: 0;
            border-radius: 8px;
            padding: 0 14px;
            font-weight: 900;
        }

        .excel-modal-actions .secondary {
            background: #eef2f7;
            color: #344256;
        }

        .excel-modal-actions .primary {
            background: #1266f1;
            color: #ffffff;
        }

        @media (max-width: 700px) {
            .excel-modal-backdrop {
                align-items: flex-start;
                padding: 10px;
            }

            .excel-modal-panel {
                max-height: calc(100vh - 20px);
                padding: 14px;
                border-radius: 8px;
            }

            .excel-modal-head {
                gap: 10px;
            }

            .excel-modal-head h4 {
                font-size: 19px;
            }

            .excel-modal-head p {
                font-size: 13px;
            }

            .excel-upload-box {
                display: grid;
            }

            .excel-modal-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .excel-modal-actions button {
                width: 100%;
            }
        }

        .import-box {
            display: grid;
            gap: 6px;
            border-radius: 8px;
            padding: 12px;
            margin-top: 14px;
            font-weight: 800;
        }

        .import-box strong {
            font-weight: 900;
        }

        .import-box.error {
            background: #fff0f3;
            color: #b42345;
            border: 1px solid #ffd6df;
        }

        .import-box.ok {
            background: #eafaf2;
            color: #0f7c55;
            border: 1px solid #c8f0dd;
        }

        .import-preview {
            display: grid;
            gap: 8px;
            margin-top: 12px;
            max-height: 240px;
            overflow: auto;
        }

        .import-preview div {
            border: 1px solid #edf1f5;
            border-radius: 8px;
            padding: 10px;
        }

        .import-preview strong,
        .import-preview span {
            display: block;
        }

        .import-preview span {
            color: #607086;
            font-size: 12px;
            font-weight: 800;
            margin-top: 2px;
        }

        .income-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .btn-ingreso-delete {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 11px;
            background: #fee2e2;
            color: #b91c1c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .15s ease;
        }

        .btn-ingreso-delete:hover {
            background: #fecaca;
            color: #991b1b;
        }

        .suggestion-stack {
            display: grid;
            gap: 8px;
        }

        .suggest-box-multiple {
            border-left: 4px solid #0f9f6e;
        }

        .suggest-box-multiple .suggest-mini-meta {
            line-height: 1.35;
        }

        .auto-pay-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1060;
            background: rgba(15, 23, 42, .65);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 28px;
            overflow-y: auto;
        }

        .auto-pay-modal {
            width: min(850px, 100%);
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 70px rgba(15, 23, 42, .30);
            overflow: hidden;
        }

        .auto-pay-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 24px;
            border-bottom: 1px solid #edf1f5;
        }

        .auto-pay-kicker {
            color: #0f9f6e;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .auto-pay-header h4 {
            margin: 0;
            color: #111827;
            font-size: 21px;
            font-weight: 900;
        }

        .auto-pay-header p {
            margin: 5px 0 0;
            color: #8b95a7;
            font-size: 12px;
            font-weight: 750;
        }

        .auto-pay-close {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 12px;
            background: #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .auto-pay-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 16px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #edf1f5;
        }

        .auto-pay-summary div {
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 15px;
            padding: 13px;
        }

        .auto-pay-summary span {
            display: block;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .auto-pay-summary strong {
            color: #111827;
            font-size: 17px;
            font-weight: 900;
        }

        .auto-pay-body {
            padding: 20px 24px;
        }

        .auto-pay-title {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .auto-pay-list {
            display: grid;
            gap: 12px;
        }

        .auto-pay-item {
            display: grid;
            grid-template-columns: 1.2fr 1.4fr auto;
            gap: 14px;
            align-items: center;
            border: 1px solid #edf1f5;
            border-radius: 17px;
            padding: 14px;
            background: #ffffff;
        }

        .auto-pay-month strong {
            display: block;
            color: #111827;
            font-size: 15px;
            font-weight: 900;
        }

        .auto-pay-month span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 750;
            margin-top: 4px;
        }

        .auto-pay-month small {
            display: inline-flex;
            margin-top: 8px;
            border-radius: 999px;
            padding: 5px 9px;
            font-size: 10px;
            font-weight: 900;
        }

        .discount-ok {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .partial-ok {
            background: #fff8dd;
            color: #9a6a00;
        }

        .normal-ok {
            background: #eef2f7;
            color: #64748b;
        }

        .auto-pay-amounts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .auto-pay-amounts div {
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 12px;
            padding: 10px;
        }

        .auto-pay-amounts span {
            display: block;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .auto-pay-amounts strong {
            color: #111827;
            font-size: 12px;
            font-weight: 900;
        }

        .auto-pay-state span {
            display: inline-flex;
            border-radius: 999px;
            padding: 8px 11px;
            font-size: 11px;
            font-weight: 900;
            white-space: nowrap;
        }

        .state-paid {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .state-partial {
            background: #fff8dd;
            color: #9a6a00;
        }

        .auto-pay-footer {
            display: flex;
            justify-content: flex-end;
            padding: 0 24px 22px;
        }

        .btn-auto-pay-ok {
            border: none;
            background: #0f9f6e;
            color: #ffffff;
            border-radius: 13px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 900;
        }

        .auto-pay-empty {
            background: #f8fafc;
            border: 1px dashed #dbe3ef;
            border-radius: 15px;
            padding: 18px;
            color: #8b95a7;
            font-size: 13px;
            font-weight: 800;
            text-align: center;
        }

        .text-primary {
            color: #0095e8 !important;
        }

        .text-danger {
            color: #f1416c !important;
        }

        .text-success {
            color: #0f9f6e !important;
        }

        @media (max-width: 768px) {
            .auto-pay-modal-backdrop {
                padding: 12px;
            }

            .auto-pay-summary,
            .auto-pay-item,
            .auto-pay-amounts {
                grid-template-columns: 1fr;
            }
        }

        .btn-report-debt {
            border: none;
            background: #fff8dd;
            color: #9a6a00;
            border-radius: 14px;
            padding: 13px 18px;
            font-size: 13px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 25px rgba(154, 106, 0, .12);
        }

        .btn-report-debt:hover {
            background: #ffeeb3;
            color: #7a4f00;
        }

        .modal-report-debt {
            width: min(1200px, 100%);
        }

        .report-filter-bar {
            display: grid;
            grid-template-columns: 170px 1fr 150px 170px;
            gap: 14px;
            align-items: end;
            margin-bottom: 18px;
        }

        .report-info-box,
        .report-total-box {
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 14px;
            padding: 13px 15px;
            min-height: 72px;
        }

        .report-info-box span,
        .report-total-box span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 850;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-info-box strong {
            color: #374151;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 750;
        }

        .report-total-box strong {
            color: #111827;
            font-size: 17px;
            font-weight: 900;
        }

        .report-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
        }

        .report-table-wrap {
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 16px;
            overflow: hidden;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table thead th {
            background: #f8fafc;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid #eef0f4;
        }

        .report-table tbody td {
            padding: 15px 16px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
        }

        .report-dept {
            font-size: 14px;
            font-weight: 900;
            color: #111827;
        }

        .debt-months-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .debt-month-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            background: #fff7f9;
            border: 1px solid #ffe1e9;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .debt-month-item strong {
            display: block;
            color: #111827;
            font-size: 13px;
            font-weight: 900;
        }

        .suggest-actions {
            display: flex;
            gap: 6px;
            margin-top: 8px;
        }

        .btn-use-suggest,
        .btn-auto-pay {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 9px;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .15s ease;
        }

        .btn-use-suggest {
            background: #eaf6ff;
            color: #0095e8;
        }

        .btn-use-suggest:hover {
            background: #0095e8;
            color: #ffffff;
        }

        .btn-auto-pay {
            background: #e8fff3;
            color: #0f9f6e;
        }

        .btn-auto-pay:hover {
            background: #0f9f6e;
            color: #ffffff;
        }

        .debt-month-item span {
            display: block;
            margin-top: 2px;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 650;
        }

        .debt-month-balance {
            color: #f1416c;
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
        }

        .count-pill {
            display: inline-flex;
            min-width: 36px;
            height: 30px;
            align-items: center;
            justify-content: center;
            background: #eef0f4;
            color: #374151;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
        }

        @media print {

            html,
            body {
                background: #ffffff !important;
                height: auto !important;
                min-height: auto !important;
                overflow: visible !important;
            }

            body * {
                visibility: hidden !important;
            }

            .modal-report-debt,
            .modal-report-debt * {
                visibility: visible !important;
            }

            .reg-modal-backdrop {
                position: static !important;
                inset: auto !important;
                display: block !important;
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
            }

            .modal-report-debt {
                position: static !important;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
                overflow: visible !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                background: #ffffff !important;
            }

            .reg-modal-body {
                padding: 0 !important;
                overflow: visible !important;
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
            }

            .report-table-wrap {
                overflow: visible !important;
                border: none !important;
                border-radius: 0 !important;
            }

            .report-table {
                width: 100% !important;
                border-collapse: collapse !important;
                page-break-inside: auto !important;
            }

            .report-table thead {
                display: table-header-group !important;
            }

            .report-table tbody {
                display: table-row-group !important;
            }

            .report-table tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .report-table th,
            .report-table td {
                border: 1px solid #d1d5db !important;
                padding: 8px 10px !important;
                font-size: 11px !important;
                color: #111827 !important;
            }

            .debt-month-item {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                border: 1px solid #e5e7eb !important;
                background: #ffffff !important;
            }

            .reg-modal-header,
            .report-actions {
                display: none !important;
            }

            .report-filter-bar {
                display: grid !important;
                grid-template-columns: 1fr 1fr 1fr !important;
                margin-bottom: 12px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .report-info-box,
            .report-total-box {
                border: 1px solid #d1d5db !important;
                box-shadow: none !important;
                background: #ffffff !important;
            }

            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }

        @media (max-width: 992px) {
            .report-filter-bar {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .report-filter-bar {
                grid-template-columns: 1fr;
            }

            .debt-month-item {
                flex-direction: column;
            }
        }

        .dept-filter-grid {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 12px;
            align-items: end;
        }

        @media (max-width: 768px) {
            .dept-filter-grid {
                grid-template-columns: 1fr;
            }
        }

        .btn-regularizar-icon {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 12px;
            background: #eaf6ff;
            color: #0095e8;
            font-size: 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .15s ease;
        }

        .btn-regularizar-icon:hover {
            background: #0095e8;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .regularizacion-page {
            padding: 22px;
            background: #f5f7fb;
            min-height: 100vh;
            color: #111827;
        }

        .reg-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .reg-header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .reg-kicker {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #0095e8;
            margin-bottom: 6px;
        }

        .reg-title {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            color: #111827;
        }

        .reg-subtitle {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .reg-header-summary {
            display: flex;
            gap: 12px;
        }

        .summary-box {
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 16px;
            padding: 13px 18px;
            min-width: 110px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
        }

        .summary-box span {
            display: block;
            font-size: 11px;
            color: #9ca3af;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .summary-box strong {
            font-size: 15px;
            color: #111827;
        }

        .reg-filter-card,
        .reg-table-card,
        .section-card {
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
        }

        .reg-filter-card {
            padding: 20px;
            margin-bottom: 20px;
        }

        .reg-label {
            display: block;
            color: #374151;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .reg-control {
            width: 100%;
            height: 48px;
            border: 1px solid #dbe1ea;
            border-radius: 12px;
            padding: 0 14px;
            color: #111827;
            font-weight: 650;
            background: #ffffff;
            outline: none;
            transition: .15s ease;
        }

        .reg-control:focus {
            border-color: #0095e8;
            box-shadow: 0 0 0 4px rgba(0, 149, 232, .10);
        }

        .reg-control.compact {
            height: 38px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .textarea-control {
            height: 95px;
            padding-top: 12px;
            resize: vertical;
        }

        .reg-search {
            position: relative;
        }

        .reg-search i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .reg-search input {
            width: 100%;
            height: 48px;
            border: 1px solid #dbe1ea;
            border-radius: 12px;
            padding: 0 14px 0 42px;
            font-weight: 650;
            outline: none;
        }

        .reg-search input:focus {
            border-color: #0095e8;
            box-shadow: 0 0 0 4px rgba(0, 149, 232, .10);
        }

        .reg-table-card {
            overflow: hidden;
        }

        .reg-table-header {
            padding: 20px 22px;
            border-bottom: 1px solid #eef0f4;
        }

        .reg-table-header h5,
        .section-head h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            color: #111827;
        }

        .reg-table-header span,
        .section-head span {
            display: block;
            margin-top: 3px;
            color: #8b95a7;
            font-size: 12px;
            font-weight: 600;
        }

        .reg-table-wrap {
            width: 100%;
            overflow: visible;
        }

        .reg-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .reg-table th,
        .reg-table td {
            white-space: normal;
            word-break: break-word;
        }

        .reg-table thead th {
            background: #f8fafc;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 14px 10px;
            border-bottom: 1px solid #eef0f4;
        }

        .reg-table tbody td {
            padding: 15px 10px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: middle;
        }

        .reg-table tbody tr:hover {
            background: #fbfdff;
        }

        .col-fecha {
            width: 9%;
        }

        .col-depositante {
            width: 22%;
        }

        .col-sugerencia {
            width: 18%;
        }

        .col-comprobante {
            width: 12%;
        }

        .col-monto {
            width: 9%;
        }

        .col-estado {
            width: 10%;
        }

        .col-accion {
            width: 11%;
        }

        .date-main,
        .person-main,
        .amount-main {
            font-size: 12px;

            color: #111827;
            line-height: 1.35;
        }

        .date-sub,
        .person-sub {
            margin-top: 4px;
            font-size: 12px;
            color: #8b95a7;
            font-weight: 600;
            line-height: 1.35;
        }

        .person-main,
        .person-sub {
            max-width: 100%;
            overflow: visible;
            text-overflow: unset;
            white-space: normal;
        }

        .code-pill {
            display: inline-flex;
            background: #f3f6fb;
            color: #111827;
            border-radius: 10px;
            padding: 7px 10px;
            font-size: 12px;

            letter-spacing: .02em;
            white-space: normal;
            word-break: break-all;
        }

        .suggest-box {
            display: block;
            max-width: 100%;
            background: #eef8ff;
            border: 1px solid #cbeaff;
            border-radius: 12px;
            padding: 9px 10px;
        }

        .suggest-main {
            color: #075985;
            font-size: 13px;
            font-weight: 900;
            line-height: 1.25;
            word-break: break-word;
        }

        .suggest-sub {
            margin-top: 4px;
            color: #64748b;
            font-size: 10px;
            font-weight: 750;
            line-height: 1.25;
        }

        .btn-use-suggest {
            margin-top: 8px;
            border: none;
            border-radius: 9px;
            background: #0095e8;
            color: #ffffff;
            font-size: 11px;
            font-weight: 850;
            padding: 6px 9px;
        }

        .btn-use-suggest:hover {
            background: #007fc6;
        }

        .suggest-empty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #9ca3af;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 800;
        }

        .amount-applied {
            color: #0095e8;
            font-weight: 850;
        }

        .amount-pending {
            color: #f1416c;
            font-weight: 850;
        }

        .amount-ok {
            color: #50cd89;
            font-weight: 850;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 850;
            white-space: normal;
            text-align: center;
            line-height: 1.2;
        }

        .status-ok {
            background: #e8fff3;
            color: #0f9f6e;
        }

        .status-warning {
            background: #fff8dd;
            color: #b58105;
        }

        .status-pending {
            background: #eef0f4;
            color: #374151;
        }

        .status-muted {
            background: #f3f4f6;
            color: #6b7280;
        }

        .btn-new-income,
        .btn-regularizar,
        .btn-save,
        .btn-special-add {
            border: none;
            background: #0095e8;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 850;
            transition: .15s ease;
        }

        .btn-new-income {
            background: #111827;
            padding: 13px 18px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(17, 24, 39, .18);
        }

        .btn-new-income:hover {
            background: #000000;
        }

        .btn-regularizar:hover,
        .btn-save:hover,
        .btn-special-add:hover {
            background: #007fc6;
        }

        .btn-save {
            padding: 12px 22px;
        }

        .btn-special-add {
            width: 100%;
            height: 48px;
            background: #111827;
        }

        .btn-special-add:hover {
            background: #000000;
        }

        .btn-line,
        .btn-add-mini,
        .btn-remove {
            border: none;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 850;
            padding: 8px 12px;
        }

        .btn-line {
            background: #f3f6fb;
            color: #374151;
        }

        .btn-add-mini {
            background: #eaf6ff;
            color: #0095e8;
        }

        .btn-remove {
            background: #fff0f4;
            color: #f1416c;
        }

        .reg-pagination {
            padding: 16px 22px;
            background: #ffffff;
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #f3f6fb;
            color: #9ca3af;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 14px;
        }

        .empty-state h6 {
            font-size: 15px;
            font-weight: 800;
            margin: 0;
        }

        .empty-state p {
            color: #8b95a7;
            margin: 5px 0 0;
        }

        .reg-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, .70);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 24px;
            overflow-y: auto;
        }

        .reg-modal-panel {
            position: relative;
            z-index: 1051;
            width: min(1500px, 100%);
            background: #f5f7fb;
            border-radius: 22px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, .30);
            overflow: hidden;
        }

        .modal-create-income {
            width: min(900px, 100%);
        }

        .reg-modal-header {
            background: #ffffff;
            padding: 22px 26px;
            border-bottom: 1px solid #eef0f4;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .reg-modal-header h4 {
            margin: 0;
            font-size: 21px;
            font-weight: 900;
        }

        .reg-modal-header p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .reg-modal-close {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 12px;
            background: #f3f4f6;
            color: #374151;
        }

        .reg-modal-body {
            padding: 22px;
        }

        .income-strip {
            display: grid;
            grid-template-columns: 2fr repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .income-item {
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 16px;
            padding: 14px;
            min-height: 74px;
        }

        .income-item span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 850;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .income-item strong {
            font-size: 14px;
            font-weight: 900;
            color: #111827;
            word-break: break-word;
        }

        .reg-workspace {
            display: grid;
            grid-template-columns: 42% 58%;
            gap: 18px;
        }

        .reg-left-panel,
        .reg-right-panel {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .section-card {
            overflow: hidden;
        }

        .section-head {
            padding: 17px 18px;
            border-bottom: 1px solid #eef0f4;
            background: #ffffff;
        }

        .actions-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .section-body {
            padding: 18px;
        }

        .discount-note {
            margin-top: 4px;
            font-size: 10px;
            font-weight: 800;
            color: #0f9f6e;
            line-height: 1.25;
        }

        .section-footer {
            padding: 16px 18px;
            border-top: 1px solid #eef0f4;
            background: #ffffff;
            text-align: right;
        }

        .dept-title {
            margin-top: 18px;
            margin-bottom: 10px;
            padding: 12px 14px;
            background: #f8fafc;
            border: 1px solid #eef0f4;
            border-radius: 14px;
        }

        .dept-title span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 850;
            text-transform: uppercase;
        }

        .dept-title strong {
            font-size: 14px;
            font-weight: 900;
        }

        .mini-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mini-table thead th {
            background: #f8fafc;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 12px 14px;
            border-bottom: 1px solid #eef0f4;
            white-space: nowrap;
        }

        .mini-table tbody td {
            padding: 13px 14px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: middle;
        }

        .mini-main {
            font-size: 13px;
            font-weight: 850;
            color: #111827;
        }

        .mini-sub {
            margin-top: 3px;
            font-size: 11px;
            font-weight: 650;
            color: #8b95a7;
        }

        .hint-box,
        .empty-inside {
            margin-top: 14px;
            background: #f8fafc;
            border: 1px dashed #dbe1ea;
            color: #6b7280;
            border-radius: 14px;
            padding: 18px;
            font-size: 13px;
            font-weight: 650;
            text-align: center;
        }

        .hint-box {
            text-align: left;
        }

        .hint-box i {
            color: #0095e8;
            margin-right: 6px;
        }

        .special-grid {
            display: grid;
            grid-template-columns: 1.3fr .8fr 1.3fr 130px;
            gap: 12px;
        }

        .form-grid-income {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .form-grid-income .span-2 {
            grid-column: span 2;
        }

        .obs-pill {
            display: inline-block;
            max-width: 260px;
            background: #fff8dd;
            color: #7a5a00;
            border: 1px solid #f4df9b;
            border-radius: 10px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 750;
            line-height: 1.3;
            white-space: normal;
        }

        .row-muted {
            opacity: .55;
            background: #f9fafb;
        }

        .text-primary {
            color: #0095e8 !important;
        }

        .text-danger {
            color: #f1416c !important;
        }

        .text-success {
            color: #50cd89 !important;
        }

        .swal2-container {
            z-index: 99999 !important;
        }

        .swal2-popup {
            z-index: 100000 !important;
        }

        @media (max-width: 1300px) {
            .reg-table {
                table-layout: auto;
            }

            .reg-table-wrap {
                overflow-x: auto;
            }

            .reg-table {
                min-width: 1150px;
            }
        }

        @media (max-width: 1200px) {
            .income-strip {
                grid-template-columns: repeat(3, 1fr);
            }

            .income-item.wide {
                grid-column: span 3;
            }

            .reg-workspace {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .reg-header-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .btn-new-income {
                width: 100%;
            }

            .form-grid-income {
                grid-template-columns: 1fr 1fr;
            }

            .form-grid-income .span-2 {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .regularizacion-page {
                padding: 14px;
            }

            .reg-header {
                flex-direction: column;
            }

            .reg-header-summary {
                width: 100%;
            }

            .summary-box {
                flex: 1;
            }

            .reg-table-wrap {
                overflow: visible;
            }

            .reg-table {
                min-width: unset;
            }

            .reg-table thead {
                display: none;
            }

            .reg-table tbody tr {
                display: block;
                padding: 14px;
                border-bottom: 1px solid #eef0f4;
            }

            .reg-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 12px;
                padding: 8px 0;
                border-bottom: none;
                text-align: right !important;
            }

            .reg-table tbody td::before {
                content: attr(data-label);
                font-weight: 800;
                color: #8b95a7;
                text-align: left;
                min-width: 110px;
            }

            .reg-table tbody td>* {
                max-width: calc(100% - 120px);
            }

            .reg-modal-backdrop {
                padding: 10px;
            }

            .reg-modal-panel {
                border-radius: 16px;
            }

            .income-strip {
                grid-template-columns: 1fr;
            }

            .income-item.wide {
                grid-column: span 1;
            }

            .special-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .form-grid-income {
                grid-template-columns: 1fr;
            }

            .form-grid-income .span-2 {
                grid-column: span 1;
            }
        }

        .suggest-box-mini {
            width: 100%;
            max-width: 250px;
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 14px;
            padding: 10px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
        }

        .suggest-mini-top {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 9px;
        }

        .suggest-mini-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #eef8ff;
            color: #0095e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .suggest-mini-info {
            min-width: 0;
            flex: 1;
        }

        .suggest-mini-title {
            color: #111827;
            font-size: 13px;
            font-weight: 900;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .suggest-mini-meta {
            margin-top: 3px;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .suggest-mini-actions {
            display: flex;
            gap: 7px;
        }

        .btn-suggest-mini {
            height: 32px;
            border: none;
            border-radius: 10px;
            padding: 0 10px;
            font-size: 11px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex: 1;
            transition: .15s ease;
        }

        .btn-suggest-mini i {
            font-size: 13px;
        }

        .btn-suggest-review {
            background: #eef8ff;
            color: #007fc7;
        }

        .btn-suggest-review:hover {
            background: #0095e8;
            color: #ffffff;
        }

        .btn-suggest-pay {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .btn-suggest-pay:hover {
            background: #0f9f6e;
            color: #ffffff;
        }

        .suggestion-stack {
            display: grid;
            gap: 6px;
        }

        .btn-suggestion-pay {
            width: 100%;
            border: 1px solid #dbe3ef;
            background: #ffffff;
            border-radius: 12px;
            padding: 9px 10px;
            text-align: left;
            transition: .15s ease;
        }

        .btn-suggestion-pay:hover {
            border-color: #0f9f6e;
            background: #f0fdf4;
        }

        .sg-main {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
        }

        .sg-main strong {
            color: #111827;
            font-size: 13px;
            font-weight: 900;
        }

        .sg-main span {
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .btn-suggestion-pay small {
            display: block;
            margin-top: 3px;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
        }

        .reg-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .reg-table-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #111827;
        }

        .reg-table-header span {
            display: block;
            margin-top: 4px;
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        .reg-total-box {
            min-width: 210px;
            padding: 12px 16px;
            border-radius: 16px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            text-align: right;
        }

        .reg-total-box span {
            display: block;
            margin: 0;
            font-size: 11px;
            font-weight: 900;
            color: #16a34a;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .reg-total-box strong {
            display: block;
            margin-top: 3px;
            font-size: 20px;
            font-weight: 950;
            color: #047857;
        }

        .reg-total-box small {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .reg-table-header {
                align-items: stretch;
                flex-direction: column;
            }

            .reg-total-box {
                width: 100%;
                text-align: left;
            }
        }
    </style>

</div>
