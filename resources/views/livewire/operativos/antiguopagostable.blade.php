<div>
    <style>
        .mobile-payment-modal {
            padding: 14px;
            background: #f5f7fb;
            max-height: 88vh;
            overflow-y: auto;
            border-radius: 18px;
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .payment-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #111827;
        }

        .payment-header p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .btn-close-mobile {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: #e5e7eb;
            color: #111827;
            font-size: 24px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }

        .section-title {
            font-size: 13px;
            font-weight: 800;
            color: #374151;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .readonly-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .readonly-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 13px;
            padding: 10px 12px;
            margin-bottom: 8px;
        }

        .readonly-box span {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .readonly-box strong {
            display: block;
            font-size: 15px;
            color: #111827;
            font-weight: 800;
            word-break: break-word;
        }

        .form-group-mobile {
            margin-bottom: 12px;
        }

        .form-group-mobile label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-mobile {
            height: 46px;
            border-radius: 13px;
            border: 1px solid #d1d5db;
            font-size: 15px;
            padding: 10px 12px;
            background: #ffffff;
        }

        .input-mobile:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .12);
        }

        .suggestions-mobile {
            position: absolute;
            left: 0;
            right: 0;
            top: 74px;
            z-index: 9999;
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .16);
            max-height: 180px;
            overflow-y: auto;
        }

        .suggestion-item {
            width: 100%;
            border: none;
            background: #ffffff;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:active {
            background: #f3f4f6;
        }

        .upload-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            background: #f8fafc;
            cursor: pointer;
        }

        .upload-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 50%;
            background: #e8f5ee;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .upload-box strong {
            display: block;
            font-size: 14px;
            color: #111827;
            font-weight: 800;
        }

        .upload-box span {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .upload-loading {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #0d6efd;
        }

        .preview-box {
            margin-top: 12px;
        }

        .preview-box span {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }

        .preview-box img {
            width: 100%;
            max-height: 260px;
            object-fit: contain;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .mobile-actions {
            position: sticky;
            bottom: 0;
            background: #f5f7fb;
            padding: 12px 0 2px;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 10px;
            z-index: 20;
        }

        .btn-cancel-mobile,
        .btn-save-mobile {
            border: none;
            border-radius: 14px;
            height: 48px;
            font-size: 14px;
            font-weight: 800;
        }

        .btn-cancel-mobile {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-save-mobile {
            background: #198754;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(25, 135, 84, .25);
        }

        .btn-save-mobile:disabled {
            opacity: .7;
        }

        @media (max-width: 576px) {
            .mobile-payment-modal {
                padding: 12px;
                max-height: 90vh;
            }

            .readonly-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .payment-header h5 {
                font-size: 17px;
            }

            .section-card {
                padding: 12px;
                border-radius: 15px;
            }

            .mobile-actions {
                grid-template-columns: 1fr;
            }

            .btn-cancel-mobile,
            .btn-save-mobile {
                width: 100%;
            }
        }
    </style>
    <div class="mt-4 mb-4 section-body">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header border-0 pt-5">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 w-100">

                        {{-- TÍTULO --}}
                        <div>
                            <h3 class="fw-bold mb-1">
                                <i class="bi bi-receipt me-2"></i> Gestión de Expensas
                            </h3>
                            <span class="text-muted small">
                                Administración de pagos, ingresos y control anual
                            </span>
                        </div>

                        {{-- BOTÓN --}}
                        {{-- <div class="d-flex flex-column align-items-start align-items-md-end gap-1">
                            <button type="button" class="btn btn-primary btn-sm" wire:click="generarPagosFaltantes"
                                wire:loading.attr="disabled" wire:target="generarPagosFaltantes">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Generar pagos faltantes
                            </button>
                            <button type="button" class="btn btn-success btn-sm" wire:click="abrirModalVoz">
                                <i class="bi bi-mic-fill me-1"></i>
                                Registrar por voz
                            </button>
                            <div wire:loading wire:target="generarPagosFaltantes" class="text-primary small">
                                Generando pagos, espere...
                            </div>
                        </div> --}}

                    </div>
                </div>

                <div class="card-body pt-0">
                    {{-- <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                {{ $vista === 'pagos' ? 'active' : '' }}"
                                wire:click="$set('vista','pagos')">

                                <i class="bi bi-cash-stack"></i>
                                Registro de expensas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                {{ $vista === 'ingresos' ? 'active' : '' }}"
                                wire:click="$set('vista','ingresos')">

                                <i class="bi bi-calendar-check"></i>
                                Alquiler salón
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                {{ $vista === 'deudas' ? 'active' : '' }}"
                                wire:click="$set('vista','deudas')">

                                <i class="bi bi-table"></i>
                                Control anual
                            </a>
                        </li>

                    </ul> --}}
                    {{-- <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <!-- BUSCADOR -->
                                    @if ($vista == 'pagos' || $vista == 'ingresos')
                                        <div class="card">
                                            <div class="card-body py-2">

                                                <div class="row g-2">

                                                    <!-- BUSCADOR -->
                                                    <div class="col-12 col-md-4">
                                                        <input type="text" class="form-control form-control-sm w-100"
                                                            placeholder="Buscar..."
                                                            wire:model.debounce.500ms="busqueda">
                                                    </div>

                                                    <!-- DEPTO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroTratamiento"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Depto</option>
                                                            @foreach ($tratamientos as $t)
                                                                <option value="{{ $t->nombre }}">{{ $t->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- MES -->
                                                    <!-- MES -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroMes"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Mes</option>
                                                            @foreach ($meses as $numero => $nombre)
                                                                <option value="{{ $numero }}">{{ $nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- AÑO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroAnio"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Año</option>
                                                            @for ($i = 2024; $i <= 2026; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <!-- ESTADO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroEstado"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Estado</option>
                                                            <option value="Pendiente">Pendiente</option>
                                                            <option value="Pagado">Pagado</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                    @if ($vista == 'ingresos')
                                                        <button class="btn btn-success"
                                                            wire:click="$set('crear',true)">Crear
                                                            registro de alquiler</button>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    @if ($vista == 'pagos')
                                        <!-- TABLA -->
                                        <div class="table-responsive card mt-2">
                                            <table class="table table-striped mb-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ACCIÓN</th>
                                                        <th>DEPTO</th>
                                                        <th>FECHA</th>
                                                        <th>MONTO A PAGAR</th>
                                                        <th>MONTO PAGADO</th>
                                                        <th>FECHA/ HORA DE PAGO</th>
                                                        <th>DEPOSITANTE</th>
                                                        <th>ESTADO</th>
                                                        <th>REGISTRADO POR</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pagos as $p)
                                                        <tr>
                                                            <td>
                                                                <button wire:click="editar({{ $p->id }})"
                                                                    class="btn btn-sm btn-primary">
                                                                    Editar
                                                                </button>
                                                            </td>
                                                            <td>{{ $p->empresa }}</td>

                                                            <td>{{ $p->fechainicio }}</td>
                                                            <td>{{ $p->cantidad }}</td>
                                                            <td>{{ $p->pagado }}</td>

                                                            <td>
                                                                @if ($p->fechapagado)
                                                                    {{ \Carbon\Carbon::parse($p->fechapagado)->format('d/m/Y H:i') }}
                                                                @else
                                                                    SIN DATOS
                                                                @endif

                                                            </td>
                                                            <td>
                                                                @if ($p->namebeneficiario)
                                                                    {{ $p->namebeneficiario }}
                                                                @else
                                                                    SIN DATOS
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span @class([
                                                                    'badge',
                                                                    'bg-success' => $p->estado == 'Pagado',
                                                                    'bg-warning' => $p->estado == 'Pendiente',
                                                                    'bg-danger' => $p->estado == 'Inactivo',
                                                                    'bg-dark' => $p->estado == 'Atrasado',
                                                                    'bg-info' => $p->estado == 'Adelantado',
                                                                ])>
                                                                    {{ $p->estado }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($p->nameuser)
                                                                    {{ $p->nameuser }}
                                                                @else
                                                                    SIN DATOS
                                                                @endif

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="py-2 px-3 d-flex justify-content-end">
                                                {{ $pagos->links() }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($vista == 'ingresos')
                                        <!-- TABLA -->
                                        <div class="table-responsive card mt-2">
                                            <table class="table table-striped mb-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ACCIÓN</th>
                                                        <th>DEPTO</th>
                                                        <th>FECHA PAGADO</th>
                                                        <th>FECHA A ALQUILAR</th>
                                                        <th>MONTO PAGADO</th>
                                                        <th>ESTADO</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($alquileres as $p)
                                                        <tr>
                                                            <td>
                                                                <button
                                                                    wire:click="editaralquiler({{ $p->id }})"
                                                                    class="btn btn-sm btn-primary">
                                                                    Editar
                                                                </button>
                                                            </td>
                                                            <td>{{ $p->namebeneficiario }}</td>
                                                            <td>{{ $p->fechainicio }}</td>
                                                            <td>{{ $p->fechapagado }}</td>
                                                            <td>{{ $p->pagado }}</td>
                                                            <td>
                                                                <span @class([
                                                                    'badge',
                                                                    'bg-success' => $p->estado == 'Pagado',
                                                                    'bg-warning' => $p->estado == 'Pendiente',
                                                                    'bg-danger' => $p->estado == 'Inactivo',
                                                                    'bg-dark' => $p->estado == 'Atrasado',
                                                                    'bg-info' => $p->estado == 'Adelantado',
                                                                ])>
                                                                    {{ $p->estado }}
                                                                </span>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="py-2 px-3 d-flex justify-content-end">
                                                {{ $alquileres->links() }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($vista == 'deudas')
                                        <div class="card mt-3">
                                            <div class="card-body">

                                                <!-- FILTRO POR AÑO -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <h5>Control de Deudas</h5>

                                                    <select wire:model="filtroAnio" class="form-control form-control-sm"
                                                        style="width:120px;">
                                                        @for ($i = 2024; $i <= date('Y'); $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm text-center">

                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th>Departamento</th>
                                                                @for ($m = 1; $m <= 12; $m++)
                                                                    <th>{{ $m }}</th>
                                                                @endfor

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($tratamientos as $t)
                                                                <tr>
                                                                    <td><strong>{{ $t->nombre }}</strong></td>

                                                                    @for ($m = 1; $m <= 12; $m++)
                                                                        @php

                                                                            $inicio =
                                                                                $filtroAnio .
                                                                                '-' .
                                                                                str_pad($m, 2, '0', STR_PAD_LEFT) .
                                                                                '-01';
                                                                            $fin =
                                                                                $filtroAnio .
                                                                                '-' .
                                                                                str_pad($m, 2, '0', STR_PAD_LEFT) .
                                                                                '-31';

                                                                            $pago = DB::table('pagos')
                                                                                ->where('empresa', $t->nombre)
                                                                                ->whereBetween('fechainicio', [
                                                                                    $inicio,
                                                                                    $fin,
                                                                                ])
                                                                                ->first();

                                                                            $monto = $pago->cantidad ?? 0;
                                                                            $pagado = $pago->pagado ?? 0;

                                                                            $color = 'text-muted';

                                                                            if (
                                                                                $pagado > 0 &&
                                                                                $pago &&
                                                                                $pago->fechapagado
                                                                            ) {
                                                                                $diaPago = date(
                                                                                    'd',
                                                                                    strtotime($pago->fechapagado),
                                                                                );

                                                                                if ($diaPago <= 10) {
                                                                                    $color = 'text-success'; // 🟢 a tiempo
                                                                                } else {
                                                                                    $color = 'text-danger'; // 🔴 atrasado
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        <td style="cursor:pointer"
                                                                            wire:click="editar({{ $pago->id ?? 0 }})">

                                                                            <div style="font-size:11px;">
                                                                                <div>
                                                                                    <strong>{{ $monto }}</strong>
                                                                                </div>
                                                                                <div class="color">{{ $pagado }}
                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    @endfor


                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @livewire('tesoreria.regularizar-ingresos')
                </div>
            </div>
        </div>
    </div>
    <x-modal wire:model="modalVoz">
        <div class="mobile-payment-modal">

            {{-- HEADER --}}
            <div class="payment-header">
                <div>
                    <h5>Registrar pago por voz</h5>
                    <p>Dicta fecha, hora, depositante, monto y departamento</p>
                </div>

                <button type="button" class="btn-close-mobile" wire:click="$set('modalVoz', false)">
                    ×
                </button>
            </div>

            {{-- BOTÓN MICRÓFONO --}}
            <div class="section-card">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" onclick="iniciarDictadoPago()">
                        <i class="bi bi-mic-fill me-1"></i>
                        Iniciar dictado
                    </button>

                    <button type="button" class="btn btn-danger" onclick="detenerDictadoPago()">
                        <i class="bi bi-stop-circle me-1"></i>
                        Detener y procesar
                    </button>
                </div>

                <button type="button" class="btn btn-light w-100 border" wire:click="procesarTextoVoz">
                    Procesar texto
                </button>

                <textarea id="textoVozInput" wire:model.defer="textoVoz" class="form-control" rows="4"
                    placeholder="Ej: 2 de septiembre 2024 hora 15 14 depositante ferrufino B Nataly monto 400 departamento 12j mes de pago abril 2024"></textarea>

                @if ($vozMensaje)
                    <div class="alert alert-info py-2 px-3 mb-0">
                        {{ $vozMensaje }}
                    </div>
                @endif
            </div>

            {{-- VISTA PREVIA --}}
            <div class="section-card">
                <div class="section-title">
                    Vista previa antes de guardar
                </div>

                <div class="form-group-mobile">
                    <label>Departamento / Oficina</label>
                    <select wire:model="vozDepartamento" class="form-control input-mobile">
                        <option value="">Seleccione...</option>
                        @foreach ($tratamientos as $t)
                            <option value="{{ $t->nombre }}">
                                {{ $t->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="readonly-grid">
                    <div class="form-group-mobile">
                        <label>Fecha de pago</label>
                        <input type="date" wire:model="vozFechaPago" class="form-control input-mobile">
                    </div>

                    <div class="form-group-mobile">
                        <label>Hora de pago</label>
                        <input type="time" wire:model="vozHoraPago" class="form-control input-mobile"
                            step="60">
                    </div>
                </div>

                <div class="form-group-mobile">
                    <label>Depositante</label>
                    <input type="text" wire:model="vozDepositante" class="form-control input-mobile"
                        placeholder="Nombre del depositante">
                </div>

                <div class="form-group-mobile">
                    <label>Monto pagado</label>
                    <input type="number" wire:model="vozMonto" class="form-control input-mobile"
                        placeholder="Ej: 300">
                </div>
                <div class="form-group-mobile">
                    <label>Mes del pago</label>
                    <input type="month" wire:model="vozMesPago" class="form-control input-mobile">
                </div>

                <div class="readonly-box mb-0">
                    <span>Acción del sistema</span>
                    <strong>
                        @if ($vozPagoYaPagado)
                            Este mes ya está pagado. No se sobrescribirá.
                        @elseif ($vozPagoId)
                            Actualizará un pago pendiente existente.
                        @else
                            No hay pago pendiente seleccionado.
                        @endif
                    </strong>
                </div>
            </div>
            @if (!empty($vozMesesDepartamento))
                <div class="mt-3">
                    <div class="section-title">
                        Meses detectados del departamento
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Estado</th>
                                    <th>Pagado</th>
                                    <th>Depositante</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vozMesesDepartamento as $mes)
                                    <tr @class([
                                        'table-success' =>
                                            $mes['pagado'] > 0 ||
                                            in_array($mes['estado'], ['Pagado', 'Atrasado', 'Adelantado']),
                                        'table-warning' => $mes['estado'] == 'Pendiente',
                                    ])>
                                        <td>
                                            <button type="button" class="btn btn-link btn-sm p-0"
                                                wire:click="$set('vozMesPago', '{{ \Carbon\Carbon::parse($mes['fecha_inicio'])->format('Y-m') }}')">
                                                {{ $mes['mes'] }}
                                            </button>
                                        </td>
                                        <td>{{ $mes['estado'] }}</td>
                                        <td>Bs {{ number_format($mes['pagado'], 2) }}</td>
                                        <td style="min-width: 180px;">
                                            {{ $mes['depositante'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <small class="text-muted d-block mt-2">
                        Verde: ya tiene pago registrado. Amarillo: pendiente.
                    </small>
                </div>
            @endif
            {{-- BOTONES --}}
            <div class="mobile-actions">
                <button type="button" wire:click="$set('modalVoz', false)" class="btn-cancel-mobile">
                    Cancelar
                </button>

                <button type="button" wire:click="guardarPagoVoz" wire:loading.attr="disabled"
                    wire:target="guardarPagoVoz" class="btn-save-mobile">
                    Guardar Pago
                </button>
            </div>

        </div>
    </x-modal>

    <x-modal wire:model="modal">
        <div class="mobile-payment-modal">

            {{-- HEADER --}}
            <div class="payment-header">
                <div>
                    <h5>Editar Pago</h5>
                    <p>Actualiza el estado y comprobante del pago</p>
                </div>

                <button type="button" class="btn-close-mobile" wire:click="$set('modal', false)">
                    ×
                </button>
            </div>

            {{-- DATOS DEL PAGO --}}
            <div class="section-card">
                <div class="section-title">
                    Datos del pago
                </div>

                <div class="readonly-box">
                    <span>Departamento</span>
                    <strong>{{ $pagoEditar['empresa'] ?? 'SIN DATOS' }}</strong>
                </div>

                <div class="readonly-grid">
                    <div class="readonly-box">
                        <span>Fecha correspondiente</span>
                        <strong>{{ $pagoEditar['fechainicio'] ?? 'SIN DATOS' }}</strong>
                    </div>

                    <div class="readonly-box">
                        <span>Monto total</span>
                        <strong>Bs {{ $pagoEditar['cantidad'] ?? '0.00' }}</strong>
                    </div>
                </div>
            </div>

            {{-- DATOS EDITABLES --}}
            <div class="section-card">
                <div class="section-title">
                    Registro de pago
                </div>

                <div class="form-group-mobile">
                    <label>Monto pagado</label>
                    <input type="number" wire:model="pagoEditar.pagado" class="form-control input-mobile"
                        placeholder="Ej: 300">
                </div>

                <div class="form-group-mobile">
                    <label>Fecha y hora de pago</label>
                    <input type="datetime-local" wire:model="pagoEditar.fechapagado"
                        class="form-control input-mobile">
                </div>

                <div class="form-group-mobile position-relative">
                    <label>Responsable de pago</label>

                    <input type="text" wire:model.debounce.300ms="busquedaBeneficiario"
                        class="form-control input-mobile" placeholder="Buscar responsable...">

                    @if (!empty($sugerencias))
                        <div class="suggestions-mobile">
                            @foreach ($sugerencias as $s)
                                <button type="button" wire:click="seleccionarBeneficiario('{{ $s }}')"
                                    class="suggestion-item">
                                    {{ $s }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group-mobile">
                    <label>Estado</label>
                    <select wire:model="pagoEditar.estado" class="form-control input-mobile">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Inactivo</option>
                        <option value="Atrasado">Atrasado</option>
                        <option value="Adelantado">Adelantado</option>
                    </select>
                </div>
            </div>

            {{-- COMPROBANTE --}}
            <div class="section-card">
                <div class="section-title">
                    Comprobante
                </div>

                <label class="upload-box">
                    <input type="file" wire:model="comprobante" accept="image/*" class="d-none">

                    <div class="upload-icon">
                        <i class="fa fa-upload"></i>
                    </div>

                    <div>
                        <strong>Subir comprobante</strong>
                        <span>Toca aquí para seleccionar una imagen</span>
                    </div>
                </label>

                <div wire:loading wire:target="comprobante" class="upload-loading">
                    Subiendo imagen...
                </div>

                @if ($comprobante)
                    <div class="preview-box">
                        <span>Vista previa nueva</span>
                        <img src="{{ $comprobante->temporaryUrl() }}" alt="Comprobante nuevo">
                    </div>
                @elseif (!empty($pagoEditar['path']))
                    <div class="preview-box">
                        <span>Comprobante actual</span>
                        <img src="{{ asset('storage/' . $pagoEditar['path']) }}" alt="Comprobante actual">
                    </div>
                @endif
            </div>

            {{-- BOTONES --}}
            <div class="mobile-actions">
                <button type="button" wire:click="$set('modal', false)" class="btn-cancel-mobile">
                    Cancelar
                </button>

                <button type="button" wire:click="guardar" class="btn-save-mobile" wire:loading.attr="disabled"
                    wire:target="guardar">
                    Guardar Cambios
                </button>
            </div>

        </div>
    </x-modal>
    <x-modal wire:model="crear">
        <div class="p-4">
            <h5 class="mb-3">Pago de alquiler de salon</h5>
            <div class="row">
                <!-- NO EDITABLES -->
                <div class="col-md-6">
                    <label>Departamento responsable</label>
                    <select name="" id="" wire:model='departamentodealquiler'
                        class="form-control mb-2>
                            <option value="">Seleccione
                        un
                        departamento</option>
                        @foreach ($tratamientos as $item)
                            <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Fecha de alquiler</label>
                    <input type="date" wire:model="fechacorrespondiente" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Monto cancelado</label>
                    <input type="number" wire:model="montopago" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Fecha de pago realizado</label>
                    <input type="date" wire:model="fechadepago" class="form-control mb-2">
                </div>

                <!-- ESTADO -->
                <div class="col-md-6">
                    <label>Estado</label>
                    <select wire:model="estadodepago" class="form-control mb-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Cancelado</option>s
                    </select>
                </div>

                <!-- SUBIR COMPROBANTE -->
                <div class="col-md-6">
                    <label>Subir comprobante o nota</label>
                    <input type="file" wire:model="comprobante" class="form-control mb-2">

                    <!-- Loader -->
                    <div wire:loading wire:target="comprobante" class="text-primary">
                        Subiendo imagen...
                    </div>
                </div>

                <!-- PREVIEW NUEVO -->
                @if ($comprobante)
                    <div class="col-md-6">
                        <label>Vista previa</label>
                        <img src="{{ $comprobante->temporaryUrl() }}" class="img-fluid rounded shadow"
                            style="max-height:200px;">
                    </div>
                @endif

            </div>

            <!-- BOTONES -->
            <div class="text-end mt-3">
                <button wire:click="$set('crear', false)" class="btn btn-secondary me-2">
                    Cancelar
                </button>

                <button wire:click="guardaringreso" class="btn btn-success">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </x-modal>
    <x-modal wire:model="editar">
        <div class="p-4">
            <h5 class="mb-3">Pago de alquiler de salon</h5>
            <div class="row">
                <!-- NO EDITABLES -->
                <div class="col-md-6">
                    <label>Departamento responsable</label>
                    <select name="" id="" wire:model='pagoEditar.namebeneficiario'
                        class="form-control mb-2>
                            <option value="">Seleccione
                        un
                        departamento</option>
                        @foreach ($tratamientos as $item)
                            <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Fecha de alquiler</label>
                    <input type="date" wire:model="pagoEditar.fechainicio" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Monto cancelado</label>
                    <input type="number" wire:model="pagoEditar.pagado" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Fecha de pago realizado</label>
                    <input type="date" wire:model="pagoEditar.fechapagado" class="form-control mb-2">
                </div>

                <!-- ESTADO -->
                <div class="col-md-6">
                    <label>Estado</label>
                    <select wire:model="pagoEditar.estado" class="form-control mb-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Cancelado</option>s
                    </select>
                </div>

                <!-- SUBIR COMPROBANTE -->
                <div class="col-md-6">
                    <label>Subir comprobante o nota</label>
                    <input type="file" wire:model="comprobante" class="form-control mb-2">

                    <!-- Loader -->
                    <div wire:loading wire:target="comprobante" class="text-primary">
                        Subiendo imagen...
                    </div>
                </div>

                <!-- PREVIEW NUEVO -->
                @if (!empty($pagoEditar['path']))
                    <img class="mt-4" src="{{ asset('storage/' . $pagoEditar['path']) }}" alt="">>
                @endif

            </div>

            <!-- BOTONES -->
            <div class="text-end mt-3">
                <button wire:click="$set('editar', false)" class="btn btn-secondary me-2">
                    Cancelar
                </button>

                <button wire:click="guardar" class="btn btn-success">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </x-modal>

  <script>
    let recognitionPago = null;
    let dictadoPagoActivo = false;
    let textoAcumuladoPago = '';
    let ultimoTextoDetectado = '';
    let detenerSolicitado = false;
    let reinicioPendiente = null;

    function iniciarDictadoPago() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            alert('Tu navegador no permite dictado por voz. Usa Google Chrome en Android o Microsoft Edge.');
            return;
        }

        if (dictadoPagoActivo) {
            return;
        }

        dictadoPagoActivo = true;
        detenerSolicitado = false;
        textoAcumuladoPago = '';
        ultimoTextoDetectado = '';

        actualizarTextareaVoz('');

        iniciarReconocimientoPago();
    }

    function iniciarReconocimientoPago() {
        if (!dictadoPagoActivo || detenerSolicitado) {
            return;
        }

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        recognitionPago = new SpeechRecognition();

        recognitionPago.lang = 'es-BO';
        recognitionPago.continuous = false;
        recognitionPago.interimResults = false;
        recognitionPago.maxAlternatives = 1;

        recognitionPago.onresult = function(event) {
            if (!dictadoPagoActivo || detenerSolicitado) {
                return;
            }

            let texto = event.results[0][0].transcript || '';
            texto = texto.trim();

            if (!texto) {
                return;
            }

            /*
                Evita duplicados cuando el celular devuelve la misma frase
                después de reiniciar el reconocimiento.
            */
            if (texto.toLowerCase() === ultimoTextoDetectado.toLowerCase()) {
                return;
            }

            ultimoTextoDetectado = texto;

            textoAcumuladoPago = (textoAcumuladoPago + ' ' + texto)
                .replace(/\s+/g, ' ')
                .trim();

            actualizarTextareaVoz(textoAcumuladoPago);
        };

        recognitionPago.onerror = function(event) {
            console.log('Error micrófono:', event.error);

            if (event.error === 'not-allowed') {
                alert('Permiso de micrófono denegado.');
                dictadoPagoActivo = false;
                detenerSolicitado = true;
                return;
            }

            if (event.error === 'audio-capture') {
                alert('No se detectó micrófono.');
                dictadoPagoActivo = false;
                detenerSolicitado = true;
                return;
            }

            if (event.error === 'no-speech') {
                return;
            }
        };

        recognitionPago.onend = function() {
            /*
                Muy importante:
                Si ya presionaste detener, NO debe reiniciar.
            */
            if (!dictadoPagoActivo || detenerSolicitado) {
                return;
            }

            clearTimeout(reinicioPendiente);

            reinicioPendiente = setTimeout(function() {
                if (dictadoPagoActivo && !detenerSolicitado) {
                    iniciarReconocimientoPago();
                }
            }, 700);
        };

        try {
            recognitionPago.start();
        } catch (e) {
            console.log('No se pudo iniciar reconocimiento:', e);
        }
    }

    function detenerDictadoPago() {
        detenerSolicitado = true;
        dictadoPagoActivo = false;

        clearTimeout(reinicioPendiente);

        if (recognitionPago) {
            try {
                recognitionPago.onend = null;
                recognitionPago.stop();
            } catch (e) {
                console.log('No se pudo detener:', e);
            }
        }

        const textoFinal = textoAcumuladoPago
            .replace(/\s+/g, ' ')
            .trim();

        if (!textoFinal) {
            alert('No se detectó texto.');
            return;
        }

        actualizarTextareaVoz(textoFinal);

        if (typeof Livewire !== 'undefined') {
            Livewire.emit('textoDictadoRecibido', textoFinal);
        }
    }

    function limpiarDictadoPago() {
        detenerSolicitado = true;
        dictadoPagoActivo = false;

        clearTimeout(reinicioPendiente);

        textoAcumuladoPago = '';
        ultimoTextoDetectado = '';

        if (recognitionPago) {
            try {
                recognitionPago.onend = null;
                recognitionPago.stop();
            } catch (e) {
                console.log(e);
            }
        }

        actualizarTextareaVoz('');

        if (typeof Livewire !== 'undefined') {
            Livewire.emit('textoDictadoTemporal', '');
        }
    }

    function actualizarTextareaVoz(texto) {
        const textarea = document.getElementById('textoVozInput');

        if (textarea) {
            textarea.value = texto;
        }
    }
</script>

</div>
