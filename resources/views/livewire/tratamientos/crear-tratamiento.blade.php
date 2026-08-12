<div>

    <!-- BOTÓN -->
    <button class="btn btn-primary d-flex align-items-center gap-2"
        wire:click="$set('crear',true)">
        <i class="bi bi-plus-circle fs-5"></i>
        <span>Registrar departamento</span>
    </button>

    <!-- MODAL -->
    <x-modal wire:model.defer="crear">
        
        <!-- HEADER -->
        <div class="px-6 pt-5 pb-3 border-bottom">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-building-add me-2"></i>
                Nuevo departamento
            </h4>
            <span class="text-muted small">
                Complete la información del departamento
            </span>
        </div>

        <!-- BODY -->
        <div class="px-6 py-4">

            <div class="row g-4">

                <!-- NOMBRE -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control"
                        wire:model.defer="nombre"
                        placeholder="Ej: Departamento 101">
                </div>

                <!-- TIPO -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo</label>
                    <select wire:model.defer="tipo" class="form-select">
                        <option value="">Seleccione tipo</option>
                        @php
                            $tipos = DB::table('tipohabitacions')->where('estado', 'Activo')->get();
                        @endphp
                        @foreach ($tipos as $item)
                            <option value="{{ $item->tipo }}">{{ $item->tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control"
                        rows="3"
                        wire:model.defer="descripcion"
                        placeholder="Descripción del departamento..."></textarea>
                </div>

                <!-- COSTO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Costo mensual</label>
                    <input type="number" class="form-control"
                        wire:model.defer="costo"
                        placeholder="Bs 0.00">
                </div>

                <!-- CAPACIDAD -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Metros (m²)</label>
                    <input type="number" class="form-control"
                        wire:model.defer="capacidad"
                        placeholder="Ej: 80">
                </div>

                <!-- ÁREA -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Área</label>
                    <select wire:model.defer="area" class="form-select">
                        <option value="">Seleccione área</option>
                        @php
                            $areas = DB::table('areas')->where('estado', 'Activo')->get();
                        @endphp
                        @foreach ($areas as $item)
                            <option value="{{ $item->area }}">{{ $item->area }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Permisos de uso</label>
                    <div class="d-flex flex-wrap gap-4">
                        <label class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" wire:model.defer="puede_usar_piscina">
                            <span class="form-check-label">Puede usar piscina</span>
                        </label>

                        <label class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" wire:model.defer="puede_usar_salon">
                            <span class="form-check-label">Puede usar salon</span>
                        </label>
                    </div>
                </div>

                <!-- USUARIO -->
                <div class="col-12">
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
                Guardar
            </button>

            <span wire:loading wire:target="guardartodo" class="text-muted">
                Guardando...
            </span>

        </div>

    </x-modal>

</div>
