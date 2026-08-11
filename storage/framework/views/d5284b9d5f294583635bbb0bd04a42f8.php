<div>
    <button class="mt-2 btn btn-primary" wire:click="$set('creartransaccion',true)" wire:click.prevent.stop><span
            style="color: white;">NUEVA TRANSACCION</span></button>
    <button class="mt-2 btn btn-warning" wire:click="$set('aumento',true)" wire:click.prevent.stop><span
            style="color: white; ">RECARGAR SALDO TRJ</span></button>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'creartransaccion','wire:click.prevent.stop' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'creartransaccion','wire:click.prevent.stop' => true]); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA TRANSACCIÓN
            </div>
            <div class="table-responsive">
                <table id="mitablaregistros1" class="table table-striped" role="grid">
                    <tbody>
                        <tr>
                            <td>
                                <label class="form-label">TARJETA EMISORA: </label>
                            </td>
                            <td>
                                <select wire:model="tarjetae" style="font-size: 0.7vw;">
                                    <option value="">NINGUNA</option>
                                    <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tarjetae'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <label style="color:firebrick"> No selecciono Tarjeta emisora</label>
                                    <br>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label">TIPO DE TRANSACCIÓN </label>
                            </td>
                            <td>
                                <select wire:model="opcion" style="font-size: 0.7vw;">
                                    <option value="">NINGUNA</option>
                                    <option value="verificacion">VERIFICACIÓN</option>
                                    <option value="seguro">SEGURO</option>
                                    <option value="pagosPublicidad">USAR SALDO PARA PUBLICIDAD</option>
                                    <option value="pagosPublicidadenvio">ENVIAR SALDO PARA PUBLICIDAD</option>
                                    <option value="envioSaldo">ENVIO DE SALDO</option>
                                    <option value="otro">OTROS</option>
                                </select>
                            </td>
                        </tr>
                        <?php if($opcion != ''): ?>
                            <?php if($opcion == 'verificacion'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE DESCUENTO:</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($opcion == 'seguro'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE DESCUENTO:</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($opcion == 'otro'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE DESCUENTO:</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">DESCRIPCIÓN:</label>

                                    </td>
                                    <td>
                                        <input type="text" style="font-size: 0.7vw;" wire:model="motivo">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($opcion == 'pagosPublicidad'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">CUENTA COMERCIAL</label>

                                    </td>
                                    <td>
                                        <select wire:model="cuentaseleccionado" style="font-size: 0.7vw;">
                                            <option value="">NINGUNA</option>
                                            <?php $__currentLoopData = $cuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombrecuenta); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['cuentaseleccionado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No selecciono cuenta comercial</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE USO</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CODIGO TRANSACCIONAL</label>

                                    </td>
                                    <td>
                                        <input type="text" style="font-size: 0.7vw;" wire:model="codigo">
                                        <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay codigo</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($opcion == 'pagosPublicidadenvio'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">TARJETA RECEPTORA:</label>
                                    </td>
                                    <td>
                                        <select wire:model="tarjetap" style="font-size: 0.7vw;">
                                            <option value="">NINGUNA</option>
                                            <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['tarjetap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No selecciono Tarjeta receptora</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="form-label">CUENTA COMERCIAL</label>

                                    </td>
                                    <td>
                                        <select wire:model="cuentaseleccionado" style="font-size: 0.7vw;">
                                            <option value="">NINGUNA</option>
                                            <?php $__currentLoopData = $cuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombrecuenta); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['cuentaseleccionado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No selecciono cuenta comercial</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE ENVIO</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE USO</label>
                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidadde">
                                        <?php $__errorArgs = ['cantidadde'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de uso</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CODIGO TRANSACCIONAL</label>

                                    </td>
                                    <td>
                                        <input type="text" style="font-size: 0.7vw;" wire:model="codigo">
                                        <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay codigo</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($opcion == 'envioSaldo'): ?>
                                <tr>
                                    <td>
                                        <label class="form-label">TARJETA RECEPTORA:</label>
                                    </td>
                                    <td>
                                        <select wire:model="tarjetap" style="font-size: 0.7vw;">
                                            <option value="">NINGUNA</option>
                                            <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['tarjetap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No selecciono Tarjeta receptora</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">CANTIDAD DE ENVIO</label>

                                    </td>
                                    <td>
                                        <input type="number" style="font-size: 0.7vw;" wire:model="cantidaddeuso">
                                        <?php $__errorArgs = ['cantidaddeuso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No puso la cantidad de envio</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label">FECHA DE TRANSACCION</label>
                                    </td>
                                    <td>
                                        <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <label style="color:firebrick"> No hay fecha</label>
                                            <br>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>


                        <?php endif; ?>

                    </tbody>
                </table>

            </div>

        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" style="background-color: green" wire:click="guardartodo"
                wire:loading.remove wire:target="guardartodo">Crear</label>
            <span class="" wire:loading wire:target="guardartodo">Guardando...</span>
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
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'aumento','wire:click.prevent.stop' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'aumento','wire:click.prevent.stop' => true]); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVO AUMENTO
            </div>
            <div class="table-responsive">
                <table id="mitablaregistros1" class="table table-striped" role="grid">
                    <thead>
                        <tr>


                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>
                                <label class="form-label">TARJETA RECEPTORA:</label>

                            </td>
                            <td>
                                <select wire:model="tarjetap" style="font-size: 0.7vw;">
                                    <option value="">NINGUNA</option>
                                    <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label class="form-label">CANTIDAD DE AUMENTO</label>

                            </td>
                            <td>
                                <input type="number" style="font-size: 0.7vw;" wire:model="cantidaaumnento">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label">FECHA DE TRANSACCION</label>
                            </td>
                            <td>
                                <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" style="background-color: green"
                wire:click="guardaraumento" wire:loading.remove wire:target="guardaraumento">Guardar</label>
            <span class="" wire:loading wire:target="guardaraumento">Guardando...</span>
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
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'devolucion','wire:click.prevent.stop' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'devolucion','wire:click.prevent.stop' => true]); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                NUEVA DEVOLUCIÓN
            </div>
            <div class="table-responsive">
                <table id="mitablaregistros1" class="table table-striped" role="grid">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="form-label">TARJETA EMISORA:</label>
                            </td>
                            <td>
                                <select wire:model="tarjetae" style="font-size: 0.7vw;">
                                    <option value="">NINGUNA</option>
                                    <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label">TARJETA RECEPTORA:</label>
                            </td>
                            <td>
                                <select wire:model="tarjetap" style="font-size: 0.7vw;">
                                    <option value="">NINGUNA</option>
                                    <?php $__currentLoopData = $tarjetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lista->id); ?>"><?php echo e($lista->nombretarjeta); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label">CANTIDAD DE DISMINUCION</label>
                            </td>
                            <td>
                                <input type="number" style="font-size: 0.7vw;" wire:model="cantidaaumnento">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label">FECHA DE TRANSACCION</label>
                            </td>
                            <td>
                                <input type="date" style="font-size: 0.7vw;" wire:model="fecha">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" style="background-color: green"
                wire:click="guardardevolucion" wire:loading.remove wire:target="guardardevolucion">Guardar</label>
            <span class="" wire:loading wire:target="guardardevolucion">Guardando...</span>
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/marketing/crear-transaccion.blade.php ENDPATH**/ ?>