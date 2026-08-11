<div>
    
    <?php if (isset($component)) { $__componentOriginald23ea5f67bd99780e64d56df3cdab825 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald23ea5f67bd99780e64d56df3cdab825 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.panel-show','data' => ['presionado' => 18,'areas' => $areas,'sucursal' => $sucursalName]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('panel-show'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['presionado' => 18,'areas' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($areas),'sucursal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sucursalName)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald23ea5f67bd99780e64d56df3cdab825)): ?>
<?php $attributes = $__attributesOriginald23ea5f67bd99780e64d56df3cdab825; ?>
<?php unset($__attributesOriginald23ea5f67bd99780e64d56df3cdab825); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald23ea5f67bd99780e64d56df3cdab825)): ?>
<?php $component = $__componentOriginald23ea5f67bd99780e64d56df3cdab825; ?>
<?php unset($__componentOriginald23ea5f67bd99780e64d56df3cdab825); ?>
<?php endif; ?>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/registros.blade.php ENDPATH**/ ?>