<div>

    <!-- 🔥 BOTÓN -->
    <button class="btn btn-primary d-flex align-items-center gap-2"
        wire:click="$set('crear',true)">
        <i class="bi bi-plus-circle fs-5"></i>
        <span>Nuevo tipo</span>
    </button>

    <!-- 🔥 MODAL -->
    <x-modal wire:model.defer="crear">

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-diagram-3 me-2"></i>
                Nuevo tipo de departamento
            </h4>
            <span class="text-muted small">
                Defina una nueva categoría de departamento
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- TIPO -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Tipo de departamento</label>
                    <input type="text"
                        class="form-control"
                        wire:model.defer="tipo"
                        placeholder="Ej: Departamento 2 habitaciones">
                </div>

                <!-- USUARIO -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Registrado por</label>
                    <input type="text"
                        class="form-control bg-light"
                        value="{{ Auth::user()->name }}"
                        disabled>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light"
                wire:click="$set('crear',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2"
                wire:click="guardartodo"
                wire:loading.remove
                wire:target="guardartodo">

                <i class="bi bi-check-circle"></i>
                Guardar tipo
            </button>

            <span wire:loading wire:target="guardartodo" class="text-muted">
                Guardando...
            </span>

        </div>

    </x-modal>

</div>