<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            Compra de productos:
        </div>
        <div class="mt-4 text-sm text-gray-600">
            <div style="align-content: center; display:flex; font-size: 1vw;" class="mb-4">
                <div class="flex flex-row justify-start" style="align-items: center; flex:1;">

                </div>
                <div class="ml-2">
                    <label style="font-size: 1vw;">Sucursal: </label>
                    <select class="ml-4 mr-2 form-select-lg" style="font-size: 1vw;" wire:model="sucursalseleccionada">

                        <option value="<?php echo e($areas->id); ?>"><?php echo e($areas->area); ?></option>


                    </select>
                </div>
                <div class="flex flex-row justify-end" style="align-items: center;">
                    <button wire:click="realizarfarmacia" class="btn btn-warning">Comprar</button>
                </div>
            </div>
            <label class="form-label" for="">Cartera de egreso:</label>
            <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="cartera">
                <option value="Caja">Caja central</option>
                <option value="Externo">Externo</option>
            </select>
            <div class="mb-4">
                <label for="">Cantidad de gasto: </label>
                <div style="display: flex;">
                    <input type="number" wire:model="nombre" placeholder="Escriba la cantidad..." style="width: 100%;">
                </div>
                <div class="flex flex-row justify-end mt-2 mr-2" style="align-items: center;">
                    <label style="font-size: 24px;">Modo de pago: </label>
                    <select class="ml-4 form-select-lg" wire:model="modo">
                        <option value="efectivo">Efectivo</option>
                        <option value="qr">QR</option>
                    </select>
                </div>
                
            </div>
            <div>
                <label for="">Fecha realizado:</label>
                <input type="date" wire:model='fecha'>
            </div>
        </div>
        <div class="table-responsive" style="font-size: 1vw;">
            <table class="table table-bordered">
                <thead style="font-size: 0.7vw;">
                    <tr>
                        <th>PRODUCTO SELECCIONADO</th>
                        <th>CANTIDAD</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.6vw;">

                    <?php $__currentLoopData = $cantidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cantidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                        ?>
                        <tr>
                            <?php if($producto): ?>
                                <td><?php echo e($producto->nombre); ?></td>
                                <td><?php echo e($cantidad); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex">
            <input class="mt-1" type="text" wire:model.defer="search" placeholder="Buscar productos..."
                style="width: 100%;">
            <button class="btn btn-warning" wire:click="buscar">Buscar</button>
        </div>

        <div class="table-responsive" style="font-size: 1vw;">
            <table class="table table-bordered">
                <thead style="font-size: 0.7vw;">
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Cantidad</th>

                    </tr>
                </thead>
                <tbody style="font-size: 0.6vw;">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($producto->nombre); ?></td>
                            <td><?php echo e($producto->cantidad); ?></td>
                            <td>
                                <input style="font-size: 1vw;" type="number"
                                    wire:model="cantidades.<?php echo e($producto->id); ?>" min="0">
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    

</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/inventario/compra-productos.blade.php ENDPATH**/ ?>