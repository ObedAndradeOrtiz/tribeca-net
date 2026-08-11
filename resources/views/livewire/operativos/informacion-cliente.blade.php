<div>
    <label style="width: 100%;" for="" class="btn btn-success" wire:click="$set('crear',true)">AGREGAR
        INFORMACION</label>
    <div class="table-responsive">
        <table class="table mb-0 table-striped text-nowrap">
            <thead>
                <th>INFORMACION</th>
                <th>FECHA</th>

                <th>ACCION</th>
            </thead>
            <tbody>
                @foreach ($misfichas as $ficha)
                    <tr>
                        <td>
                            {{ $ficha->descripcion }}
                        </td>
                        <td>
                            {{ $ficha->fecha }}
                        </td>

                        <td>
                            <div class="d-flex">
                                <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="preeliminar({{ $ficha->id }})">

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
    <x-modal wire:model="crear">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA INFORMACION
            </div>
            <div class="mt-4 text-gray-600 ml-4text-sm">
                <form>
                    <label class="form-label" for="">INFORMACION:</label>
                    <div class="form-group">

                        <textarea rows="4" style="width: 100%" wire:model="tratamiento"></textarea>

                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="guardartodo">Guardar</button>
        </div>
    </x-modal>
    <x-modal wire:model="eliminar">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar esta informacion?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarinformacion">Si eliminar</label>
        </div>
    </x-modal>
</div>
