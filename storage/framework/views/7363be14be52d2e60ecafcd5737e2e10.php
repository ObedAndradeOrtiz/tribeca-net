<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php
        $sugerido = 0;
    ?>
    <style>
        .content {
            display: none;
        }

        .collapsible {
            cursor: pointer;
        }

        .collapsible .icon {
            margin-right: 10px;
        }
    </style>
    <div class="">
        <div class="text-lg font-medium text-gray-900">
            Panel de administracion de departamento de: <?php echo e($operativo->empresa); ?>

        </div>
        <div class="table-responsive">
            <table class="table mb-0 table-striped text-nowrap">
                <tbody>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Departamento(s):</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Costo</th>
                                            <th>Meses</th>
                                            <th>Departamento</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $totalhabitaciones = 0;
                                        ?>
                                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($lista->costo); ?></td>
                                                <td>

                                                    <?php
                                                        $fecha_dada = new DateTime($lista->fecha);
                                                        $fecha_hoy = new DateTime();

                                                        $diff = $fecha_hoy->diff($fecha_dada);

                                                        // calcular meses totales
                                                        $meses = $diff->y * 12 + $diff->m;

                                                        // si quieres contar mes actual parcialmente
                                                        if ($diff->d > 0) {
                                                            $meses += 1;
                                                        }

                                                        // evitar 0 meses
                                                        $meses = max(1, $meses);

                                                        $totalhabitaciones += $lista->costo * $meses;
                                                    ?>

                                                    <?php echo e($meses); ?>

                                                </td>
                                                <td><?php echo e($lista->nombretratamiento); ?></td>
                                                <td><?php echo e($lista->costo * $meses); ?> (.Bs)</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php
                        $sugerido = $sugerido + $totalhabitaciones;
                    ?>
                    

                    <tr class="collapsible">
                        <td><i class="fas fa-chevron-right icon"></i>Lista de pagos:</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <div style="display: flex;">
                                <label class="mr-1 btn btn-sm btn-icon btn-success align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('crearhabitacion',true)" style="flex:1">
                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">Pagar despensa</span>
                                </label>
                                <label class="mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ELIMINAR"
                                    data-original-title="Edit" wire:click="$set('confirmarimprimir',true)"
                                    style="flex:1">
                                    <span class="ms-1" style="font-size: 12px; color:aliceblue;">Imprimir pagos</span>
                                </label>
                            </div>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pagos.lista-pagos', ['idoperativo' => $operativo->id])->html();
} elseif ($_instance->childHasBeenRendered('l47488630-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l47488630-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l47488630-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l47488630-0');
} else {
    $response = \Livewire\Livewire::mount('pagos.lista-pagos', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l47488630-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            
                            

                            

                            

                        </td>
                    </tr>
                    <tr class="collapsible">
                        <td><i class="fas fa-chevron-right icon"></i>Cobranza:</td>
                    </tr>
                   <tr class="content" wire:ignore>
                        <td>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped text-nowrap">
                                    <thead>
                                        <th>Precio sugerido</th>
                                        <th>Monto a cobrar</th>
                                        <th>Total cancelado</th>
                                        <th>Deuda pendiente</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($sugerido); ?></td>
                                            <td>
                                                <input type="number" wire:model="pagotratamientostotal"
                                                    placeholder="Ingrese cantidad total a cobrar..." />
                                            </td>
                                            <td><?php echo e($this->totalpagado); ?></td>
                                            <td><?php echo e($this->deuda); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if($this->operativo->ingreso == 0): ?>
                                <label for="" class="btn btn-success" style="width: 100%"
                                    wire:click="guardaroperativo">Guardar</label>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Lista de copropietarios:</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.lista-hospedados', ['idoperativo' => $operativo->id])->html();
} elseif ($_instance->childHasBeenRendered('l47488630-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l47488630-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l47488630-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l47488630-1');
} else {
    $response = \Livewire\Livewire::mount('operativos.lista-hospedados', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l47488630-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </td>
                    </tr>
                    <tr class="collapsible" style="width: 100%">
                        <td style="width: 100%"><i class="fas fa-chevron-right icon"></i>Información del departamento:
                        </td>
                    </tr>
                    <tr class="content">
                        <td>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $operativo->id])->html();
} elseif ($_instance->childHasBeenRendered('l47488630-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l47488630-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l47488630-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l47488630-2');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $operativo->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l47488630-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        

    </div>

    <script>
        $(document).ready(function() {
            // Añadir el evento de clic a las filas colapsables
            $('.collapsible').on('click', function() {
                $(this).next('.content').toggle();
                $(this).find('.icon').toggleClass('fa-chevron-right fa-chevron-down');
            });
        });
    </script>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'confirmarimprimir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmarimprimir']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Confirmación de imnpresión
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <button type="submit" style="background-color: green;" class="btn btn-success"
                wire:click="imprimir">Imprimir</button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'eliminart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'eliminart']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Desea eliminar este departamento?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" style="background-color: red;" class="btn btn-danger"
                wire:click="eliminarTratamiento">Si
                eliminar</label>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'crearpagoproducto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'crearpagoproducto']); ?>
        <div>
            <div class="row">

                <div class="form-group col-md-2">
                    <label class="form-label" for="">MONTO:</label>
                    <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="cantidadpago">
                </div>
                <div class="form-group col-md-2">
                    <label for="form-label">METODO DE PAGO</label>
                    <br>
                    <select name="" id="" wire:model="mododepago">
                        <option value="Efectivo">
                            Efectivo
                        </option>
                        <option value="Qr">Qr</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="form-label">PRODUCTO:</label>
                    <br>
                    <select name="productoseleccionado" id="productoseleccionado" wire:model="productoseleccionado"
                        style="width: 100%;">
                        <option value="">Seleccionar</option>
                        <?php $__currentLoopData = $miscompras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>">
                                <?php echo e($item->nombreproducto); ?> (<?php echo e($item->precio); ?> BS)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                    value="<?php echo e(Auth::user()->name); ?>">
            </div>
            <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
                <button type="submit" style="background-color: green;" class="btn btn-success"
                    wire:click="guardartodoinventario">Guardar</button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'crearhabitacion']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'crearhabitacion']); ?>
        <div>
            <div class="row">

                <div class="form-group col-md-2">
                    <label class="form-label" for="">MONTO:</label>
                    <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="cantidadpago">
                </div>
                <div class="form-group col-md-2">
                    <label for="form-label">METODO DE PAGO</label>
                    <br>
                    <select name="" id="" wire:model="mododepago">
                        <option value="Efectivo">
                            Efectivo
                        </option>
                        <option value="Qr">Qr</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="form-label">HABITACION:</label>
                    <br>
                    <select name="productoseleccionado" id="productoseleccionado" wire:model="habitacionseleccionado"
                        style="width: 100%;">
                        <option value="">Seleccionar</option>
                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lista->id); ?>">
                                <?php echo e($lista->nombretratamiento); ?>(<?php echo e($lista->costo . '.BS'); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                    value="<?php echo e(Auth::user()->name); ?>">
            </div>
            <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
                <button type="submit" style="background-color: green;" class="btn btn-success"
                    wire:click="guardartodo">Guardar</button>
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
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/operativos/pagos-cliente.blade.php ENDPATH**/ ?>