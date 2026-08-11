<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.regularizar-ingresos')->html();
} elseif ($_instance->childHasBeenRendered('l1331174739-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1331174739-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1331174739-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1331174739-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.regularizar-ingresos');
    $html = $response->html();
    $_instance->logRenderedChild('l1331174739-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/operativos/pagos-table.blade.php ENDPATH**/ ?>