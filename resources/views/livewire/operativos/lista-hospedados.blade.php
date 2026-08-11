<div>
    <label for="" class="btn btn-success" style="width: 100%;" wire:click="$set('crear',true)">Agregar copropietario</label>

    <div class="table-responsive">
        <label>Persona principal: {{$this->operativo->empresa}}</label>
        <table class="table mb-0 table-striped text-nowrap">
            <thead>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Ci</th>
            </thead>
            <th>Acción</th>
            <tbody>
                @foreach ($hospedados as $hospedado)
                    <tr>
                        <td>
                            {{ $hospedado->nombre }}
                        </td>
                        <td>
                            {{ $hospedado->edad }}
                        </td>
                        <td>
                            {{ $hospedado->identificacion }}
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="preeliminar({{ $hospedado->id }})">

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
                Nuevo copropietario
            </div>
            <div class="mt-4 text-gray-600 ml-4text-sm">
                <form>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="">Nombre:</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="name">
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Identificación:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="ci">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Edad:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="edad">
                        </div>
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
                ¿Desea eliminar esta persona?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarinformacion">Sí, eliminar</label>
        </div>
    </x-modal>
</div>
