<div>
    <?php if($habitacion->estado == 'Activo' || $habitacion->estado == 'Ocupado'): ?>
        <div style="display: flex;">
            <label class="ml-1 btn btn-secundary" style="background-color: blue; color:white;" wire:click='cambiar("limpieza")'>Lim</label>
            <label class="ml-1 btn btn-danger" wire:click='cambiar("mantenimiento")'>Man</label>
        </div>
    <?php endif; ?>
    <?php if($habitacion->estado == 'mantenimiento' || $habitacion->estado == 'limpieza'): ?>
        <div>
            <label for="" class="ml-1 btn btn-success" wire:click="cambiar('Activo')">Des</label>
            <label for="" class="ml-1 btn btn-warning" wire:click="cambiar('Ocupado')">Ocu</label>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/recepcionista/estados.blade.php ENDPATH**/ ?>