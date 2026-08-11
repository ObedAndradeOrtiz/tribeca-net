<div>
    <div class="card">

        <div class="mt-2 ml-4 mr-4 d-flex">
            <button type="button"
                class="mr-4 <?php echo e($botonRecepcion === 'citas' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                wire:click="$set('botonRecepcion','citas')" style="flex:1;">
                <div style="display: flex;">
                    CITAS
                </div>
            </button>
            <button type="button"
                class="mr-4 <?php echo e($botonRecepcion === 'llamadas' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                wire:click="$set('botonRecepcion','llamadas')" style="flex:1;">
                <div style="display: flex;">
                    LLAMADAS
                </div>
            </button>
            <button type="button"
                class="mr-4 <?php echo e($botonRecepcion === 'usuarios' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                wire:click="$set('botonRecepcion','usuarios')" style="flex:1;">
                <div style="display: flex;">
                    USUARIOS
                </div>
            </button>
            <button type="button"
                class="mr-4 <?php echo e($botonRecepcion === 'planillas' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                wire:click="$set('botonRecepcion','planillas')" style="flex:1;">
                <div style="display: flex;">
                    PLANILLA DE SUELDOS
                </div>
            </button>
        </div>
        <?php if($botonRecepcion == 'citas'): ?>
            <div style="display: flex;">
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-diario')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-0');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-1');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <div style="display: flex;">
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-semanal-agendados')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-2');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-mensual')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-3');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-mensual');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        <?php endif; ?>
        <?php if($botonRecepcion == 'llamadas'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-diario')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-4');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-5');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-6');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-7');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
        <?php if($botonRecepcion == 'usuarios'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.lista-user')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-8');
} else {
    $response = \Livewire\Livewire::mount('users.lista-user');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
        <?php if($botonRecepcion == 'planillas'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('planilla.lista-planilla')->html();
} elseif ($_instance->childHasBeenRendered('l3428718519-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l3428718519-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3428718519-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3428718519-9');
} else {
    $response = \Livewire\Livewire::mount('planilla.lista-planilla');
    $html = $response->html();
    $_instance->logRenderedChild('l3428718519-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/rh/listarh.blade.php ENDPATH**/ ?>