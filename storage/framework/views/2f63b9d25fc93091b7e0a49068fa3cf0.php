<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <div class="card">
        <div class="flex-wrap card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="mb-0 card-title">Permiso de Roles</h4>
            </div>
            <div class="">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.crear-rol')->html();
} elseif ($_instance->childHasBeenRendered('l1411923900-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1411923900-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1411923900-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1411923900-0');
} else {
    $response = \Livewire\Livewire::mount('roles.crear-rol');
    $html = $response->html();
    $_instance->logRenderedChild('l1411923900-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Administrador</th>
                            <th>Call Center</th>
                            <th>Clientes</th>
                            <th>Empleados</th>
                            <th>Tratamientos</th>
                            <th>Recepcion</th>
                            <th>Inventario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($item->rol); ?>

                                </td>
                                <?php
                                $rolesderol = DB::table('roles_vistas')
                                    ->where('idrol', $item->id)
                                    ->orderBy('id', 'asc')
                                    ->get();
                                ?>
                                <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="text-center">
                                        <?php if($rol->estado == 'Activo'): ?>
                                            <input type="checkbox" wire:click="guardartodo(<?php echo e($rol->id,); ?>)" checked>
                                        <?php else: ?>
                                            <input type="checkbox" wire:click="guardartodo(<?php echo e($rol->id); ?>)">
                                        <?php endif; ?>

                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                </table>
                <div class="text-center">

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/roles/lista-roles.blade.php ENDPATH**/ ?>