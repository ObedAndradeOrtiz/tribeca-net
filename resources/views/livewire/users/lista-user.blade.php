<div class="mt-4 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-person-badge me-2"></i> Gestión de Personal
                </h3>
                <span class="text-muted small">
                    Administración de usuarios, roles y estados
                </span>
            </div>

            <!-- FILTROS -->
            <div class="d-flex align-items-center gap-3">

                <!-- ESTADO -->
                <div>
                    <label class="form-label fw-semibold mb-1">Estado</label>
                    <select wire:model="estadoUser" class="form-select form-select-sm">
                        <option value="todos">Todos</option>
                        <option value="Activo">Activos</option>
                        <option value="Inactivo">Inactivos</option>
                    </select>
                </div>

                <!-- ROL -->
                <div>
                    <label class="form-label fw-semibold mb-1">Cargo</label>
                    <select wire:model="rolseleccionado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->rol }}">{{ $item->rol }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="card-body pt-0">

            <!-- 🔥 BUSCADOR + BOTÓN -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                        class="form-control ps-10"
                        placeholder="Buscar personal..."
                        wire:model.debounce.500ms="busqueda"
                        style="min-width: 260px;">
                </div>

                @livewire('users.crear-user')

            </div>

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($users as $lista)

                            <tr>

                                <!-- NOMBRE + ROL -->
                                <td>
                                    <div class="fw-semibold">
                                        <i class="bi bi-person me-1 text-muted"></i>
                                        {{ $lista->name }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $lista->rol }}
                                    </div>
                                </td>

                                <!-- TEL -->
                                <td>{{ $lista->telefono }}</td>

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

                                <!-- ACCIONES -->
                                <td>
                                    @livewire('users.editar-user', ['iduser' => $lista->id], key($lista->id))
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay personal registrado
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- 🔥 PAGINACIÓN -->
            <div class="mt-4 d-flex justify-content-end">
                {{ $users->links() }}
            </div>

        </div>

    </div>

</div>