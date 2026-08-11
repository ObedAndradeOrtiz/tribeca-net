<div>
    <div class="card-body">
        <div>
            <div class="flex flex-row justify-end py-2 mr-2">
                <div class="" style="display: flex;">
                    <label for="fecha-inicio mr-2">Desde:</label>
                    <input class="mr-2" type="date" id="fecha-inicio" wire:model="fechaInicioMes">

                    <label for="fecha-actual mr-2">Hasta:</label>
                    <input class="mr2" type="date" id="fecha-actual" wire:model="fechaActual">
                </div>
                <label class="">Modo: </label>
                <select class="" wire:model="modo">
                    <option value="">Todos</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="qr">Qr</option>

                </select>
                <label class="">Sucursal: </label>
                <select class="" wire:model="empresaseleccionada">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

            </div>
        </div>


        <div>
            <h3>Historial de pagos por consultas</h3>
        </div>

        <div class="table-responsive">
            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>Monto</th>
                        <th>Modo</th>
                        <th>Responsable</th>
                        <th>Cliente</th>

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
                    <?php $__currentLoopData = $total_monto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pagado = $pagado + $lista->monto;
                        ?>
                        <tr>
                            <td><?php echo e($lista->sucursal); ?></td>
                            <td><?php echo e($lista->monto); ?></td>
                            <td><?php echo e($lista->modo); ?></td>
                            <td><?php echo e($lista->responsable); ?></td>
                            <td><?php echo e($lista->nombrecliente); ?></td>


                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray">
                        <td style="color: white">Total</td>
                        <td style="color: white"><?php echo e($pagado); ?></td>
                        <td style="color: white"></td>
                        <td style="color: white"></td>
                        <td> </td>
                        <td></td>

                    </tr>
                </tbody>
            </table>

        </div>
        <div>
            <h3>Historial de pagos por productos</h3>
        </div>

        <div class="table-responsive">
            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>Monto</th>
                        <th>Modo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Responsable</th>

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
                    <?php $__currentLoopData = $total_inventario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pagado = $pagado + $lista->precio;
                        ?>
                        <tr>
                            <td><?php echo e($lista->sucursal); ?></td>
                            <td><?php echo e($lista->precio); ?></td>
                            <td><?php echo e($lista->modo); ?></td>
                            <td><?php echo e($lista->nombreproducto); ?></td>
                            <td><?php echo e($lista->cantidad); ?></td>
                            <?php
                                $responsable = DB::table('users')
                                    ->where('id', $lista->iduser)
                                    ->pluck('name')
                                    ->first();
                            ?>
                            <td><?php echo e($responsable); ?></td>



                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray">
                        <td style="color: white">Total</td>
                        <td style="color: white"><?php echo e($pagado); ?></td>
                        <td style="color: white"></td>
                        <td style="color: white"></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                </tbody>
            </table>

        </div>
        <div>
            <h3>Historial de productos utilizados</h3>
        </div>

        <div class="table-responsive">
            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>Monto</th>
                        <th>Motivo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Responsable</th>
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
                    <?php $__currentLoopData = $total_inventario_uso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pagado = $pagado + $lista->precio;
                        ?>
                        <tr>
                            <td><?php echo e($lista->sucursal); ?></td>
                            <td><?php echo e($lista->precio); ?></td>
                            <td><?php echo e($lista->motivo); ?></td>
                            <td><?php echo e($lista->nombreproducto); ?></td>
                            <td><?php echo e($lista->cantidad); ?></td>
                            <?php
                                $responsable = DB::table('users')
                                    ->where('id', $lista->iduser)
                                    ->pluck('name')
                                    ->first();
                            ?>
                            <td><?php echo e($responsable); ?></td>


                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray">
                        <td style="color: white">Total</td>
                        <td style="color: white"><?php echo e($pagado); ?></td>
                        <td style="color: white"></td>
                        <td style="color: white"></td>
                        <td></td>
                        <td></td>

                    </tr>
                </tbody>
            </table>

        </div>
        <div>
            <h3>Historial de productos traspasados</h3>
        </div>

        <div class="table-responsive">
            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                    <tr class="ligth">
                        <th>SUCURSAL</th>
                        <th>Monto</th>
                        <th>Motivo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Responsable</th>
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
                    <?php $__currentLoopData = $total_inventario_traspaso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pagado = $pagado + $lista->precio;
                        ?>
                        <tr>
                            <td><?php echo e($lista->sucursal); ?></td>
                            <td><?php echo e($lista->precio); ?></td>
                            <td><?php echo e($lista->motivo); ?></td>
                            <td><?php echo e($lista->nombreproducto); ?></td>
                            <td><?php echo e($lista->cantidad); ?></td>
                            <?php
                                $responsable = DB::table('users')
                                    ->where('id', $lista->iduser)
                                    ->pluck('name')
                                    ->first();
                            ?>
                            <td><?php echo e($responsable); ?></td>


                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray">
                        <td style="color: white">Total</td>
                        <td style="color: white"><?php echo e($pagado); ?></td>
                        <td style="color: white"></td>
                        <td style="color: white"></td>
                        <td></td>
                        <td></td>

                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/tesoreria/pago-historial.blade.php ENDPATH**/ ?>