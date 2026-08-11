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
            margin-top: 10px;
            margin-bottom: 10px;
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
    <div>

    </div>
    <div class="col-sm-12">
        <div>
            <select name="" id="" wire:model="lista">
                <option value="historial">HISTORIAL</option>
                <option value="planilla">PLANILLA DE PAGOS</option>
                <option value="csv">IMPORTAR DATOS CSV</option>
            </select>
        </div>
        <?php if($lista == 'historial'): ?>
            <div class="flex flex-row justify-end">
                <div>
                    <label for="fecha-inicio">Desde:</label>
                    <input class="shadow-none form-select form-select-smmt-5" type="date" id="fecha-inicio"
                        wire:model="fechaInicioMes">
                </div>
                <div>
                    <label for="fecha-actual">Hasta:</label>
                    <input class="shadow-none form-select form-select-smmt-5" type="date" id="fecha-actual"
                        wire:model="fechaActual">
                </div>
                <div class="">
                    <label>Sucursal: </label>
                    <select class="shadow-none form-select form-select-smmt-5" wire:model="sucursal">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label>Modo: </label>
                    <select class="ml-2 shadow-none form-select form-select-smmt-5" wire:model="modogeneral">
                        <option>Todos</option>
                        <option>QR</option>
                        <option>Efectivo</option>
                    </select>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <h3 class="mb-2 ">Historial de egresos</h3>
                    </div>
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>Detalle de gasto</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>FECHA</th>
                                <th>Modo</th>
                                <th>Responsable</th>
                                <th>SUCURSAL</th>
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
                                $sumador = 0;
                                if ($modogeneral == 'Todos') {
                                    $gastos = DB::table('gastos')
                                        ->where('fechainicio', '>=', $fechaInicioMes)
                                        ->where('area', 'LIKE', '%' . $sucursal . '%')
                                        ->where('fechainicio', '<=', $fechaActual)
                                        ->get();
                                } else {
                                    $gastos = DB::table('gastos')
                                        ->where('modo', $modogeneral)
                                        ->where('area', 'LIKE', '%' . $sucursal . '%')
                                        ->where('fechainicio', '>=', $fechaInicioMes)
                                        ->where('fechainicio', '<=', $fechaActual)
                                        ->get();
                                }

                            ?>
                            <?php $__currentLoopData = $gastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="font-size: 10px;"><?php echo e($lista->empresa); ?></td>
                                    <td><?php echo e($lista->tipo); ?></td>
                                    <td><?php echo e($lista->cantidad); ?></td>
                                    <td><?php echo e($lista->fechainicio); ?></td>
                                    <td><?php echo e($modogeneral); ?></td>
                                    <td><?php echo e($lista->nameuser); ?></td>
                                    <td><?php echo e($lista->area); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-gray">
                                <td style="color: white">TOTALES</td>
                                <td></td>
                                <?php
                                    if ($modogeneral == 'Todos') {
                                        $sumador = DB::table('gastos')
                                            ->where('fechainicio', '>=', $fechaInicioMes)
                                            ->where('area', 'LIKE', '%' . $sucursal . '%')
                                            ->where('fechainicio', '<=', $fechaActual)
                                            ->sum('cantidad');
                                    } else {
                                        $sumador = DB::table('gastos')
                                            ->where('fechainicio', '>=', $fechaInicioMes)
                                            ->where('area', 'LIKE', '%' . $sucursal . '%')
                                            ->where('fechainicio', '<=', $fechaActual)
                                            ->where('modo', $modogeneral)
                                            ->sum('cantidad');
                                    }
                                ?>
                                <td style="color: white"><?php echo e($sumador); ?></td>
                                <td></td>
                                <td style="color: white"><?php echo e($modogeneral); ?></td>
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
} elseif ($_instance->childHasBeenRendered('l2983532555-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2983532555-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2983532555-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2983532555-0');
} else {
    $response = \Livewire\Livewire::mount('planilla.lista-planilla');
    $html = $response->html();
    $_instance->logRenderedChild('l2983532555-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
        <?php if($lista == 'csv'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.subir-csv')->html();
} elseif ($_instance->childHasBeenRendered('l2983532555-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2983532555-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2983532555-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2983532555-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.subir-csv');
    $html = $response->html();
    $_instance->logRenderedChild('l2983532555-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>

    </div>
</div>


</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/tesoreria/egreso-interno.blade.php ENDPATH**/ ?>