<div>

    <!-- 🔥 BOTÓN -->
    <button class="btn btn-primary d-flex align-items-center gap-2"
        wire:click="$set('crear',true)">
        <i class="bi bi-building-add fs-5"></i>
        <span>Registrar área común</span>
    </button>

    <!-- 🔥 MODAL -->
    <x-modal wire:model.defer="crear">

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-building-add me-2"></i>
                Nueva área común
            </h4>
            <span class="text-muted small">
                Complete la información del área
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Nombre del área</label>
                    <input type="text" class="form-control"
                        wire:model.defer="area"
                        placeholder="Ej: Salón de eventos">
                </div>

                <!-- TELÉFONO -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teléfono de contacto</label>
                    <input type="text" class="form-control"
                        wire:model.defer="telefono"
                        placeholder="Ej: 78945612">
                </div>

                <!-- USUARIO -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Registrado por</label>
                    <input type="text" class="form-control bg-light"
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
                Guardar área
            </button>

            <span wire:loading wire:target="guardartodo" class="text-muted">
                Guardando...
            </span>

        </div>

    </x-modal>

</div>