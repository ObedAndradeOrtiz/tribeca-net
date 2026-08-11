<div class="mt-4 section-body">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane active" id="Student-all">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="input-group d-flex">
                                <input type="text" class="form-control" placeholder="Nombre o número del cliente..."
                                    wire:model="busqueda">
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.crear-cliente')->html();
} elseif ($_instance->childHasBeenRendered('l1801733659-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1801733659-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1801733659-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1801733659-0');
} else {
    $response = \Livewire\Livewire::mount('clientes.crear-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('l1801733659-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            </div>
                        </div>

                        <div class="float-left">

                        </div>

                    </div>
                </div>
                <div class="table-responsive card">
                    <table class="table mb-0 table-striped text-nowrap">
                        <thead>
                            <tr class="ligth">
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>CI</th>
                                <th>TELEFONO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($lista->estado == $actividad): ?>
                                    <tr>
                                        <td><?php echo e($lista->id); ?></td>
                                        <td><?php echo e($lista->name); ?></td>
                                        <td><?php echo e($lista->ci); ?></td>
                                        <td><?php echo e($lista->telefono); ?></td>
                                        <td>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.editar-cliente', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('clientes.editar-cliente', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="py-2 ml-2">
                        <?php echo e($users->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/clientes/lista-clientes.blade.php ENDPATH**/ ?>