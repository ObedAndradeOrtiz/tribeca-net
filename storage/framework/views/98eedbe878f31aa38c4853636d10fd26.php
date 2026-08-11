<div>



    <!-- TABS MODERNOS -->
    <div class="d-flex justify-content-center mb-4">

        <div class="btn-group bg-light rounded-pill p-1">

            <!-- ÁREAS -->
            <button
                class="btn px-4 rounded-pill d-flex align-items-center gap-2
                <?php echo e($actividad === 'Areas' ? 'btn-primary' : 'btn-light'); ?>"
                wire:click="$set('actividad','Areas')">

                <i class="bi bi-building"></i>
                Áreas comunes
            </button>

            <!-- USUARIOS -->
            <button
                class="btn px-4 rounded-pill d-flex align-items-center gap-2
                <?php echo e($actividad === 'Empresas' ? 'btn-primary' : 'btn-light'); ?>"
                wire:click="$set('actividad','Empresas')">

                <i class="bi bi-people"></i>
                Usuarios
            </button>

        </div>

    </div>

    <!-- CONTENIDO -->
    <div>

        <div class="card-body">

            <?php if($actividad == 'Areas'): ?>
                <div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-sucursal')->html();
} elseif ($_instance->childHasBeenRendered('l2463584351-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2463584351-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2463584351-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2463584351-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-sucursal');
    $html = $response->html();
    $_instance->logRenderedChild('l2463584351-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            <?php endif; ?>

            <?php if($actividad == 'Empresas'): ?>
                <div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-usuarios')->html();
} elseif ($_instance->childHasBeenRendered('l2463584351-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2463584351-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2463584351-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2463584351-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-usuarios');
    $html = $response->html();
    $_instance->logRenderedChild('l2463584351-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div><?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/tesoreria/menu.blade.php ENDPATH**/ ?>