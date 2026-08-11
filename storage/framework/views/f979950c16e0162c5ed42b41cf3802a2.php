<div>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hope-ui.min.css?v=2.0.0')); ?>" />
    <div class="card">

        <?php if($activado->estado == 1): ?>
            <button class="btn btn-danger" wire:click='activarsistema'>Desactivar sistema</button>
        <?php else: ?>
            <button class="btn btn-success" wire:click='activarsistema'>Activar sistema</button>
        <?php endif; ?>
        <div class="card-header d-flex justify-content-between ">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>
            <div style="margin-right: 1%; font-size: 1vw;">
                <label for="fecha-inicio">Desde:</label>
                <input style="font-size: 1vw;" type="date" id="fecha-inicio" class="form-control"
                    wire:model="fechaInicioMes">
            </div>
            <div style="margin-right: 1%; font-size: 1vw;">
                <label for="fecha-actual">Hasta:</label>
                <input style="font-size: 1vw;" type="date" id="fecha-actual" class="form-control"
                    wire:model="fechaActual">
            </div>
            <div style="margin-right: 1%; font-size: 1vw;">
                <label for="fecha-actual">Estado:</label>
                <select wire:model="estadoUser">
                    <option value="todos">Todos</option>
                    <option value="Activo">Activos</option>
                    <option value="Inactivo">Inactivos</option>
                </select>
            </div>
            <div style="margin-right: 1%; font-size: 1vw;">
                <label for="fecha-actual">Cargo:</label>
                <select wire:model="rolseleccionado">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->rol); ?>"><?php echo e($item->rol); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div style="margin-right: 1%; font-size: 1vw;">
                <label for="fecha-actual">Sucursal:</label>
                <select wire:model="areaseleccionada">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.crear-user')->html();
} elseif ($_instance->childHasBeenRendered('l4065445965-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l4065445965-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l4065445965-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l4065445965-0');
} else {
    $response = \Livewire\Livewire::mount('users.crear-user');
    $html = $response->html();
    $_instance->logRenderedChild('l4065445965-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <br>
        </div>
        <div class="px-4 card-body">
            <div class="table-responsive">

                <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                    <thead>
                        <tr class="ligth">
                            <th>CARGO</th>
                            <th>SUCURSAL</th>
                            <th>NOMBRE</th>
                            <th>ESTADO</th>
                            <th>INICIO</th>
                            <th>DIAS TRABAJADOS</th>
                            <th style="font-size: 10px;">MEMORANDUM</th>
                            <th>TOTAL PAGADO</th>


                            <th style="min-width: 100px">ACCIÓN</th>
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
                                <td><?php echo e($lista->rol); ?></td>
                                <td><?php echo e($lista->sucursal); ?></td>
                                <td><?php echo e($lista->name); ?></td>

                                <?php if($lista->estado == 'Activo'): ?>
                                    <td><span class="badge bg-primary">Activo</span></td>
                                <?php else: ?>
                                    <td><span class="badge bg-danger">Inactivo</span></td>
                                <?php endif; ?>
                                <td><?php echo e($lista->fechainicio); ?></td>
                                <?php
                                    $mesesPasados = 0;
                                    $fechaInicio = new DateTime($lista->fechainicio);
                                    $hoy = new DateTime();
                                    $diferencia = $hoy->diff($fechaInicio);
                                    $diasRestantes = $diferencia->days;
                                    $mesesPasados = intval($diferencia->days / 30.4);

                                    $gastoarea = DB::table('gastos')
                                        ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                                        ->where('tipo', 'SUELDO')
                                        ->where('iduser', $lista->id)
                                        ->sum('cantidad');

                                ?>

                                <td><?php echo e($diasRestantes); ?></td>
                                <?php if($lista->memorandum == 3): ?>
                                    <td style="background-color: red">
                                        <label for="" style="color: white">Expulsión</label>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.editar-numero', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->name)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->name);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->name);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->name);
} else {
    $response = \Livewire\Livewire::mount('users.editar-numero', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->name, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                <?php else: ?>
                                    <td><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.editar-numero', ['iduser' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->name)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->name);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->name);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->name);
} else {
    $response = \Livewire\Livewire::mount('users.editar-numero', ['iduser' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->name, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></td>
                                <?php endif; ?>

                                <td>
                                    <?php echo e($gastoarea); ?>

                                </td>


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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/users/lista-user.blade.php ENDPATH**/ ?>