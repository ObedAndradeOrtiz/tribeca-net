<div class="resident-page">
    <div class="resident-topbar">
        <div>
            <span>TRIBECA SOHO</span>
            <h1>Mi departamento</h1>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="resident-logout-btn" title="Cerrar sesion">
                <i class="bi bi-box-arrow-right"></i>
                Salir
            </button>
        </form>
    </div>

    @if ($mensaje)
        <div class="resident-alert">
            {{ $mensaje }}
        </div>
    @endif

    <section class="resident-section">
        <div class="resident-section-head">
            <div>
                <span>Perfil</span>
                <h2>Datos del residente</h2>
            </div>
            <button type="button" class="resident-primary-btn" wire:click="guardarPerfil">
                <i class="bi bi-check2"></i>
                Guardar
            </button>
        </div>

        <div class="resident-form-grid">
            <label>
                Nombre
                <input type="text" wire:model.defer="nombre">
            </label>

            <label>
                CI
                <input type="text" wire:model.defer="ci">
            </label>
        </div>
    </section>

    <section class="resident-section">
        <div class="resident-section-head">
            <div>
                <span>Autorizacion</span>
                <h2>Departamentos</h2>
            </div>
        </div>

        <div class="resident-tabs">
            <button type="button" class="{{ $tabActiva === 'autorizados' ? 'active' : '' }}" wire:click="$set('tabActiva', 'autorizados')">
                <i class="bi bi-shield-check"></i>
                Autorizados
            </button>
            <button type="button" class="{{ $tabActiva === 'solicitar' ? 'active' : '' }}" wire:click="$set('tabActiva', 'solicitar')">
                <i class="bi bi-send"></i>
                Solicitar autorizacion
            </button>
        </div>

        @if ($tabActiva === 'autorizados')
            <div class="resident-filter-grid">
                <label>
                    Año
                    <select wire:model="anioFiltro">
                        <option value="">Todos</option>
                        @foreach ($this->aniosDisponibles as $anio)
                            <option value="{{ $anio }}">{{ $anio }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    Mes
                    <select wire:model="mesFiltro">
                        <option value="">Todos</option>
                        @foreach ([1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'] as $numeroMes => $nombreMes)
                            <option value="{{ $numeroMes }}">{{ $nombreMes }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="resident-access-list compact">
                @forelse ($this->accesosAprobados as $acceso)
                    @php
                        $resumen = $this->resumenDepartamento($acceso->departamento_nombre);
                        $estadoClase = $resumen['estado'] === 'Pagado' ? 'ok' : ($resumen['estado'] === 'Parcial' ? 'pending' : 'off');
                    @endphp

                    <article class="resident-dept-card {{ $estadoClase }}">
                        <div class="resident-dept-summary">
                            <div>
                                <h3>{{ $acceso->departamento_nombre }}</h3>
                                <span class="{{ $estadoClase }}">{{ $resumen['estado'] }}</span>
                            </div>

                            <div class="resident-mini-money">
                                <div>
                                    <small>Pagado</small>
                                    <strong>Bs {{ number_format($resumen['total_pagado'], 2) }}</strong>
                                </div>
                                <div>
                                    <small>Saldo</small>
                                    <strong>Bs {{ number_format($resumen['saldo'], 2) }}</strong>
                                </div>
                            </div>

                            <button type="button" class="resident-secondary-btn" wire:click="alternarDepartamento(@js($acceso->departamento_nombre))">
                                <i class="bi {{ $departamentoAbierto === $acceso->departamento_nombre ? 'bi-chevron-up' : 'bi-chevron-down' }}"></i>
                                Ver
                            </button>
                        </div>

                        @if ($departamentoAbierto === $acceso->departamento_nombre)
                            <div class="resident-dept-detail">
                                <div class="resident-money-grid">
                                    <div>
                                        <span>Expensas</span>
                                        <strong>Bs {{ number_format($resumen['total_expensas'], 2) }}</strong>
                                    </div>
                                    <div>
                                        <span>Pagado</span>
                                        <strong>Bs {{ number_format($resumen['total_pagado'], 2) }}</strong>
                                    </div>
                                    <div>
                                        <span>Saldo</span>
                                        <strong>Bs {{ number_format($resumen['saldo'], 2) }}</strong>
                                    </div>
                                </div>

                                <div class="resident-pdf-actions">
                                    <button type="button" wire:click="generarPdfDepartamento(@js($acceso->departamento_nombre), 'anual')" wire:loading.attr="disabled">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        PDF anual
                                    </button>
                                    <button type="button" wire:click="generarPdfDepartamento(@js($acceso->departamento_nombre), 'total')" wire:loading.attr="disabled">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        PDF total
                                    </button>
                                </div>

                                <div class="resident-payments">
                                    <h4>Detalle por mes</h4>

                                    @forelse ($resumen['meses'] as $mes)
                                        @php($mesClase = $mes->estado === 'Pagado' ? 'ok' : ($mes->estado === 'Parcial' ? 'pending' : 'off'))

                                        <div class="resident-month-row {{ $mesClase }}">
                                            <div class="resident-month-head">
                                                <div>
                                                    <strong>{{ $mes->mes_nombre }} {{ $mes->anio }}</strong>
                                                    <span class="{{ $mesClase }}">{{ $mes->estado }}</span>
                                                </div>

                                                <div class="resident-month-money">
                                                    <small>Expensa: Bs {{ number_format($mes->monto_expensa, 2) }}</small>
                                                    <small>Pagado: Bs {{ number_format($mes->monto_pagado, 2) }}</small>
                                                    <b>Saldo: Bs {{ number_format($mes->saldo, 2) }}</b>
                                                </div>
                                            </div>

                                            <div class="resident-month-payments">
                                                @forelse ($mes->pagos as $pago)
                                                    <div>
                                                        <span>{{ $pago->depositante ?: 'Ingreso bancario' }}</span>
                                                        <small>{{ \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') }} - Comp. {{ $pago->numero_comprobante ?: 'Sin comprobante' }}</small>
                                                        <b>Bs {{ number_format((float) $pago->monto, 2) }}</b>
                                                    </div>
                                                @empty
                                                    <small>Sin pagos aplicados en este mes.</small>
                                                @endforelse
                                            </div>
                                        </div>
                                    @empty
                                        <div class="resident-empty">No hay meses en el filtro seleccionado.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="resident-empty">
                        Aun no tienes departamentos autorizados.
                    </div>
                @endforelse
            </div>
        @else
            <div class="resident-request-tools">
                <label class="resident-search">
                    <i class="bi bi-search"></i>
                    <input type="search" wire:model.debounce.350ms="busquedaDepartamento" placeholder="Buscar departamento">
                </label>

                <button type="button" class="resident-primary-btn" wire:click="solicitarAccesos">
                    <i class="bi bi-send"></i>
                    Solicitar
                </button>
            </div>

            <div class="resident-dept-picker">
                @forelse ($this->departamentos as $departamento)
                    @php($estado = $this->estadoDepartamento($departamento->id))

                    <label class="resident-check-card {{ $estado ? 'disabled' : '' }}">
                        <input
                            type="checkbox"
                            wire:model.defer="departamentosSolicitados"
                            value="{{ $departamento->id }}"
                            @disabled($estado)
                        >
                        <span>
                            <strong>{{ $departamento->nombre }}</strong>
                            <small>{{ $departamento->TIPO ?: 'Departamento' }}</small>
                        </span>

                        @if ($estado)
                            <em class="{{ $estado === 'Aprobado' ? 'ok' : ($estado === 'Solicitado' ? 'pending' : 'off') }}">
                                {{ $estado }}
                            </em>
                        @endif
                    </label>
                @empty
                    <div class="resident-empty">
                        No encontramos departamentos con esa busqueda.
                    </div>
                @endforelse
            </div>
        @endif
    </section>

    <footer class="resident-footer">
        Creado por Digitbol
    </footer>

    <style>
        .resident-page {
            min-height: 100vh;
            background: #f4f7fb;
            color: #172033;
            padding: 18px;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            display: flex;
            flex-direction: column;
        }

        .resident-topbar,
        .resident-section-head,
        .resident-payment-row,
        .resident-dept-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .resident-topbar span,
        .resident-section-head span {
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .resident-topbar h1,
        .resident-section-head h2,
        .resident-dept-card h3 {
            margin: 2px 0 0;
            font-weight: 900;
            letter-spacing: 0;
        }

        .resident-topbar h1 {
            font-size: 28px;
        }

        .resident-section-head h2 {
            font-size: 18px;
        }

        .resident-section {
            background: #ffffff;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 16px;
            margin-top: 14px;
        }

        .resident-alert {
            margin-top: 14px;
            border-radius: 8px;
            background: #eafaf2;
            color: #0f7c55;
            padding: 12px 14px;
            font-weight: 800;
        }

        .resident-logout-btn,
        .resident-primary-btn,
        .resident-secondary-btn,
        .resident-pdf-actions button {
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-weight: 900;
            border-radius: 8px;
        }

        .resident-logout-btn {
            height: 42px;
            padding: 0 13px;
            background: #172033;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(23, 32, 51, .18);
        }

        .resident-primary-btn {
            min-height: 40px;
            padding: 0 13px;
            background: #1266f1;
            color: #ffffff;
            white-space: nowrap;
        }

        .resident-secondary-btn,
        .resident-pdf-actions button {
            min-height: 38px;
            padding: 0 12px;
            background: #eef2f7;
            color: #344256;
        }

        .resident-form-grid,
        .resident-money-grid,
        .resident-filter-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 14px;
        }

        .resident-form-grid label,
        .resident-filter-grid label {
            color: #607086;
            font-size: 12px;
            font-weight: 900;
        }

        .resident-form-grid input,
        .resident-filter-grid select {
            width: 100%;
            height: 44px;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            padding: 0 12px;
            margin-top: 7px;
            color: #172033;
            font-weight: 800;
            background: #ffffff;
        }

        .resident-tabs {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 14px;
            padding: 4px;
            border: 1px solid #d6e2f2;
            border-radius: 8px;
            background: #f7f9fc;
        }

        .resident-tabs button {
            min-height: 46px;
            border: 0;
            border-radius: 6px;
            background: #ffffff;
            color: #344256;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 900;
        }

        .resident-tabs button.active {
            background: #1266f1;
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(18, 102, 241, .18);
        }

        .resident-request-tools {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
            margin-top: 14px;
        }

        .resident-search {
            min-height: 42px;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 12px;
            color: #607086;
            background: #ffffff;
        }

        .resident-search input {
            width: 100%;
            border: 0;
            outline: 0;
            color: #172033;
            font-weight: 800;
        }

        .resident-dept-picker,
        .resident-access-list {
            display: grid;
            gap: 10px;
            margin-top: 14px;
        }

        .resident-check-card {
            display: flex;
            gap: 11px;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 12px;
        }

        .resident-check-card.disabled {
            background: #f8fafc;
        }

        .resident-check-card input {
            width: 20px;
            height: 20px;
            flex: 0 0 auto;
        }

        .resident-check-card > span {
            min-width: 0;
            flex: 1 1 auto;
        }

        .resident-check-card strong,
        .resident-payment-row strong {
            display: block;
            font-size: 14px;
            font-weight: 900;
            color: #172033;
        }

        .resident-check-card small,
        .resident-payment-row span,
        .resident-payment-row small {
            display: block;
            color: #607086;
            font-size: 11px;
            font-weight: 750;
            margin-top: 2px;
        }

        .resident-check-card em,
        .resident-dept-summary span {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 11px;
            font-style: normal;
            font-weight: 900;
            white-space: nowrap;
        }

        .resident-dept-card {
            border: 1px solid #e5ebf3;
            border-left-width: 5px;
            border-radius: 8px;
            padding: 14px;
        }

        .resident-dept-card h3 {
            font-size: 18px;
        }

        .resident-dept-card.ok {
            border-left-color: #10b981;
        }

        .resident-dept-card.pending {
            border-left-color: #f59e0b;
        }

        .resident-dept-card.off {
            border-left-color: #ef4444;
        }

        .resident-dept-summary .ok,
        .resident-check-card .ok {
            background: #eafaf2;
            color: #0f7c55;
        }

        .resident-dept-summary .pending,
        .resident-check-card .pending {
            background: #fff7df;
            color: #956400;
        }

        .resident-dept-summary .off,
        .resident-check-card .off {
            background: #fff0f3;
            color: #b42345;
        }

        .resident-mini-money {
            display: grid;
            grid-template-columns: repeat(2, minmax(120px, 1fr));
            gap: 8px;
            min-width: 270px;
        }

        .resident-mini-money div,
        .resident-money-grid div {
            background: #f7f9fc;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .resident-mini-money small,
        .resident-money-grid span {
            display: block;
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .resident-mini-money strong,
        .resident-money-grid strong {
            font-size: 16px;
            font-weight: 900;
        }

        .resident-money-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .resident-dept-detail {
            border-top: 1px solid #edf1f5;
            margin-top: 14px;
            padding-top: 14px;
        }

        .resident-pdf-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .resident-payments {
            margin-top: 14px;
        }

        .resident-payments h4 {
            margin: 0 0 10px;
            font-size: 14px;
            font-weight: 900;
        }

        .resident-payment-row {
            border-top: 1px solid #edf1f5;
            padding: 10px 0;
        }

        .resident-payment-row b {
            white-space: nowrap;
            color: #1266f1;
        }

        .resident-month-row {
            border: 1px solid #e5ebf3;
            border-left-width: 5px;
            border-radius: 8px;
            padding: 12px;
            margin-top: 10px;
        }

        .resident-month-row.ok {
            border-left-color: #10b981;
        }

        .resident-month-row.pending {
            border-left-color: #f59e0b;
        }

        .resident-month-row.off {
            border-left-color: #ef4444;
        }

        .resident-month-head {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: start;
        }

        .resident-month-head strong,
        .resident-month-payments span {
            display: block;
            color: #172033;
            font-weight: 900;
        }

        .resident-month-head span {
            display: inline-flex;
            border-radius: 999px;
            padding: 5px 8px;
            margin-top: 5px;
            font-size: 11px;
            font-weight: 900;
        }

        .resident-month-head .ok {
            background: #eafaf2;
            color: #0f7c55;
        }

        .resident-month-head .pending {
            background: #fff7df;
            color: #956400;
        }

        .resident-month-head .off {
            background: #fff0f3;
            color: #b42345;
        }

        .resident-month-money {
            text-align: right;
        }

        .resident-month-money small,
        .resident-month-payments small {
            display: block;
            color: #607086;
            font-size: 11px;
            font-weight: 800;
        }

        .resident-month-money b,
        .resident-month-payments b {
            color: #1266f1;
            font-weight: 900;
        }

        .resident-month-payments {
            display: grid;
            gap: 7px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #edf1f5;
        }

        .resident-month-payments div {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
        }

        .resident-empty {
            border: 1px dashed #cfd8e5;
            border-radius: 8px;
            padding: 14px;
            color: #607086;
            font-weight: 800;
            text-align: center;
        }

        .resident-footer {
            margin-top: auto;
            padding: 18px 0 4px;
            color: #607086;
            font-size: 12px;
            font-weight: 900;
            text-align: center;
        }

        @media (max-width: 700px) {
            .resident-page {
                padding: 10px;
            }

            .resident-topbar {
                align-items: flex-start;
            }

            .resident-topbar h1 {
                font-size: 24px;
            }

            .resident-form-grid,
            .resident-money-grid,
            .resident-filter-grid,
            .resident-request-tools {
                grid-template-columns: 1fr;
            }

            .resident-section {
                padding: 14px;
            }

            .resident-section-head {
                align-items: flex-start;
            }

            .resident-tabs {
                grid-template-columns: 1fr;
                gap: 6px;
                background: #eef4ff;
            }

            .resident-tabs button {
                min-height: 50px;
                font-size: 14px;
            }

            .resident-primary-btn {
                min-width: 42px;
            }

            .resident-dept-summary {
                display: grid;
                grid-template-columns: 1fr;
            }

            .resident-mini-money {
                min-width: 0;
                grid-template-columns: 1fr 1fr;
            }

            .resident-secondary-btn,
            .resident-pdf-actions button {
                width: 100%;
            }

            .resident-payment-row {
                display: grid;
                grid-template-columns: 1fr;
            }

            .resident-month-head,
            .resident-month-payments div {
                grid-template-columns: 1fr;
            }

            .resident-month-money {
                text-align: left;
            }
        }
    </style>
</div>
