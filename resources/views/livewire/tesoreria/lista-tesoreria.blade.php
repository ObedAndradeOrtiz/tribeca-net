<div class="card shadow-sm">

    <!-- HEADER -->
    <div class="card-header border-0 pt-5">
        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-wallet2 me-2"></i> Tesorería
            </h3>
            <span class="text-muted small">
                Gestión de ingresos y egresos del sistema
            </span>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-0">

        <!-- 🔥 NAV TABS PRO -->
        <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

            <!-- INGRESOS -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 
                    {{ $tipoingreso === 'ingresoexterno' ? 'active' : '' }}"
                    wire:click="$set('tipoingreso','ingresoexterno')">

                    <i class="bi bi-cash-stack"></i>
                    Caja general
                </a>
            </li>

            <!-- EGRESOS -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 
                    {{ $tipoingreso === 'gastointerno' ? 'active' : '' }}"
                    wire:click="$set('tipoingreso','gastointerno')">

                    <i class="bi bi-receipt"></i>
                    Panel de gastos
                </a>
            </li>

        </ul>

        <!-- 🔥 CONTENIDO -->
        <div class="mt-3">

            @if ($tipoingreso == 'ingresoexterno')
                <div class="fade show active">
                    @livewire('tesoreria.pago-sucursal')
                </div>
            @endif

            @if ($tipoingreso == 'gastointerno')
                <div class="fade show active">
                    @livewire('tesoreria.egreso-interno')
                </div>
            @endif

        </div>

    </div>

</div>