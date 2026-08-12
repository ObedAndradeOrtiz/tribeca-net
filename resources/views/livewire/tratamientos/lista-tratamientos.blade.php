<div class="card shadow-sm">

    <!-- 🔥 HEADER -->
    <div class="card-header border-0 pt-5">

        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-building me-2"></i> Gestión de Departamentos
            </h3>
            <span class="text-muted small">
                Administración de departamentos, ocupación y accesos
            </span>
        </div>

    </div>

    <!-- 🔥 BODY -->
    <div class="card-body pt-0">

        <!-- 🔥 TABS -->
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">

            <li class="nav-item">
                <a class="nav-link {{ $opcion == 'departamento' ? 'active' : '' }}"
                    wire:click="$set('opcion','departamento')">
                    <i class="bi bi-building me-1"></i>
                    Lista de Departamentos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $opcion == 'ocupacion' ? 'active' : '' }}"
                    wire:click="$set('opcion','ocupacion')">
                    <i class="bi bi-people me-1"></i>
                    Gestión de ocupación
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $opcion == 'acceso' ? 'active' : '' }}" wire:click="$set('opcion','acceso')">
                    <i class="bi bi-shield-check me-1"></i>
                    Gestión de acceso a áreas
                </a>
            </li>

        </ul>

        <!-- 🔥 CONTENIDO -->
        <div class="tab-content">
            @switch($opcion)
                @case('departamento')
                    <!-- ===================== TAB 1 ===================== -->
                    <div class="">

                        <!-- TU CÓDIGO ORIGINAL -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>
                                    <h5 class="fw-bold mb-1">

                                    </h5>
                                    <span class="text-muted small">

                                    </span>
                                </div>

                                <!-- BOTÓN CREAR -->
                                @livewire('tratamientos.crear-tratamiento')

                            </div>
                            <!-- HEADER -->


                            <!-- BUSCADOR -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" class="form-control ps-10" wire:model.debounce.500ms="busqueda"
                                            placeholder="Buscar departamento...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" wire:model="filtroEstadoDepartamento">
                                        <option value="Todos">Todos</option>
                                        <option value="Activo">Activos</option>
                                        <option value="Inactivo">Inactivos</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" wire:model="filtroAccesoArea">
                                        <option value="">Todos los accesos</option>
                                        <option value="piscina">Uso piscina</option>
                                        <option value="salon">Uso salon</option>
                                    </select>
                                </div>
                            </div>

                            <!-- TABLA -->
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-hover align-middle">

                                    <thead class="fw-bold text-muted">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Costo</th>
                                            <th>Accesos</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($tratamientos as $lista)
                                            <tr>

                                                <td class="fw-semibold">
                                                    {{ $lista->nombre }}
                                                </td>

                                                <td>
                                                    <span class="badge bg-light-primary text-dark">
                                                        {{ $lista->TIPO }}
                                                    </span>
                                                </td>

                                                <td style="max-width: 250px;">
                                                    <span class="text-muted d-block text-truncate">
                                                        {{ $lista->descripcion ?: 'SIN DATOS' }}
                                                    </span>
                                                </td>

                                                <td class="fw-bold text-success">
                                                    Bs {{ number_format($lista->costo, 2) }}
                                                </td>

                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @if ($areaPiscinaId && isset($permisos[$lista->id][$areaPiscinaId]))
                                                            <span class="badge bg-light-info text-info">Piscina</span>
                                                        @else
                                                            <span class="badge bg-light text-muted">Sin piscina</span>
                                                        @endif

                                                        @if ($areaSalonId && isset($permisos[$lista->id][$areaSalonId]))
                                                            <span class="badge bg-light-success text-success">Salon</span>
                                                        @else
                                                            <span class="badge bg-light text-muted">Sin salon</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-success' => in_array($lista->estado, ['Activo', 'Ocupado']),
                                                        'bg-danger' => $lista->estado == 'Inactivo',
                                                        'bg-warning' => $lista->estado == 'Pendiente',
                                                    ])>
                                                        {{ $lista->estado }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <button class="btn btn-sm btn-light-info"
                                                            title="Ver reporte de uso"
                                                            wire:click="verReporteDepartamento({{ $lista->id }})">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        @livewire('tratamientos.vista-tratamiento', ['idtratamiento' => $lista->id], key($lista->id))
                                                    </div>
                                                </td>

                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-5">
                                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                    No hay departamentos registrados
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                @break

                @case('ocupacion')
                    <!-- ===================== TAB 2 ===================== -->
                    <div class="">

                        <div>

                            <!-- 🔥 HEADER + BOTÓN -->
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>
                                    <h5 class="fw-bold mb-1">

                                    </h5>
                                    <span class="text-muted small">

                                    </span>
                                </div>

                                <!-- BOTÓN CREAR -->
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                                    data-bs-target="#modalOcupacion" wire:click="$set('modalOcupacion',true)">
                                    <i class="bi bi-person-plus"></i>
                                    Registrar persona
                                </button>

                            </div>

                            <!-- 🔥 TABLA -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <select class="form-select" wire:model="filtroEstadoOcupacion">
                                        <option value="Todos">Todos</option>
                                        <option value="Activo">Activos</option>
                                        <option value="Inactivo">Inactivos</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">

                                <table class="table table-row-bordered table-hover align-middle">

                                    <thead class="fw-bold text-muted bg-light">
                                        <tr>
                                            <th>Departamento</th>
                                            <th>Nombre</th>
                                            <th>CI</th>
                                            <th>Edad</th>
                                            <th>Tipo</th>
                                            <th>Fecha de inicio</th>
                                            <th>Fecha desalojo</th>
                                            <th>Estado</th>
                                            <th class="text-end">Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($ocupaciones as $o)
                                            <tr>

                                                <!-- DEPARTAMENTO -->
                                                <td class="fw-semibold">
                                                    @php
                                                        $depto = \App\Models\Tratamiento::find($o->tratamiento_id);
                                                    @endphp
                                                    {{ $depto->nombre ?? '---' }}
                                                </td>

                                                <!-- NOMBRE -->
                                                <td>{{ $o->nombre }}</td>

                                                <!-- CI -->
                                                <td>{{ $o->ci }}</td>

                                                <!-- EDAD -->
                                                <td>{{ $o->edad ?? '-' }}</td>

                                                <!-- TIPO -->
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-primary' => $o->tipo == 'dueno',
                                                        'bg-warning text-dark' => $o->tipo == 'inquilino',
                                                        'bg-info text-dark' => $o->tipo == 'habitante',
                                                    ])>
                                                        {{ strtoupper($o->tipo) }}
                                                    </span>

                                                    @if ($o->tipo == 'habitante' && $o->parentesco)
                                                        <div class="text-muted small">
                                                            {{ $o->parentesco }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- FECHA INICIO -->
                                                <td>
                                                    {{ \Carbon\Carbon::parse($o->fecha_inicio)->format('d/m/Y') }}
                                                </td>

                                                <!-- FECHA FIN -->
                                                <td>
                                                    @if ($o->fecha_fin)
                                                        <span class="text-danger">
                                                            {{ \Carbon\Carbon::parse($o->fecha_fin)->format('d/m/Y') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <!-- ESTADO -->
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-success' => $o->estado == 'Activo',
                                                        'bg-danger' => $o->estado == 'Inactivo',
                                                    ])>
                                                        {{ $o->estado }}
                                                    </span>
                                                </td>

                                                <!-- ACCIONES -->
                                                <td class="text-end">

                                                    <button class="btn btn-sm btn-light-warning"
                                                        wire:click="editarOcupacion({{ $o->id }})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-5">
                                                    <i class="bi bi-person-lines-fill fs-2 d-block mb-2"></i>
                                                    No hay registros de ocupación
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                @break

                @case('acceso')
                    <!-- ===================== TAB 3 ===================== -->
                    <div class="">

                        <div class="card shadow-sm">
                            <!-- BUSCADOR -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" class="form-control ps-10" wire:model.debounce.500ms="busqueda"
                                            placeholder="Buscar departamento...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" wire:model="filtroEstadoDepartamento">
                                        <option value="Todos">Todos</option>
                                        <option value="Activo">Activos</option>
                                        <option value="Inactivo">Inactivos</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" wire:model="filtroAccesoArea">
                                        <option value="">Todos los accesos</option>
                                        <option value="piscina">Uso piscina</option>
                                        <option value="salon">Uso salon</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">

                                <table class="table table-bordered align-middle text-center">

                                    <thead class="bg-light fw-bold">

                                        <tr>
                                            <th class="text-start">Departamento</th>

                                            @foreach ($areas as $area)
                                                <th>
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ $area->area }}
                                                </th>
                                            @endforeach
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse ($tratamientos as $t)
                                            <tr>

                                                <!-- NOMBRE DEPTO -->
                                                <td class="text-start fw-semibold">
                                                    {{ $t->nombre }}
                                                </td>

                                                <!-- AREAS -->
                                                @foreach ($areas as $area)
                                                    <td>

                                                        <div class="form-check d-flex justify-content-center">

                                                            <input type="checkbox" class="form-check-input"
                                                                wire:click="toggleArea({{ $t->id }}, {{ $area->id }})"
                                                                {{ isset($permisos[$t->id][$area->id]) ? 'checked' : '' }}>

                                                        </div>

                                                    </td>
                                                @endforeach

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="{{ count($areas) + 1 }}" class="text-muted py-5">
                                                    No hay departamentos
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>
                @break

            @endswitch
        </div>
        <x-modal wire:model.defer="modalOcupacion">

            <!-- HEADER -->
            <div class="px-6 pt-5 pb-3 border-bottom">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-person-plus me-2"></i>
                    Registrar ocupante
                </h4>
                <span class="text-muted small">
                    Datos del residente del departamento
                </span>
            </div>

            <!-- BODY -->
            <div class="px-6 py-4">

                <div class="row g-4">

                    <!-- DEPARTAMENTO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Departamento</label>
                        <select class="form-select" wire:model.defer="departamento_id">
                            <option value="">Seleccionar</option>
                            @foreach ($tratamientos as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TIPO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tipo de ocupación</label>
                        <select class="form-select" wire:model.defer="tipo">
                            <option value="">Seleccionar</option>
                            <option value="dueno">Dueño principal</option>
                            <option value="inquilino">Inquilino</option>
                            <option value="habitante">Habitante</option>
                        </select>
                    </div>

                    <!-- NOMBRE -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre completo</label>
                        <input type="text" class="form-control" wire:model.defer="nombre">
                    </div>

                    <!-- CI -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Carnet de identidad</label>
                        <input type="text" class="form-control" wire:model.defer="ci">
                    </div>

                    <!-- EDAD -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Edad</label>
                        <input type="number" class="form-control" wire:model.defer="edad">
                    </div>

                    <!-- TEL -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" class="form-control" wire:model.defer="telefono">
                    </div>

                    <!-- ESTADO -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Estado</label>
                        <select class="form-select" wire:model.defer="estado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <!-- FECHA INICIO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha inicio</label>
                        <input type="date" class="form-control" wire:model.defer="fecha_inicio">
                    </div>

                    <!-- PARENTESCO -->
                    @if ($tipo == 'habitante')
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Parentesco</label>
                            <select class="form-select" wire:model.defer="parentesco">
                                <option value="">Seleccionar</option>
                                <option>Esposo</option>
                                <option>Esposa</option>
                                <option>Hijo</option>
                                <option>Hija</option>
                                <option>Primo</option>
                                <option>Prima</option>
                                <option>Tío</option>
                                <option>Tía</option>
                                <option>Abuelo</option>
                                <option>Abuela</option>
                                <option>Otro</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-12">
                        <label class="form-label fw-semibold">Imágenes del ocupante</label>

                        <input type="file" class="form-control" multiple wire:model="imagenes">

                        <span class="text-muted small">
                            Puede subir varias imágenes (documentos, rostro, etc.)
                        </span>
                    </div>
                    @if ($imagenes)
                        <div class="row mt-3">
                            @foreach ($imagenes as $index => $img)
                                <div class="col-md-3 text-center">

                                    <img src="{{ $img->temporaryUrl() }}" class="img-fluid rounded shadow mb-2"
                                        style="height:120px; object-fit:cover;">

                                    <button class="btn btn-sm btn-danger"
                                        wire:click="quitarImagen({{ $index }})">
                                        Quitar
                                    </button>

                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($imagenesExistentes)
                        <div class="row mt-3">

                            @foreach ($imagenesExistentes as $img)
                                <div class="col-md-3 text-center">

                                    <img src="{{ asset('storage/' . $img->ruta) }}"
                                        class="img-fluid rounded shadow mb-2" style="height:120px; object-fit:cover;">

                                    <button class="btn btn-sm btn-danger"
                                        wire:click="eliminarImagen({{ $img->id }})">
                                        Eliminar
                                    </button>

                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

                <button class="btn btn-light" wire:click="$set('modalOcupacion',false)">
                    Cancelar
                </button>

                <button class="btn btn-success d-flex align-items-center gap-2"
                    wire:click="{{ $editando ? 'actualizarOcupacion' : 'guardarOcupacion' }}">

                    <i class="bi bi-check-circle"></i>
                    Guardar
                </button>

            </div>

        </x-modal>

        <x-modal wire:model.defer="modalReporteDepartamento">
            <div class="px-6 pt-5 pb-3 border-bottom">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-eye me-2"></i>
                    Reporte {{ $reporteDepartamento['nombre'] ?? '' }}
                </h4>
                <span class="text-muted small">
                    Personas registradas y uso estimado de salon
                </span>
            </div>

            <div class="px-6 py-4">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $reporteTab === 'personas' ? 'active' : '' }}"
                            wire:click="$set('reporteTab','personas')">
                            Personas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $reporteTab === 'salon' ? 'active' : '' }}"
                            wire:click="$set('reporteTab','salon')">
                            Uso salon
                        </button>
                    </li>
                </ul>

                @if ($reporteTab === 'personas')
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle">
                            <thead class="fw-bold text-muted bg-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>CI</th>
                                    <th>Tipo</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportePersonas as $persona)
                                    <tr>
                                        <td class="fw-semibold">{{ $persona['nombre'] }}</td>
                                        <td>{{ $persona['ci'] }}</td>
                                        <td>
                                            {{ strtoupper($persona['tipo']) }}
                                            @if ($persona['parentesco'])
                                                <div class="text-muted small">{{ $persona['parentesco'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $persona['fecha_inicio'] ? \Carbon\Carbon::parse($persona['fecha_inicio'])->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            {{ $persona['fecha_fin'] ? \Carbon\Carbon::parse($persona['fecha_fin'])->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $persona['estado'] === 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $persona['estado'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            No hay personas registradas para este departamento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="row g-3 mb-4">
                        @foreach ($reporteUsoSalonResumen as $anio => $cantidad)
                            <div class="col-6 col-md-3 col-xl-2">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">{{ $anio }}</div>
                                    <div class="fs-4 fw-bold">{{ $cantidad }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="alert alert-light-warning">
                        Total estimado: <strong>{{ $reporteUsoSalonTotal }}</strong>. Se calcula buscando ingresos de salon que mencionen el departamento en detalle, observacion o aplicacion.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle">
                            <thead class="fw-bold text-muted bg-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Depositante</th>
                                    <th>Detalle</th>
                                    <th>Comprobante</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reporteUsoSalon as $uso)
                                    <tr>
                                        <td>{{ $uso['fecha'] ? \Carbon\Carbon::parse($uso['fecha'])->format('d/m/Y') : '-' }}</td>
                                        <td class="fw-semibold">{{ $uso['depositante'] }}</td>
                                        <td style="min-width: 260px;">{{ $uso['detalle'] }}</td>
                                        <td>{{ $uso['comprobante'] }}</td>
                                        <td class="text-end fw-bold">Bs {{ number_format($uso['monto'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            No se encontraron coincidencias de uso de salon para este departamento desde 2024.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="px-6 py-4 border-top d-flex justify-content-end">
                <button class="btn btn-light" wire:click="$set('modalReporteDepartamento',false)">
                    Cerrar
                </button>
            </div>
        </x-modal>
    </div>
