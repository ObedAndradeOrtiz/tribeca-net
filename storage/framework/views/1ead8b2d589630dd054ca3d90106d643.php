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

    <div class="mb-4 text-lg font-medium text-gray-900">
        Venta de productos:
    </div>

    <div class="mb-4 row">
        <div class="col-md-6">
            <label for="motivo">Motivo de uso: </label>
            <select class="form-control form-control-lg" wire:model="motivo">
                <option value="compra">Cargo a la habitación</option>
                <option value="personal">Uso interno</option>
                <option value="farmacia">Venta directa</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="sucursal">Sucursal: </label>
            <select class="form-control form-control-lg" wire:model="sucursalseleccionada">
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->area); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <?php if($motivo == 'compra'): ?>
    <div class="mb-4" style="position: relative;">
        <label for="">Lista de habitaciones</label>
        <input type="text" class="form-control" wire:model="searchcliente" placeholder="Buscar habitación...">
        <?php if(!empty($searchcliente)): ?>
        <ul class="mt-2 list-group">
            <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li wire:click="seleccionarhabitacion(<?php echo e($cliente->id); ?>)" class="list-group-item">
                    <?php echo e($cliente->nombre); ?>

                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item">No se encontraron resultados</li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if($motivo == 'farmacia'): ?>
    <div class="mb-4">
        <label for="nombre">Nombre: </label>
        <input type="text" class="form-control" wire:model="nombre" placeholder="Escriba el nombre...">
        <div class="mt-2 d-flex justify-content-between">
            <label class="h5">Modo de pago: </label>
            <select class="form-control form-control-lg" wire:model="modo">
                <option value="efectivo">Efectivo</option>
                <option value="qr">QR</option>
            </select>
        </div>
        <div class="mt-2 d-flex justify-content-end">
            <label class="h5">Total: <?php echo e($pagar); ?></label>
        </div>
    </div>
    <?php endif; ?>

    <?php if($motivo == 'traspaso'): ?>
    <div class="mb-4">
        <label for="areaseleccionada">Lista de sucursales: </label>
        <select class="form-control form-control-lg" wire:model="areaseleccionada">
            <option>Seleccione sucursal</option>
            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <?php endif; ?>

    <div class="mb-4 table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>PRODUCTO SELECCIONADO</th>
                    <th>PRECIO</th>
                    <th>CANTIDAD</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php $__currentLoopData = $cantidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cantidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                    ?>
                    <?php if($producto): ?>
                        <tr>
                            <td><?php echo e($producto->nombre); ?></td>
                            <td><?php echo e(floatval($this->precios[$id])); ?></td>
                            <td><?php echo e($cantidad); ?></td>
                            <td><?php echo e(floatval($this->precios[$id]) * $cantidad); ?></td>
                            <?php
                                $total += floatval($this->precios[$id]) * $cantidad;
                            ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td><?php echo e($total); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-end">
            <?php if($motivo == 'traspaso'): ?>
                <button wire:click="realizartraspaso" class="btn btn-success">Traspasar</button>
            <?php endif; ?>
            <?php if($motivo == 'compra' || $motivo == 'personal'): ?>
                <?php if($motivo == 'compra'): ?>
                <?php if($habitacion): ?>
                <h2>CARGO A HABITACION: <?php echo e($habitacion->nombre); ?></h2>
                <?php endif; ?>

                <?php endif; ?>
                <button wire:click="realizarCompra" class="ml-1 btn btn-warning">Registrar</button>
            <?php endif; ?>
            <?php if($motivo == 'farmacia'): ?>
                <button wire:click="realizarfarmacia" class="btn btn-warning">Vender</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="mb-4">
        <input class="mt-1 form-control" type="text" wire:model="search" placeholder="Buscar productos...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($producto->nombre); ?></td>
                        <td><?php echo e($producto->descripcion); ?></td>
                        <td>
                            <input type="number" class="form-control" wire:model="cantidades.<?php echo e($producto->id); ?>" min="0">
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model="precios.<?php echo e($producto->id); ?>" value="<?php echo e($producto->precio); ?>">
                        </td>
                        <td><?php echo e($producto->cantidad); ?></td>
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
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/inventario/comprar-secundario.blade.php ENDPATH**/ ?>