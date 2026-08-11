<div class="mt-4 container-fluid">

    <!-- 🔥 CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-people me-2"></i> Copropietarios
                </h3>
                <span class="text-muted small">
                    Gestión de propietarios y departamentos
                </span>
            </div>

            <!-- BUSCADOR -->
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                <input type="text" class="form-control ps-10"
                    placeholder="Buscar por nombre, departamento o teléfono..." wire:model.debounce.500ms="busqueda"
                    style="min-width: 260px;">
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body pt-0">

            <!-- 🔥 TABLA -->
            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Teléfono</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($users as $lista)

                            @if ($lista->estado == $actividad)
                                @php
                                    // 🔥 obtener ocupaciones del usuario
                                    $misDeptos = $ocupaciones->where('user_id', $lista->id);

                                    $cantidadDeptos = $misDeptos->count();
                                @endphp

                                <tr>

                                    <!-- ID -->
                                    <td class="text-muted">
                                        #{{ $lista->id }}
                                    </td>

                                    <!-- NOMBRE + EDAD -->
                                    <td class="fw-semibold">
                                        <i class="bi bi-person me-1 text-muted"></i>
                                        {{ $lista->name }}

                                        <div class="text-muted small">
                                            Edad: {{ $lista->edad ?? '-' }}
                                        </div>
                                    </td>

                                    <!-- DEPARTAMENTOS -->
                                    <td>

                                        <!-- CANTIDAD -->
                                        <span class="badge bg-primary mb-1">
                                            {{ $cantidadDeptos }} Deptos
                                        </span>

                                        <!-- LISTADO -->
                                        <div class="small text-muted">

                                            @foreach ($misDeptos as $d)
                                                @php
                                                    $depto = \App\Models\Tratamiento::find($d->tratamiento_id);
                                                @endphp

                                                <div>
                                                    • {{ $depto->nombre ?? '---' }}
                                                </div>
                                            @endforeach

                                        </div>

                                    </td>

                                    <!-- TEL -->
                                    <td>
                                        <i class="bi bi-telephone me-1 text-muted"></i>
                                        {{ $lista->telefono ?? '-' }}
                                    </td>

                                    <!-- ACCIONES -->
                                    <td>
                                        @livewire('clientes.editar-cliente', ['iduser' => $lista->id], key($lista->id))
                                    </td>

                                </tr>
                            @endif

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay copropietarios registrados
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
