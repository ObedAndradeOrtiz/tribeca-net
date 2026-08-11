<div class="px-4">

    <div class="card shadow-sm">

        <!-- 🔥 HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-diagram-3 me-2"></i> Tipos de departamentos
                </h3>
                <span class="text-muted small">
                    Gestión de categorías de departamentos
                </span>
            </div>

            <!-- BOTÓN CREAR -->
            @livewire('tipos.crear-tipo')

        </div>

        <!-- 🔥 BODY -->
        <div class="card-body pt-0">

            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Tipo</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($tipos as $lista)
                            <tr>

                                <!-- TIPO -->
                                <td class="fw-semibold">
                                    <i class="bi bi-tag me-1 text-muted"></i>
                                    {{ $lista->tipo }}
                                </td>

                                <!-- ACCIÓN -->
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
                                        wire:click="$emit('borrarTipoHabitacion',{{ $lista->id }})">
                                        <i class="bi bi-trash"></i>
                                        Eliminar
                                    </button>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No hay tipos registrados
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>