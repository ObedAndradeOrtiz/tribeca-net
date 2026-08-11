<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.panel-inicial')->html();
} elseif ($_instance->childHasBeenRendered('l1254662450-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1254662450-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1254662450-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1254662450-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.panel-inicial');
    $html = $response->html();
    $_instance->logRenderedChild('l1254662450-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/panel-inicio/ver-panel.blade.php ENDPATH**/ ?>