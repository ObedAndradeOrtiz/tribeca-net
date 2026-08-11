<div>



    <!-- TABS MODERNOS -->
    <div class="d-flex justify-content-center mb-4">

        <div class="btn-group bg-light rounded-pill p-1">

            <!-- ÁREAS -->
            <button
                class="btn px-4 rounded-pill d-flex align-items-center gap-2
                {{ $actividad === 'Areas' ? 'btn-primary' : 'btn-light' }}"
                wire:click="$set('actividad','Areas')">

                <i class="bi bi-building"></i>
                Áreas comunes
            </button>

            <!-- USUARIOS -->
            <button
                class="btn px-4 rounded-pill d-flex align-items-center gap-2
                {{ $actividad === 'Empresas' ? 'btn-primary' : 'btn-light' }}"
                wire:click="$set('actividad','Empresas')">

                <i class="bi bi-people"></i>
                Usuarios
            </button>

        </div>

    </div>

    <!-- CONTENIDO -->
    <div>

        <div class="card-body">

            @if ($actividad == 'Areas')
                <div>
                   
                </div>
            @endif

            @if ($actividad == 'Empresas')
                <div>
                    @livewire('tesoreria.pago-usuarios')
                </div>
            @endif

        </div>

    </div>

</div>