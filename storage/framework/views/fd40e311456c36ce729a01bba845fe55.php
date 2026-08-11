<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.regularizar-ingresos')->html();
} elseif ($_instance->childHasBeenRendered('l149549562-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l149549562-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l149549562-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l149549562-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.regularizar-ingresos');
    $html = $response->html();
    $_instance->logRenderedChild('l149549562-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div><?php /**PATH D:\2.TRIBECA\1.WEB\git\resources\views/livewire/operativos/pagos-table.blade.php ENDPATH**/ ?>