<div class="px-4 mt-4">

    <div class="card shadow-sm">

        <!-- 🔥 HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-journal-text me-2"></i> Registros
                </h3>
                <span class="text-muted small">
                    Historial de actividades del sistema
                </span>
            </div>

            <!-- 🔥 SELECTOR -->
            <div>
                <label class="form-label fw-semibold mb-1">Tipo de registro</label>
                <select wire:model="botonRecepcion" class="form-select">
                    <option value="gastos">Gastos</option>
                   
                </select>
            </div>

        </div>

        <!-- 🔥 BODY -->
        <div class="card-body pt-0">

            <div class="mt-4">

                @if ($botonRecepcion == 'llamada')
                    @livewire('registros.reg-llamadas')
                @endif

                @if ($botonRecepcion == 'clientes')
                    @livewire('registros.reg-citas')
                @endif

                @if ($botonRecepcion == 'citas')
                    @livewire('registros.reg-pagos')
                @endif

                @if ($botonRecepcion == 'producto')
                    @livewire('registros.reg-producto')
                @endif

                @if ($botonRecepcion == 'gastos')
                    @livewire('registros.reg-gastos')
                @endif

                @if ($botonRecepcion == 'traspaso')
                    @livewire('registros.reg-traspaso')
                @endif

                @if ($botonRecepcion == 'creacion')
                    @livewire('registros.reg-crear')
                @endif

                @if ($botonRecepcion == 'modificacion')
                    @livewire('registros.reg-edicion')
                @endif

                @if ($botonRecepcion == 'compras')
                    @livewire('registros.reg-compras')
                @endif

            </div>

        </div>

    </div>

</div>