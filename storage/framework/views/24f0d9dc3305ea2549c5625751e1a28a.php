<div>
    <div class="flex flex-wrap">
        
        <a class="btn btn-sm btn-light-primary d-flex align-items-center gap-1" data-bs-toggle="tooltip"
            data-bs-placement="top" title="EDITAR" data-original-title="Edit" wire:click="$set('openArea',true)">

            <i class="bi bi-pencil-square"></i>
        Editar
        </a>
    </div>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Editar copropietario <?php echo e($usuario->name); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de copropietario: </label>
                        <input type="text" class="form-control" id="texto" oninput="convertirAMayusculas()"
                            wire:model.defer="usuario.name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Telefono:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="usuario.telefono">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">CI:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1" wire:model.defer="ci">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardartodo">Guardar</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea5']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Información de <?php echo e($usuario->name); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de cliente: </label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="usuario.name">
                    </div>
                    <div class="px-4 card-body">
                        <div class="table-responsive">

                            <table id="user-list-table" class="table table-striped" role="grid"
                                data-bs-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>Departamento</th>
                                        <th>Fecha de pago</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody style="overflow-y: scroll;">
                                    <style>
                                        td {
                                            max-width: 200px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;
                                        }
                                    </style>
                                    <?php
                                        $mistratamientos = DB::table('historial_clientes')
                                            ->where('idcliente', $usuario->id)
                                            ->get();
                                    ?>
                                    <?php $__currentLoopData = $mistratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php
                                                $collection = DB::table('tratamientos')
                                                    ->where('id', $item->idtratamiento)
                                                    ->get();
                                            ?>
                                            <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e($coll->nombre); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <td><?php echo e($item->fecha); ?></td>
                                            <td><?php echo e($item->estado); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <style>
                                .container-but {
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }
                            </style>
                        </div>
                    </div>

                </form>
            </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea6']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">

                <?php if($verificar): ?>
                    <label style="color:firebrick"> Cita ya creada para hoy</label>
                    <br>
                    Asignar tratamientos a la cita de <?php echo e($usuario->name); ?>

                <?php else: ?>
                    Nueva cita de: <?php echo e($usuario->name); ?>

                <?php endif; ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <?php if($verificar): ?>
                        <div class="mt-2 form-group">
                            <div class="mt-2 form-group">
                                <label class="form-label" for="exampleInputdate">Fecha de cita:</label>
                                <input type="date" class="form-control" id="exampleInputdate"
                                    wire:model="fechacita">
                            </div>
                            <label class="form-label" for="">Seleccionar Paquete o tratamientos:</label>
                            
                            <div class="">
                                <input type="text" class="form-control" id="exampleInputDisabled1"
                                    wire:model="busquedatratamiento" placeholder="Buscar tratamiento...">
                            </div>
                            <?php if($botonpaquete): ?>
                                <div>
                                    <select name="type" class="selectpicker form-control" data-style="py-0"
                                        wire:model.defer="elegidopaquete">
                                        <option>Ninguno</option>
                                        <?php $__currentLoopData = $paquetes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($paquete->id); ?>"><?php echo e($paquete->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="form-group" style="margin-bottom: 35px;">
                                    <label class="form-label" for="">Selecciona tratamientos:</label>
                                    <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tratamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <div>
                                                <input type="checkbox"
                                                    wire:model.defer="tratamientosSeleccionados.<?php echo e($tratamiento->id); ?>"
                                                    value="<?php echo e($tratamiento->id); ?>">
                                                <label
                                                    for=""><?php echo e($tratamiento->nombre); ?>(<?php echo e($tratamiento->costo . 'Bs.'); ?>)</label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__errorArgs = ['tratamientosSeleccionados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <label style="color:firebrick"> Tratamiento requerido</label>
                                        <br>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label class="form-label" for="">Sucursal perteneciente:</label>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="empresaseleccionada">
                                <option>Seleccionar sucursal</option>
                                <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($empresa->area); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php $__errorArgs = ['empresaseleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick"> No selecciono ningun area</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-group">
                            <label class="form-label" for="">Nombre de cliente: </label>
                            <input type="text" class="form-control" id="texto"
                                oninput="convertirAMayusculas()" disabled="" wire:model.defer="usuario.name">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="">Telefono:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                                wire:model.defer="usuario.telefono">
                        </div>
                        <div class="mt-2 form-group">
                            <label class="form-label" for="exampleInputdate">Fecha de cita:</label>
                            <input type="date" class="form-control" id="exampleInputdate" wire:model="fechacita">
                        </div>
                        <?php $__errorArgs = ['fechacita'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick"> Fecha requerida</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="mt-2 form-group">
                            <label class="form-label">Hora de cita:</label>
                            <div class="d-flex">
                                <select name="type" class="selectpicker form-control" data-style="py-0"
                                    wire:model.defer="hora">
                                    <option>Seleccionar hora</option>
                                    <option>00</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                    <option>15</option>
                                    <option>16</option>
                                    <option>17</option>
                                    <option>18</option>
                                    <option>19</option>
                                    <option>20</option>
                                    <option>21</option>
                                    <option>22</option>
                                    <option>23</option>
                                </select>
                                <select name="type" class="selectpicker form-control" data-style="py-0"
                                    wire:model.defer="minuto">
                                    <option>Seleccionar minuto</option>
                                    <option>00</option>
                                    <option>10</option>
                                    <option>15</option>
                                    <option>20</option>
                                    <option>25</option>
                                    <option>30</option>
                                    <option>35</option>
                                    <option>40</option>
                                    <option>45</option>
                                    <option>50</option>
                                    <option>55</option>
                                </select>
                            </div>
                        </div>
                        <?php $__errorArgs = ['hora'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick"> Hora requerido</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['minuto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick"> Minuto requerido</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="mt-2 form-group">
                            <label class="form-label" for="">Seleccionar Paquete o tratamientos:</label>
                            <div class="">
                                <input type="text" class="form-control" id="exampleInputDisabled1"
                                    wire:model="busquedatratamiento" placeholder="Buscar tratamiento...">
                            </div>
                            <?php if($botonpaquete): ?>
                                <div>
                                    <select name="type" class="selectpicker form-control" data-style="py-0"
                                        wire:model.defer="elegidopaquete">
                                        <option>Ninguno</option>
                                        <?php $__currentLoopData = $paquetes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($paquete->id); ?>"><?php echo e($paquete->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="form-group" style="margin-bottom: 35px;">
                                    <label class="form-label" for="">Selecciona tratamientos:</label>
                                    <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tratamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <div>
                                                <input type="checkbox"
                                                    wire:model.defer="tratamientosSeleccionados.<?php echo e($tratamiento->id); ?>"
                                                    value="<?php echo e($tratamiento->id); ?>">
                                                <label
                                                    for=""><?php echo e($tratamiento->nombre); ?>(<?php echo e($tratamiento->costo . 'Bs.'); ?>)</label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__errorArgs = ['tratamientosSeleccionados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <label style="color:firebrick"> Tratamiento requerido</label>
                                        <br>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardarCita" wire:loading.remove
                wire:target="guardarCita">Guardar Cita</label>
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
</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/clientes/editar-cliente.blade.php ENDPATH**/ ?>