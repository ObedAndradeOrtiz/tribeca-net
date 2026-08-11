<div>
    <div>
        <button class="ml-4 mr-4 btn btn-primary" wire:click="$set('crearcuenta',true)" wire:click.prevent.stop><span
                style="color: white;">REGISTRAR CAMPAÑA</span></button>
        <x-modal wire:model.defer="crearcuenta" wire:click.prevent.stop>
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900">
                    NUEVA CAMPAÑA
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="">NOMBRE DE CAMPAÑA</label>
                            <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                                wire:model.defer="name">
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
