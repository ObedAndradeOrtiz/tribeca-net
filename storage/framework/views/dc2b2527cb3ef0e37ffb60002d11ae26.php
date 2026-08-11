<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['id']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['id']); ?>
<?php foreach (array_filter((['id']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $id = $id ?? md5($attributes->wire('model'));
?>

<div x-data="{ show: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>.defer }" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show"
    id="<?php echo e($id); ?>" class="fixed inset-0 flex items-center justify-center overflow-y-auto"
    style="display: none; background-color: rgba(0, 0, 0, 0.5); z-index: 500;">
    <div class="p-6 mx-auto overflow-y-auto bg-white rounded-lg" style="width: 1000px; max-height: 80vh;"
        x-on:click.away="show = false">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/components/modal.blade.php ENDPATH**/ ?>