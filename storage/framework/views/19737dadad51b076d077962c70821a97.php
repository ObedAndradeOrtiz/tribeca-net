<div>
     <link rel="stylesheet" href="../assets/css/hope-ui.min.css?v=2.0.0" />
    
    <link rel="stylesheet" href="../assets/css/core/libs.min.css" />
    <!-- Hope Ui Design System Css -->
     <link rel="stylesheet" href="../assets/css/hope-ui.min.css?v=2.0.0" />
    
    <div class=" flex flex-col sm:justify-center items-center sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" wire:model.defer="contra">
            </div>
            <?php if($activar == true): ?>
                <input type="checkbox" id="myCheckbox" class="ml-4" checked  wire:click="$set('activar',false)">
                <label for="myCheckbox" class="mb-4">Mantener desbloquedo en mi cuenta</label>
                <br>
            <?php else: ?>
                <input type="checkbox" id="myCheckbox" class="ml-4" wire:click="$set('activar',true)">
                <label for="myCheckbox" class="mb-4">Mantener desbloquedo en mi cuenta</label>
                <br>
            <?php endif; ?>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" wire:click="confirmar">Abrir Tesoreria</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/tesoreria/seguridad.blade.php ENDPATH**/ ?>