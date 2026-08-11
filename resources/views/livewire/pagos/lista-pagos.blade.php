<div>
    <h3>Pago de departamentos</h3>
    <div class="table-responsive">
        <table class="table mb-0 table-striped text-nowrap">
            <thead>
                <th>Monto
                </th>
                <th>Fecha</th>
                <th>Modo</th>
                <th>Acción</th>
            </thead>
            <tbody>
                @foreach ($pagos as $pago)
                    <tr>
                        <td>
                            {{ $pago->monto }}
                        </td>
                        <td>
                            {{ $pago->fecha }}
                        </td>
                        <td>
                            {{ $pago->modo }}
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="mr-1 btn btn-sm btn-icon btn-warning d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="editarpago({{ $pago->id }})">

                                    <span class="ms-1" style="font-size: 12px;  color:aliceblue;">EDITAR</span>
                                </a>
                                <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="preeliminar({{ $pago->id }})">

                                    <span class="ms-1" style="font-size: 12px;  color:aliceblue;">ELIMINAR</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <x-modal wire:model="eliminarboton">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ESTA SEGURO DE ELIMINAR ESTE PAGO?
            </div>

        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color:red;" class="btn btn-success" wire:click="eliminarPago">SI,
                ELIMINAR</button>
        </div>
    </x-modal>
    <x-modal wire:model="editar">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                EDITAR PAGO
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
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="guardartodo">Guardar</button>
        </div>
    </x-modal>
</div>
