<div class="d-flex gap-2 flex-wrap">

    <!-- ✏️ EDITAR -->
    <button class="btn btn-sm btn-light-primary d-flex align-items-center gap-1" wire:click="$set('openArea',true)">
        <i class="bi bi-pencil-square"></i>
        Editar
    </button>

    <!-- 🔴 ELIMINAR / 🟢 ACTIVAR -->
    @if ($usuario->estado == 'Activo')
        <button class="btn btn-sm btn-light-danger d-flex align-items-center gap-1"
            wire:click="$emit('inactivarUser',{{ $usuario->id }})">
            <i class="bi bi-trash"></i>
            Desactivar
        </button>
    @else
        <button class="btn btn-sm btn-light-success d-flex align-items-center gap-1"
            wire:click="$emit('activarUser',{{ $usuario->id }})">
            <i class="bi bi-check-circle"></i>
            Activar
        </button>
    @endif

    <!-- ℹ️ INFO -->
    <button class="btn btn-sm btn-light-info d-flex align-items-center gap-1" wire:click="$set('openuser',true)">
        <i class="bi bi-info-circle"></i>
        Información
    </button>

    <!-- ================= MODAL EDITAR ================= -->
    <x-modal wire:model.defer="openArea">

        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Editar usuario
            </h4>
            <span class="text-muted small">
                {{ $usuario->name }}
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" wire:model.defer="usuario.name">
                </div>

                <!-- TEL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" wire:model.defer="usuario.telefono">
                </div>

                <!-- EMAIL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" wire:model.defer="usuario.email">
                </div>

                <!-- ROL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rol</label>
                    <select class="form-select" wire:model.defer="usuario.rol">
                        <option value="">Seleccionar rol</option>
                        @foreach ($roles as $rol)
                            <option>{{ $rol->rol }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- FECHA -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fecha ingreso</label>
                    <input type="date" class="form-control" wire:model="usuario.fechainicio">
                </div>

                <!-- HORARIOS -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hora inicio</label>
                    <input type="time" class="form-control" wire:model.defer="usuario.horainicio">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hora fin</label>
                    <input type="time" class="form-control" wire:model.defer="usuario.horafin">
                </div>
                <div class="form-group">
                    <label class="form-label" for="">Foto de perfil:</label>
                    <input class="form-control" type="file" wire:model="image">
                    <img class="mt-4" src="{{ asset('storage/' . $usuario->path) }}" alt="">
                    @if ($image)
                        @if ($image->getClientOriginalExtension() === 'jpg' || $image->getClientOriginalExtension() === 'png')
                            <img class="mt-4" src="{{ $image->temporaryUrl() }}" alt=""
                                style="max-height: 250px;">
                        @endif
                    @endif
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

            <button class="btn btn-light" wire:click="$set('openArea',false)">
                Cancelar
            </button>

            <button class="btn btn-success d-flex align-items-center gap-2" wire:click="guardartodo">

                <i class="bi bi-check-circle"></i>
                Guardar cambios
            </button>

        </div>

    </x-modal>

    <!-- ================= MODAL INFORMACIÓN ================= -->
    <x-modal wire:model.defer="openuser">

        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-lines-fill me-2"></i>
                Información del usuario
            </h4>
            <span class="text-muted small">
                {{ $usuario->name }}
            </span>
        </div>

        <div class="px-6 py-4">

            <div class="mb-3">
                <span class="fw-semibold text-muted">Horario:</span>
                <div class="fw-bold">
                    {{ $usuario->horainicio }} - {{ $usuario->horafin }}
                </div>
            </div>

            <div class="mb-3">
                <span class="fw-semibold text-muted">Teléfono:</span>
                <div class="fw-bold">
                    {{ $usuario->telefono }}
                </div>
            </div>

            <div class="mb-3">
                <span class="fw-semibold text-muted">Email:</span>
                <div class="fw-bold">
                    {{ $usuario->email }}
                </div>
            </div>

        </div>

        <div class="px-6 py-4 border-top text-end">
            <button class="btn btn-light" wire:click="$set('openuser',false)">
                Cerrar
            </button>
        </div>

    </x-modal>

</div>
