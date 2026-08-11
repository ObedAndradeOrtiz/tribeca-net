<div>
    <div class="flex-wrap mt-2 ml-4 mr-4" style="display: flex;">
        <div class="form-group" style="margin-right: 5%;">
            <label>Sucursal: </label>
            <select wire:model="areaseleccionada">
                <option value="">Todas</option>
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mr-4">
            <label for="fecha-inicio">Desde:</label>
            <input type="date" id="fecha-inicio" wire:model="fechaInicioMes">
        </div>

        <div class="ml-4 mr-4">
            <label for="fecha-actual">Hasta:</label>
            <input type="date" id="fecha-actual" wire:model="fechaActual">
        </div>
        <div class="form-group" style="margin-right: 5%;">
            <label>Responsable: </label>
            <select wire:model="usuarioseleccionado">
                <option value="">Todos</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lista->name); ?>"><?php echo e($lista->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group" style="margin-right: 5%;">
            <label>Tipo de Gasto: </label>
            <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="tipogasto">
                <option>Seleccionar:</option>
                <option value="AGUA POTABLE">AGUA POTABLE</option>
                <option value="ALQUILER">ALQUILER</option>
                <option value="GAS">GAS</option>
                <option value="IMPUESTOS">IMPUESTOS</option>
                <option value="LUZ ELECTRICA">LUZ ELECTRICA</option>
                <option value="INTERNET/TEL">INTERNET/TEL</option>
                <option value="Dra. PAOLA">Dra. PAOLA</option>
                <option value="Sr. ALEXANDRE">Sr. ALEXANDRE</option>
                <option value="ADELANTO AL PERSONAL">ADELANTO AL PERSONAL</option>
                <option value="MATERIAL CAFETERIA">MATERIAL CAFETERIA</option>
                <option value="MATERIAL ESCRITORIO">MATERIAL ESCRITORIO</option>
                <option value="MATERIAL LIMPIEZA">MATERIAL LIMPIEZA</option>
                <option value="MATERIAL DE PROCEDIMIENTOS">MATERIAL DE PROCEDIMIENTOS</option>
                <option value="MATERIAL PARA EVENTOS">MATERIAL PARA EVENTOS</option>
                <option value="MATERIAL PARA MANTENIMIENTO">MATERIAL PARA MANTENIMIENTO</option>
                <option value="MANTENIMIENTO DE EQUIPOS">MANTENIMIENTO DE EQUIPOS</option>
                <option value="MANTENIMIENTO DE SUCURSAL">MANTENIMIENTO DE SUCURSAL</option>
                <option value="COMPRA DE EQUIPO">COMPRA DE EQUIPO</option>
                <option value="COMPRA DE MUEBLE">COMPRA DE MUEBLE</option>
                <option value="MERIENDAS">MERIENDAS</option>
                <option value="PUBLICIDAD">PUBLICIDAD</option>
                <option value="SERVICIOS PROFESIONALES">SERVICIOS PROFESIONALES</option>
                <option value="TRAMITES">TRAMITES</option>
                <option value="TRANSPORTE">TRANSPORTE</option>
                <option value="SUELDO">PAGO SUELDO</option>
                <option value="OTRO">OTRO</option>
            </select>
        </div>
    </div>
    <div class="mb-2 ml-4">
        <h3>GASTOS REALIZADOS</h3>
    </div>
    <div class="table-responsive">
        <table id="tabla2" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr class="ligth">
                    <th>MOTIVO</th>
                    <th>FECHA</th>
                    <th>MONTO</th>
                    <th>TIPO</th>
                    <th>MODO</th>
                    <th>RESPONSABLE</th>
                    <th>SUCURSAL</th>
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
                <?php
                    $pagado = 0;
                ?>
                <?php if($gastoarealista): ?>
                    <?php $__currentLoopData = $gastoarealista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pagado = $pagado + $lista->cantidad;
                        ?>
                        <tr>
                            <td><?php echo e($lista->empresa); ?></td>
                            <td><?php echo e($lista->created_at); ?></td>
                            <td><?php echo e($lista->cantidad); ?></td>
                            <td><?php echo e($lista->tipo); ?></td>
                            <td><?php echo e($lista->modo); ?></td>
                            <td><?php echo e($lista->nameuser); ?></td>
                            <td><?php echo e($lista->area); ?></td>
                            <td><a class="mt-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$emit('eliminarGasto',<?php echo e($lista->id); ?>)">
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
                                </a></td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <tr class="bg-gray">
                    <td style="color: white">Total</td>
                    <td></td>
                    <td style="color: white"><?php echo e($pagado); ?></td>
                    <td style="color: white"></td>
                    <td style="color: white"></td>
                    <td style="color: white"></td>
                    <td style="color: white"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/registros/reg-gastos.blade.php ENDPATH**/ ?>