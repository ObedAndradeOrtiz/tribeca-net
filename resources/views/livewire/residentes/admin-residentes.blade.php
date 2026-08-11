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

            <label class="admin-resident-search">
                <i class="bi bi-search"></i>
                <input type="search" wire:model.debounce.350ms="busquedaDepartamento" placeholder="Buscar departamento, comercio u oficina">
            </label>

            <div class="admin-resident-depts">
                @forelse ($this->departamentosDisponibles as $departamento)
                    <label>
                        <input type="checkbox" wire:model.defer="departamentos" value="{{ $departamento->id }}">
                        <span>{{ $departamento->nombre }}</span>
                    </label>
                @empty
                    <div class="admin-resident-empty">No encontramos resultados con esa busqueda.</div>
                @endforelse
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
                        <th>Correo / CI</th>
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
                            <td>
                                <strong>{{ $codigo->user_email ?: 'Sin correo' }}</strong>
                                <span>{{ $codigo->user_ci ?: $codigo->ci ?: 'Sin CI' }}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" wire:click="abrirEditarCodigo({{ $codigo->id }})">Editar</button>
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

    <section class="admin-resident-card">
        <h3>Residentes registrados</h3>

        <div class="admin-resident-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>CI</th>
                        <th>Ingreso</th>
                        <th>Accesos</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->residentes as $residente)
                        <tr>
                            <td><strong>{{ $residente->name }}</strong></td>
                            <td>{{ $residente->email ?: 'Sin correo' }}</td>
                            <td>{{ $residente->ci ?: 'Sin CI' }}</td>
                            <td>{{ $residente->provider ?: '-' }}</td>
                            <td>{{ $residente->accesos_count }}</td>
                            <td class="text-end">
                                <button type="button" wire:click="abrirEditarResidente({{ $residente->id }})">Editar accesos</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Todavia no hay residentes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @if ($editandoCodigoId || $editandoResidenteId)
        <div class="admin-resident-modal-backdrop">
            <section class="admin-resident-modal">
                <div class="admin-resident-modal-head">
                    <div>
                        <span>Editar acceso</span>
                        <h3>Datos y departamentos</h3>
                    </div>
                    <button type="button" wire:click="cerrarEditarCodigo">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="admin-resident-form">
                    <label>
                        Nombre
                        <input type="text" wire:model.defer="editarNombre">
                    </label>

                    <label>
                        CI
                        <input type="text" wire:model.defer="editarCi">
                    </label>
                </div>

                <label class="admin-resident-search">
                    <i class="bi bi-search"></i>
                    <input type="search" wire:model.debounce.350ms="busquedaDepartamento" placeholder="Buscar departamento para editar">
                </label>

                <div class="admin-resident-depts modal-list">
                    @forelse ($this->departamentosDisponibles as $departamento)
                        <label>
                            <input type="checkbox" wire:model.defer="editarDepartamentos" value="{{ $departamento->id }}">
                            <span>{{ $departamento->nombre }}</span>
                        </label>
                    @empty
                        <div class="admin-resident-empty">No encontramos resultados con esa busqueda.</div>
                    @endforelse
                </div>

                <div class="admin-resident-modal-actions">
                    <button type="button" class="secondary" wire:click="cerrarEditarCodigo">Cancelar</button>
                    <button
                        type="button"
                        class="primary"
                        wire:click="{{ $editandoResidenteId ? 'guardarEdicionResidente' : 'guardarEdicionCodigo' }}"
                    >
                        <i class="bi bi-check2"></i>
                        Guardar cambios
                    </button>
                </div>
            </section>
        </div>
    @endif

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

        .admin-resident-search {
            height: 42px;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 12px;
            margin-top: 14px;
            color: #607086;
            background: #ffffff;
        }

        .admin-resident-search input {
            width: 100%;
            border: 0;
            outline: 0;
            color: #172033;
            font-weight: 800;
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
            min-width: 900px;
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

        .admin-resident-table-wrap td span {
            display: block;
            color: #607086;
            font-size: 12px;
            margin-top: 2px;
        }

        .admin-resident-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .admin-resident-modal {
            width: min(760px, 100%);
            max-height: 90vh;
            overflow: auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, .22);
        }

        .admin-resident-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .admin-resident-modal-head span {
            color: #1266f1;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .admin-resident-modal-head button,
        .admin-resident-modal-actions button {
            border: none;
            border-radius: 8px;
            font-weight: 900;
        }

        .admin-resident-modal-head button {
            width: 38px;
            height: 38px;
            background: #eef2f7;
            color: #344256;
        }

        .admin-resident-depts.modal-list {
            max-height: 260px;
        }

        .admin-resident-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 14px;
        }

        .admin-resident-modal-actions button {
            min-height: 42px;
            padding: 0 14px;
        }

        .admin-resident-modal-actions .secondary {
            background: #eef2f7;
            color: #344256;
        }

        .admin-resident-modal-actions .primary {
            background: #1266f1;
            color: #ffffff;
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

            .admin-resident-modal-actions {
                display: grid;
                grid-template-columns: 1fr;
            }
        }
    </style>
</div>
