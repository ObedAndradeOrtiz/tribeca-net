<div>
    <style>
        .fixed-button2 {
           
            right: 0px;
            bottom: 28%;
            padding: 15px;
            /* Igual padding en todas las direcciones */
            background-color: rgb(255, 136, 0);
            color: white;
            border: none;
            border-radius: 5%;
            /* Hace que el botón sea redondo */
            cursor: pointer;
            z-index: 9999;
            width: 150px;
            margin: 1%;
            height: 25px;
            /* Asegura que el botón esté delante de otros elementos */
        }

        @media (max-width: 900px) {
            .fixed-button2 {
                width: 50px;
            }

            .fixed-button2 span {
                display: none;
                /* Oculta la palabra "REGISTRO" */
            }
        }
    </style>
    <label class="fixed-button2" style="display: flex; align-items: center;" wire:click="$set('comprar',true)">
        <i class="icon">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z"
                    fill="currentColor"></path>
            </svg>
        </i>
        <span style="margin-left: 5px;">VENTA</span>
    </label>


    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'comprar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'comprar']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Inventario de productos:
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <div style="align-content: center; display:flex; font-size: 1vw;" class="mb-4">
                    <div class="flex flex-row justify-start" style="align-items: center; flex:1;">
                        <label style="">Motivo de uso: </label>
                        <select class="ml-4 form-select-lg" wire:model="motivo" style="font-size: 1vw;">
                            <option value="personal">GABINETE</option>
                            <option value="compra">VENTA</option>
                            <option value="traspaso">TRASPASO</option>
                            <option value="farmacia">FARMACIA</option>
                        </select>
                    </div>
                    <div class="ml-2">
                        <label style="font-size: 1vw;">Sucursal: </label>
                        <select class="ml-4 mr-2 form-select-lg" style="font-size: 1vw;"
                            wire:model="sucursalseleccionada">
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
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.6vw;">

                        <?php $__currentLoopData = $cantidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cantidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $producto = DB::table('productos')->select('tituloProducto')->where('id', $id)->first();
                            ?>
                            <tr>
                                <?php if($producto): ?>
                                    <td><?php echo e($producto->tituloProducto); ?></td>
                                    <td><?php echo e($cantidad); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <input class="mt-1" type="text" wire:model="search" placeholder="Buscar productos..."
                style="width: 100%;">
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
                                <td><?php echo e($producto->tituloProducto); ?></td>
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
            </div>

            
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/inventario/comprar-secundario.blade.php ENDPATH**/ ?>