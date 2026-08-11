<div>
    <div class="px-4 section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Inicio</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ Auth::user()->sucursal }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link @if ($opcion == 4) active @endif" data-toggle="tab"
                            href="#admin-habitacion" wire:click="setOpcion(4)">Departamentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($opcion == 0) active @endif" data-toggle="tab"
                            href="#admin-Dashboard" wire:click="setOpcion(0)">Registrados({{ $agendados }})</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PANEL DE REGISTRO DE PAGOS: </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Búsqueda: </label>
                        <input type="text" class="form-control" wire:model="busqueda"
                            placeholder="Buscar departamento...">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div style="margin-right: 1%; ">
                                <label for="fecha-inicio">Desde:</label>
                                <input style="" type="date" id="fecha-inicio" class="form-control"
                                    wire:model="fechaInicioMes">
                            </div>
                            <div style="margin-right: 1%; ">
                                <label for="fecha-actual">Hasta:</label>
                                <input style="" type="date" id="fecha-actual" class="form-control"
                                    wire:model="fechaActual">
                            </div>
                        </div>
                    </div>

                </div>
                @if ($opcion == 0)


                    <div class="table-responsive">
                        <table class="table mb-0 table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>COPROPIETARIO</th>
                                    <th>COMENTARIO</th>
                                    <th>HOSPEDAJE</th>
                                    <th>DEPARTAMENTO(S)</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($llamadas as $lista)
                                    <tr>
                                        <td>
                                            <div class="text-muted">Nombre:{{ $lista->empresa }}</div>
                                            <div class="text-muted">Teléfono:{{ $lista->telefono }}</div>
                                            <div class="text-muted">CI:{{ $lista->ci }}</div>
                                        </td>
                                        <td>
                                            {{ $lista->comentario }}
                                        </td>
                                        <td>
                                            <div class="text-muted">Hora de entrada:  {{ $lista->hora }}</div>
                                            <div class="text-muted">Fecha de entrada:  {{ $lista->fecha }}</div>
                                            <div class="text-muted">Fecha de salida:  {{ $lista->fechafin }}</div>
                                        </td>
                                        @php
                                            $historial = DB::table('historial_clientes')
                                                ->where('idoperativo', $lista->id)
                                                ->get();
                                        @endphp
                                        <td>
                                            @foreach ($historial as $historia)
                                                {{ $historia->nombretratamiento . '/' }}
                                            @endforeach
                                        </td>
                                        <td>
                                            @livewire('operativos.editar-operativo', ['operativo' => $lista], key($lista->id))
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $llamadas->links() }}
                    </div>
                @endif
                @if ($opcion == 4)
                    <div class="">
                        @foreach ($estados as $estado => $titulo)
                            @php
                                $habitacionesEstado = $habitaciones->where('estado', $estado);
                            @endphp

                            @if ($habitacionesEstado->count() > 0)
                                <h2 class="mt-2">{{ $titulo }}</h2>
                                <div class="row">
                                    @foreach ($habitacionesEstado as $index => $habitacion)
                                        <div class="mb-2 col-3">
                                            <div class="card"
                                                style="width:80%; background-color:
                                             {{ $habitacion->estado == 'Activo'
                                                 ? '#28a745'
                                                 : ($habitacion->estado == 'Ocupado'
                                                     ? '#ffc107'
                                                     : ($habitacion->estado == 'mantenimiento'
                                                         ? '#dc3545'
                                                         : ($habitacion->estado == 'limpieza'
                                                             ? '#007bff'
                                                             : ($habitacion->estado == 'reservado'
                                                                 ? '#ff9800'
                                                                 : '')))) }};">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $habitacion->nombre }}</h5>
                                                    <p>Capacidad: {{ $habitacion->capacidad }} mt2</p>
                                                    <div style="display:flex;">

                                                            @livewire('clientes.crear-cliente', ['idhabitacion' => $habitacion->id], key($habitacion->id))

                                                        {{-- @if ($habitacion->estado == 'Ocupado')
                                                        @endif
                                                        @livewire('recepcionista.estados', ['habitacion' => $habitacion], key($habitacion->id * 10)) --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
