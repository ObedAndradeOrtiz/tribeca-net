<div>
    <button class="ml-4 mr-4 btn btn-primary" wire:click="$set('crearpublicidad',true)" wire:click.prevent.stop><span
            style="color: white;">REGISTRAR PUBLICIDAD</span></button>
    <x-modal wire:model.defer="crearpublicidad" wire:click.prevent.stop>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA PUBLICIDAD
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">TIPO DE CAMPAÑA</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="campañaelegida">
                            <option value="">Seleccionar cuenta</option>
                            @foreach ($campañas as $campaña)
                                <option value="{{ $campaña->id }}">{{ $campaña->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">CUENTA COMERCIAL:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="cuentaelegida">
                            <option value="">Seleccionar cuenta</option>
                            @foreach ($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}">{{ $cuenta->nombrecuenta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">SUCURSAL:</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="areaelegida">
                            <option value="">Seleccionar sucursal</option>
                            @foreach ($areas as $cuenta)
                                <option value="{{ $cuenta->id }}">{{ $cuenta->area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 form-group d-flex">
                        <div>
                            <label class="form-label" for="">FECHA DE INICIO:</label>
                            <input type="date" style="font-size: 0.7vw;" wire:model="fechainicio">
                        </div>
                        <div>
                            <label class="form-label" for="">FECHA DE FIN:</label>
                            <input type="date" style="font-size: 0.7vw;" wire:model="fechafin">
                        </div>

                    </div>
                    <div class="mt-2 form-group">

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">COMENTARIO</label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="comentario">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo" wire:loading.remove
                wire:target="guardartodo">Crear</label>
            <span class="" wire:loading wire:target="guardartodo">Guardando...</span>
        </div>
    </x-modal>
</div>
</div>
