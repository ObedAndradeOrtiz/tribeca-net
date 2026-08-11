<div style="margin-top: -5px;">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hope-ui.min.css?v=2.0.0')); ?>" />
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>


            <br>
        </div>
        <style>
            .boton-container {
                display: flex;
                /* justify-content: space-between; */
            }

            .boton {
                padding: 10px 20px;
                font-size: 16px;
                /* Utilizamos unidades de medida relativas */
                width: 30%;
            }

            /* Aplicamos estilos diferentes para pantallas más pequeñas */
            @media screen and (max-width: 600px) {
                .boton {
                    font-size: 9px;
                    width: 30%;
                }
            }
        </style>

        <div class="card-body">
            <div class="flex-wrap d-flex">
                <div style="flex: 1">
                    <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
                        placeholder="Buscar Clientes...">
                </div>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.crear-cliente')->html();
} elseif ($_instance->childHasBeenRendered('l88275064-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l88275064-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l88275064-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l88275064-0');
} else {
    $response = \Livewire\Livewire::mount('clientes.crear-cliente');
    $html = $response->html();
    $_instance->logRenderedChild('l88275064-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            <div class="table-responsive-sm">

                <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
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
                        <style>
                            td {
                                max-width: 200px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }
                        </style>
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
                <?php echo e($users->links()); ?>


            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/clientes/lista-clientes.blade.php ENDPATH**/ ?>