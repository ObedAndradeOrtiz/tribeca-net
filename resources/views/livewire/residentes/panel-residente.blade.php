<div class="resident-page">
    <div class="resident-topbar">
        <div>
            <span>TRIBECA SOHO</span>
            <h1>Mi departamento</h1>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="resident-icon-btn" title="Cerrar sesion">
                <i class="bi bi-box-arrow-right"></i>
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
            <div class="resident-access-list">
                @forelse ($this->accesosAprobados as $acceso)
                    @php($resumen = $this->resumenDepartamento($acceso->departamento_nombre))

                    <article class="resident-dept-card">
                        <div class="resident-dept-head">
                            <div>
                                <h3>{{ $acceso->departamento_nombre }}</h3>
                                <span class="ok">Aprobado</span>
                            </div>
                        </div>

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

                        <div class="resident-payments">
                            <h4>Ultimos ingresos aplicados</h4>

                            @forelse ($resumen['pagos'] as $pago)
                                <div class="resident-payment-row">
                                    <div>
                                        <strong>{{ $pago->depositante ?: 'Ingreso bancario' }}</strong>
                                        <span>{{ \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') }} - Comp. {{ $pago->numero_comprobante ?: 'Sin comprobante' }}</span>
                                        <small>{{ $pago->mes_pago }}/{{ $pago->anio_pago }} {{ $pago->estado_pago ? '- '.$pago->estado_pago : '' }}</small>
                                    </div>
                                    <b>Bs {{ number_format((float) $pago->monto, 2) }}</b>
                                </div>
                            @empty
                                <div class="resident-empty">Todavia no hay pagos aplicados para mostrar.</div>
                            @endforelse
                        </div>
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

    <style>
        .resident-page {
            min-height: 100vh;
            background: #f4f7fb;
            color: #172033;
            padding: 18px;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .resident-topbar,
        .resident-section-head,
        .resident-dept-head,
        .resident-payment-row {
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

        .resident-icon-btn,
        .resident-primary-btn {
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-weight: 900;
        }

        .resident-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #eef2f7;
            color: #344256;
        }

        .resident-primary-btn {
            min-height: 40px;
            border-radius: 8px;
            padding: 0 13px;
            background: #1266f1;
            color: #ffffff;
            white-space: nowrap;
        }

        .resident-form-grid,
        .resident-money-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 14px;
        }

        .resident-form-grid label {
            color: #607086;
            font-size: 12px;
            font-weight: 900;
        }

        .resident-form-grid input {
            width: 100%;
            height: 44px;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            padding: 0 12px;
            margin-top: 7px;
            color: #172033;
            font-weight: 800;
        }

        .resident-tabs {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 14px;
            padding: 4px;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            background: #f7f9fc;
        }

        .resident-tabs button {
            min-height: 42px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #607086;
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
        .resident-dept-head span {
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
            border-radius: 8px;
            padding: 14px;
        }

        .resident-dept-card h3 {
            font-size: 18px;
        }

        .resident-dept-head .ok,
        .resident-check-card .ok {
            background: #eafaf2;
            color: #0f7c55;
        }

        .resident-dept-head .pending,
        .resident-check-card .pending {
            background: #fff7df;
            color: #956400;
        }

        .resident-dept-head .off,
        .resident-check-card .off {
            background: #fff0f3;
            color: #b42345;
        }

        .resident-money-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .resident-money-grid div {
            background: #f7f9fc;
            border-radius: 8px;
            padding: 12px;
        }

        .resident-money-grid span {
            display: block;
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .resident-money-grid strong {
            font-size: 16px;
            font-weight: 900;
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

        .resident-empty {
            border: 1px dashed #cfd8e5;
            border-radius: 8px;
            padding: 14px;
            color: #607086;
            font-weight: 800;
            text-align: center;
        }

        @media (max-width: 700px) {
            .resident-page {
                padding: 12px;
            }

            .resident-form-grid,
            .resident-money-grid,
            .resident-tabs,
            .resident-request-tools {
                grid-template-columns: 1fr;
            }

            .resident-section-head {
                align-items: flex-start;
            }

            .resident-primary-btn {
                min-width: 42px;
            }
        }
    </style>
</div>
