<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'id' => null,
    'maxWidth' => '4xl',
    'closeOutside' => false
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'id' => null,
    'maxWidth' => '4xl',
    'closeOutside' => false
]); ?>
<?php foreach (array_filter(([
    'id' => null,
    'maxWidth' => '4xl',
    'closeOutside' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidthClass = [
        'sm' => 'max-width: 400px;',
        'md' => 'max-width: 500px;',
        'lg' => 'max-width: 700px;',
        'xl' => 'max-width: 900px;',
        '2xl' => 'max-width: 1100px;',
        '3xl' => 'max-width: 1250px;',
        '4xl' => 'max-width: 1400px;',
        'full' => 'max-width: 95vw;',
    ][$maxWidth] ?? 'max-width: 900px;';
?>

<div
    x-data="{ show: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>.defer }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    x-transition.opacity
    id="<?php echo e($id); ?>"
    class="modal-overlay-custom"
    style="display: none;"
>
    <div
        class="modal-box-custom"
        style="<?php echo e($maxWidthClass); ?>"
        <?php if($closeOutside): ?>
            x-on:click.away="show = false"
        <?php endif; ?>
    >
        <?php echo e($slot); ?>

    </div>
</div>

<style>
    .modal-overlay-custom {
        position: fixed;
        inset: 0;
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(0, 0, 0, 0.55);
        overflow-y: auto;
    }

    .modal-box-custom {
        position: relative;
        z-index: 1051;
        width: 100%;
        max-height: 92vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        padding: 24px;
        text-align: left;
    }

    .modal-box-custom label,
    .modal-box-custom .form-label,
    .modal-box-custom p,
    .modal-box-custom h1,
    .modal-box-custom h2,
    .modal-box-custom h3,
    .modal-box-custom h4,
    .modal-box-custom h5,
    .modal-box-custom h6 {
        text-align: left !important;
    }

    .swal2-container {
        z-index: 99999 !important;
    }

    @media (max-width: 768px) {
        .modal-overlay-custom {
            align-items: flex-start;
            padding: 12px;
        }

        .modal-box-custom {
            max-height: 95vh;
            border-radius: 12px;
            padding: 16px;
        }
    }
</style><?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/components/modal.blade.php ENDPATH**/ ?>