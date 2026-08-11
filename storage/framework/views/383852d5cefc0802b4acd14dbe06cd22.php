<div class="container px-6 py-4">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>

    <style>
        .list-group-item {
            cursor: pointer;
            z-index: 1000;
        }

        .list-group-item:hover {
            background-color: #0a0a0a3f;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #52b1e5;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="text-lg font-medium text-gray-900 mb-4">
        Compra de productos:
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <label for="sucursal">Sucursal: </label>
            <select class="form-control form-control-lg" wire:model="sucursalseleccionada">
                  <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option value="<?php echo e($area->id); ?>"><?php echo e($area->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
            </select>
        </div>
        <div class="col-md-3">
            <div class="mb-4">
                <label for="cartera">Cartera de egreso:</label>
                <select class="form-control form-select-lg" wire:model="cartera">
                    <option value="Caja">Caja central</option>
                    <option value="Externo">Externo</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div>
                <label>Modo de pago: </label>
                <select class="form-control form-select-lg" wire:model="modo">
                    <option value="efectivo">Efectivo</option>
                    <option value="qr">QR</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="cantidad">Cantidad de gasto: </label>
                <input type="number" class="form-control" wire:model="nombre" placeholder="Escriba la cantidad...">

            </div>
        </div>
        <div class="col-md-2">
                <div class="mb-4 mt-4 py-2">
                    <button wire:click="realizarfarmacia" class="btn btn-warning">Comprar</button>
                </div>
        </div>
    </div>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>PRODUCTO SELECCIONADO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cantidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cantidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                    ?>
                    <?php if($producto): ?>
                        <tr>
                            <td><?php echo e($producto->nombre); ?></td>
                            <td><?php echo e($cantidad); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex mb-4">
        <input type="text" class="form-control" wire:model.defer="search" placeholder="Buscar productos...">
        <button class="btn btn-warning ml-2" wire:click="buscar">Buscar</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($producto->nombre); ?></td>
                        <td><?php echo e($producto->cantidad); ?></td>
                        <td>
                            <input type="number" class="form-control" wire:model="cantidades.<?php echo e($producto->id); ?>"
                                min="0">
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div>
            <?php echo e($productos->links()); ?>

        </div>
    </div>
</div>

<div id="preloader">
    <div class="spinner"></div>
</div>

<script>
    document.addEventListener("livewire:load", function() {
        Livewire.hook('message.sent', function() {
            document.getElementById('preloader').style.display = 'flex';
        });

        Livewire.hook('message.processed', function() {
            document.getElementById('preloader').style.display = 'none';
        });
    });
</script>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/inventario/compra-productos.blade.php ENDPATH**/ ?>