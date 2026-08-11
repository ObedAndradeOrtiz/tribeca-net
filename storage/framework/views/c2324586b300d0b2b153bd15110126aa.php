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
            Inventario de productos:
        </div>
        <div class="mt-4 text-sm text-gray-600">
            <div style="align-content: center; display:flex; font-size: 1vw;" class="mb-4">
                <div class="flex flex-row justify-start" style="align-items: center; flex:1;">
                    <label style="">Motivo de uso: </label>
                    <select class="ml-4 form-select-lg" wire:model="motivo" style="font-size: 1vw;">
                        <option value="personal">USO PERSONAL</option>
                        <option value="compra">VENTA A CLIENTE</option>
                        <option value="traspaso">TRASPASO</option>
                        <option value="farmacia">VENTA DIRECTA</option>
                    </select>
                </div>
                <div class="ml-2">
                    <label style="font-size: 1vw;">Sucursal: </label>
                    <select class="ml-4 mr-2 form-select-lg" style="font-size: 1vw;" wire:model="sucursalseleccionada">
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>
                <?php if($motivo == 'traspaso'): ?>
                    <div class="flex flex-row justify-end" style="align-items: center;">
                        <button wire:click="realizartraspaso" class="btn btn-success">Trapasar</button>
                    </div>
                <?php endif; ?>
                <?php if($motivo == 'compra' || $motivo == 'personal'): ?>
                    <div class="flex flex-row justify-end" style="align-items: center;">
                        <button wire:click="realizarCompra" class="btn btn-warning">Registrar</button>
                    </div>
                <?php endif; ?>
                <?php if($motivo == 'farmacia'): ?>
                    <div class="flex flex-row justify-end" style="align-items: center;">
                        <button wire:click="realizarfarmacia" class="btn btn-warning">Vender</button>
                    </div>
                <?php endif; ?>

            </div>
            <?php if($motivo == 'compra'): ?>
                <div class="mb-4">
                    <label for="">Lista de clientes</label>
                    <div style="display: flex;">
                        <input type="text" wire:model="searchcliente" placeholder="Buscar cliente..."
                            style="width: 100%;">
                        <select class="ml-4 mr-2 form-select-lg" wire:model="clienteseleccionado">
                            <option>Seleccione cliente</option>
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="flex flex-row justify-end mt-2 mr-2" style="align-items: center;">
                        <label style="font-size: 24px;">Modo de pago: </label>
                        <select class="ml-4 form-select-lg" wire:model="modo">
                            <option value="efectivo">Efectivo</option>
                            <option value="qr">QR</option>
                        </select>
                    </div>
                    <div class="flex flex-row justify-end mt-2 mr-2" style="align-items: center;">
                        <label style="font-size: 24px;">Total: <?php echo e($pagar); ?></label>
                    </div>

                </div>
            <?php endif; ?>
            <?php if($motivo == 'farmacia'): ?>
                <div class="mb-4">
                    <label for="">Nombre: </label>
                    <div style="display: flex;">
                        <input type="text" wire:model="nombre" placeholder="Escriba el nombre..."
                            style="width: 100%;">
                    </div>
                    <div class="flex flex-row justify-end mt-2 mr-2" style="align-items: center;">
                        <label style="font-size: 24px;">Modo de pago: </label>
                        <select class="ml-4 form-select-lg" wire:model="modo">
                            <option value="efectivo">Efectivo</option>
                            <option value="qr">QR</option>
                        </select>
                    </div>
                    <div class="flex flex-row justify-end mt-2 mr-2" style="align-items: center;">
                        <label style="font-size: 24px;">Total: <?php echo e($pagar); ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($motivo == 'traspaso'): ?>
                <div class="mb-4">
                    <label for="">Lista de sucursales: </label>
                    <select class="ml-4 mr-2 form-select-lg" wire:model="areaseleccionada">
                        <option>Seleccione sucursal</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>
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
                        <th>PRECIO</th>
                        <th>CANTIDAD</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.6vw;">
                    <?php
                        $total = 0;
                    ?>
                    <?php $__currentLoopData = $cantidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cantidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                        ?>
                        <tr>
                            <?php if($producto): ?>
                                <td><?php echo e($producto->nombre); ?></td>
                                <td><?php echo e(floatval($this->precios[$id])); ?></td>
                                <td><?php echo e($cantidad); ?></td>
                                <td><?php echo e(floatval($this->precios[$id]) * $cantidad); ?></td>
                                <?php
                                    $total = $total + floatval($this->precios[$id]) * $cantidad;
                                ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>TOTAL</td>
                        <td></td>
                        <td></td>
                        <td><?php echo e($total); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex">
            <input class="mt-1" type="text" wire:model="search" placeholder="Buscar productos..."
                style="width: 100%;">

        </div>

        <div class="table-responsive" style="font-size: 1vw;">
            <table class="table table-bordered">
                <thead style="font-size: 0.7vw;">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.6vw;">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($producto->nombre); ?></td>
                            <td>
                                <input style="font-size: 0.7vw;" type="number"
                                    wire:model="cantidades.<?php echo e($producto->id); ?>" min="0">
                            </td>
                            <td>
                                <input style="font-size: 0.7vw;" type="number"
                                    wire:model="precios.<?php echo e($producto->id); ?>" value="<?php echo e($producto->precio); ?>">

                            </td>
                            <td>
                                <label for=""><?php echo e($producto->cantidad); ?></label>
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
    <style>
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
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <script>
        // resources/js/app.js (o cualquier otro archivo JavaScript principal)

        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.sent', function() {
                document.getElementById('preloader').style.display = 'flex';
            });

            Livewire.hook('message.processed', function() {
                document.getElementById('preloader').style.display = 'none';
            });
        });
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/inventario/comprar-secundario.blade.php ENDPATH**/ ?>