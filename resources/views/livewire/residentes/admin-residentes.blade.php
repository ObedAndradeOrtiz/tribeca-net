<div class="admin-resident-page">
    <div class="admin-resident-header">
        <div>
            <span>Administracion</span>
            <h2>Accesos de residentes</h2>
            <p>Crear codigos, aprobar solicitudes y regenerar accesos por departamento.</p>
        </div>
    </div>

    @if ($mensaje)
        <div class="admin-resident-alert">
            {{ $mensaje }}
            @if ($codigoGenerado)
                <strong>{{ $codigoGenerado }}</strong>
            @endif
        </div>
    @endif

    <div class="admin-resident-grid">
        <section class="admin-resident-card">
            <h3>Crear codigo de acceso</h3>

            <div class="admin-resident-form">
                <label>
                    Nombre opcional
                    <input type="text" wire:model.defer="nombre">
                </label>

                <label>
                    CI opcional
                    <input type="text" wire:model.defer="ci">
                </label>
            </div>

            <div class="admin-resident-depts">
                @foreach ($this->departamentosDisponibles as $departamento)
                    <label>
                        <input type="checkbox" wire:model.defer="departamentos" value="{{ $departamento->id }}">
                        <span>{{ $departamento->nombre }}</span>
                    </label>
                @endforeach
            </div>

            <button type="button" class="admin-resident-primary" wire:click="crearCodigo">
                <i class="bi bi-key"></i>
                Generar codigo
            </button>
        </section>

        <section class="admin-resident-card">
            <h3>Solicitudes pendientes</h3>

            <div class="admin-resident-list">
                @forelse ($this->solicitudes as $solicitud)
                    <div class="admin-resident-row">
                        <div>
                            <strong>{{ $solicitud->departamento_nombre }}</strong>
                            <span>{{ $solicitud->user_name ?: 'Residente' }} · {{ $solicitud->email ?: 'sin correo' }}</span>
                        </div>
                        <div class="admin-resident-actions">
                            <button type="button" class="ok" wire:click="aprobar({{ $solicitud->id }})">
                                <i class="bi bi-check2"></i>
                            </button>
                            <button type="button" class="bad" wire:click="rechazar({{ $solicitud->id }})">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="admin-resident-empty">No hay solicitudes pendientes.</div>
                @endforelse
            </div>
        </section>
    </div>

    <section class="admin-resident-card">
        <h3>Codigos recientes</h3>

        <div class="admin-resident-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->codigos as $codigo)
                        <tr>
                            <td><strong>{{ $codigo->code }}</strong></td>
                            <td>{{ $codigo->name ?: '-' }}</td>
                            <td>{{ $codigo->status }}</td>
                            <td>{{ $codigo->user_name ?: 'No usado' }}</td>
                            <td class="text-end">
                                <button type="button" wire:click="regenerarCodigo({{ $codigo->id }})">Regenerar</button>
                                <button type="button" wire:click="desactivarCodigo({{ $codigo->id }})">Desactivar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Todavia no hay codigos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <style>
        .admin-resident-page {
            min-height: 100vh;
            background: #f5f7fb;
            padding: 24px;
            color: #172033;
        }

        .admin-resident-header span {
            color: #1266f1;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .admin-resident-header h2,
        .admin-resident-card h3 {
            margin: 4px 0;
            font-weight: 900;
        }

        .admin-resident-header p {
            margin: 0;
            color: #607086;
            font-weight: 700;
        }

        .admin-resident-alert,
        .admin-resident-card {
            background: #ffffff;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 16px;
            margin-top: 16px;
        }

        .admin-resident-alert {
            background: #eafaf2;
            color: #0f7c55;
            font-weight: 850;
        }

        .admin-resident-alert strong {
            display: inline-flex;
            margin-left: 8px;
            color: #172033;
            letter-spacing: 1px;
        }

        .admin-resident-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .admin-resident-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
        }

        .admin-resident-form label {
            color: #607086;
            font-size: 12px;
            font-weight: 900;
        }

        .admin-resident-form input {
            width: 100%;
            height: 42px;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            padding: 0 12px;
            margin-top: 6px;
        }

        .admin-resident-depts,
        .admin-resident-list {
            display: grid;
            gap: 9px;
            margin-top: 14px;
            max-height: 320px;
            overflow: auto;
        }

        .admin-resident-depts label,
        .admin-resident-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border: 1px solid #edf1f5;
            border-radius: 8px;
            padding: 10px;
        }

        .admin-resident-depts label {
            justify-content: flex-start;
            font-weight: 850;
        }

        .admin-resident-row strong {
            display: block;
            font-weight: 900;
        }

        .admin-resident-row span {
            display: block;
            color: #607086;
            font-size: 12px;
            font-weight: 750;
            margin-top: 2px;
        }

        .admin-resident-primary,
        .admin-resident-actions button,
        .admin-resident-table-wrap button {
            border: none;
            border-radius: 8px;
            font-weight: 900;
        }

        .admin-resident-primary {
            margin-top: 14px;
            height: 42px;
            padding: 0 14px;
            background: #1266f1;
            color: #ffffff;
        }

        .admin-resident-actions {
            display: flex;
            gap: 8px;
        }

        .admin-resident-actions button {
            width: 36px;
            height: 36px;
        }

        .admin-resident-actions .ok {
            background: #eafaf2;
            color: #0f7c55;
        }

        .admin-resident-actions .bad {
            background: #fff0f3;
            color: #b42345;
        }

        .admin-resident-empty {
            border: 1px dashed #cfd8e5;
            border-radius: 8px;
            padding: 14px;
            color: #607086;
            text-align: center;
            font-weight: 800;
        }

        .admin-resident-table-wrap {
            overflow-x: auto;
        }

        .admin-resident-table-wrap table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .admin-resident-table-wrap th,
        .admin-resident-table-wrap td {
            border-bottom: 1px solid #edf1f5;
            padding: 12px;
            text-align: left;
        }

        .admin-resident-table-wrap th {
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .admin-resident-table-wrap button {
            background: #eef2f7;
            color: #344256;
            padding: 8px 10px;
            margin-left: 6px;
        }

        .text-end {
            text-align: right !important;
        }

        @media (max-width: 900px) {
            .admin-resident-page {
                padding: 14px;
            }

            .admin-resident-grid,
            .admin-resident-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</div>
