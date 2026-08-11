<div>
    <?php
        $misllamadalista = DB::table('calls')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->get();
        $cantidad = DB::table('calls')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('estado', '!=', 'llamadas')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->get();
        $misagendadoslista = DB::table('calls')
            ->where('telefono', 'LIKE', '%' . $busquedaag . '%')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->where('estado', '!=', 'llamadas')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->get();
        $llamadastotal = DB::table('calls')
            ->where('telefono', 'LIKE', '%' . $busquedatot . '%')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->get();
        $fechaInicioMes = date('Y-m-d', strtotime($fechaInicioMes));
        $fechaActual = date('Y-m-d', strtotime($fechaActual));
        $miscitaslista = DB::table('operativos')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('fecha', '<=', $fechaActual)
            ->get();
        $miscitaslistacount = DB::table('operativos')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('fecha', '<=', $fechaActual)
            ->count();

    ?>
    <?php
        $misllamada = DB::table('calls')
            ->where('telefono', 'LIKE', '%' . $busquedatot . '%')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->count();
        $remarketing = DB::table('registrollamadas')

            ->where('sucursal', 'LIKE', '%' . $areaseleccionada . '%')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->count();
        $misagendados = DB::table('calls')
            ->where('telefono', 'LIKE', '%' . $busquedaag . '%')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('estado', '!=', 'llamadas')
            ->whereBetween('fecha', [$fechaInicioMes, $fechaActual])
            ->count();
        $fechaInicioMes = date('Y-m-d', strtotime($fechaInicioMes));
        $fechaActual = date('Y-m-d', strtotime($fechaActual));
        $miscitas = DB::table('operativos')
            ->where('area', 'LIKE', '%' . $areaseleccionada . '%')
            ->where('responsable', 'LIKE', '%' . $usuarioseleccionado . '%')
            ->where('fecha', '>=', $fechaInicioMes)
            ->where('fecha', '<=', $fechaActual)
            ->count();

    ?>
    <div class="flex-wrap mt-2 ml-4 mr-4 d-flex" style="display: flex;">
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
    </div>
    <div class="mb-2 ml-4">
        <h3>REGISTRO DE LLAMADAS AGENDADAS</h3>
    </div>
    <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busquedaag"
            placeholder="Buscar numero...">
    </div>
    <div class="mb-2 ml-4">
        <label for="">Se estan mostrando: <?php echo e($misagendados); ?> llamadas agendadas.</label>
    </div>
    <div class="table-responsive">
        <table id="mitablaregistros1" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead style="">
                <tr>
                    <th>ID</th>
                    <th>CLIENTE</th>
                    <th>NUMERO</th>
                    <th>FECHA Y HORA</th>
                    <th>RESPONSABLE</th>
                    <th>SUCURSAL</th>
                </tr>
            </thead>
            <tbody style="">

                <?php $__currentLoopData = $misagendadoslista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->id); ?></td>
                        <td><?php echo e($item->empresa); ?></td>
                        <td><?php echo e($item->telefono); ?></td>
                        <td><?php echo e($item->created_at); ?></td>
                        <td><?php echo e($item->responsable); ?></td>
                        <td><?php echo e($item->area); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




            </tbody>
        </table>
    </div>
    <div class="mb-2 ml-4">
        <h3>REGISTRO DE LLAMADAS CREADAS</h3>
    </div>
    <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busquedatot"
            placeholder="Buscar numero...">
    </div>
    <div class="mb-2 ml-4">
        <label for="">Se estan mostrando: <?php echo e($misllamada); ?> llamadas nuevas creadas.</label>
    </div>
    <div class="table-responsive">
        <table id="mitablaregistros1" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead style="">
                <tr>
                    <th>ID</th>
                    <th>CLIENTE</th>
                    <th>NUMERO</th>
                    <th>FECHA Y HORA</th>
                    <th>RESPONSABLE</th>
                    <th>SUCURSAL</th>
                </tr>
            </thead>
            <tbody style="">

                <?php $__currentLoopData = $llamadastotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->id); ?></td>
                        <td><?php echo e($item->empresa); ?></td>
                        <td><?php echo e($item->telefono); ?></td>
                        <td><?php echo e($item->created_at); ?></td>
                        <td><?php echo e($item->responsable); ?></td>
                        <td><?php echo e($item->area); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/registros/reg-llamadas.blade.php ENDPATH**/ ?>