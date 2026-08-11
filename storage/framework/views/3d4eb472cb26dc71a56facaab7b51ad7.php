<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>
            <br>
        </div>
        <div class="px-4 card-body">
            <div class="mr-2 header-title">
                <h4 class="card-title">Habitaciones</h4>
            </div>
            <div class="d-flex">
                <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
                    placeholder="Busque la habitacion...">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.crear-tratamiento')->html();
} elseif ($_instance->childHasBeenRendered('l799923965-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l799923965-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l799923965-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l799923965-0');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.crear-tratamiento');
    $html = $response->html();
    $_instance->logRenderedChild('l799923965-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>

            <div class="px-4 card-body">
                <div class="table-responsive">

                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>Habitación</th>
                                <th>Descripcion</th>
                                <th>Costo Bs.</th>
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
                            <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td><?php echo e($lista->nombre); ?></td>
                                    <td><?php echo e($lista->descripcion); ?></td>
                                    <td><?php echo e($lista->costo); ?></td>
                                    <td><?php echo e($lista->estado); ?></td>
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.vista-tratamiento', ['idtratamiento' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('tratamientos.vista-tratamiento', ['idtratamiento' => $lista->id]);
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

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/tratamientos/lista-tratamientos.blade.php ENDPATH**/ ?>