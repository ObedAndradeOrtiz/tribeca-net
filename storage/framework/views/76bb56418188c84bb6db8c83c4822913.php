<div>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>

    <div class="flex flex-row justify-between" style="margin: 2%;">
        <div>
            <div>
                <label for="semana">SEMANA DE PAGO</label>
                <select class="shadow-none form-select form-select-smmt-5" id="semana" wire:model="semana">
                    <option value="SIN SELECCIONAR">SIN SELECCIONAR</option>
                    <option value="SEMANA-1">SEMANA-1</option>
                    <option value="SEMANA-2">SEMANA-2</option>
                    <option value="SEMANA-3">SEMANA-3</option>
                    <option value="SEMANA-4">SEMANA-4</option>
                </select>
            </div>
            <div>
                <label for="semana">ESTADO DE PLANILLA</label>
                <select class="shadow-none form-select form-select-smmt-5" id="semana" wire:model="estado">
                    <option value="POR PAGAR">POR PAGAR</option>
                    <option value="PAGADO">PAGADO</option>

                </select>
            </div>
        </div>
        <div>
            <label for="fecha-fin">FECHA DE PAGO:</label>
            <input type="date" wire:model="fechapago">
            <?php if(Auth::user()->rol == 'Contador' ||
                    Auth::user()->rol == 'Administrador' ||
                    Auth::user()->rol == 'Sistema' ||
                    Auth::user()->rol == 'Recursos Humanos'): ?>
                <button class=" btn btn-warning" wire:click='actualizarplanilla'>ACTUALIZAR</button>
                <button class=" btn btn-success" wire:click='guardarplanilla'>GUARDAR PLANILLA</button>
            <?php endif; ?>

        </div>

    </div>
    <div>
        <h4>TOTALES DE: <?php echo e($semana); ?></h4>
        <?php
            $nro = 0;
        ?>
        <table>
            <thead>
                <th>NRO</th>
                <th>NOMBRE Y APELLIDO</th>
                <th>HABER BASICO</th>
                <th>BONOS</th>
                <th>SUELDO <br> HORA</th>
                <th>HORAS <br> DIAS</th>
                <th>DIAS <br> TRABAJADOS</th>
                <th>HORAS <br> EXTRAS</th>
                <th>ANTICIPOS</th>
                <th>LIQUIDO <br> PAGABLE</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $planillas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr> <?php
                        $nro = $nro + 1;
                    ?>
                        <td><?php echo e($nro); ?></td>
                        <td><?php echo e($item->nombre); ?></td>
                        <?php if(Auth::user()->rol == 'Contador' ||
                                Auth::user()->rol == 'Administrador' ||
                                Auth::user()->rol == 'Sistema' ||
                                Auth::user()->rol == 'Recursos Humanos'): ?>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="haberbasico.<?php echo e($item->id); ?>"
                                    min="0" value="<?php echo e($haberbasico[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="bonos.<?php echo e($item->id); ?>"
                                    value="<?php echo e($bonos[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="sueldohora.<?php echo e($item->id); ?>"
                                    value="<?php echo e($sueldohora[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="horasdias.<?php echo e($item->id); ?>"
                                    value="<?php echo e($horasdias[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number"
                                    wire:model="diastrabajados.<?php echo e($item->id); ?>"
                                    value="<?php echo e($diastrabajados[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="horasextras.<?php echo e($item->id); ?>"
                                    value="<?php echo e($horasextras[$item->id]); ?>">
                            </td>

                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="anticipo.<?php echo e($item->id); ?>"
                                    value="<?php echo e($anticipo[$item->id]); ?>">
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" wire:model="pagado.<?php echo e($item->id); ?>"
                                    value="<?php echo e($pagado[$item->id]); ?>">
                            </td>
                        <?php else: ?>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" min="0" value="0" disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0"disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>

                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>
                            <td style="max-width: 100px;">
                                <input style="width: 100%;" type="number" value="0" disabled>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>TOTALES</td>
                    <td></td>
                    <td><?php echo e($totalHaberBasico); ?></td>
                    <td><?php echo e($totalBonos); ?></td>
                    <td><?php echo e($totalSueldoHora); ?></td>
                    <td><?php echo e($totalHorasDias); ?></td>
                    <td><?php echo e($totalDiasTrabajados); ?></td>
                    <td><?php echo e($totalHorasExtras); ?></td>
                    <td><?php echo e($totalAnticipo); ?></td>
                    <td><?php echo e($totalPagado); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/planilla-editar.blade.php ENDPATH**/ ?>