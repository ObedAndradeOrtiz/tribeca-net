<div>
    <div class="flex flex-wrap">
        <a class="mt-1 mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Ver cliente" data-original-title="Ver cliente"
            wire:click="$set('openArea5',true)">

            <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z"
                    fill="currentColor"></path>
                <path
                    d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z"
                    fill="currentColor"></path>
            </svg><span class="ms-1" style="font-size: 8px;"><span>
        </a>
        <a class="mr-1 mt-1 btn btn-sm btn-icon btn-warning d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="EDITAR" data-original-title="Edit" wire:click="$set('openArea',true)">

            <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="ms-1" style="font-size: 8px;"></span>

        </a>
        <a class="mt-1 mr-1 btn btn-sm btn-icon btn-primary d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="NUEVA RESERVA" data-original-title="Nueva reserva"
            wire:click="$set('openArea6',true)">

          <i class="fa fa-bed"></i>
            <span class="ms-1" style="font-size: 8px;"></span>

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
                Editar Cliente <?php echo e($usuario->name); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de cliente: </label>
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
                                        <th>Tratamiento</th>
                                        <th>Fecha de tratamiendo</th>
                                        <th>Estado</th>
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
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/clientes/editar-cliente.blade.php ENDPATH**/ ?>