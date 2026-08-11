<div class="card shadow-sm">

    <!-- HEADER -->
    <div class="card-header border-0 pt-5">
        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-wallet2 me-2"></i> Tesorería
            </h3>
            <span class="text-muted small">
                Gestión de ingresos y egresos del sistema
            </span>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-0">

        <!-- 🔥 NAV TABS PRO -->
        <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

            <!-- INGRESOS -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 
                    <?php echo e($tipoingreso === 'ingresoexterno' ? 'active' : ''); ?>"
                    wire:click="$set('tipoingreso','ingresoexterno')">

                    <i class="bi bi-cash-stack"></i>
                    Caja general
                </a>
            </li>

            <!-- EGRESOS -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 
                    <?php echo e($tipoingreso === 'gastointerno' ? 'active' : ''); ?>"
                    wire:click="$set('tipoingreso','gastointerno')">

                    <i class="bi bi-receipt"></i>
                    Panel de gastos
                </a>
            </li>

        </ul>

        <!-- 🔥 CONTENIDO -->
        <div class="mt-3">

            <?php if($tipoingreso == 'ingresoexterno'): ?>
                <div class="fade show active">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.pago-sucursal')->html();
} elseif ($_instance->childHasBeenRendered('l1601519628-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1601519628-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1601519628-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1601519628-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.pago-sucursal');
    $html = $response->html();
    $_instance->logRenderedChild('l1601519628-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            <?php endif; ?>

            <?php if($tipoingreso == 'gastointerno'): ?>
                <div class="fade show active">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso-interno')->html();
} elseif ($_instance->childHasBeenRendered('l1601519628-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1601519628-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1601519628-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1601519628-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso-interno');
    $html = $response->html();
    $_instance->logRenderedChild('l1601519628-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div><?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tesoreria/lista-tesoreria.blade.php ENDPATH**/ ?>