<div>

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-box-seam me-2"></i> Gestión de Inmuebles
                </h3>
                <span class="text-muted small">
                    Control de activos, bienes y equipamiento
                </span>
            </div>

            <!-- BUSCADOR + BOTÓN -->
            <div class="d-flex align-items-center gap-2">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        wire:model.debounce.500ms="busqueda"
                        placeholder="Buscar inmueble...">
                </div>

                @livewire('inmuebles.crear-inmuebles')

            </div>

        </div>

        <!-- 🔥 FILTRO -->
        <div class="card-body pt-0">

            <div class="row mb-4">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Área común</label>
                    <select wire:model="sucursal" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($areas as $lista)
                            <option value="{{ $lista->area }}">{{ $lista->area }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- 🔥 TABLA -->
            <div class="table-responsive" wire:loading.lazy>

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Área común</th>
                            <th>Área uso</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($productoslist as $lista)
                            <tr>

                                <!-- AREA -->
                                <td class="fw-semibold">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    {{ $lista->sucursal }}
                                </td>

                                <!-- AREA USO -->
                                <td>{{ $lista->area }}</td>

                                <!-- TIPO -->
                                <td>
                                    <span class="badge bg-light-primary text-dark">
                                        {{ $lista->tipo }}
                                    </span>
                                </td>

                                <!-- NOMBRE -->
                                <td class="fw-semibold">
                                    {{ $lista->nombre }}
                                </td>

                                <!-- DETALLE -->
                                <td style="max-width:200px;" class="text-truncate">
                                    {{ $lista->descripcion }}
                                </td>

                                <!-- ESTADO -->
                                <td>
                                    <span @class([
                                        'badge',
                                        'bg-success' => $lista->estado == 'Activo',
                                        'bg-danger' => $lista->estado != 'Activo',
                                    ])>
                                        {{ $lista->estado }}
                                    </span>
                                </td>

                                <!-- CANTIDAD -->
                                <td>
                                    <span class="badge bg-light-dark">
                                        {{ $lista->cantidad }}
                                    </span>
                                </td>

                                <!-- PRECIO -->
                                <td class="fw-bold text-success">
                                    Bs {{ number_format($lista->precio,2) }}
                                </td>

                                <!-- FECHA -->
                                <td>
                                    {{ \Carbon\Carbon::parse($lista->fecha)->format('d/m/Y') }}
                                </td>

                                <!-- ACCIONES -->
                                <td class="text-end">
                                    @livewire('inmuebles.editar-inmuebles', ['producto' => $lista], key($lista->id))
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay inmuebles registrados
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- 🔥 PAGINACIÓN -->
            <div class="mt-4 d-flex justify-content-end">
                {{ $productoslist->links() }}
            </div>

        </div>

    </div>

</div>