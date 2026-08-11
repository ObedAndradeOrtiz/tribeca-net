<div>

    <style>
        .container {
            display: flex;
            flex-direction: column;
        }

        .flex-row {
            display: flex;
            flex-direction: row;
        }

        .justify-between {
            justify-content: space-between;
        }

        .divider {
            height: 2px;
            background-color: #898282;
            margin: 10px 0;
        }

        .boton-container {
            display: flex;
        }

        .boton {
            padding: 10px 20px;
            font-size: 16px;
            width: 30%;
        }

        @media screen and (max-width: 600px) {
            .boton {
                font-size: 9px;
                width: 30%;
            }
        }
    </style>

    <div class="col-sm-12">

        <?php if($lista == 'historial'): ?>

            <!-- 🔥 FILTROS -->
            <div class="flex flex-row justify-end">

                <div>
                    <label>Desde:</label>
                    <input type="date" class="shadow-none form-select" wire:model="fechaInicioMes">
                </div>

                <div>
                    <label>Hasta:</label>
                    <input type="date" class="shadow-none form-select" wire:model="fechaActual">
                </div>

                <div>
                    <label>Sucursal:</label>
                    <select class="shadow-none form-select" wire:model="sucursal">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label>Modo:</label>
                    <select class="shadow-none form-select" wire:model="modogeneral">
                        <option>Todos</option>
                        <option>QR</option>
                        <option>Efectivo</option>
                    </select>
                </div>

            </div>

            <!-- 🔥 PRE-CONSULTA OPTIMIZADA -->
            <?php
                $gastos = DB::table('gastos')
                    ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                    ->where('area', 'LIKE', '%' . $sucursal . '%')
                    ->when($modogeneral != 'Todos', fn($q) => $q->where('modo', $modogeneral))
                    ->get();

                $sumador = $gastos->sum('cantidad');
            ?>

            <!-- 🔥 TABLA -->
            <div class="card-body">
                <div class="table-responsive">

                    <h3 class="mb-3">Historial de egresos</h3>

                    <table id="user-list-table" class="table align-middle table-striped">

                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Modo</th>
                                <th>Responsable</th>
                                <th>Sucursal</th>
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

                            <?php $__currentLoopData = $gastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="font-size: 11px;"><?php echo e($item->empresa); ?></td>
                                    <td><?php echo e($item->tipo); ?></td>

                                    <td class="text-danger fw-bold">
                                        Bs <?php echo e(number_format($item->cantidad, 2)); ?>

                                    </td>

                                    <td><?php echo e($item->fechainicio); ?></td>

                                    <td>
                                        <?php echo e($item->modo ?? $modogeneral); ?>

                                    </td>

                                    <td><?php echo e($item->nameuser); ?></td>
                                    <td><?php echo e($item->area); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <!-- 🔥 TOTAL -->
                            <tr style="background:#0f172a; color:white; font-weight:bold;">
                                <td>TOTALES</td>
                                <td></td>
                                <td>Bs <?php echo e(number_format($sumador, 2)); ?></td>
                                <td></td>
                                <td><?php echo e($modogeneral); ?></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

        <?php endif; ?>


        <?php if($lista == 'planilla'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('planilla.lista-planilla')->html();
} elseif ($_instance->childHasBeenRendered('l3379245991-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3379245991-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3379245991-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3379245991-0');
} else {
    $response = \Livewire\Livewire::mount('planilla.lista-planilla');
    $html = $response->html();
    $_instance->logRenderedChild('l3379245991-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>

        <?php if($lista == 'csv'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.subir-csv')->html();
} elseif ($_instance->childHasBeenRendered('l3379245991-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3379245991-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3379245991-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3379245991-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.subir-csv');
    $html = $response->html();
    $_instance->logRenderedChild('l3379245991-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/tesoreria/egreso-interno.blade.php ENDPATH**/ ?>