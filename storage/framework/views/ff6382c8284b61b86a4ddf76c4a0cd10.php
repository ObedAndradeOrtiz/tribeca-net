<div>
    <div class="flex flex-row card-header d-flex boton-container ">
        <button type="button" style="flex:1;"
            class="ml-4 mr-4 <?php echo e($actividad === 'Areas' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
            wire:click="$set('actividad','Areas')">Sucursales</button>
        <button type="button" style="flex:1;"
            class="mr-4 <?php echo e($actividad === 'Empresas' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
            wire:click="$set('actividad','Empresas')">Usuarios</button>
        <button type="button" style="flex:1;"
            class="mr-4 <?php echo e($actividad === 'Historial' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
            wire:click="$set('actividad','Historial')">Historial</button>
    </div>
    <?php if($actividad == 'Areas'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-sucursal')->html();
} elseif ($_instance->childHasBeenRendered('l772477474-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l772477474-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l772477474-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l772477474-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-sucursal');
    $html = $response->html();
    $_instance->logRenderedChild('l772477474-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>

    <?php if($actividad == 'Empresas'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-usuarios')->html();
} elseif ($_instance->childHasBeenRendered('l772477474-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l772477474-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l772477474-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l772477474-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-usuarios');
    $html = $response->html();
    $_instance->logRenderedChild('l772477474-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>
    <?php if($actividad == 'Historial'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-historial')->html();
} elseif ($_instance->childHasBeenRendered('l772477474-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l772477474-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l772477474-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l772477474-2');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-historial');
    $html = $response->html();
    $_instance->logRenderedChild('l772477474-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>
</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/tesoreria/menu.blade.php ENDPATH**/ ?>