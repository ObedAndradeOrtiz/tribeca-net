<div class="card shadow-sm">

    <!-- HEADER -->
    <div class="card-header border-0 pt-5">
        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-cash-coin me-2"></i> Gestión de Egresos
            </h3>
            <span class="text-muted small">
                Registro y control de gastos del sistema
            </span>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-0">

        <!-- 🔥 TABS SIN VARIABLES -->
        <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#registro">
                    <i class="bi bi-plus-circle me-1"></i>
                    Registro
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#historial">
                    <i class="bi bi-clock-history me-1"></i>
                    Historial
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ================= REGISTRO ================= -->
            <div class="tab-pane fade show active" id="registro">

                <div class="px-2">

                    <h5 class="fw-bold mb-4 text-dark">
                        Registrar egreso
                    </h5>

                    <form>

                        <div class="row g-4">

                            <!-- AREA -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Área</label>
                                <select class="form-select" wire:model="sucursal">
                                    <option value="">Seleccione</option>
                                    @foreach ($areas as $item)
                                        <option value="{{ $item->id }}">{{ $item->area }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- TIPO -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipo de egreso</label>
                                <select class="form-select" wire:model="tipogasto">
                                    <option value="">Seleccionar</option>
                                    <option>AGUA POTABLE</option>
                                    <option>ALQUILER</option>
                                    <option>GAS</option>
                                    <option>IMPUESTOS</option>
                                    <option>LUZ ELECTRICA</option>
                                    <option>INTERNET/TEL</option>
                                    <option>MATERIAL LIMPIEZA</option>
                                    <option>MANTENIMIENTO</option>
                                    <option>COMPRA EQUIPO</option>
                                    <option>PUBLICIDAD</option>
                                    <option>SUELDO</option>
                                </select>
                            </div>

                            <!-- FECHA -->
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Fecha</label>
                                <input type="date" class="form-control" wire:model="fechagasto">
                            </div>

                            <!-- CARTERA -->
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Cartera</label>
                                <select class="form-select" wire:model="cartera">
                                    <option value="Caja">Caja central</option>
                                    <option value="Externo">Externo</option>
                                </select>
                            </div>

                            <!-- MONTO -->
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Monto</label>
                                <input type="number" class="form-control" wire:model="montoegreso">
                            </div>

                            <!-- MÉTODO -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Método de pago</label>
                                <select class="form-select" wire:model="modopago">
                                    <option>QR</option>
                                    <option>Efectivo</option>
                                </select>
                            </div>

                            <!-- DETALLE -->
                            <div class="col-md-9">
                                <label class="form-label fw-semibold">Detalle</label>
                                <input type="text" class="form-control" wire:model="comentario">
                            </div>

                            <!-- IMAGEN -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Comprobante</label>
                                <input type="file" wire:model="comprobante" class="form-control">

                                <!-- LOADING -->
                                <div wire:loading wire:target="comprobante" class="text-primary mt-2">
                                    Subiendo imagen...
                                </div>
                            </div>

                            <!-- PREVIEW -->
                            @if ($comprobante)
                                <div class="col-md-6 text-center">
                                    <label class="form-label fw-semibold">Vista previa</label>
                                    <div class="border rounded p-2">
                                        <img src="{{ $comprobante->temporaryUrl() }}" class="img-fluid rounded shadow"
                                            style="max-height:200px;">
                                    </div>
                                </div>
                            @endif

                            <!-- USUARIO -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Registrado por</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}"
                                    disabled>
                            </div>

                        </div>

                    </form>

                    <!-- BOTÓN -->
                    <div class="mt-4 text-end">
                        <button class="btn btn-success px-4" wire:click="confirmar">

                            <i class="bi bi-check-circle"></i>
                            Guardar egreso
                        </button>
                    </div>

                </div>

            </div>

            <!-- ================= HISTORIAL ================= -->
            <div class="tab-pane fade" id="historial">

                <div class="text-center text-muted py-5">
                   @livewire('tesoreria.egreso-interno')
                </div>

            </div>

        </div>

    </div>

</div>
