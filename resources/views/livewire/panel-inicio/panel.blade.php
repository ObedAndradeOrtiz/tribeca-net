<div class="container-fluid mt-4">

    @php
        use App\Models\Pagos;
        use App\Models\User;
        use App\Models\Tratamiento;
        use App\Models\Mantenimiento;
         use App\Models\Gastos;

        $totalIngresos = Pagos::where('estado','Pagado')->sum('cantidad');
        $totalPendientes = Pagos::where('estado','Pendiente')->sum('cantidad');
        $totalEgresos = Gastos::sum('cantidad');

        $totalDeptos = Tratamiento::count();
        $totalUsuarios = User::count();

        $mantenimientosPendientes = Mantenimiento::where(function ($q) {
                $q->whereNull('estado')->orWhere('estado', 'Activo');
            })
            ->whereDate('fecha_siguiente','<=',now())
            ->count();

        $ultimosPagos = Pagos::latest()->take(5)->get();
    @endphp

    <!-- 🔥 TARJETAS PRINCIPALES -->
    <div class="row g-4 mb-4">

        <!-- INGRESOS -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">Ingresos</span>
                            <h3 class="fw-bold text-success mb-0">
                                Bs {{ number_format($totalIngresos,2) }}
                            </h3>
                        </div>
                        <i class="bi bi-cash-stack fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- PENDIENTES -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">Pendientes</span>
                            <h3 class="fw-bold text-warning mb-0">
                                Bs {{ number_format($totalPendientes,2) }}
                            </h3>
                        </div>
                        <i class="bi bi-exclamation-circle fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- EGRESOS -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">Egresos</span>
                            <h3 class="fw-bold text-danger mb-0">
                                Bs {{ number_format($totalEgresos,2) }}
                            </h3>
                        </div>
                        <i class="bi bi-receipt fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MANTENIMIENTOS -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">Mantenimientos</span>
                            <h3 class="fw-bold text-primary mb-0">
                                {{ $mantenimientosPendientes }}
                            </h3>
                        </div>
                        <i class="bi bi-tools fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 🔥 SEGUNDA FILA -->
    <div class="row g-4">

        <!-- DEPARTAMENTOS -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-building me-2"></i> Departamentos
                    </h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="fw-bold text-primary">{{ $totalDeptos }}</h1>
                    <span class="text-muted">Total registrados</span>
                </div>
            </div>
        </div>

        <!-- COPROPIETARIOS -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people me-2"></i> Copropietarios
                    </h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="fw-bold text-dark">{{ $totalUsuarios }}</h1>
                    <span class="text-muted">Usuarios registrados</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 🔥 ÚLTIMOS MOVIMIENTOS -->
    <div class="card shadow-sm mt-4">

        <div class="card-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2"></i> Últimos movimientos
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-row-bordered align-middle">

                    <thead class="bg-light fw-bold">
                        <tr>
                            <th>Detalle</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ultimosPagos as $p)
                            <tr>
                                <td>{{ $p->empresa }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->fechainicio)->format('d/m/Y') }}</td>
                                <td class="fw-bold">
                                    Bs {{ number_format($p->cantidad,2) }}
                                </td>
                                <td>
                                    <span @class([
                                        'badge',
                                        'bg-success' => $p->estado == 'Pagado',
                                        'bg-warning' => $p->estado == 'Pendiente',
                                    ])>
                                        {{ $p->estado }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>
