<div class="estado-page">
    @php
        $soloLecturaDirectorio = strtoupper((string) (Auth::user()->rol ?? '')) === 'DIRECTORIO';
    @endphp

    <div class="estado-header">
        <div>
            <h3>Estado de cuenta por departamento</h3>
            <p>
                Revisión de expensas, pagos aplicados, deudas, descuentos y pagos observados.
            </p>
        </div>
        <div>
            <button type="button" class="btn-audit-report" wire:click="abrirModalAuditoria">
                <i class="bi bi-shield-check"></i>
                Generar auditoría
            </button>
        </div>
    </div>

    <div class="estado-filters">
        <div>
            <label>Buscar departamento</label>
            <input type="text" wire:model.debounce.500ms="busquedaDepartamento" placeholder="Ej: DPTO 11B, OF 3C..."
                class="estado-control">
        </div>

        <div>
            <label>Año</label>
            <select wire:model="anioFiltro" class="estado-control">
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>
        </div>

        @if ($tieneTipo)
            <div>
                <label>Tipo</label>
                <select wire:model="tipoFiltro" class="estado-control">
                    <option value="">Todos</option>
                    @foreach ($this->tipos as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
            <label>Estado</label>
            <select wire:model="estadoFiltro" class="estado-control">
                <option value="Todos">Todos</option>
                <option value="Irregular">Solo irregulares</option>
                <option value="Al día">Al día</option>
                <option value="Parcial / Atrasado">Parcial / Atrasado</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>
        
    </div>

    <div class="estado-table-wrap">
        <table class="estado-table">
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Tipo</th>
                    <th class="text-center">Meses</th>
                    <th class="text-end">Expensa</th>
                    <th class="text-end">Pagado</th>
                    <th class="text-end">Saldo</th>
                    <th>Estado</th>
                    <th>Irregularidad</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($departamentos as $dep)
                    <tr>
                        <td>
                            <div class="dep-name">{{ $dep->nombre }}</div>
                            <div class="dep-sub">Bs {{ number_format($dep->costo, 2) }} mensual</div>
                        </td>

                        <td>
                            <span class="tipo-pill">{{ $dep->tipo }}</span>
                        </td>

                        <td class="text-center">
                            <strong>{{ $dep->total_meses }}</strong>
                        </td>

                        <td class="text-end">
                            Bs {{ number_format($dep->total_expensa, 2) }}
                        </td>

                        <td class="text-end text-primary fw-bold">
                            Bs {{ number_format($dep->total_pagado, 2) }}
                        </td>

                        <td class="text-end text-danger fw-bold">
                            Bs {{ number_format($dep->total_saldo, 2) }}
                        </td>

                        <td>
                            <span class="estado-pill {{ $dep->estado_clase }}">
                                {{ $dep->estado_cuenta }}
                            </span>
                        </td>
                        <td>
                            @if ($dep->es_irregular)
                                <button type="button" class="btn-irregular"
                                    wire:click="verIrregularidad('{{ addslashes($dep->nombre) }}')">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    {{ $dep->cantidad_irregularidades }} irregular
                                </button>
                            @else
                                <span class="regular-pill">
                                    Regular
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="depto-actions">
                                <button type="button" class="btn-view"
                                    wire:click="abrirDetalle('{{ addslashes($dep->nombre) }}')">
                                    <i class="bi bi-eye"></i>
                                    Ver
                                </button>
                                <button type="button" class="btn-pdf-depto-mini"
                                    title="Reporte completo desde agosto 2024"
                                    wire:click="generarPdfDepartamentoCompleto(@js($dep->nombre))"
                                    wire:loading.attr="disabled" wire:target="generarPdfDepartamentoCompleto">

                                    <span wire:loading.remove wire:target="generarPdfDepartamentoCompleto">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </span>

                                    <span wire:loading wire:target="generarPdfDepartamentoCompleto">
                                        <i class="bi bi-hourglass-split spin-icon"></i>
                                    </span>
                                </button>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                No se encontraron departamentos con los filtros seleccionados.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($modalIrregularidad)
        <div class="estado-modal-backdrop">
            <div class="estado-modal-panel small-modal">

                <div class="estado-modal-header">
                    <div>
                        <div class="modal-kicker">Irregularidades</div>
                        <h4>{{ $departamentoSeleccionado }}</h4>
                        <p>
                            Meses pendientes anteriores a meses pagados. Agosto 2024 no se considera si septiembre ya
                            está pagado.
                        </p>
                    </div>

                    <button type="button" class="modal-close" wire:click="$set('modalIrregularidad', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="irregular-list">
                    @forelse ($irregularidadesDepartamento as $item)
                        <div class="irregular-card">
                            <div>
                                <div class="irregular-title">
                                    {{ $item['mes_pendiente'] }} pendiente
                                </div>

                                <div class="irregular-desc">
                                    Tiene saldo pendiente de
                                    <strong>Bs {{ number_format($item['saldo_pendiente'], 2) }}</strong>,
                                    pero existe pago posterior en
                                    <strong>{{ $item['mes_pagado_posterior'] }}</strong>.
                                </div>

                                <div class="irregular-meta">
                                    Estado pendiente: {{ $item['estado_pendiente'] }}
                                </div>
                            </div>

                            <div class="irregular-actions">
                                <button type="button" class="btn-delete-expensa"
                                    onclick="confirm('¿Eliminar esta expensa pendiente?') || event.stopImmediatePropagation()"
                                    wire:click="eliminarExpensaIrregular({{ $item['expensa_pendiente_id'] }})">
                                    <i class="bi bi-trash"></i>
                                    Eliminar expensa
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            No se encontraron irregularidades.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    @endif
    @if ($modalDetalle)
        <div class="estado-modal-backdrop">
            <div class="estado-modal-panel">

                <div class="estado-modal-header">
                    <div>
                        <div class="modal-kicker">Estado de cuenta</div>
                        <h4>{{ $departamentoSeleccionado }}</h4>
                        <p>
                            Tipo: {{ $tipoSeleccionado }} · Costo mensual: Bs
                            {{ number_format($costoSeleccionado, 2) }}
                        </p>
                    </div>

                    <button type="button" class="modal-close" wire:click="$set('modalDetalle', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="estado-summary-grid">
                    <div class="summary-card">
                        <span>Total expensas</span>
                        <strong>Bs {{ number_format($resumenDepartamento['total_expensas'] ?? 0, 2) }}</strong>
                    </div>

                    <div class="summary-card">
                        <span>Total pagado</span>
                        <strong class="text-primary">Bs
                            {{ number_format($resumenDepartamento['total_pagado'] ?? 0, 2) }}</strong>
                    </div>

                    <div class="summary-card">
                        <span>Saldo pendiente</span>
                        <strong class="text-danger">Bs
                            {{ number_format($resumenDepartamento['total_saldo'] ?? 0, 2) }}</strong>
                    </div>

                    <div class="summary-card">
                        <span>Observados</span>
                        <strong class="text-warning">{{ $resumenDepartamento['pagos_observados'] ?? 0 }}</strong>
                    </div>
                </div>

                <div class="detail-actions">

                    @unless ($soloLecturaDirectorio)
                        <button type="button" class="btn-create-exp" wire:click="abrirCrearExpensas">
                            <i class="bi bi-calendar-plus"></i>
                            Crear expensas
                        </button>
                    @endunless
                </div>

                <div class="estado-lista-expensas">

                    <div class="lista-title-row">
                        <div class="lista-title-info">
                            <h5>Historial de expensas</h5>
                            <p>
                                Desde agosto 2024 en adelante. Agosto 2024 se muestra, pero no suma como deuda si
                                septiembre ya tiene pago.
                            </p>
                        </div>

                        <div class="lista-title-actions">
                            <button type="button" class="btn-pdf-depto"
                                wire:click="generarPdfDepartamentoAnual(@js($departamentoSeleccionado), {{ $anioFiltro }})"
                                wire:loading.attr="disabled" wire:target="generarPdfDepartamentoAnual">

                                <span class="btn-inner" wire:loading.remove wire:target="generarPdfDepartamentoAnual">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    PDF año {{ $anioFiltro }}
                                </span>

                                <span class="btn-inner" wire:loading wire:target="generarPdfDepartamentoAnual">
                                    <i class="bi bi-hourglass-split"></i>
                                    Generando PDF...
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="lista-expensas-table-wrap">
                        <table class="lista-expensas-table">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th class="text-end">Expensa</th>
                                    <th class="text-end">Pagado</th>
                                    <th class="text-end">Saldo</th>
                                    <th>Estado</th>
                                    <th>Pagos aplicados</th>
                                    <th>Diagnóstico</th>
                                    <th class="text-end">Acción</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($expensasDetalle as $exp)
                                    <tr class="{{ $exp['diagnostico']['clase'] }}">
                                        <td>
                                            <div class="mes-cell">
                                                <strong>{{ $exp['mes_nombre'] }} {{ $exp['anio'] }}</strong>

                                                @if ($exp['aplica_descuento'])
                                                    <span>
                                                        Desc.: Bs {{ number_format($exp['monto_con_descuento'], 2) }}
                                                        hasta
                                                        {{ $exp['fecha_limite_descuento'] ? \Carbon\Carbon::parse($exp['fecha_limite_descuento'])->format('d/m/Y') : '-' }}
                                                    </span>
                                                @else
                                                    <span>Sin descuento</span>
                                                @endif

                                                @if ($exp['ignorar_saldo_agosto'])
                                                    <small>Visible, no contable</small>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <strong>Bs {{ number_format($exp['monto_expensa'], 2) }}</strong>
                                        </td>

                                        <td class="text-end text-primary fw-bold">
                                            Bs {{ number_format($exp['monto_pagado'], 2) }}
                                        </td>

                                        <td class="text-end">
                                            @if ($exp['ignorar_saldo_agosto'])
                                                <span class="saldo-neutral">
                                                    No suma
                                                </span>
                                            @else
                                                <strong
                                                    class="{{ $exp['saldo'] > 0 ? 'text-danger' : 'text-success' }}">
                                                    Bs {{ number_format($exp['saldo'], 2) }}
                                                </strong>
                                            @endif
                                        </td>

                                        <td>
                                            <span
                                                class="estado-mini {{ $exp['estado'] === 'Pagado' ? 'estado-ok' : ($exp['estado'] === 'Parcial' ? 'estado-warning' : 'estado-danger') }}">
                                                {{ $exp['estado'] }}
                                            </span>

                                            @if (!empty($exp['tipo_estado']))
                                                <div class="tipo-estado-mini">
                                                    {{ $exp['tipo_estado'] }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            @if (count($exp['aplicaciones']) > 0)
                                                <div class="pagos-mini-list">
                                                    @foreach ($exp['aplicaciones'] as $pago)
                                                        <div class="pago-mini-item">

                                                            <div class="pago-mini-info">
                                                                <strong>{{ $pago['depositante'] }}</strong>

                                                                <span>
                                                                    {{ \Carbon\Carbon::parse($pago['fecha'])->format('d/m/Y') }}
                                                                    {{ $pago['hora'] }}
                                                                    · Comp.
                                                                    {{ $pago['numero_comprobante'] ?: 'Sin comprobante' }}
                                                                </span>

                                                                @if (!empty($pago['estado_pago']))
                                                                    <small>{{ $pago['estado_pago'] }}</small>
                                                                @endif

                                                                @if (!empty($pago['observacion']))
                                                                    <small>{{ $pago['observacion'] }}</small>
                                                                @endif
                                                            </div>

                                                            <div class="pago-mini-side">
                                                                <div class="pago-mini-monto">
                                                                    Bs {{ number_format($pago['monto'], 2) }}
                                                                </div>

                                                                @unless ($soloLecturaDirectorio)
                                                                    <div class="pago-move-actions">
                                                                        <button type="button" class="btn-move-payment"
                                                                            title="Mover este pago al mes anterior"
                                                                            wire:click="moverPagoAplicado({{ $pago['id'] }}, 'arriba')">
                                                                            <i class="bi bi-arrow-up"></i>
                                                                        </button>

                                                                        <button type="button" class="btn-move-payment"
                                                                            title="Mover este pago al mes siguiente"
                                                                            wire:click="moverPagoAplicado({{ $pago['id'] }}, 'abajo')">
                                                                            <i class="bi bi-arrow-down"></i>
                                                                        </button>
                                                                        <button type="button" class="btn-move-payment"
                                                                            title="Dividir este pago"
                                                                            wire:click="abrirModalDividirPago({{ $pago['id'] }})">
                                                                            <i class="bi bi-scissors"></i>
                                                                        </button>
                                                                    </div>
                                                                @endunless
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="sin-pagos-mini">Sin pagos</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="diag-mini {{ $exp['diagnostico']['clase'] }}">
                                                <strong>{{ $exp['diagnostico']['label'] }}</strong>
                                                <span>{{ $exp['diagnostico']['mensaje'] }}</span>

                                                @if (($exp['no_cobrar'] ?? 0) == 1)
                                                    <div class="tipo-estado-mini">
                                                        {{ $exp['tipo_estado'] }}
                                                    </div>

                                                    @if (!empty($exp['motivo_no_cobro']))
                                                        <small class="text-muted">
                                                            {{ $exp['motivo_no_cobro'] }}
                                                        </small>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            @if ($soloLecturaDirectorio)
                                                <span class="no-delete-mini">
                                                    {{ ($exp['monto_pagado'] > 0 || count($exp['aplicaciones']) > 0) ? 'Con pago' : 'Solo lectura' }}
                                                </span>
                                            @else
                                            @if ($exp['monto_pagado'] <= 0 && count($exp['aplicaciones']) === 0)
                                                <button type="button" class="btn-delete-exp-mini"
                                                    onclick="confirm('¿Eliminar esta expensa? Esta acción no se puede deshacer.') || event.stopImmediatePropagation()"
                                                    wire:click="eliminarExpensa({{ $exp['id'] }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @else
                                                <span class="no-delete-mini">
                                                    Con pago
                                                </span>
                                            @endif
                                            @if (($exp['no_cobrar'] ?? 0) == 1)
                                                <button type="button" class="btn-delete-exp-mini"
                                                    title="Volver a cobrar"
                                                    wire:click="quitarNoCobro({{ $exp['id'] }})">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn-exp-action btn-exp-restore"
                                                    title="Volver a cobrar esta expensa"
                                                    wire:click="quitarNoCobro({{ $exp['id'] }})">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                                <button type="button" class="btn-delete-exp-mini"
                                                    title="Marcar como incompleto tolerado"
                                                    wire:click="marcarIncompletoTolerado({{ $exp['id'] }})">
                                                    <i class="bi bi-shield-check"></i>
                                                </button>

                                                <button type="button" class="btn-delete-exp-mini"
                                                    title="Exonerado administrador"
                                                    wire:click="marcarExoneradoAdministrador({{ $exp['id'] }})">
                                                    <i class="bi bi-person-badge"></i>
                                                </button>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                Este departamento todavía no tiene expensas creadas.
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

    @if ($modalCrearExpensas)
        <div class="estado-modal-backdrop">
            <div class="estado-modal-panel small-modal">

                <div class="estado-modal-header">
                    <div>
                        <div class="modal-kicker">Crear expensas</div>
                        <h4>{{ $departamentoSeleccionado }}</h4>
                        <p>
                            Crea meses faltantes sin duplicar registros existentes.
                        </p>
                    </div>

                    <button type="button" class="modal-close" wire:click="$set('modalCrearExpensas', false)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="crear-grid">
                    <div>
                        <label>Año</label>
                        <select wire:model="anioCrearExpensas" class="estado-control">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>

                    <div>
                        <label>Desde mes</label>
                        <select wire:model="desdeMesCrear" class="estado-control">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $this->nombreMes($i) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label>Hasta mes</label>
                        <select wire:model="hastaMesCrear" class="estado-control">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $this->nombreMes($i) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" wire:click="$set('modalCrearExpensas', false)">
                        Cancelar
                    </button>

                    <button type="button" class="btn-save" wire:click="crearExpensasDepartamento">
                        Crear expensas
                    </button>
                </div>

            </div>
        </div>
    @endif

    @if ($modalDividirPago)
        <div class="modal-backdrop-custom">
            <div class="modal-card-custom modal-dividir-pago">

                <div class="modal-header-custom">
                    <div>
                        <h3>Dividir pago aplicado</h3>

                        @if (!empty($pagoDividir))
                            <p>
                                Pago original:
                                <strong>Bs {{ number_format($pagoDividir['monto'] ?? 0, 2) }}</strong>
                                · {{ $pagoDividir['departamento_nombre'] ?? '' }}
                                · {{ $pagoDividir['mes_nombre'] ?? '' }} {{ $pagoDividir['anio'] ?? '' }}
                            </p>
                        @endif
                    </div>

                    <button type="button" class="btn-close-custom" wire:click="cerrarModalDividirPago">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="modal-body-custom">

                    <div class="split-summary">
                        <div>
                            <span>Monto original</span>
                            <strong>Bs {{ number_format($pagoDividir['monto'] ?? 0, 2) }}</strong>
                        </div>

                        <div>
                            <span>Total dividido</span>
                            <strong>Bs {{ number_format(collect($partesDividir)->sum('monto'), 2) }}</strong>
                        </div>

                        <div>
                            <span>Diferencia</span>
                            @php
                                $diferenciaDividir = round(
                                    ($pagoDividir['monto'] ?? 0) - collect($partesDividir)->sum('monto'),
                                    2,
                                );
                            @endphp

                            <strong class="{{ abs($diferenciaDividir) <= 0.01 ? 'text-success' : 'text-danger' }}">
                                Bs {{ number_format($diferenciaDividir, 2) }}
                            </strong>
                        </div>
                    </div>

                    <div class="split-lines">
                        @foreach ($partesDividir as $index => $parte)
                            <div class="split-line">
                                <div>
                                    <label>Monto</label>
                                    <input type="number" step="0.01" min="0"
                                        wire:model.defer="partesDividir.{{ $index }}.monto">
                                </div>

                                <div>
                                    <label>Observación</label>
                                    <input type="text"
                                        wire:model.defer="partesDividir.{{ $index }}.observacion"
                                        placeholder="Ej: Parte 1">
                                </div>

                                <button type="button" class="btn-remove-split" title="Quitar parte"
                                    wire:click="quitarParteDividir({{ $index }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="split-actions">
                        <button type="button" class="btn-split-secondary" wire:click="agregarParteDividir">
                            <i class="bi bi-plus-circle"></i>
                            Agregar parte
                        </button>

                        <button type="button" class="btn-split-secondary" wire:click="dividirRapidoPago('100')">
                            100 + 100 + 100
                        </button>

                        <button type="button" class="btn-split-secondary" wire:click="dividirRapidoPago('200_100')">
                            200 + 100
                        </button>
                    </div>

                </div>

                <div class="modal-footer-custom">
                    <button type="button" class="btn-split-cancel" wire:click="cerrarModalDividirPago">
                        Cancelar
                    </button>

                    <button type="button" class="btn-split-save" wire:click="guardarDivisionPago">
                        <i class="bi bi-check2-circle"></i>
                        Guardar división
                    </button>
                </div>

            </div>
        </div>
    @endif
    @if ($modalAuditoria)
        <div class="audit-modal-backdrop">
            <div class="audit-modal">

                <div class="audit-modal-header">
                    <div>
                        <h4>Generar auditoría del sistema</h4>
                        <p>
                            Complete los datos del responsable y el rango auditado.
                        </p>
                    </div>

                    <button type="button" class="audit-modal-close" wire:click="cerrarModalAuditoria">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="audit-form-grid">

                    <div class="audit-field span-2">
                        <label>Nombre completo del auditor</label>
                        <input type="text" wire:model.defer="auditorNombre" placeholder="Ej. Juan Pérez López">
                        @error('auditorNombre')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="audit-field">
                        <label>Carnet de identidad</label>
                        <input type="text" wire:model.defer="auditorCarnet" placeholder="Ej. 12345678 SC">
                        @error('auditorCarnet')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="audit-field">
                        <label>Cargo / Rol</label>
                        <input type="text" wire:model.defer="auditorCargo"
                            placeholder="Ej. Contador, Administrador, Auditor">
                    </div>

                    <div class="audit-field">
                        <label>Fecha de realización</label>
                        <input type="date" wire:model.defer="auditoriaFechaRealizacion">
                        @error('auditoriaFechaRealizacion')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="audit-field">
                        <label>Inicio del trabajo</label>
                        <input type="date" wire:model.defer="auditoriaTrabajoInicio">
                    </div>

                    <div class="audit-field">
                        <label>Fin del trabajo</label>
                        <input type="date" wire:model.defer="auditoriaTrabajoFin">
                    </div>

                    <div class="audit-field">
                        <label>Mes inicial auditado</label>
                        <select wire:model.defer="auditoriaDesdeMes">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ $this->nombreMes($m) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="audit-field">
                        <label>Año inicial auditado</label>
                        <select wire:model.defer="auditoriaDesdeAnio">
                            @for ($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="audit-field">
                        <label>Mes final auditado</label>
                        <select wire:model.defer="auditoriaHastaMes">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ $this->nombreMes($m) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="audit-field">
                        <label>Año final auditado</label>
                        <select wire:model.defer="auditoriaHastaAnio">
                            @for ($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="audit-field span-2">
                        <label>Observaciones generales</label>
                        <textarea rows="4" wire:model.defer="auditoriaObservaciones"
                            placeholder="Ej. Auditoría realizada sobre registros digitalizados del sistema, comprobantes bancarios, expensas y egresos registrados."></textarea>
                    </div>

                </div>

                <div class="audit-modal-footer">
                    <button type="button" class="btn-audit-cancel" wire:click="cerrarModalAuditoria">
                        Cancelar
                    </button>

                    <button type="button" class="btn-audit-generate" wire:click="generarPdfAuditoriaGeneral"
                        wire:loading.attr="disabled" wire:target="generarPdfAuditoriaGeneral">

                        <span wire:loading.remove wire:target="generarPdfAuditoriaGeneral">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Generar PDF de auditoría
                        </span>

                        <span wire:loading wire:target="generarPdfAuditoriaGeneral">
                            <i class="bi bi-hourglass-split spin-icon"></i>
                            Generando auditoría...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    <style>
        .btn-audit-report {
            height: 38px;
            border: none;
            border-radius: 12px;
            padding: 0 14px;
            background: #0f172a;
            color: #ffffff;
            font-size: 12px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }

        .btn-audit-report:hover {
            background: #1e293b;
        }

        .audit-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, .55);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .audit-modal {
            width: min(920px, 100%);
            max-height: 92vh;
            overflow-y: auto;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 24px 80px rgba(15, 23, 42, .35);
        }

        .audit-modal-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .audit-modal-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 950;
            color: #0f172a;
        }

        .audit-modal-header p {
            margin: 5px 0 0;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
        }

        .audit-modal-close {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 12px;
            background: #f1f5f9;
            color: #334155;
            cursor: pointer;
        }

        .audit-form-grid {
            padding: 18px 20px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .audit-field {
            display: grid;
            gap: 6px;
        }

        .audit-field.span-2 {
            grid-column: span 2;
        }

        .audit-field label {
            font-size: 11px;
            font-weight: 950;
            color: #64748b;
            text-transform: uppercase;
        }

        .audit-field input,
        .audit-field select,
        .audit-field textarea {
            border: 1px solid #d1d5db;
            border-radius: 13px;
            padding: 10px 12px;
            outline: none;
            font-size: 13px;
            font-weight: 800;
            color: #111827;
            background: #ffffff;
        }

        .audit-field textarea {
            resize: vertical;
        }

        .audit-field small {
            color: #dc2626;
            font-size: 11px;
            font-weight: 800;
        }

        .audit-modal-footer {
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-audit-cancel,
        .btn-audit-generate {
            height: 40px;
            border: none;
            border-radius: 13px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-audit-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-audit-generate {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-audit-generate:hover {
            background: #fecaca;
        }

        .spin-icon {
            animation: spinIcon .8s linear infinite;
        }

        @keyframes spinIcon {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 700px) {
            .audit-form-grid {
                grid-template-columns: 1fr;
            }

            .audit-field.span-2 {
                grid-column: span 1;
            }

            .audit-modal-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-audit-cancel,
            .btn-audit-generate {
                width: 100%;
                justify-content: center;
            }
        }

        .depto-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .btn-pdf-depto,
        .btn-pdf-depto-mini {
            border: none;
            border-radius: 11px;
            background: #fee2e2;
            color: #b91c1c;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-pdf-depto {
            height: 36px;
            padding: 0 13px;
            font-size: 12px;
        }

        .btn-pdf-depto-mini {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }

        .btn-pdf-depto:hover,
        .btn-pdf-depto-mini:hover {
            background: #fecaca;
        }

        .btn-pdf-depto:disabled,
        .btn-pdf-depto-mini:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .modal-card-custom {
            width: 100%;
            max-width: 720px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(15, 23, 42, .25);
            overflow: hidden;
        }

        .modal-dividir-pago {
            max-width: 760px;
        }

        .modal-header-custom {
            padding: 22px 26px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .modal-header-custom h3 {
            margin: 0;
            font-size: 19px;
            font-weight: 900;
            color: #111827;
        }

        .modal-header-custom p {
            margin: 6px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .btn-close-custom {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 12px;
            background: #f3f4f6;
            color: #374151;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .modal-body-custom {
            padding: 24px 26px;
        }

        .split-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .split-summary div {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px;
        }

        .split-summary span {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
        }

        .split-summary strong {
            display: block;
            margin-top: 5px;
            font-size: 16px;
        }

        .split-lines {
            display: grid;
            gap: 12px;
        }

        .split-line {
            display: grid;
            grid-template-columns: 140px 1fr 36px;
            gap: 10px;
            align-items: end;
        }

        .split-line label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 5px;
        }

        .split-line input {
            width: 100%;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 0 12px;
            outline: none;
        }

        .btn-remove-split {
            width: 36px;
            height: 38px;
            border: none;
            border-radius: 12px;
            background: #fee2e2;
            color: #b91c1c;
        }

        .split-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .btn-split-secondary {
            border: none;
            border-radius: 12px;
            background: #eef2ff;
            color: #3730a3;
            font-weight: 800;
            padding: 9px 13px;
        }

        .modal-footer-custom {
            padding: 18px 26px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-split-cancel,
        .btn-split-save {
            border: none;
            border-radius: 12px;
            font-weight: 900;
            padding: 10px 16px;
        }

        .btn-split-cancel {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-split-save {
            background: #16a34a;
            color: #fff;
        }

        .pago-mini-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .pago-mini-info {
            display: grid;
            gap: 3px;
            min-width: 0;
        }

        .pago-mini-side {
            display: grid;
            justify-items: end;
            gap: 8px;
            flex-shrink: 0;
        }

        .pago-move-actions {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-move-payment {
            width: 26px;
            height: 26px;
            border: none;
            border-radius: 8px;
            background: #eef2ff;
            color: #4338ca;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            transition: .15s ease;
        }

        .btn-move-payment:hover {
            background: #c7d2fe;
            color: #312e81;
        }

        .exp-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-exp-action {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: .15s ease;
            cursor: pointer;
        }

        .btn-exp-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-exp-delete:hover {
            background: #fecaca;
        }

        .btn-exp-restore {
            background: #e0f2fe;
            color: #0369a1;
        }

        .btn-exp-restore:hover {
            background: #bae6fd;
        }

        .btn-exp-tolerated {
            background: #dcfce7;
            color: #15803d;
        }

        .btn-exp-tolerated:hover {
            background: #bbf7d0;
        }

        .btn-exp-exempt {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-exp-exempt:hover {
            background: #fde68a;
        }

        .exp-action-label,
        .exp-no-charge-label {
            display: inline-flex;
            align-items: center;
            height: 26px;
            padding: 0 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .exp-action-label {
            background: #f1f5f9;
            color: #64748b;
        }

        .exp-no-charge-label {
            background: #ede9fe;
            color: #6d28d9;
        }

        .btn-delete-exp-mini {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 11px;
            background: #fff0f3;
            color: #f1416c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            transition: .15s ease;
        }

        .btn-delete-exp-mini:hover {
            background: #f1416c;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .no-delete-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eef2f7;
            color: #64748b;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 10px;
            font-weight: 900;
            white-space: nowrap;
        }

        .estado-filters {
            display: grid;
            grid-template-columns: 1fr 150px 180px 190px;
            gap: 14px;
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 18px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .btn-irregular {
            border: none;
            background: #fff8dd;
            color: #9a6a00;
            border-radius: 999px;
            padding: 8px 11px;
            font-size: 11px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-irregular:hover {
            background: #ffe9a3;
            color: #7a4f00;
        }

        .regular-pill {
            display: inline-flex;
            background: #eafaf2;
            color: #0f9f6e;
            border-radius: 999px;
            padding: 8px 11px;
            font-size: 11px;
            font-weight: 900;
        }

        .irregular-list {
            padding: 20px 24px 24px;
            display: grid;
            gap: 12px;
        }

        .irregular-card {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            background: #fffdf5;
            border: 1px solid #ffe39b;
            border-radius: 16px;
            padding: 14px;
        }

        .irregular-title {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
        }

        .irregular-desc {
            margin-top: 5px;
            color: #64748b;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.4;
        }

        .irregular-meta {
            margin-top: 6px;
            color: #9a6a00;
            font-size: 11px;
            font-weight: 850;
        }

        .irregular-actions {
            flex-shrink: 0;
        }

        .btn-delete-expensa {
            border: none;
            background: #fff0f3;
            color: #f1416c;
            border-radius: 12px;
            padding: 10px 13px;
            font-size: 12px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-delete-expensa:hover {
            background: #f1416c;
            color: #ffffff;
        }

        @media (max-width: 700px) {
            .irregular-card {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-delete-expensa {
                width: 100%;
                justify-content: center;
            }
        }

        .estado-lista-expensas {
            padding: 20px 24px 24px;
        }

        .lista-title-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .lista-title-row h5 {
            margin: 0;
            color: #111827;
            font-size: 17px;
            font-weight: 900;
        }

        .lista-title-row p {
            margin: 4px 0 0;
            color: #8b95a7;
            font-size: 12px;
            font-weight: 700;
        }

        .lista-expensas-table-wrap {
            border: 1px solid #edf1f5;
            border-radius: 18px;
            overflow-x: auto;
            background: #ffffff;
        }

        .lista-expensas-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
        }

        .lista-expensas-table th {
            background: #f8fafc;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 13px 14px;
            border-bottom: 1px solid #edf1f5;
        }

        .lista-expensas-table td {
            padding: 14px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
            color: #111827;
            font-size: 12px;
            font-weight: 700;
        }

        .lista-expensas-table tr.diag-mal {
            background: #fff8fa;
        }

        .lista-expensas-table tr.diag-parcial {
            background: #fffdf5;
        }

        .lista-expensas-table tr.diag-ok {
            background: #fbfffd;
        }

        .lista-expensas-table tr.diag-neutral {
            background: #f8fafc;
        }

        .mes-cell strong {
            display: block;
            color: #111827;
            font-size: 13px;
            font-weight: 900;
        }

        .mes-cell span {
            display: block;
            margin-top: 4px;
            color: #0f9f6e;
            font-size: 10px;
            font-weight: 850;
        }

        .mes-cell small {
            display: inline-flex;
            margin-top: 6px;
            background: #eef2f7;
            color: #64748b;
            border-radius: 999px;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 900;
        }

        .saldo-neutral {
            display: inline-flex;
            background: #eef2f7;
            color: #64748b;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 11px;
            font-weight: 900;
        }

        .estado-mini {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 10px;
            font-weight: 900;
        }

        .estado-ok {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .estado-warning {
            background: #fff8dd;
            color: #9a6a00;
        }

        .estado-danger {
            background: #fff0f3;
            color: #f1416c;
        }

        .tipo-estado-mini {
            margin-top: 6px;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 850;
        }

        .pagos-mini-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pago-mini-item {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 13px;
            padding: 9px 10px;
        }

        .pago-mini-item strong {
            display: block;
            color: #111827;
            font-size: 12px;
            font-weight: 900;
        }

        .pago-mini-item span {
            display: block;
            margin-top: 3px;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 750;
        }

        .pago-mini-item small {
            display: block;
            margin-top: 3px;
            color: #9a6a00;
            font-size: 10px;
            font-weight: 800;
        }

        .pago-mini-monto {
            color: #0095e8;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .sin-pagos-mini {
            display: inline-flex;
            background: #f8fafc;
            color: #8b95a7;
            border: 1px dashed #dbe3ef;
            border-radius: 999px;
            padding: 7px 10px;
            font-size: 11px;
            font-weight: 900;
        }

        .diag-mini {
            border-radius: 13px;
            padding: 10px;
            max-width: 260px;
        }

        .diag-mini strong {
            display: block;
            font-size: 11px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .diag-mini span {
            display: block;
            font-size: 10px;
            font-weight: 750;
            line-height: 1.35;
        }

        .diag-mini.diag-ok {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .diag-mini.diag-mal {
            background: #fff0f3;
            color: #f1416c;
        }

        .diag-mini.diag-parcial {
            background: #fff8dd;
            color: #9a6a00;
        }

        .diag-mini.diag-pendiente {
            background: #eef2f7;
            color: #64748b;
        }

        .diag-mini.diag-neutral {
            background: #eef2f7;
            color: #64748b;
        }

        .text-success {
            color: #0f9f6e !important;
        }

        .estado-page {
            padding: 24px;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .estado-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .estado-header h3 {
            margin: 0;
            color: #111827;
            font-size: 24px;
            font-weight: 900;
        }

        .estado-header p {
            margin: 4px 0 0;
            color: #8b95a7;
            font-size: 13px;
            font-weight: 700;
        }

        .estado-filters {
            display: grid;
            grid-template-columns: 1fr 140px 170px 180px 170px;
            gap: 14px;
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 18px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .estado-filters label,
        .crear-grid label {
            display: block;
            margin-bottom: 7px;
            color: #6b7280;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .estado-control {
            width: 100%;
            height: 44px;
            border: 1px solid #dfe5ee;
            border-radius: 13px;
            padding: 0 14px;
            color: #111827;
            font-size: 13px;
            font-weight: 800;
            outline: none;
            background: #ffffff;
        }

        .estado-control:focus {
            border-color: #0095e8;
            box-shadow: 0 0 0 4px rgba(0, 149, 232, .10);
        }

        .estado-table-wrap {
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 18px;
            overflow: hidden;
        }

        .estado-table {
            width: 100%;
            border-collapse: collapse;
        }

        .estado-table th {
            background: #f8fafc;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid #edf1f5;
        }

        .estado-table td {
            padding: 15px 16px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: middle;
            color: #111827;
            font-size: 13px;
            font-weight: 700;
        }

        .dep-name {
            font-size: 14px;
            font-weight: 900;
            color: #111827;
        }

        .dep-sub {
            margin-top: 3px;
            font-size: 11px;
            font-weight: 700;
            color: #8b95a7;
        }

        .tipo-pill,
        .estado-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 7px 10px;
            font-size: 11px;
            font-weight: 900;
        }

        .tipo-pill {
            background: #eef2f7;
            color: #64748b;
        }

        .status-ok {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .status-warning {
            background: #fff8dd;
            color: #9a6a00;
        }

        .status-danger {
            background: #fff0f3;
            color: #f1416c;
        }

        .btn-view {
            border: none;
            background: #eef8ff;
            color: #007fc7;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-view:hover {
            background: #0095e8;
            color: #ffffff;
        }

        .estado-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, .65);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 24px;
            overflow-y: auto;
        }

        .estado-modal-panel {
            width: min(1280px, 100%);
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 70px rgba(15, 23, 42, .30);
            overflow: hidden;
        }

        .small-modal {
            width: min(620px, 100%);
        }

        .estado-modal-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 24px;
            border-bottom: 1px solid #edf1f5;
            background: #ffffff;
        }

        .modal-kicker {
            color: #0095e8;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .estado-modal-header h4 {
            margin: 0;
            color: #111827;
            font-size: 21px;
            font-weight: 900;
        }

        .estado-modal-header p {
            margin: 5px 0 0;
            color: #8b95a7;
            font-size: 13px;
            font-weight: 700;
        }

        .modal-close {
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

        .estado-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #edf1f5;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 16px;
            padding: 14px;
        }

        .summary-card span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .summary-card strong {
            font-size: 18px;
            font-weight: 900;
            color: #111827;
        }

        .detail-actions {
            display: flex;
            justify-content: flex-end;
            padding: 16px 24px 0;
        }

        .btn-create-exp {
            border: none;
            background: #eafaf2;
            color: #0f9f6e;
            border-radius: 13px;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-create-exp:hover {
            background: #0f9f6e;
            color: #ffffff;
        }

        .expensas-list {
            padding: 20px 24px 24px;
            display: grid;
            gap: 14px;
        }

        .expensa-card {
            border: 1px solid #edf1f5;
            border-radius: 18px;
            padding: 16px;
            background: #ffffff;
        }

        .expensa-card.diag-mal {
            border-color: #ffb3c2;
            background: #fff8fa;
        }

        .expensa-card.diag-parcial {
            border-color: #ffe39b;
            background: #fffdf5;
        }

        .expensa-card.diag-ok {
            border-color: #bdebd4;
            background: #fbfffd;
        }

        .expensa-card-head {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .expensa-card h5 {
            margin: 0;
            font-size: 17px;
            font-weight: 900;
            color: #111827;
        }

        .expensa-meta {
            margin-top: 4px;
            color: #8b95a7;
            font-size: 12px;
            font-weight: 700;
        }

        .diag-box {
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 900;
            height: fit-content;
            white-space: nowrap;
        }

        .diag-ok {
            background: #eafaf2;
            color: #0f9f6e;
        }

        .diag-mal {
            background: #fff0f3;
            color: #f1416c;
        }

        .diag-parcial {
            background: #fff8dd;
            color: #9a6a00;
        }

        .diag-pendiente {
            background: #eef2f7;
            color: #64748b;
        }

        .expensa-amount-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 12px;
        }

        .expensa-amount-grid div {
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 14px;
            padding: 11px;
        }

        .expensa-amount-grid span {
            display: block;
            color: #8b95a7;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .expensa-amount-grid strong {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
        }

        .diagnostico-message {
            background: #f8fafc;
            border-left: 4px solid #dbe3ef;
            border-radius: 10px;
            padding: 10px 12px;
            color: #64748b;
            font-size: 12px;
            font-weight: 750;
            margin-bottom: 12px;
        }

        .pagos-box {
            border-top: 1px solid #edf1f5;
            padding-top: 12px;
        }

        .pagos-title {
            color: #6b7280;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .pago-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            background: #ffffff;
            border: 1px solid #edf1f5;
            border-radius: 13px;
            padding: 10px 12px;
            margin-bottom: 8px;
        }

        .pago-row strong {
            display: block;
            color: #111827;
            font-size: 13px;
            font-weight: 900;
        }

        .pago-row span {
            display: block;
            color: #8b95a7;
            font-size: 11px;
            font-weight: 700;
            margin-top: 3px;
        }

        .pago-row small {
            display: block;
            color: #9a6a00;
            font-size: 11px;
            font-weight: 700;
            margin-top: 4px;
        }

        .pago-monto {
            color: #0095e8;
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
        }

        .no-pagos,
        .empty-state {
            background: #f8fafc;
            border: 1px dashed #dbe3ef;
            color: #8b95a7;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            font-size: 13px;
            font-weight: 800;
        }

        .crear-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            padding: 22px 24px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 0 24px 24px;
        }

        .btn-cancel,
        .btn-save {
            border: none;
            border-radius: 13px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 900;
        }

        .btn-cancel {
            background: #eef2f7;
            color: #64748b;
        }

        .btn-save {
            background: #0095e8;
            color: #ffffff;
        }

        .text-primary {
            color: #0095e8 !important;
        }

        .text-danger {
            color: #f1416c !important;
        }

        .text-warning {
            color: #9a6a00 !important;
        }

        .fw-bold {
            font-weight: 900;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 1100px) {

            .estado-filters,
            .estado-summary-grid,
            .expensa-amount-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 700px) {
            .estado-page {
                padding: 14px;
            }

            .estado-filters,
            .estado-summary-grid,
            .expensa-amount-grid,
            .crear-grid {
                grid-template-columns: 1fr;
            }

            .estado-table-wrap {
                overflow-x: auto;
            }

            .estado-table {
                min-width: 900px;
            }

            .estado-modal-backdrop {
                padding: 10px;
            }

            .estado-modal-panel {
                border-radius: 16px;
            }

            .pago-row,
            .expensa-card-head {
                flex-direction: column;
            }
        }

        .spin-icon {
            animation: spinIcon .8s linear infinite;
        }

        @keyframes spinIcon {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</div>
