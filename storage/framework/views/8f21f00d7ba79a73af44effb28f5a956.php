<div>

    <?php if (isset($component)) { $__componentOriginald23ea5f67bd99780e64d56df3cdab825 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald23ea5f67bd99780e64d56df3cdab825 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.panel-show','data' => ['presionado' => 0,'areas' => $areas,'sucursal' => $sucursalName]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('panel-show'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['presionado' => 0,'areas' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($areas),'sucursal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sucursalName)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald23ea5f67bd99780e64d56df3cdab825)): ?>
<?php $attributes = $__attributesOriginald23ea5f67bd99780e64d56df3cdab825; ?>
<?php unset($__attributesOriginald23ea5f67bd99780e64d56df3cdab825); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald23ea5f67bd99780e64d56df3cdab825)): ?>
<?php $component = $__componentOriginald23ea5f67bd99780e64d56df3cdab825; ?>
<?php unset($__componentOriginald23ea5f67bd99780e64d56df3cdab825); ?>
<?php endif; ?>
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #52b1e5;

            border-radius: 50%;

            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.sent', function() {
                document.getElementById('preloader').style.display = 'flex';
            });

            Livewire.hook('message.processed', function() {
                document.getElementById('preloader').style.display = 'none';
            });
        });
    </script>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/panel.blade.php ENDPATH**/ ?>