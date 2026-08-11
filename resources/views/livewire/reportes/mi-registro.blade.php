<div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reportes: </h3>

                <div class="card-options">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
                    <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i
                            class="fe fe-maximize"></i></a>
                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="card-body">

                {{-- <div class="table-responsive">
                    <table class="table mb-0 table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Hr entrada</th>
                                <th>Hr salida</th>
                            </tr>
                        </thead>
                        <tbody>



                        </tbody>
                    </table>
                </div> --}}
                <div>
                    <div class="" style="display: flex; font-size: 10PX;">
                        <label for="fecha-inicio mr-2">Desde:</label>
                        <input style="font-size: 10px;" class="mr-2" type="date" id="fecha-inicio"
                            wire:model="fechaInicioMes">
                        <label for="fecha-actual mr-2">Hasta:</label>
                        <input style="font-size: 10PX;" class="mr2" type="date" id="fecha-actual"
                            wire:model="fechaActual">
                        <div style="margin-left: 1%; font-size: 10px;">
                            <label for="fecha-actual">Responsable:</label>
                            <select class="form-control" wire:model="responsableseleccionado" style="font-size: 10px;">
                                <option value="{{ $responsableseleccionado }}">{{ $responsableseleccionado }}</option>
                                @if (in_array(Auth::user()->rol, ['Administrador', 'Asist. Administrativo', 'Recursos Humanos']))
                                    @foreach ($responsables as $lista)
                                        <option value="{{ $lista->name }}">{{ $lista->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        {{-- <button class="ml-2 boton" onclick="exportToExcel()">Exportar a Excel</button> --}}
                    </div>

                </div>
                <div class="table-responsive">
                    <h1 style="font-size: 24px; margin-top:2%;"><strong>Atención al Cliente</strong></h1>
                    @php
                        $atendidos = DB::table('registropagos')
                            ->where('responsable', $responsableseleccionado)
                            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                            ->count('iduser');
                    @endphp
                    <h1 class="mt-2">Total atendidos: {{ $atendidos }}</h1>
                    <h1 style="font-size: 24px; margin-top:2%;"><strong>Metricas de desempeño</strong></h1>
                    <table id="mitablaregistros" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr>
                                <th>LLAMADAS REALIZADAS</th>
                                <th>LLAMADAS AGENDADAS</th>
                                <th>AGENDADOS CREADOS</th>
                                <th>REMARKETING</th>
                                <th>VENTAS UNIDAD > 100 Bs.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $misllamada = DB::table('registrollamadas')
                                        ->where('responsable', $responsableseleccionado)
                                        ->where('sucursal', '0')
                                        ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                                        ->count();
                                    $remarketing = DB::table('registrollamadas')
                                        ->where('responsable', $responsableseleccionado)
                                        ->where('sucursal', '1')
                                        ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                                        ->count();
                                    $misagendados = DB::table('calls')
                                        ->where('responsable', $responsableseleccionado)
                                        ->where('estado', '!=', 'llamadas')
                                        ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                                        ->count();
                                    $fechaInicioMes = date('Y-m-d', strtotime($fechaInicioMes));
                                    $fechaActual = date('Y-m-d', strtotime($fechaActual));
                                    $miscitas = DB::table('operativos')
                                        ->where('responsable', $responsableseleccionado)
                                        ->whereDate('created_at', '>=', $fechaInicioMes)
                                        ->whereDate('created_at', '<=', $fechaActual)
                                        ->count();
                                    $venta = DB::table('registroinventarios')
                                        ->where('iduser', $usuario->id)
                                        ->where(DB::raw('CAST(precio AS FLOAT)'), '>', 99.0) // Convertir precio a float
                                        ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
                                        ->where('cantidad', 1)
                                        ->count();

                                @endphp
                                <td>{{ $misllamada }}</td>
                                <td>{{ $misagendados }}</td>
                                <td>{{ $miscitas }}</td>
                                <td>{{ $remarketing }}</td>
                                <td>{{ $venta }}</td>
                            </tr>


                        </tbody>
                    </table>

                    <h1 style="font-size: 24px; margin-top:2%;"><strong>Manejo de caja registradora y pagos:</strong>
                    </h1>
                    <table id="mitablaregistros" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr>
                                <th>AGENDADOS QR</th>
                                <th>AGENDADOS EFECTIVO</th>
                                <th>PRODUCTOS QR</th>
                                <th>PRODUCTOS EFECTIVO</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $suma = 0;
                                    $resultados_efectivo = DB::table('users as u')
                                        ->select(
                                            'u.id as id_usuario',
                                            'u.name as nombre_usuario',
                                            DB::raw('SUM(CAST(r.precio AS DECIMAL(10, 2))) as total_ingreso'),
                                        )
                                        ->join('registroinventarios as r', 'u.id', '=', 'r.iduser')
                                        ->where('u.name', $responsableseleccionado)
                                        ->whereIn('r.motivo', ['compra', 'farmacia'])
                                        ->where('r.modo', 'LIKE', '%efectivo%')
                                        ->whereBetween('r.fecha', [$this->fechaInicioMes, $this->fechaActual])
                                        ->groupBy('u.id', 'u.name')
                                        ->orderBy('total_ingreso', 'desc')
                                        ->get();
                                    $resultados_qr = DB::table('users as u')
                                        ->select(
                                            'u.id as id_usuario',
                                            'u.name as nombre_usuario',
                                            DB::raw('SUM(CAST(r.precio AS DECIMAL(10, 2))) as total_ingreso'),
                                        )
                                        ->join('registroinventarios as r', 'u.id', '=', 'r.iduser')
                                        ->where('u.name', $responsableseleccionado)
                                        ->whereIn('r.motivo', ['compra', 'farmacia'])
                                        ->where('r.modo', 'LIKE', '%Qr%')
                                        ->whereBetween('r.fecha', [$this->fechaInicioMes, $this->fechaActual])
                                        ->groupBy('u.id', 'u.name')
                                        ->orderBy('total_ingreso', 'desc')
                                        ->get();
                                    $agendados_efectivo = DB::table('users as u')
                                        ->select(
                                            'u.id as id_usuario',
                                            'u.name as nombre_usuario',
                                            DB::raw('SUM(CAST(r.monto AS DECIMAL(10, 2))) as total_ingreso'),
                                        )
                                        ->join('registropagos as r', 'u.id', '=', 'r.iduser')
                                        ->where('u.name', $responsableseleccionado)
                                        ->where('r.modo', 'LIKE', '%efectivo%')
                                        ->whereBetween('r.fecha', [$this->fechaInicioMes, $this->fechaActual])
                                        ->groupBy('u.id', 'u.name')
                                        ->orderBy('total_ingreso', 'desc')
                                        ->get();
                                    $agendados_qr = DB::table('users as u')
                                        ->select(
                                            'u.id as id_usuario',
                                            'u.name as nombre_usuario',
                                            DB::raw('SUM(CAST(r.monto AS DECIMAL(10, 2))) as total_ingreso'),
                                        )
                                        ->join('registropagos as r', 'u.id', '=', 'r.iduser')
                                        ->where('u.name', $responsableseleccionado)
                                        ->where('r.modo', 'LIKE', '%qr%')
                                        ->whereBetween('r.fecha', [$this->fechaInicioMes, $this->fechaActual])
                                        ->groupBy('u.id', 'u.name')
                                        ->orderBy('total_ingreso', 'desc')
                                        ->get();

                                @endphp
                                @foreach ($agendados_qr as $item)
                                    @php
                                        $suma = $suma + $item->total_ingreso;
                                    @endphp
                                    <td>
                                        {{ $item->total_ingreso }}
                                    </td>
                                @endforeach
                                @foreach ($agendados_efectivo as $item)
                                    @php
                                        $suma = $suma + $item->total_ingreso;
                                    @endphp
                                    <td>
                                        {{ $item->total_ingreso }}
                                    </td>
                                @endforeach
                                @foreach ($resultados_efectivo as $item)
                                    @php
                                        $suma = $suma + $item->total_ingreso;
                                    @endphp
                                    <td>
                                        {{ $item->total_ingreso }}
                                    </td>
                                @endforeach

                                @foreach ($resultados_qr as $item)
                                    @php
                                        $suma = $suma + $item->total_ingreso;
                                    @endphp
                                    <td>
                                        {{ $item->total_ingreso }}
                                    </td>
                                @endforeach

                                <td>{{ $suma }}</td>
                            </tr>
                            <tr>
                                <td>EGRESOS</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @php
                                    $egreso = DB::table('gastos')
                                        ->where('nameuser', $responsableseleccionado)
                                        ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                                        ->sum('cantidad');
                                @endphp
                                <td>{{ $egreso }}</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
