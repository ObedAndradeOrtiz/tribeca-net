<div class="d-flex gap-2">

    <!-- ✏️ EDITAR -->
    <button class="btn btn-sm btn-light-primary d-flex align-items-center gap-1"
        wire:click="$set('openArea',true)">
        <i class="bi bi-pencil-square"></i>
        Editar
    </button>

    <!-- 🔴 ELIMINAR / 🟢 ACTIVAR -->
    @if ($area->estado == 'Activo')
        <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
            wire:click="$set('openArea2',true)">
            <i class="bi bi-trash"></i>
            Desactivar
        </button>
    @else
        <button class="btn btn-sm btn-light-success d-flex align-items-center gap-1"
            wire:click="$set('openArea3',true)">
            <i class="bi bi-check-circle"></i>
            Activar
        </button>
    @endif

    <!-- ================= MODAL EDITAR ================= -->
    <x-modal wire:model.defer="openArea">

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Editar área
            </h4>
            <span class="text-muted small">
                {{ $area->area }}
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control"
                        wire:model.defer="area.area">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control"
                        wire:model.defer="area.telefono">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ticket</label>
                    <input type="text" class="form-control"
                        wire:model.defer="area.ticket">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Registrado por</label>
                    <input type="text" class="form-control bg-light"
                        value="{{ Auth::user()->name }}" disabled>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light"
                wire:click="$set('openArea',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2"
                wire:click="guardartodo">

                <i class="bi bi-check-circle"></i>
                Guardar cambios
            </button>

        </div>

    </x-modal>

    <!-- ================= MODAL DESACTIVAR ================= -->
    <x-modal wire:model.defer="openArea2">

        <div class="px-6 pt-5 pb-3 text-center">
            <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
            <h5 class="fw-bold mt-3">
                ¿Desactivar área?
            </h5>
            <p class="text-muted">
                {{ $area->area }}
            </p>
        </div>

        <div class="px-6 py-4 border-top d-flex justify-content-center gap-2">

            <button class="btn btn-light" wire:click="cancelar">
                Cancelar
            </button>

            <button class="btn btn-danger d-flex align-items-center gap-2"
                wire:click="inactivar">

                <i class="bi bi-trash"></i>
                Desactivar
            </button>

        </div>

    </x-modal>

    <!-- ================= MODAL ACTIVAR ================= -->
    <x-modal wire:model.defer="openArea3">

        <div class="px-6 pt-5 pb-3 text-center">
            <i class="bi bi-check-circle fs-1 text-success"></i>
            <h5 class="fw-bold mt-3">
                ¿Activar área?
            </h5>
            <p class="text-muted">
                {{ $area->area }}
            </p>
        </div>

        <div class="px-6 py-4 border-top d-flex justify-content-center gap-2">

            <button class="btn btn-light" wire:click="cancelar">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2"
                wire:click="activar">

                <i class="bi bi-check-circle"></i>
                Activar
            </button>

        </div>

    </x-modal>

</div>