<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @php
        $sugerido = 0;
    @endphp
    <style>
        .content {
            display: none;
        }

        .collapsible {
            cursor: pointer;
        }

        .collapsible .icon {
            margin-right: 10px;
        }
    </style>
    <div class="">
        <div class="text-lg font-medium text-gray-900">
            Panel de administracion de departamento de: {{ $operativo->empresa }}
        </div>
        <div class="table-responsive">
            <table class="table mb-0 table-striped text-nowrap">
                <tbody>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Departamento(s):</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Costo</th>
                                            <th>Meses</th>
                                            <th>Departamento</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalhabitaciones = 0;
                                        @endphp
                                        @foreach ($tratamientos as $lista)
                                            <tr>
                                                <td>{{ $lista->costo }}</td>
                                                <td>

                                                    @php
                                                        $fecha_dada = new DateTime($lista->fecha);
                                                        $fecha_hoy = new DateTime();

                                                        $diff = $fecha_hoy->diff($fecha_dada);

                                                        // calcular meses totales
                                                        $meses = $diff->y * 12 + $diff->m;

                                                        // si quieres contar mes actual parcialmente
                                                        if ($diff->d > 0) {
                                                            $meses += 1;
                                                        }

                                                        // evitar 0 meses
                                                        $meses = max(1, $meses);

                                                        $totalhabitaciones += $lista->costo * $meses;
                                                    @endphp

                                                    {{ $meses }}
                                                </td>
                                                <td>{{ $lista->nombretratamiento }}</td>
                                                <td>{{ $lista->costo * $meses }} (.Bs)</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @php
                        $sugerido = $sugerido + $totalhabitaciones;
                    @endphp
                    {{-- <tr class="collapsible">
                        <td><i class="fas fa-chevron-right icon"></i>Productos consumidos:</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($miscompras as $pago)
                                            <tr>
                                                <td>
                                                    {{ $pago->precio }}
                                                </td>
                                                @php
                                                    $sugerido = $sugerido + $pago->precio;
                                                @endphp
                                                <td>
                                                    {{ $pago->fecha }}
                                                </td>
                                                <td>
                                                    {{ $pago->nombreproducto }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr> --}}

                    <tr class="collapsible">
                        <td><i class="fas fa-chevron-right icon"></i>Lista de pagos:</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <div style="display: flex;">
                                <label class="mr-1 btn btn-sm btn-icon btn-success align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('crearhabitacion',true)" style="flex:1">
                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">Pagar despensa</span>
                                </label>
                                <label class="mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('confirmarimprimir',true)"
                                    style="flex:1">
                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">Imprimir pagos</span>
                                </label>
                            </div>
                            @livewire('pagos.lista-pagos', ['idoperativo' => $operativo->id])
                            {{-- @livewire('pagos.lista-pagos-productos', ['idoperativo' => $operativo->id]) --}}
                            {{-- @if ($this->operativo->ingreso == 0) --}}

                            {{-- <label class="mr-1 btn btn-sm btn-icon btn-success align-items-center"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                        data-original-title="Edit" wire:click="$set('crearpagoproducto',true)"
                                        style="flex:1">
                                        <span class="ms-1" style="font-size: 12px; color:aliceblue;">PAGAR
                                            PRODUCTOS</span>
                                    </label> --}}

                            {{-- @endif --}}

                        </td>
                    </tr>
                    <tr class="collapsible">
                        <td><i class="fas fa-chevron-right icon"></i>Cobranza:</td>
                    </tr>
                   <tr class="content" wire:ignore>
                        <td>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <th>Precio sugerido</th>
                                        <th>Monto a cobrar</th>
                                        <th>Total cancelado</th>
                                        <th>Deuda pendiente</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $sugerido }}</td>
                                            <td>
                                                <input type="number" wire:model="pagotratamientostotal"
                                                    placeholder="Ingrese cantidad total a cobrar..." />
                                            </td>
                                            <td>{{ $this->totalpagado }}</td>
                                            <td>{{ $this->deuda }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if ($this->operativo->ingreso == 0)
                                <label for="" class="btn btn-success" style="width: 100%"
                                    wire:click="guardaroperativo">Guardar</label>
                            @endif
                        </td>
                    </tr>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Lista de copropietarios:</td>
                    </tr>
                    <tr class="content">
                        <td>
                            @livewire('operativos.lista-hospedados', ['idoperativo' => $operativo->id])
                        </td>
                    </tr>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Información del departamento:
                        </td>
                    </tr>
                    <tr class="content">
                        <td>
                            @livewire('operativos.informacion-cliente', ['idoperativo' => $operativo->id])
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- @if ($this->operativo->ingreso == 0)
            <label for="" class="mt-3 btn btn-danger" style="width: 100%;"
                wire:click='desocuparhabitacion'>DESOCUPAR HABITACION</label>
        @else
            <label for="" class="mt-3 btn btn-success" style="width: 100%;"
                wire:click='habilitarhabitacion'>HABILITAR HABITACION</label>
        @endif --}}

    </div>

    <script>
        $(document).ready(function() {
            // Añadir el evento de clic a las filas colapsables
            $('.collapsible').on('click', function() {
                $(this).next('.content').toggle();
                $(this).find('.icon').toggleClass('fa-chevron-right fa-chevron-down');
            });
        });
    </script>
    <x-modal wire:model='confirmarimprimir'>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Confirmación de imnpresión
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="imprimir">Imprimir</button>
        </div>
    </x-modal>
    <x-modal wire:model="eliminart">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar este departamento?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarTratamiento">Si
                eliminar</label>
        </div>
    </x-modal>
    <x-modal wire:model="crearpagoproducto">
        <div>
            <div class="row">

                <div class="form-group col-md-2">
                    <label class="form-label" for="">MONTO:</label>
                    <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="cantidadpago">
                </div>
                <div class="form-group col-md-2">
                    <label for="form-label">METODO DE PAGO</label>
                    <br>
                    <select name="" id="" wire:model="mododepago">
                        <option value="Efectivo">
                            Efectivo
                        </option>
                        <option value="Qr">Qr</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="form-label">PRODUCTO:</label>
                    <br>
                    <select name="productoseleccionado" id="productoseleccionado" wire:model="productoseleccionado"
                        style="width: 100%;">
                        <option value="">Seleccionar</option>
                        @foreach ($miscompras as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nombreproducto }} ({{ $item->precio }} BS)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                    value="{{ Auth::user()->name }}">
            </div>
            <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
                <button type="submit" style="background-color: green;" class="btn btn-success"
                    wire:click="guardartodoinventario">Guardar</button>
            </div>
        </div>
    </x-modal>
    <x-modal wire:model="crearhabitacion">
        <div>
            <div class="row">

                <div class="form-group col-md-2">
                    <label class="form-label" for="">MONTO:</label>
                    <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="cantidadpago">
                </div>
                <div class="form-group col-md-2">
                    <label for="form-label">METODO DE PAGO</label>
                    <br>
                    <select name="" id="" wire:model="mododepago">
                        <option value="Efectivo">
                            Efectivo
                        </option>
                        <option value="Qr">Qr</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="form-label">HABITACION:</label>
                    <br>
                    <select name="productoseleccionado" id="productoseleccionado" wire:model="habitacionseleccionado"
                        style="width: 100%;">
                        <option value="">Seleccionar</option>
                        @foreach ($tratamientos as $lista)
                            <option value="{{ $lista->id }}">
                                {{ $lista->nombretratamiento }}({{ $lista->costo . '.BS' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                    value="{{ Auth::user()->name }}">
            </div>
            <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
                <button type="submit" style="background-color: green;" class="btn btn-success"
                    wire:click="guardartodo">Guardar</button>
            </div>
        </div>
    </x-modal>
</div>
