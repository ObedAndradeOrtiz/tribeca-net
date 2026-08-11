<div>
    <div class="container d-flex">

        
        </a>
        <a href="/pagos/<?php echo e($operativo->id); ?>" class="mt-1 mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
            data-bs-toggle="tooltip" data-bs-placement="top" title="CONFIRMAR TRATAMIENTO" data-original-title="Edit"><svg
                class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4"
                    d="M16.3405 1.99976H7.67049C4.28049 1.99976 2.00049 4.37976 2.00049 7.91976V16.0898C2.00049 19.6198 4.28049 21.9998 7.67049 21.9998H16.3405C19.7305 21.9998 22.0005 19.6198 22.0005 16.0898V7.91976C22.0005 4.37976 19.7305 1.99976 16.3405 1.99976Z"
                    fill="currentColor"></path>
                <path
                    d="M10.8134 15.248C10.5894 15.248 10.3654 15.163 10.1944 14.992L7.82144 12.619C7.47944 12.277 7.47944 11.723 7.82144 11.382C8.16344 11.04 8.71644 11.039 9.05844 11.381L10.8134 13.136L14.9414 9.00796C15.2834 8.66596 15.8364 8.66596 16.1784 9.00796C16.5204 9.34996 16.5204 9.90396 16.1784 10.246L11.4324 14.992C11.2614 15.163 11.0374 15.248 10.8134 15.248Z"
                    fill="currentColor"></path>
            </svg>
            <span class="ms-1" style="font-size: 8px;"></span></a>

        
        <a href="/informacion/<?php echo e($operativo->id); ?>"
            class="mt-1 mr-1 btn btn-sm btn-icon btn-primary d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="INFORMACIÓN DE HOSPEDAJE">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z"
                    fill="currentColor"></path>
                <path
                    d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z"
                    fill="currentColor"></path>
            </svg>
        </a>
        <a class="mt-1 mr-1 btn btn-sm btn-icon btn-warning d-flex align-items-center" data-bs-toggle="tooltip"
            data-bs-placement="top" title="REAGENDAR" data-original-title="Editar"wire:click="$set('openArea',true)">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4"
                    d="M19.9927 18.9534H14.2984C13.7429 18.9534 13.291 19.4124 13.291 19.9767C13.291 20.5422 13.7429 21.0001 14.2984 21.0001H19.9927C20.5483 21.0001 21.0001 20.5422 21.0001 19.9767C21.0001 19.4124 20.5483 18.9534 19.9927 18.9534Z"
                    fill="currentColor"></path>
                <path
                    d="M10.309 6.90385L15.7049 11.2639C15.835 11.3682 15.8573 11.5596 15.7557 11.6929L9.35874 20.0282C8.95662 20.5431 8.36402 20.8344 7.72908 20.8452L4.23696 20.8882C4.05071 20.8903 3.88775 20.7613 3.84542 20.5764L3.05175 17.1258C2.91419 16.4915 3.05175 15.8358 3.45388 15.3306L9.88256 6.95545C9.98627 6.82108 10.1778 6.79743 10.309 6.90385Z"
                    fill="currentColor"></path>
                <path opacity="0.4"
                    d="M18.1208 8.66544L17.0806 9.96401C16.9758 10.0962 16.7874 10.1177 16.6573 10.0124C15.3927 8.98901 12.1545 6.36285 11.2561 5.63509C11.1249 5.52759 11.1069 5.33625 11.2127 5.20295L12.2159 3.95706C13.126 2.78534 14.7133 2.67784 15.9938 3.69906L17.4647 4.87078C18.0679 5.34377 18.47 5.96726 18.6076 6.62299C18.7663 7.3443 18.597 8.0527 18.1208 8.66544Z"
                    fill="currentColor"></path>
            </svg>

        </a>
        
        

    </div>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'eliminar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'eliminar']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar este tratamiento?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="eliminarTratamiento">Si eliminar</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'editar']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                CONFIRMAR CITA DE: <?php echo e($operativo->empresa); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group" style="margin-bottom: 35px;">
                        <label class="form-label" for="">Seleccione tratamientos realizados (SOLO SI
                            FUE
                            FINALIZADO):</label>

                        <div class="table-responsive">
                            <table class="table mb-0 table-striped text-nowrap">
                                <thead>
                                    <th>CHECK</th>
                                    <th>TRATAMIENTO</th>
                                    <th>COSTO</th>
                                    <th>ACCION</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if(in_array($lista->idtratamiento, $tratamientosSeleccionados)): ?>
                                                    <input type="checkbox"
                                                        wire:click="toggleTratamiento(<?php echo e($lista->idtratamiento); ?>)"
                                                        checked>
                                                <?php else: ?>
                                                    <input type="checkbox"
                                                        wire:click="toggleTratamiento(<?php echo e($lista->idtratamiento); ?>)">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <label for=""><?php echo e($lista->nombretratamiento); ?></label>
                                            </td>
                                            <td>
                                                (<?php echo e($lista->costo); ?>.Bs)
                                            </td>
                                            <td>
                                                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                                    data-original-title="Edit"
                                                    wire:click="eliminarVista(<?php echo e($lista->id); ?>)">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.4"
                                                            d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    <span style="color: white;">Eliminar</span>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0 table-striped text-nowrap">
                                <thead>
                                    <th>TOTAL A COBRAR</th>
                                    <th>TOTAL CANCELADO</th>
                                    <th>PENDIENTE</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo e($pagotratamientostotal); ?>

                                        </td>
                                        <td>
                                            <?php echo e($totalpagado); ?>

                                        </td>

                                        <td>
                                            <?php echo e($this->deuda); ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <label for="">Aumento o Decuento a realizar:(LOS AUMENTOS SE COLOCAN CON SIGNO
                                -)</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model="descuentotratamientos">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="">MONTO EN QR:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="pagoqr">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="">MONTO EN EFECTIVO:</label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model="pagoefectivo">
                        </div>
                        <div class="mt-2 form-group">
                            <label class="form-label" for="">Encargado de cita (Cosmetologa):</label>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="elegido">
                                <option value="">Seleccionar operario</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php $__errorArgs = ['elegido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick">Encargad@ de cita requerido</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="form-group">
                            <label class="form-label" for="exampleInputdate">Fecha siguiente cita (SOLO SI NO
                                FINALIZO):</label>
                            <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                                wire:model.defer="operativo.fecha">
                        </div>
                        <?php $__errorArgs = ['operativo.fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <label style="color:firebrick">Fecha requerida</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-group">
                            <label class="form-label">Hora siguiente cita (SOLO SI NO FINALIZO):</label>
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
                            <label style="color:firebrick">Hora requerida</label>
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
                            <label style="color:firebrick">Minuto requerido</label>
                            <br>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-group">
                            <label class="form-label" for="">Agrear comentario (opcional):</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="operativo.comentario">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                            <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                                value="<?php echo e(Auth::user()->name); ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right">
            <label type="submit" class="btn btn-success" style="background-color: green;"
                wire:click="confirmar">Confirmar</label>
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
                REAGENDAR CITA DE: <?php echo e($operativo->empresa); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group" style="margin-right: 5%;">
                        <label>Sucursal: </label>
                        <select wire:model="operativo.area">
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de cita:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model.defer="operativo.fecha">
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
                        <label class="form-label" for="">Agrear comentario(opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="operativo.comentario">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="<?php echo e(Auth::user()->name); ?>">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardaroperativogeneral">Guardar</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'ffff']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'ffff']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Volvió a llamar: con teléfono: ?
            </div>
        </div>
        <div>
            <label for="">Comentario: </label>
            <input type="text" wire:model,defer="comentariollamada">
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" class="mr-2 btn btn-light" wire:click="cancelar">Cancelar</label>
            <label type="submit" class="btn btn-success" wire:click="rellamarnum">Si llamé</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'agreagar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'agreagar']); ?>
        <div class="card">
            <div class="card-header">
                <label class="form-label" for="">Selecciona tratamientos para agregar:</label>
                <div class="card-options">
                    <label style="background-color: green;" type="submit" class="btn btn-success"
                        wire:click="agregartratamientos">Confirmar</label>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <input type="text" class="form-control" id="exampleInputDisabled1"
                        wire:model="busquedatratamiento" placeholder="Buscar tratamiento...">
                </div>
                <?php $__currentLoopData = $mistratamientospara; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tratamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div>
                            <input type="checkbox"
                                wire:model.defer="tratamientosSeleccionadosnuevos.<?php echo e($tratamiento->id); ?>"
                                value="<?php echo e($tratamiento->id); ?>">
                            <label
                                for=""><?php echo e($tratamiento->nombre); ?>(<?php echo e($tratamiento->costo . 'Bs.'); ?>)</label>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'info']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Información de tratamiendo:
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <div class="form-group">
                    <label class="form-label" for="">Nombre de cliente: </label>
                    <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                        wire:model.defer="operativo.empresa">
                    <label class="form-label" for="">Numero de cliente: </label>
                    <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                        wire:model.defer="operativo.telefono">
                    <label class="form-label" for="">Ultimo comentario: </label>
                    <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                        wire:model.defer="operativo.comentario">

                    <label class="form-label" for="">Pago Total: </label>
                    <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                        wire:model.defer="total">
                    <label class="form-label" for="">Deuda:</label>
                    <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                        wire:model.defer="deuda">
                </div>

                <div class="px-4 card-body">
                    <div class="table-responsive">
                        <table id="user-list-table" class="" role="grid" data-bs-toggle="data-table">
                            <thead>
                                <tr class="ligth">
                                    <th style=" width: 300px;">TRATAMIENTO</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $mistratamientos = DB::table('historial_clientes')
                                        ->where('idoperativo', $operativo->id)
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
                                            <td style=" width: 300px;"><?php echo e($coll->nombre); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <td><?php echo e($item->fecha); ?></td>
                                        <?php if($item->estado == 'Activo'): ?>
                                            <td>Realizado</td>
                                        <?php else: ?>
                                            <td>Pendiente</td>
                                        <?php endif; ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
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
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/operativos/editar-operativo.blade.php ENDPATH**/ ?>