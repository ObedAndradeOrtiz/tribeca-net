<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title fw-bold">
            <i class="bi bi-building-gear me-2"></i> Gestión de Mantenimientos
        </h3>
    </div>

    <div class="card-body">

        <!-- TABS -->
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

            <!-- ================= REGISTRO ================= -->
            <div class="tab-pane fade show active" id="registro">

                <!-- FORM -->
                <div class="card mb-4 border">
                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label">Tipo</label>
                                <select wire:model.defer="tipoMantenimiento" class="form-select">
                                    <option value="">Seleccionar</option>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Proveedor</label>
                                <select wire:model.defer="proveedor" class="form-select">
                                    <option value="">Seleccionar</option>
                                    @foreach ($proveedores as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Fecha</label>
                                <input type="datetime-local" wire:model.defer="fecha" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Monto</label>
                                <input type="number" wire:model.defer="monto" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Comprobante</label>
                                <input type="file" wire:model="comprobante" class="form-control">
                            </div>

                        </div>

                        <!-- PREVIEW -->
                        @if ($comprobante)
                            <div class="mt-4 text-center">
                                <span class="text-muted small">Vista previa</span><br>
                                <img src="{{ $comprobante->temporaryUrl() }}" class="img-fluid rounded shadow mt-2"
                                    style="max-height:200px;">
                            </div>
                        @endif

                        <div class="mt-4 text-end">
                            <button wire:click="guardarMantenimiento" class="btn btn-primary">
                                <i class="bi bi-save"></i> Registrar mantenimiento
                            </button>
                        </div>

                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive">
                    <table class="table table-row-bordered table-hover align-middle">
                        <thead class="fw-bold text-muted">
                            <tr>
                                <th>Tipo</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Siguiente</th>
                                <th>Monto</th>
                                <th>Comprobante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mantenimientos as $m)
                                <tr>

                                    <td>
                                        <span class="badge bg-light-primary text-dark">
                                            {{ $m->tipo->nombre }}
                                        </span>
                                    </td>

                                    <td>{{ $m->proveedor->nombre }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light-warning">
                                            {{ \Carbon\Carbon::parse($m->fecha_siguiente)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td class="fw-bold text-success">
                                        Bs {{ number_format($m->monto, 2) }}
                                    </td>

                                    <td>
                                        @if ($m->comprobante)
                                            <button class="btn btn-sm btn-light-primary"
                                                wire:click="verImagen('{{ $m->comprobante }}')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ================= TIPOS ================= -->
            <div class="tab-pane fade" id="tipos">

                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <input type="text" wire:model.defer="nombreTipo" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-md-3">
                        <input type="number" wire:model.defer="frecuencia" class="form-control"
                            placeholder="Frecuencia días">
                    </div>
                    <div class="col-md-2">
                        <button wire:click="guardarTipo" class="btn btn-primary w-100">Guardar</button>
                    </div>
                </div>

                <table class="table table-row-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Frecuencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipos as $t)
                            <tr>
                                <td>{{ $t->nombre }}</td>
                                <td>{{ $t->frecuencia_dias }} días</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- ================= PROVEEDORES ================= -->
            <div class="tab-pane fade" id="proveedores">

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input wire:model.defer="nombreProveedor" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-md-3">
                        <input wire:model.defer="telefono" class="form-control" placeholder="Teléfono">
                    </div>
                    <div class="col-md-3">
                        <select wire:model.defer="tipoProveedor" class="form-select">
                            <option value="">Tipo</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button wire:click="guardarProveedor" class="btn btn-success w-100">Guardar</button>
                    </div>
                </div>

                <table class="table table-row-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $p)
                            <tr>
                                <td>{{ $p->nombre }}</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->tipo->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <!-- 🔥 MODAL IMAGEN -->
    @if ($imagenModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.7)">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Comprobante</h5>
                        <button class="btn-close" wire:click="$set('imagenModal', null)"></button>
                    </div>

                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $imagenModal) }}" class="img-fluid rounded shadow">
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
