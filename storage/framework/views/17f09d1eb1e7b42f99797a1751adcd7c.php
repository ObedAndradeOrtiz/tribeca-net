<div>

    <div class="card">

        <div class="mt-2 ml-4 mr-4 d-flex">

            <?php if(Auth::user()->rol == 'Jefe ; Marketing y Publicidad'): ?>
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
            <?php else: ?>
                <button type="button"
                    class="mr-4 <?php echo e($botonRecepcion === 'pagos' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                    wire:click="$set('botonRecepcion','pagos')" style="flex:1;">
                    <div style="display: flex;">
                        INGRESOS / GASTOS
                    </div>
                </button>
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
                    class="mr-4 <?php echo e($botonRecepcion === 'resumen' ? 'btn btn-primary' : 'btn btn-outline-primary'); ?>"
                    wire:click="$set('botonRecepcion','resumen')" style="flex:1;">
                    <div style="display: flex;">
                        RESUMEN DEL MES
                    </div>
                </button>
            <?php endif; ?>

        </div>

        <?php if($botonRecepcion == 'pagos'): ?>
            <div style="display:flex;">
                <div style="width: 50%;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-diario')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-0');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="width: 50%;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-gasto-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-1');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-gasto-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <div style="display:flex;">
                <div style="width: 50%;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-2');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="width: 50%;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.sucursal-mensual')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-3');
} else {
    $response = \Livewire\Livewire::mount('estadistica.sucursal-mensual');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.ingresodinamico')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-4');
} else {
    $response = \Livewire\Livewire::mount('estadistica.ingresodinamico');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.mes-general')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-5');
} else {
    $response = \Livewire\Livewire::mount('estadistica.mes-general');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
        <?php if($botonRecepcion == 'citas'): ?>
            <div style="display: flex;">
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-diario')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-6');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-7');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
} elseif ($_instance->childHasBeenRendered('l370193895-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-8');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <div style="flex: 1;">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.citas-mensual')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-9');
} else {
    $response = \Livewire\Livewire::mount('estadistica.citas-mensual');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
} elseif ($_instance->childHasBeenRendered('l370193895-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-10');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-diario');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-11');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-12');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-agendados');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-13');
} else {
    $response = \Livewire\Livewire::mount('estadistica.llamadas-semanal-asistidos');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
        <?php if($botonRecepcion == 'resumen'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.resumen')->html();
} elseif ($_instance->childHasBeenRendered('l370193895-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l370193895-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l370193895-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l370193895-14');
} else {
    $response = \Livewire\Livewire::mount('estadistica.resumen');
    $html = $response->html();
    $_instance->logRenderedChild('l370193895-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/estadistica/lista-estadistica.blade.php ENDPATH**/ ?>