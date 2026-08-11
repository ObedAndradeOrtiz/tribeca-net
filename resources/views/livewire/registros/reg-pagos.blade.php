<div>
    <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">
        <div class="form-group" style="margin-right: 5%;">
            <label>Sucursal: </label>
            <select wire:model="areaseleccionada">
                <option value="">Todas</option>
                @foreach ($areas as $lista)
                    <option value="{{ $lista->area }}">{{ $lista->area }}</option>
                @endforeach
            </select>
        </div>
        <div class="">
            <label for="fecha-inicio">Desde:</label>
            <input type="date" id="fecha-inicio" wire:model="fechaInicioMes">
        </div>

        <div class="">
            <label for="fecha-actual">Hasta:</label>
            <input type="date" id="fecha-actual" wire:model="fechaActual">
        </div>
        <div class="form-group" style="margin-right: 5%;">
            <label>Responsable: </label>
            <select wire:model="usuarioseleccionado">
                <option value="">Todos</option>
                @foreach ($users as $lista)
                    <option value="{{ $lista->name }}">{{ $lista->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="ml-1">
        <h3>INGRESOS POR CONSULTA EN EFECTIVO</h3>
    </div>
    <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busquedaefec"
            placeholder="Buscar cliente...">
    </div>
    <div class="mb-2 ml-4">
        <label for="">Se estan mostrando: {{ $total_monto_citasc }} pagos.</label>
    </div>
    <div class="table-responsive">
        <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>ID</th>
                    <th>MODO</th>
                    <th>MONTO</th>
                    <th>CLIENTE</th>
                    <th>FECHA/HORA</th>
                    <th>RESPONSABLE</th>
                    <th>SUCURSAL</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <style>
                    td {
                        max-width: 200px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                </style>
                @php
                    $pagado = 0;
                @endphp
                @foreach ($total_monto_citas as $lista)
                    @php
                        $pagado = $pagado + $lista->monto;
                    @endphp
                    <tr>
                        <td>{{ $lista->id }}</td>
                        <td>{{ $lista->modo }}</td>
                        <td>{{ $lista->monto }}</td>
                        <td>{{ $lista->nombrecliente }}</td>
                        <td>{{ $lista->created_at }}</td>
                        <td>{{ $lista->responsable }}</td>

                        <td>{{ $lista->sucursal }}</td>
                        <td>
                            <a class="mt-1 btn btn-sm btn-icon btn-warning d-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                data-original-title="Edit" wire:click="editarpago({{ $lista->id }})">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="ms-1" style="font-size: 8px;">EDITAR</span>
                            </a>
                            <a class="mt-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                data-original-title="Edit" wire:click="$emit('eliminarPagoCita',{{ $lista->id }})">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                        fill="currentColor"></path>
                                </svg>
                                <span class="ms-1" style="font-size: 8px;">ELIMINAR</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-gray">
                    <td style="color: white">Total</td>
                    <td></td>
                    <td style="color: white">{{ $pagado }}</td>
                    <td style="color: white"></td>
                    <td style="color: white"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    {{ $total_monto_citas->links() }}
    <div class="mb-2 ml-4">
        <h3>INGRESOS POR CONSULTA EN QR</h3>
    </div>
    <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busquedaqr"
            placeholder="Buscar cliente...">
    </div>
    <div class="mb-2 ml-4">
        <label for="">Se estan mostrando: {{ $total_monto_qr_listac }} pagos.</label>
    </div>
    <div class="table-responsive">
        <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>MODO</th>
                    <th>MONTO</th>
                    <th>RESPONSABLE</th>
                    <th>CLIENTE</th>
                    <th>FECHA/HORA</th>
                    <th>SUCURSAL</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <style>
                    td {
                        max-width: 200px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                </style>
                @php
                    $pagado = 0;
                @endphp
                @foreach ($total_monto_qr_lista as $lista)
                    @php
                        $pagado = $pagado + $lista->monto;
                    @endphp
                    <tr>
                        <td>{{ $lista->modo }}</td>
                        <td>{{ $lista->monto }}</td>
                        <td>{{ $lista->responsable }}</td>
                        <td>{{ $lista->nombrecliente }}</td>
                        <td>{{ $lista->created_at }}</td>
                        <td>{{ $lista->sucursal }}</td>
                        <td>
                            <a class="mt-1 btn btn-sm btn-icon btn-warning d-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                data-original-title="Edit" wire:click="editarpago({{ $lista->id }})">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="ms-1" style="font-size: 8px;">EDITAR</span>
                            </a>
                            <a class="mt-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                data-original-title="Edit"
                                wire:click="$emit('eliminarPagoCita',{{ $lista->id }})">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                        fill="currentColor"></path>
                                </svg>
                                <span class="ms-1" style="font-size: 8px;">ELIMINAR</span>
                            </a>
                        </td>

                    </tr>
                @endforeach
                <tr class="bg-gray">
                    <td style="color: white">Total</td>

                    <td style="color: white">{{ $pagado }}</td>
                    <td style="color: white"></td>
                    <td style="color: white"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    {{ $total_monto_qr_lista->links() }}
    <x-modal wire:model="editar">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Editar pago (SE DEBE EDITAR TAMBIEN EL MONTO EN EL CLIENTE)
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Monto de pago:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="registro.monto">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Fecha de pago:</label>
                        <input type="date" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="registro.fecha">

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Modo de pago:</label>
                        <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="registro.modo">

                            <option value="QR">Qr</option>
                            <option value="Efectivo">Efectivo</option>

                        </select>

                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo">Guardar</label>
        </div>
    </x-modal>
</div>
