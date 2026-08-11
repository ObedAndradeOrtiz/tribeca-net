<div class="py-5 px-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ki-outline ki-notification-bing text-warning me-2"></i>
                Notificaciones de mantenimiento
            </h4>
            <span class="text-muted small">
                Alertas según fechas programadas
            </span>
        </div>
    </div>

    <!-- LISTA -->
    <div class="d-flex flex-column gap-3" style="max-height: 500px; overflow-y:auto;">

        @forelse ($notificaciones as $n)

            <div class="card shadow-sm border-0">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <!-- INFO -->
                    <div class="d-flex align-items-start gap-3">

                        <!-- ICONO -->
                        <div class="symbol symbol-45px">
                            <span class="symbol-label bg-light-{{ $n->color }}">
                                <i class="ki-outline ki-notification-bing text-{{ $n->color }} fs-2"></i>
                            </span>
                        </div>

                        <!-- TEXTO -->
                        <div>
                            <div class="fw-bold text-gray-800">
                                {{ $n->nombre ?? 'Mantenimiento' }}
                            </div>

                            <div class="text-muted small">
                                {{ $n->mensaje }}
                            </div>

                            <div class="text-muted small mt-1">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ \Carbon\Carbon::parse($n->fecha_siguiente)->format('d/m/Y') }}
                            </div>
                        </div>

                    </div>

                    <!-- BADGE -->
                    <div class="text-end">

                        <span class="badge badge-light-{{ $n->color }} fw-bold px-4 py-2">
                            {{ $n->dias_restantes }} días
                        </span>

                    </div>

                </div>

                <!-- BARRA INFERIOR -->
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-{{ $n->color }}" style="width:
                        {{ $n->dias_restantes <= 2 ? '100%' : ($n->dias_restantes <= 5 ? '70%' : '40%') }}">
                    </div>
                </div>

            </div>

        @empty

            <div class="text-center py-10">
                <i class="ki-outline ki-information-5 fs-3x text-muted mb-3"></i>
                <div class="text-muted fw-semibold">
                    No hay mantenimientos próximos
                </div>
            </div>

        @endforelse

    </div>

</div>