<div>
    <div class="mt-4 mb-4 section-body">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header border-0 pt-5">
                    <div class="d-flex flex-column">
                        <h3 class="fw-bold mb-1">
                            <i class="bi bi-receipt me-2"></i> Gestión de Expensas
                        </h3>
                        <span class="text-muted small">
                            Administración de pagos, ingresos y control anual
                        </span>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <ul class="nav nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-semibold">

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                <?php echo e($vista === 'pagos' ? 'active' : ''); ?>"
                                wire:click="$set('vista','pagos')">

                                <i class="bi bi-cash-stack"></i>
                                Registro de expensas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                <?php echo e($vista === 'ingresos' ? 'active' : ''); ?>"
                                wire:click="$set('vista','ingresos')">

                                <i class="bi bi-calendar-check"></i>
                                Alquiler salón
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 
                                <?php echo e($vista === 'deudas' ? 'active' : ''); ?>"
                                wire:click="$set('vista','deudas')">

                                <i class="bi bi-table"></i>
                                Control anual
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <!-- BUSCADOR -->
                                    <?php if($vista == 'pagos' || $vista == 'ingresos'): ?>
                                        <div class="card">
                                            <div class="card-body py-2">

                                                <div class="row g-2">

                                                    <!-- BUSCADOR -->
                                                    <div class="col-12 col-md-4">
                                                        <input type="text" class="form-control form-control-sm w-100"
                                                            placeholder="Buscar..."
                                                            wire:model.debounce.500ms="busqueda">
                                                    </div>

                                                    <!-- DEPTO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroTratamiento"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Depto</option>
                                                            <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($t->nombre); ?>"><?php echo e($t->nombre); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>

                                                    <!-- MES -->
                                                    <div class="col-6 col-md-1">
                                                        <select wire:model="filtroMes"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Mes</option>
                                                            <?php for($i = 1; $i <= 12; $i++): ?>
                                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?>

                                                                </option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>

                                                    <!-- AÑO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroAnio"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Año</option>
                                                            <?php for($i = 2024; $i <= 2026; $i++): ?>
                                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?>

                                                                </option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>

                                                    <!-- ESTADO -->
                                                    <div class="col-6 col-md-2">
                                                        <select wire:model="filtroEstado"
                                                            class="form-select form-select-sm w-100">
                                                            <option value="">Estado</option>
                                                            <option value="Pendiente">Pendiente</option>
                                                            <option value="Pagado">Pagado</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <?php if($vista == 'ingresos'): ?>
                                                        <button class="btn btn-success"
                                                            wire:click="$set('crear',true)">Crear
                                                            registro de alquiler</button>
                                                    <?php endif; ?>

                                                </div>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($vista == 'pagos'): ?>
                                        <!-- TABLA -->
                                        <div class="table-responsive card mt-2">
                                            <table class="table table-striped mb-0 text-nowrap">
                                                <thead>
                                                    <tr>

                                                        <th>DEPTO</th>
                                                        <th>FECHA</th>
                                                        <th>MONTO A PAGAR</th>
                                                        <th>MONTO PAGADO</th>
                                                        <th>FECHA/ HORA DE PAGO</th>
                                                        <th>DEPOSITANTE</th>
                                                        <th>ESTADO</th>
                                                        <th>REGISTRADO POR</th>
                                                        <th>ACCIÓN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td><?php echo e($p->empresa); ?></td>

                                                            <td><?php echo e($p->fechainicio); ?></td>
                                                            <td><?php echo e($p->cantidad); ?></td>
                                                            <td><?php echo e($p->pagado); ?></td>

                                                            <td>
                                                                <?php if($p->fechapagado): ?>
                                                                    <?php echo e(\Carbon\Carbon::parse($p->fechapagado)->format('d/m/Y H:i')); ?>

                                                                <?php else: ?>
                                                                    SIN DATOS
                                                                <?php endif; ?>

                                                            </td>
                                                            <td>
                                                                <?php if($p->namebeneficiario): ?>
                                                                    <?php echo e($p->namebeneficiario); ?>

                                                                <?php else: ?>
                                                                    SIN DATOS
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                                    'badge',
                                                                    'bg-success' => $p->estado == 'Pagado',
                                                                    'bg-warning' => $p->estado == 'Pendiente',
                                                                    'bg-danger' => $p->estado == 'Inactivo',
                                                                    'bg-dark' => $p->estado == 'Atrasado',
                                                                    'bg-info' => $p->estado == 'Adelantado',
                                                                ]); ?>">
                                                                    <?php echo e($p->estado); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php if($p->nameuser): ?>
                                                                    <?php echo e($p->nameuser); ?>

                                                                <?php else: ?>
                                                                    SIN DATOS
                                                                <?php endif; ?>

                                                            </td>
                                                            <td>
                                                                <button wire:click="editar(<?php echo e($p->id); ?>)"
                                                                    class="btn btn-sm btn-primary">
                                                                    Editar
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>

                                            <div class="py-2 px-3 d-flex justify-content-end">
                                                <?php echo e($pagos->links()); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($vista == 'ingresos'): ?>
                                        <!-- TABLA -->
                                        <div class="table-responsive card mt-2">
                                            <table class="table table-striped mb-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>DEPTO</th>
                                                        <th>FECHA PAGADO</th>
                                                        <th>FECHA A ALQUILAR</th>
                                                        <th>MONTO PAGADO</th>
                                                        <th>ESTADO</th>
                                                        <th>ACCIÓN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $alquileres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($p->namebeneficiario); ?></td>
                                                            <td><?php echo e($p->fechainicio); ?></td>
                                                            <td><?php echo e($p->fechapagado); ?></td>
                                                            <td><?php echo e($p->pagado); ?></td>
                                                            <td>
                                                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                                    'badge',
                                                                    'bg-success' => $p->estado == 'Pagado',
                                                                    'bg-warning' => $p->estado == 'Pendiente',
                                                                    'bg-danger' => $p->estado == 'Inactivo',
                                                                    'bg-dark' => $p->estado == 'Atrasado',
                                                                    'bg-info' => $p->estado == 'Adelantado',
                                                                ]); ?>">
                                                                    <?php echo e($p->estado); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button
                                                                    wire:click="editaralquiler(<?php echo e($p->id); ?>)"
                                                                    class="btn btn-sm btn-primary">
                                                                    Editar
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>

                                            <div class="py-2 px-3 d-flex justify-content-end">
                                                <?php echo e($alquileres->links()); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($vista == 'deudas'): ?>
                                        <div class="card mt-3">
                                            <div class="card-body">

                                                <!-- FILTRO POR AÑO -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <h5>Control de Deudas</h5>

                                                    <select wire:model="filtroAnio" class="form-control form-control-sm"
                                                        style="width:120px;">
                                                        <?php for($i = 2024; $i <= date('Y'); $i++): ?>
                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?>

                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm text-center">

                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th>Departamento</th>
                                                                <?php for($m = 1; $m <= 12; $m++): ?>
                                                                    <th><?php echo e($m); ?></th>
                                                                <?php endfor; ?>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><strong><?php echo e($t->nombre); ?></strong></td>

                                                                    <?php for($m = 1; $m <= 12; $m++): ?>
                                                                        <?php

                                                                            $inicio =
                                                                                $filtroAnio .
                                                                                '-' .
                                                                                str_pad($m, 2, '0', STR_PAD_LEFT) .
                                                                                '-01';
                                                                            $fin =
                                                                                $filtroAnio .
                                                                                '-' .
                                                                                str_pad($m, 2, '0', STR_PAD_LEFT) .
                                                                                '-31';

                                                                            $pago = DB::table('pagos')
                                                                                ->where('empresa', $t->nombre)
                                                                                ->whereBetween('fechainicio', [
                                                                                    $inicio,
                                                                                    $fin,
                                                                                ])
                                                                                ->first();

                                                                            $monto = $pago->cantidad ?? 0;
                                                                            $pagado = $pago->pagado ?? 0;

                                                                            $color = 'text-muted';

                                                                            if (
                                                                                $pagado > 0 &&
                                                                                $pago &&
                                                                                $pago->fechapagado
                                                                            ) {
                                                                                $diaPago = date(
                                                                                    'd',
                                                                                    strtotime($pago->fechapagado),
                                                                                );

                                                                                if ($diaPago <= 10) {
                                                                                    $color = 'text-success'; // 🟢 a tiempo
                                                                                } else {
                                                                                    $color = 'text-danger'; // 🔴 atrasado
                                                                                }
                                                                            }
                                                                        ?>

                                                                        <td style="cursor:pointer"
                                                                            wire:click="editar(<?php echo e($pago->id ?? 0); ?>)">

                                                                            <div style="font-size:11px;">
                                                                                <div>
                                                                                    <strong><?php echo e($monto); ?></strong>
                                                                                </div>
                                                                                <div class="color"><?php echo e($pagado); ?>

                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    <?php endfor; ?>


                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'modal']); ?>
        <div class="p-4">
            <h5 class="mb-3">Editar Pago</h5>

            <div class="row">

                <!-- NO EDITABLES -->
                <div class="col-md-6">
                    <label>Departamento</label>
                    <input type="text" wire:model="pagoEditar.empresa" class="form-control mb-2" readonly>
                </div>

                <div class="col-md-6">
                    <label>Fecha correspondiente</label>
                    <input type="date" wire:model="pagoEditar.fechainicio" class="form-control mb-2" readonly>
                </div>

                <div class="col-md-6">
                    <label>Monto Total</label>
                    <input type="number" wire:model="pagoEditar.cantidad" class="form-control mb-2" readonly>
                </div>

                <!-- EDITABLES -->
                <div class="col-md-6">
                    <label>Pagado</label>
                    <input type="number" wire:model="pagoEditar.pagado" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Fecha y hora de pago</label>
                    <input type="datetime-local" wire:model="pagoEditar.fechapagado" class="form-control mb-2">
                </div>

                <!-- AUTOCOMPLETE BENEFICIARIO -->
                <div class="col-md-6 position-relative">
                    <label>Responsable de pago</label>

                    <input type="text" wire:model.debounce.300ms="busquedaBeneficiario" class="form-control mb-1"
                        placeholder="Buscar responsable...">

                    <?php if(!empty($sugerencias)): ?>
                        <div class="list-group position-absolute w-100 shadow"
                            style="z-index: 999; max-height: 150px; overflow-y:auto;">

                            <?php $__currentLoopData = $sugerencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" wire:click="seleccionarBeneficiario('<?php echo e($s); ?>')"
                                    class="list-group-item list-group-item-action">
                                    <?php echo e($s); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- ESTADO -->
                <div class="col-md-6">
                    <label>Estado</label>
                    <select wire:model="pagoEditar.estado" class="form-control mb-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Inactivo</option>
                        <option value="Atrasado">Atrasado</option>
                        <option value="Adelantado">Adelantado</option>
                    </select>
                </div>

                <!-- SUBIR COMPROBANTE -->
                <div class="col-md-6">
                    <label>Subir comprobante</label>
                    <input type="file" wire:model="comprobante" class="form-control mb-2">

                    <!-- Loader -->
                    <div wire:loading wire:target="comprobante" class="text-primary">
                        Subiendo imagen...
                    </div>
                </div>
                <?php if($comprobante): ?>
                    <div class="col-md-6">
                        <label>Vista previa</label>
                        <img src="<?php echo e($comprobante->temporaryUrl()); ?>" class="img-fluid rounded shadow"
                            style="max-height:200px;">
                    </div>
                <?php endif; ?>
                <?php if(!empty($pagoEditar['path'])): ?>
                    <img class="mt-4" src="<?php echo e(asset('storage/' . $pagoEditar['path'])); ?>" alt="">>
                <?php endif; ?>

            </div>
            <div class="text-end mt-3">
                <button wire:click="$set('modal', false)" class="btn btn-secondary me-2">
                    Cancelar
                </button>

                <button wire:click="guardar" class="btn btn-success">
                    Guardar Cambios
                </button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'crear']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'crear']); ?>
        <div class="p-4">
            <h5 class="mb-3">Pago de alquiler de salon</h5>
            <div class="row">
                <!-- NO EDITABLES -->
                <div class="col-md-6">
                    <label>Departamento responsable</label>
                    <select name="" id="" wire:model='departamentodealquiler'
                        class="form-control mb-2>
                            <option value="">Seleccione
                        un
                        departamento</option>
                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->nombre); ?>"><?php echo e($item->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Fecha de alquiler</label>
                    <input type="date" wire:model="fechacorrespondiente" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Monto cancelado</label>
                    <input type="number" wire:model="montopago" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Fecha de pago realizado</label>
                    <input type="date" wire:model="fechadepago" class="form-control mb-2">
                </div>

                <!-- ESTADO -->
                <div class="col-md-6">
                    <label>Estado</label>
                    <select wire:model="estadodepago" class="form-control mb-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Cancelado</option>s
                    </select>
                </div>

                <!-- SUBIR COMPROBANTE -->
                <div class="col-md-6">
                    <label>Subir comprobante o nota</label>
                    <input type="file" wire:model="comprobante" class="form-control mb-2">

                    <!-- Loader -->
                    <div wire:loading wire:target="comprobante" class="text-primary">
                        Subiendo imagen...
                    </div>
                </div>

                <!-- PREVIEW NUEVO -->
                <?php if($comprobante): ?>
                    <div class="col-md-6">
                        <label>Vista previa</label>
                        <img src="<?php echo e($comprobante->temporaryUrl()); ?>" class="img-fluid rounded shadow"
                            style="max-height:200px;">
                    </div>
                <?php endif; ?>

            </div>

            <!-- BOTONES -->
            <div class="text-end mt-3">
                <button wire:click="$set('crear', false)" class="btn btn-secondary me-2">
                    Cancelar
                </button>

                <button wire:click="guardaringreso" class="btn btn-success">
                    Guardar Cambios
                </button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'editar']); ?>
        <div class="p-4">
            <h5 class="mb-3">Pago de alquiler de salon</h5>
            <div class="row">
                <!-- NO EDITABLES -->
                <div class="col-md-6">
                    <label>Departamento responsable</label>
                    <select name="" id="" wire:model='pagoEditar.namebeneficiario'
                        class="form-control mb-2>
                            <option value="">Seleccione
                        un
                        departamento</option>
                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->nombre); ?>"><?php echo e($item->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Fecha de alquiler</label>
                    <input type="date" wire:model="pagoEditar.fechainicio" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Monto cancelado</label>
                    <input type="number" wire:model="pagoEditar.pagado" class="form-control mb-2">
                </div>

                <div class="col-md-6">
                    <label>Fecha de pago realizado</label>
                    <input type="date" wire:model="pagoEditar.fechapagado" class="form-control mb-2">
                </div>

                <!-- ESTADO -->
                <div class="col-md-6">
                    <label>Estado</label>
                    <select wire:model="pagoEditar.estado" class="form-control mb-2">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Inactivo">Cancelado</option>s
                    </select>
                </div>

                <!-- SUBIR COMPROBANTE -->
                <div class="col-md-6">
                    <label>Subir comprobante o nota</label>
                    <input type="file" wire:model="comprobante" class="form-control mb-2">

                    <!-- Loader -->
                    <div wire:loading wire:target="comprobante" class="text-primary">
                        Subiendo imagen...
                    </div>
                </div>

                <!-- PREVIEW NUEVO -->
                <?php if(!empty($pagoEditar['path'])): ?>
                    <img class="mt-4" src="<?php echo e(asset('storage/' . $pagoEditar['path'])); ?>" alt="">>
                <?php endif; ?>

            </div>

            <!-- BOTONES -->
            <div class="text-end mt-3">
                <button wire:click="$set('editar', false)" class="btn btn-secondary me-2">
                    Cancelar
                </button>

                <button wire:click="guardar" class="btn btn-success">
                    Guardar Cambios
                </button>
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
<?php /**PATH C:\xampp\htdocs\tribeca-project\resources\views/livewire/operativos/pagos-table.blade.php ENDPATH**/ ?>