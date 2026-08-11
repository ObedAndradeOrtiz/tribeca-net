<div>
    <div>
        <label for="sucursal">SELECCIONE UNA SUCURSAL:</label>
        <select id="sucursalSelect" wire:model="sucursal">
            <option value="">Seleccione una sucursal</option>
            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($empresa->area); ?>"><?php echo e($empresa->area); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <textarea wire:model="textoCSV" rows="10" cols="50"></textarea>
        <div>
            <label for="">INTRODUCIR FECHA INICIAL:</label>
            <input type="date" wire:model="fecha">
        </div>
        <button class="btn btn-success" wire:click="procesarTextoCSV">PROCESAR TEXTO</button>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/tesoreria/subir-csv.blade.php ENDPATH**/ ?>