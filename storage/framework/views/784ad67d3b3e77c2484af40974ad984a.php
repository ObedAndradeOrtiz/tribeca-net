<div class="px-4 py-5 conatiner-fluid content-inner mt-n5 fadeIn third">
    <link rel="stylesheet" href="../../assets/css/hope-ui.min.css?v=2.0.0" />
    <h3>Lista de areas comunes: </h3>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ">
                        <div class="header-title">
                            <h4 class="card-title"></h4>
                        </div>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.crear-area')->html();
} elseif ($_instance->childHasBeenRendered('l2598022263-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2598022263-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2598022263-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2598022263-0');
} else {
    $response = \Livewire\Livewire::mount('area.crear-area');
    $html = $response->html();
    $_instance->logRenderedChild('l2598022263-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <br>
                    </div>
                    <div class="card-header d-flex">
                        <?php if($actividad == 'Activo'): ?>
                            <button type="button" class="mr-4 btn btn-primary"
                                wire:click="$set('actividad','Activo')">Activos</button>
                            <button type="button" class="btn btn-outline-danger"
                                wire:click="$set('actividad','Inactivo')">Desactivados</button>
                        <?php endif; ?>
                        <?php if($actividad == 'Inactivo'): ?>
                            <button type="button" class="mr-4 btn btn-outline-primary"
                                wire:click="$set('actividad','Activo')">Activos</button>
                            <button type="button" class="btn btn-danger"
                                wire:click="$set('actividad','Inactivo')">Desactivados</button>
                        <?php endif; ?>
                    </div>
                    <div class="px-0 card-body">
                        <div class="table-responsive">

                            <table id="user-list-table" class="table table-striped" role="grid"
                                data-bs-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>
                                            Area común
                                        </th>
                                        <th>Teléfono</th>
                                        <th>#Ticket</th>
                                        <th>Estado</th>
                                        <th>Creador</th>
                                        <th style="min-width: 100px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($lista->area); ?></td>
                                            <td><?php echo e($lista->telefono); ?></td>


                                            <td><?php echo e($lista->ticket); ?></td>
                                            <?php if($lista->estado == 'Activo'): ?>
                                                <td><span class="badge bg-primary">Activo</span></td>
                                            <?php else: ?>
                                                <td><span class="badge bg-danger">Inactivo</span></td>
                                            <?php endif; ?>
                                            <td><?php echo e($lista->responsable); ?></td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.editar-area', ['area' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('area.editar-area', ['area' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/area/list-area.blade.php ENDPATH**/ ?>