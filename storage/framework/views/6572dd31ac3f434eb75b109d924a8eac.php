<div class="px-4 mt-4">

    <div class="card shadow-sm">

        <!-- 🔥 HEADER -->
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-journal-text me-2"></i> Registros
                </h3>
                <span class="text-muted small">
                    Historial de actividades del sistema
                </span>
            </div>

            <!-- 🔥 SELECTOR -->
            <div>
                <label class="form-label fw-semibold mb-1">Tipo de registro</label>
                <select wire:model="botonRecepcion" class="form-select">
                    <option value="gastos">Gastos</option>
                   
                </select>
            </div>

        </div>

        <!-- 🔥 BODY -->
        <div class="card-body pt-0">

            <div class="mt-4">

                <?php if($botonRecepcion == 'llamada'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-llamadas')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-0');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-llamadas');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'clientes'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-citas')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-1');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-citas');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'citas'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-pagos')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-2');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-pagos');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'producto'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-producto')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-3');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-producto');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'gastos'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-gastos')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-4');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-gastos');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'traspaso'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-traspaso')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-5');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-traspaso');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'creacion'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-crear')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-6');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-crear');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'modificacion'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-edicion')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-7');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-edicion');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

                <?php if($botonRecepcion == 'compras'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-compras')->html();
} elseif ($_instance->childHasBeenRendered('l3986869025-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l3986869025-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3986869025-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3986869025-8');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-compras');
    $html = $response->html();
    $_instance->logRenderedChild('l3986869025-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/registros/lista-registros.blade.php ENDPATH**/ ?>