<div class="px-4 py-5 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-building me-2"></i> Gestión de Áreas Comunes
                </h3>
                <span class="text-muted small">
                    Administración de áreas, responsables y estados
                </span>
            </div>

            <!-- BUSCADOR + BOTÓN -->
            <div class="d-flex align-items-center gap-2">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        wire:model.debounce.500ms="busqueda"
                        placeholder="Buscar área...">
                </div>

                @livewire('area.crear-area')

            </div>

        </div>

        <!-- 🔥 TABS -->
        <div class="card-body pt-0">

            <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 
                        {{ $actividad === 'Activo' ? 'active' : '' }}"
                        wire:click="$set('actividad','Activo')">

                        <i class="bi bi-check-circle"></i>
                        Activos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 
                        {{ $actividad === 'Inactivo' ? 'active' : '' }}"
                        wire:click="$set('actividad','Inactivo')">

                        <i class="bi bi-x-circle"></i>
                        Inactivos
                    </a>
                </li>

            </ul>

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Área común</th>
                            <th>Teléfono</th>
                            <th>#Ticket</th>
                            <th>Estado</th>
                            <th>Creador</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($areas as $lista)
                            <tr>

                                <!-- AREA -->
                                <td class="fw-semibold">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    {{ $lista->area }}
                                </td>

                                <!-- TEL -->
                                <td>{{ $lista->telefono }}</td>

                                <!-- TICKET -->
                                <td>
                                    <span class="badge bg-light-dark">
                                        {{ $lista->ticket }}
                                    </span>
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

                                <!-- RESPONSABLE -->
                                <td>{{ $lista->responsable }}</td>

                                <!-- ACCIONES -->
                                <td>
                                    @livewire('area.editar-area', ['area' => $lista], key($lista->id))
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay áreas registradas
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>