<div>
    <button class="btn btn-primary d-flex" wire:click="$set('crear',true)" style="">
        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z"
                fill="currentColor"></path>
        </svg>
    </button>
    <x-modal wire:model.defer="crear">

        <div class="px-6 py-4">

            <!-- 🔥 TÍTULO -->
            <div class="pb-2 mb-4 text-xl fw-bold text-dark border-bottom">
                🏢 Registrar copropietario - {{ $habitacion->nombre }}
            </div>

            <form>

                <!-- 🔥 FILA 1 -->
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Edificio</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->sucursal }}"
                            disabled>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nombre completo</label>
                        <input type="text" class="form-control text-uppercase"
                            oninput="this.value = this.value.toUpperCase()" wire:model.defer="name">
                    </div>

                </div>

                <!-- 🔥 FILA 2 -->
                <div class="mt-2 row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="number" class="form-control" wire:model.defer="telefono">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">CI</label>
                        <input type="text" class="form-control" wire:model.defer="ci">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Edad</label>
                        <input type="number" class="form-control" wire:model.defer="edad">
                    </div>

                </div>

                <!-- 🔥 FILA 3 -->
                <div class="mt-2 row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexo</label>
                        <select class="form-select" wire:model.defer="sexo">
                            <option value="">Seleccionar</option>
                            <option value="femenino">Femenino</option>
                            <option value="masculino">Masculino</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Personas</label>
                        <input type="number" class="form-control" wire:model.defer="cantidadpersona">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ocupación</label>
                        <input type="text" class="form-control" wire:model.defer="ocupacion">
                    </div>

                </div>

                <!-- 🔥 FILA 4 -->
                <div class="mt-2 row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de entrada</label>
                        <input type="date" class="form-control" wire:model.defer="fechacita">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de salida</label>
                        <input type="date" class="form-control" wire:model.defer="fechadefin">
                    </div>

                </div>

                <!-- 🔥 FILA 5 -->
                <div class="mt-3">
                    <label class="form-label fw-semibold">Hora de entrada</label>

                    <div class="gap-2 d-flex">

                        <select class="form-select" wire:model.defer="hora">
                            <option value="">Hora</option>
                            @for ($i = 0; $i < 24; $i++)
                                <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                            @endfor
                        </select>

                        <select class="form-select" wire:model.defer="minuto">
                            <option value="">Min</option>
                            <option>00</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                            <option>25</option>
                            <option>30</option>
                            <option>35</option>
                            <option>40</option>
                            <option>45</option>
                            <option>50</option>
                            <option>55</option>
                        </select>

                    </div>
                </div>

            </form>

        </div>

        <!-- 🔥 FOOTER -->
        <div class="px-6 py-3 d-flex justify-content-end border-top bg-light">

            <button class="px-4 shadow-sm btn btn-success" wire:click="guardartodo" wire:loading.remove
                wire:target="guardartodo">

                <i class="mdi mdi-content-save"></i> Guardar

            </button>

            <span class="ms-3 text-muted" wire:loading wire:target="guardartodo">
                Guardando...
            </span>

        </div>

    </x-modal>
</div>
