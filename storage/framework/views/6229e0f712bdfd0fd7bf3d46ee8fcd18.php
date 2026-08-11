<div class="mt-4 section-body">
    <link rel="stylesheet" href="../../assets/css/hope-ui.min.css?v=2.0.0" />
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane active" id="Student-all">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de personales</h3>
                        <div class="card-options">
                            <div class="row">
                                <div class="col-md-1">
                                    <div style="margin-right: 1%; display: flex; flex-direction: column;">
                                        <label for="fecha-actual">Estado:</label>
                                        <select wire:model="estadoUser" style="font-size: 10px;">
                                            <option value="todos">Todos</option>
                                            <option value="Activo">Activos</option>
                                            <option value="Inactivo">Inactivos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div style="margin-right: 1%; display: flex; flex-direction: column;">
                                        <label for="fecha-actual">Cargo:</label>
                                        <select wire:model="rolseleccionado" style="font-size: 10px;">
                                            <option value="">Todos</option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->rol); ?>"><?php echo e($item->rol); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <label for="">Buscador de personal:</label>
                        <div class="mt-4 input-group">

                            <input type="text" class="form-control" placeholder="Nombre del personal..."
                                wire:model="busqueda">
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.crear-user')->html();
} elseif ($_instance->childHasBeenRendered('l2656518876-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2656518876-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2656518876-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2656518876-0');
} else {
    $response = \Livewire\Livewire::mount('users.crear-user');
    $html = $response->html();
    $_instance->logRenderedChild('l2656518876-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </div>
                        <div class="table-responsive">
                            <div class="px-4 mt-4">
                                <div class="table-responsive">

                                    <table id="user-list-table" class="table table-striped" role="grid"
                                        data-bs-toggle="data-table">
                                        <thead>
                                            <tr class="ligth">
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
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
                                                <tr>
                                                    <td>
                                                        <div><a href="javascript:void(0);"><?php echo e($lista->name); ?></a></div>
                                                        <div class="text-muted"><?php echo e($lista->rol); ?></div>
                                                    </td>
                                                    <td><?php echo e($lista->telefono); ?></td>

                                                    <?php if($lista->estado == 'Activo'): ?>
                                                        <td><span class="badge bg-primary">Activo</span></td>
                                                    <?php else: ?>
                                                        <td><span class="badge bg-danger">Inactivo</span></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">
                                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.editar-user', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('users.editar-user', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <?php echo e($users->links()); ?>

                                </div>
                            </div>
                        </div>
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
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/users/lista-user.blade.php ENDPATH**/ ?>