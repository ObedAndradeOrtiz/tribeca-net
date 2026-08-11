<div>
    <?php
        $registrotraspasototal = DB::table('registroinventarios')
            ->where('motivo', 'Modificaciones')
            ->where('sucursal', 'ilike', '%' . $areaseleccionada . '%')
            ->where('iduser', 'ilike', '%' . $usuarioseleccionado . '%')
            ->where('nombreproducto', 'ilike', '%' . $busqueda . '%')
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
            ->get();
        $registrotraspaso = DB::table('registroinventarios')
            ->where('motivo', 'Modificaciones')
            ->where('sucursal', 'ilike', '%' . $areaseleccionada . '%')
            ->where('iduser', 'ilike', '%' . $usuarioseleccionado . '%')
            ->where('nombreproducto', 'ilike', '%' . $busqueda . '%')
            ->where('fecha', '<=', $this->fechaActual)
            ->where('fecha', '>=', $this->fechaInicioMes)
            ->count();
    ?>
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
                    <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="mb-2 ml-4">
        <h3>REGISTRO DE PRODUCTOS MODIFICADOS</h3>
    </div>
    <div class="mt-2" style="border: 2px solid #32b4ff; border-radius: 5px;">
        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda"
            placeholder="Buscar Producto...">
    </div>
    <div class="mb-2 ml-4">
        <label for="">Se estan mostrando: <?php echo e($registrotraspaso); ?> modificados.</label>
    </div>
    <div class="table-responsive">
        <table id="mitablaregistros1" class="table table-striped" role="grid" data-bs-toggle="data-table">
            <thead>
                <tr>

                    <th>PRODUCTO</th>
                    <th>CANTIDAD NUEVA REGISTRADA</th>
                    <th>CANTIDAD ANTERIOR</th>
                    <th>SUCURSAL</th>
                    <th>FECHA</th>
                    <th>RESPONSABLE</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $registrotraspasototal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->nombreproducto); ?></td>

                        <td><?php echo e($item->cantidad); ?></td>
                        <td><?php echo e($item->modo); ?></td>
                        <td><?php echo e($item->sucursal); ?></td>
                        <td><?php echo e($item->created_at); ?></td>
                        <?php
                            $name = DB::table('users')
                                ->where('id', $item->iduser)
                                ->value('name');
                        ?>
                        <td><?php echo e($name); ?></td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/registros/reg-edicion.blade.php ENDPATH**/ ?>