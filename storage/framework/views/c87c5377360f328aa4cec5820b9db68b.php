<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.panel-inicial')->html();
} elseif ($_instance->childHasBeenRendered('l226053531-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l226053531-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l226053531-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l226053531-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.panel-inicial');
    $html = $response->html();
    $_instance->logRenderedChild('l226053531-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/livewire/panel-inicio/ver-panel.blade.php ENDPATH**/ ?>