<div>

    <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">
        

    </div>
    <div class="flex flex-row justify-between">
        <h3 class="ml-4" style="font-size: 18px;"><strong>LISTA DE TARJETAS</strong> </h3>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.crear-tarjeta')->html();
} elseif ($_instance->childHasBeenRendered('l2872720434-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2872720434-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2872720434-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2872720434-0');
} else {
    $response = \Livewire\Livewire::mount('marketing.crear-tarjeta');
    $html = $response->html();
    $_instance->logRenderedChild('l2872720434-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    
    
    <div class="table-responsive">
        <table id="mitablaregistros1" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr>
                    <th>TARJETA</th>
                    <th>SALDO</th>
                    <th>BANCO</th>
                    <th>RESPONSABLE</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->nombretarjeta); ?></td>
                        <td><?php echo e($item->saldo); ?></td>
                        <td><?php echo e($item->banco); ?></td>
                        <td><?php echo e($item->responsable); ?></td>
                        <td><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.editar-tarjeta', ['idtarjeta' => $item->id])->html();
} elseif ($_instance->childHasBeenRendered($item->id)) {
    $componentId = $_instance->getRenderedChildComponentId($item->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($item->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($item->id);
} else {
    $response = \Livewire\Livewire::mount('marketing.editar-tarjeta', ['idtarjeta' => $item->id]);
    $html = $response->html();
    $_instance->logRenderedChild($item->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/mark-tarjetas.blade.php ENDPATH**/ ?>