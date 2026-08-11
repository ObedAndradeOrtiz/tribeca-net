<div class="mt-3">

    <!-- 🔥 BOTÓN -->
    <button class="btn btn-primary d-flex align-items-center gap-2"
        wire:click="$set('crear',true)">
        <i class="bi bi-person-plus fs-5"></i>
        <span>Registrar usuario</span>
    </button>

    <!-- 🔥 MODAL -->
    <x-modal wire:model.defer="crear">

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-plus me-2"></i>
                Nuevo usuario
            </h4>
            <span class="text-muted small">
                Complete la información del personal
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text"
                        class="form-control"
                        oninput="convertirAMayusculas()"
                        wire:model.defer="name"
                        placeholder="Ej: JUAN PEREZ">
                </div>

                <!-- ROL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rol</label>
                    <select class="form-select" wire:model.defer="rol">
                        <option value="">Seleccionar rol</option>
                        @foreach ($roles as $rol)
                            <option>{{ $rol->rol }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- TEL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text"
                        class="form-control"
                        wire:model.defer="telefono"
                        placeholder="Ej: 78945612">
                </div>

                <!-- FECHA -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha ingreso</label>
                    <input type="date"
                        class="form-control"
                        wire:model="fechainicio">
                </div>

                <!-- HORA INICIO -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Hora inicio</label>
                    <input type="time"
                        class="form-control"
                        wire:model.defer="horainicio">
                </div>

                <!-- HORA FIN -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Hora fin</label>
                    <input type="time"
                        class="form-control"
                        wire:model.defer="horafin">
                </div>

                <!-- EMAIL -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email"
                        class="form-control"
                        wire:model.defer="email"
                        placeholder="correo@ejemplo.com">
                </div>

                <!-- PASSWORD -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contraseña</label>
                    <input type="password"
                        class="form-control"
                        wire:model.defer="password">
                </div>

                <!-- CONFIRMAR -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmar contraseña</label>
                    <input type="password"
                        class="form-control"
                        wire:model.defer="password2">
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
                Crear usuario
            </button>

            <span wire:loading wire:target="guardartodo" class="text-muted">
                Guardando...
            </span>

        </div>

    </x-modal>

</div>