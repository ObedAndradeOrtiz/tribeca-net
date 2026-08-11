<div>
    <link rel="stylesheet" href="../../assets/css/hope-ui.min.css?v=2.0.0" />
    <button class="ml-4 btn btn-primary" wire:click="$set('crear',true)"><span style="color: white; font-size: 24px;"  >Nuevo </span></button>
    <x-modal wire:model.defer="crear">
        <div class="px-6 py-4">
            <div class="py-2 text-lg font-medium text-gray-900">
                Registrar nuevo rol
            </div>
            <div class="mt-2 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de rol:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="nombrerol">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Descripcion:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model.defer="descripcion">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="{{Auth::user()->name}}">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo" wire:loading.remove wire:target="guardartodo">Registrar</label>
                <span class="" wire:loading wire:target="guardartodo">Guardando...</span>

        </div>
    </x-modal>
</div>
