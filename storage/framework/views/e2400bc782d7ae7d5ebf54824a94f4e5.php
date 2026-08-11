<div>
    <div class="px-4 card">
        <div class="flex-wrap card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="mb-0 card-title">Permiso de Roles</h4>
            </div>
            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.crear-rol')->html();
} elseif ($_instance->childHasBeenRendered('l2645909616-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2645909616-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2645909616-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2645909616-0');
} else {
    $response = \Livewire\Livewire::mount('roles.crear-rol');
    $html = $response->html();
    $_instance->logRenderedChild('l2645909616-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="px-4 mt-4">
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">

                                <th>Roles</th>
                                <th>Super Administrador</th>
                                <th>Copropietarios</th>
                                <th>Personal interno</th>
                                <th>Departamentos</th>
                                <th>Administración</th>
                                
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td>
                                        <div><a href="javascript:void(0);"><?php echo e($item->rol); ?></a></div>
                                        <div class="text-muted"><?php echo e($item->descripcion); ?></div>
                                    </td>
                                    <?php
                                        $rolesderol = DB::table('roles_vistas')
                                            ->where('idrol', $item->id)
                                            ->orderBy('id', 'asc')
                                            ->get();
                                    ?>

                                    <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($rol->vista != 'CallCenter' && $rol->vista != 'Inventario'): ?>
                                            <td class="text-center">

                                                <?php if($rol->estado == 'Activo'): ?>
                                                    <input type="checkbox" wire:click="guardartodo(<?php echo e($rol->id); ?>)"
                                                        checked>
                                                <?php else: ?>
                                                    <input type="checkbox"
                                                        wire:click="guardartodo(<?php echo e($rol->id); ?>)">
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <a class="mt-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                            data-original-title="Edit"
                                            wire:click="$emit('borrarRoles',<?php echo e($item->id); ?>)">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span class="ms-1" style="font-size: 8px;">ELIMINAR</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/roles/lista-roles.blade.php ENDPATH**/ ?>