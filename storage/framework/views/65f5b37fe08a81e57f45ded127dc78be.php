<div>
    <?php if($numero == 3): ?>
        <div style="background-color: red">
            <input type="number" wire:model.debounce.500ms="numero"style="width: 55px;" />
        </div>
    <?php else: ?>
        <input type="number" wire:model.debounce.500ms="numero" style="width: 55px;" />
    <?php endif; ?>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/users/editar-numero.blade.php ENDPATH**/ ?>