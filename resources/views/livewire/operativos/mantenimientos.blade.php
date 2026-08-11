<div class="maintenance-page">
    <div class="maintenance-header">
        <div>
            <span>Operativos</span>
            <h3>Gestion de Mantenimientos</h3>
            <p>Registra trabajos, calcula la proxima fecha y conserva comprobantes.</p>
        </div>
    </div>

    <div class="maintenance-kpis">
        <div>
            <span>Total</span>
            <strong>{{ $mantenimientos->count() }}</strong>
        </div>
        <div>
            <span>Vencidos</span>
            <strong>{{ $mantenimientos->filter(fn ($m) => $m->fecha_siguiente && \Carbon\Carbon::parse($m->fecha_siguiente)->isPast())->count() }}</strong>
        </div>
        <div>
            <span>Tipos</span>
            <strong>{{ $tipos->count() }}</strong>
        </div>
        <div>
            <span>Proveedores</span>
            <strong>{{ $proveedores->count() }}</strong>
        </div>
    </div>

    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#registro">Registro</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tipos">Tipos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#proveedores">Proveedores</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="registro">
            <section class="maintenance-card">
                <div class="maintenance-card-head">
                    <div>
                        <span>Nuevo registro</span>
                        <h4>Registrar mantenimiento</h4>
                    </div>
                </div>

                <div class="maintenance-form">
                    <label>
                        Tipo
                        <select wire:model.defer="tipoMantenimiento">
                            <option value="">Seleccionar</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }} - cada {{ $t->frecuencia_dias }} dias</option>
                            @endforeach
                        </select>
                        @error('tipoMantenimiento') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Proveedor
                        <select wire:model.defer="proveedor">
                            <option value="">Seleccionar</option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                        @error('proveedor') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Fecha realizada
                        <input type="datetime-local" wire:model.defer="fecha">
                        @error('fecha') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Monto
                        <input type="number" step="0.01" wire:model.defer="monto">
                        @error('monto') <small>{{ $message }}</small> @enderror
                    </label>

                    <label class="span-2">
                        Descripcion
                        <textarea wire:model.defer="descripcion" rows="2" placeholder="Detalle breve del trabajo realizado"></textarea>
                        @error('descripcion') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Comprobante
                        <input type="file" wire:model="comprobante">
                        @error('comprobante') <small>{{ $message }}</small> @enderror
                    </label>
                </div>

                <button type="button" wire:click="guardarMantenimiento" class="maintenance-primary">
                    <i class="bi bi-save"></i>
                    Registrar mantenimiento
                </button>
            </section>

            <section class="maintenance-card">
                <div class="maintenance-card-head">
                    <div>
                        <span>Historial</span>
                        <h4>Mantenimientos registrados</h4>
                    </div>
                </div>

                <div class="maintenance-list">
                    @forelse ($mantenimientos as $m)
                        @php
                            $siguiente = $m->fecha_siguiente ? \Carbon\Carbon::parse($m->fecha_siguiente) : null;
                            $estado = ! $siguiente ? 'incompleto' : ($siguiente->isPast() ? 'vencido' : ($siguiente->isToday() ? 'hoy' : 'programado'));
                            $estadoTexto = ['incompleto' => 'Incompleto', 'vencido' => 'Vencido', 'hoy' => 'Hoy', 'programado' => 'Programado'][$estado];
                        @endphp

                        <article class="maintenance-row {{ $estado }}">
                            <div>
                                <strong>{{ optional($m->tipo)->nombre ?: 'Sin tipo' }}</strong>
                                <span>{{ optional($m->proveedor)->nombre ?: 'Sin proveedor' }}</span>
                                @if ($m->descripcion)
                                    <small>{{ $m->descripcion }}</small>
                                @endif
                            </div>

                            <div>
                                <span>Realizado</span>
                                <b>{{ $m->fecha ? \Carbon\Carbon::parse($m->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</b>
                            </div>

                            <div>
                                <span>Siguiente</span>
                                <b>{{ $siguiente ? $siguiente->format('d/m/Y') : 'Sin fecha' }}</b>
                                <em>{{ $estadoTexto }}</em>
                            </div>

                            <div>
                                <span>Monto</span>
                                <b>Bs {{ number_format((float) $m->monto, 2) }}</b>
                            </div>

                            <div class="maintenance-actions">
                                @if ($m->comprobante)
                                    <button type="button" wire:click="verImagen('{{ $m->comprobante }}')" title="Ver comprobante">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                @endif
                                <button type="button" wire:click="abrirEditar({{ $m->id }})" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="danger" wire:click="confirmarEliminar({{ $m->id }})" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </article>
                    @empty
                        <div class="maintenance-empty">Todavia no hay mantenimientos registrados.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="tab-pane fade" id="tipos">
            <section class="maintenance-card">
                <h4>Tipos de mantenimiento</h4>

                <div class="maintenance-inline-form">
                    <input type="text" wire:model.defer="nombreTipo" placeholder="Nombre">
                    <input type="number" wire:model.defer="frecuencia" placeholder="Frecuencia en dias">
                    <button type="button" wire:click="guardarTipo">Guardar</button>
                </div>

                <div class="maintenance-simple-list">
                    @foreach ($tipos as $t)
                        <div>
                            <strong>{{ $t->nombre }}</strong>
                            <span>Cada {{ $t->frecuencia_dias }} dias</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="tab-pane fade" id="proveedores">
            <section class="maintenance-card">
                <h4>Proveedores</h4>

                <div class="maintenance-inline-form provider">
                    <input wire:model.defer="nombreProveedor" placeholder="Nombre">
                    <input wire:model.defer="telefono" placeholder="Telefono">
                    <select wire:model.defer="tipoProveedor">
                        <option value="">Tipo</option>
                        @foreach ($tipos as $t)
                            <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                    <button type="button" wire:click="guardarProveedor">Guardar</button>
                </div>

                <div class="maintenance-simple-list">
                    @foreach ($proveedores as $p)
                        <div>
                            <strong>{{ $p->nombre }}</strong>
                            <span>{{ $p->telefono ?: 'Sin telefono' }} - {{ optional($p->tipo)->nombre ?: 'Sin tipo' }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    @if ($editandoId)
        <div class="maintenance-modal-backdrop">
            <section class="maintenance-modal">
                <div class="maintenance-modal-head">
                    <h4>Editar mantenimiento</h4>
                    <button type="button" wire:click="cerrarModal"><i class="bi bi-x-lg"></i></button>
                </div>

                <div class="maintenance-form">
                    <label>
                        Tipo
                        <select wire:model.defer="editTipoMantenimiento">
                            <option value="">Seleccionar</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        Proveedor
                        <select wire:model.defer="editProveedor">
                            <option value="">Seleccionar</option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        Fecha realizada
                        <input type="datetime-local" wire:model.defer="editFecha">
                    </label>

                    <label>
                        Monto
                        <input type="number" step="0.01" wire:model.defer="editMonto">
                    </label>

                    <label class="span-2">
                        Descripcion
                        <textarea wire:model.defer="editDescripcion" rows="2"></textarea>
                    </label>

                    <label>
                        Reemplazar comprobante
                        <input type="file" wire:model="editComprobante">
                    </label>
                </div>

                <div class="maintenance-modal-actions">
                    <button type="button" class="secondary" wire:click="cerrarModal">Cancelar</button>
                    <button type="button" class="primary" wire:click="guardarEdicion">Guardar cambios</button>
                </div>
            </section>
        </div>
    @endif

    @if ($eliminandoId)
        <div class="maintenance-modal-backdrop">
            <section class="maintenance-modal small">
                <div class="maintenance-modal-head">
                    <h4>Eliminar mantenimiento</h4>
                    <button type="button" wire:click="cerrarModal"><i class="bi bi-x-lg"></i></button>
                </div>
                <p>Esta accion eliminara el registro y su comprobante si existe.</p>
                <div class="maintenance-modal-actions">
                    <button type="button" class="secondary" wire:click="cerrarModal">Cancelar</button>
                    <button type="button" class="danger" wire:click="eliminarMantenimiento">Eliminar</button>
                </div>
            </section>
        </div>
    @endif

    @if ($imagenModal)
        <div class="maintenance-modal-backdrop">
            <section class="maintenance-modal">
                <div class="maintenance-modal-head">
                    <h4>Comprobante</h4>
                    <button type="button" wire:click="$set('imagenModal', null)"><i class="bi bi-x-lg"></i></button>
                </div>

                @if (strtolower(pathinfo($imagenModal, PATHINFO_EXTENSION)) === 'pdf')
                    <a class="maintenance-primary" href="{{ asset('storage/' . $imagenModal) }}" target="_blank">Abrir PDF</a>
                @else
                    <img src="{{ asset('storage/' . $imagenModal) }}" class="maintenance-preview" alt="Comprobante">
                @endif
            </section>
        </div>
    @endif

    <style>
        .maintenance-page {
            display: grid;
            gap: 16px;
        }

        .maintenance-header span,
        .maintenance-card-head span {
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .maintenance-header h3,
        .maintenance-card h4 {
            margin: 4px 0;
            font-weight: 900;
        }

        .maintenance-header p {
            margin: 0;
            color: #607086;
            font-weight: 700;
        }

        .maintenance-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .maintenance-kpis div,
        .maintenance-card {
            background: #ffffff;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 16px;
        }

        .maintenance-kpis span {
            display: block;
            color: #607086;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .maintenance-kpis strong {
            display: block;
            margin-top: 4px;
            font-size: 22px;
            font-weight: 900;
        }

        .maintenance-card-head,
        .maintenance-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .maintenance-form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 12px;
        }

        .maintenance-form label {
            color: #607086;
            font-size: 12px;
            font-weight: 900;
        }

        .maintenance-form input,
        .maintenance-form select,
        .maintenance-form textarea,
        .maintenance-inline-form input,
        .maintenance-inline-form select {
            width: 100%;
            border: 1px solid #d9e1ec;
            border-radius: 8px;
            padding: 0 12px;
            margin-top: 6px;
            color: #172033;
            font-weight: 800;
            background: #ffffff;
        }

        .maintenance-form input,
        .maintenance-form select,
        .maintenance-inline-form input,
        .maintenance-inline-form select {
            height: 42px;
        }

        .maintenance-form textarea {
            min-height: 70px;
            padding-top: 10px;
        }

        .maintenance-form small {
            display: block;
            color: #b42345;
            margin-top: 4px;
        }

        .span-2 {
            grid-column: span 2;
        }

        .maintenance-primary,
        .maintenance-inline-form button,
        .maintenance-modal-actions button,
        .maintenance-actions button {
            border: none;
            border-radius: 8px;
            font-weight: 900;
        }

        .maintenance-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 0 14px;
            margin-top: 14px;
            background: #1266f1;
            color: #ffffff;
        }

        .maintenance-list {
            display: grid;
            gap: 10px;
            margin-top: 14px;
        }

        .maintenance-row {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) 150px 150px 120px auto;
            gap: 12px;
            align-items: center;
            border: 1px solid #e5ebf3;
            border-left-width: 5px;
            border-radius: 8px;
            padding: 12px;
        }

        .maintenance-row.programado {
            border-left-color: #10b981;
        }

        .maintenance-row.hoy {
            border-left-color: #f59e0b;
        }

        .maintenance-row.vencido,
        .maintenance-row.incompleto {
            border-left-color: #ef4444;
        }

        .maintenance-row strong,
        .maintenance-row b {
            display: block;
            color: #172033;
            font-weight: 900;
        }

        .maintenance-row span,
        .maintenance-row small {
            display: block;
            color: #607086;
            font-size: 12px;
            font-weight: 750;
        }

        .maintenance-row em {
            display: inline-flex;
            margin-top: 4px;
            border-radius: 999px;
            background: #eef2f7;
            padding: 4px 8px;
            color: #344256;
            font-size: 11px;
            font-style: normal;
            font-weight: 900;
        }

        .maintenance-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .maintenance-actions button {
            width: 38px;
            height: 38px;
            background: #eef2f7;
            color: #344256;
        }

        .maintenance-actions .danger,
        .maintenance-modal-actions .danger {
            background: #fff0f3;
            color: #b42345;
        }

        .maintenance-inline-form {
            display: grid;
            grid-template-columns: 1fr 180px auto;
            gap: 10px;
            margin-top: 12px;
        }

        .maintenance-inline-form.provider {
            grid-template-columns: 1fr 180px 220px auto;
        }

        .maintenance-inline-form button {
            min-height: 42px;
            padding: 0 14px;
            margin-top: 6px;
            background: #1266f1;
            color: #ffffff;
        }

        .maintenance-simple-list {
            display: grid;
            gap: 8px;
            margin-top: 14px;
        }

        .maintenance-simple-list div,
        .maintenance-empty {
            border: 1px solid #edf1f5;
            border-radius: 8px;
            padding: 12px;
        }

        .maintenance-empty {
            color: #607086;
            text-align: center;
            font-weight: 800;
        }

        .maintenance-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(15, 23, 42, .48);
        }

        .maintenance-modal {
            width: min(820px, 100%);
            max-height: 90vh;
            overflow: auto;
            border-radius: 8px;
            background: #ffffff;
            padding: 16px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, .22);
        }

        .maintenance-modal.small {
            width: min(420px, 100%);
        }

        .maintenance-modal-head button {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 8px;
            background: #eef2f7;
            color: #344256;
        }

        .maintenance-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 14px;
        }

        .maintenance-modal-actions button {
            min-height: 42px;
            padding: 0 14px;
        }

        .maintenance-modal-actions .secondary {
            background: #eef2f7;
            color: #344256;
        }

        .maintenance-modal-actions .primary {
            background: #1266f1;
            color: #ffffff;
        }

        .maintenance-preview {
            display: block;
            max-width: 100%;
            max-height: 70vh;
            margin: 14px auto 0;
            border-radius: 8px;
        }

        @media (max-width: 900px) {
            .maintenance-kpis,
            .maintenance-form,
            .maintenance-inline-form,
            .maintenance-inline-form.provider,
            .maintenance-row {
                grid-template-columns: 1fr;
            }

            .span-2 {
                grid-column: span 1;
            }

            .maintenance-actions,
            .maintenance-modal-actions {
                justify-content: stretch;
            }

            .maintenance-actions button,
            .maintenance-modal-actions button,
            .maintenance-primary {
                width: 100%;
            }
        }
    </style>
</div>
