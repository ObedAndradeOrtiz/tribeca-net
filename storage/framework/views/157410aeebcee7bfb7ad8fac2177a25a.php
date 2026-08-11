<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">INGRESOS DE CAJA DINAMICO</h4>
    <div>
        <div class="" style="display: flex; font-size: 0.8vw;">
            <select wire:model="mesSeleccionado" wire:change="obtenerDiasDelMes">

                <?php $__currentLoopData = $meses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $numeroMes => $nombreMes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($numeroMes); ?>"><?php echo e($nombreMes); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
        </div>

    </div>
    <div wire:loading>
        Cargando...
    </div>
    <div>
        <canvas id="ingresodinamico2"></canvas>
    </div>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/estadistica/mes-general.blade.php ENDPATH**/ ?>