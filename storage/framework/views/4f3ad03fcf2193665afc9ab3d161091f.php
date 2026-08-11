<div class="mt-4 section-body">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane active" id="Student-all">
                <div class="card">
                    <div class="card-body">
                        <div class="input-group d-flex">
                            <input type="text" class="form-control" placeholder="Nombre del personal..."
                                wire:model="busqueda">
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.crear-user')->html();
} elseif ($_instance->childHasBeenRendered('l1286529015-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1286529015-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1286529015-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1286529015-0');
} else {
    $response = \Livewire\Livewire::mount('users.crear-user');
    $html = $response->html();
    $_instance->logRenderedChild('l1286529015-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </div>

                        <div class="row">
                            <div style="margin-right: 1%;">
                                <label for="fecha-inicio">Desde:</label>
                                <input style="width: 100px; font-size:10px;" type="date" id="fecha-inicio"
                                    class="form-control" wire:model="fechaInicioMes">
                            </div>
                            <div style="margin-right: 1%;">
                                <label for="fecha-actual">Hasta:</label>
                                <input style="width: 100px; font-size:10px;" type="date" id="fecha-actual"
                                    class="form-control" wire:model="fechaActual">
                            </div>
                            <div style="margin-right: 1%; display: flex; flex-direction: column;">
                                <label for="fecha-actual">Estado:</label>
                                <select wire:model="estadoUser" style="font-size: 10px;">
                                    <option value="todos">Todos</option>
                                    <option value="Activo">Activos</option>
                                    <option value="Inactivo">Inactivos</option>
                                </select>
                            </div>
                            <div style="margin-right: 1%; display: flex; flex-direction: column;">
                                <label for="fecha-actual">Cargo:</label>
                                <select wire:model="rolseleccionado" style="font-size: 10px;">
                                    <option value="">Todos</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->rol); ?>"><?php echo e($item->rol); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div style="margin-right: 1%; display: flex; flex-direction: column;">
                                <label for="fecha-actual">Sucursal:</label>
                                <select wire:model="areaseleccionada" style="font-size: 10px;">
                                    <option value="">Todos</option>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive card">
                    <div class="px-4 card-body">
                        <div class="table-responsive">

                            <table id="user-list-table" class="table table-striped" role="grid"
                                data-bs-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>NOMBRE</th>
                                        <th>SUCURSAL</th>
                                        <th>ESTADO</th>
                                        <th>INICIO</th>
                                        <th>DIAS TRABAJADOS</th>
                                        <th>MEMORANDUM</th>
                                        <th>TOTAL PAGADO</th>
                                        <th>ACCIÓN</th>
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
                                            <td><?php echo e($lista->sucursal); ?></td>

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
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/users/lista-user.blade.php ENDPATH**/ ?>