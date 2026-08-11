
<div class="col-12">

    <?php if($lista == 'historial'): ?>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-clock-history me-2"></i> Historial de egresos
                    </h5>
                    <span class="text-muted small">
                        Consulta y control de gastos registrados
                    </span>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success" onclick="exportarExcelEgresos()">
                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Excel
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" onclick="imprimirReporteEgresos()">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4 align-items-end">

            <div class="col-md-2">
                <label class="form-label fw-semibold">Desde</label>
                <input type="date" class="form-control" wire:model="fechaInicioMes">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Hasta</label>
                <input type="date" class="form-control" wire:model="fechaActual">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Área</label>
                <select class="form-select" wire:model="sucursal">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->area); ?>"><?php echo e($item->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Comprobante</label>
                <select class="form-select" wire:model="filtroComprobante">
                    <option value="Todos">Todos</option>
                    <option value="Con">Con comprobante</option>
                    <option value="Sin">Sin comprobante</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Modo</label>
                <select class="form-select" wire:model="modogeneral">
                    <option>Todos</option>
                    <option>QR</option>
                    <option>Efectivo</option>
                </select>
            </div>

        </div>

        <?php
            $gastos = DB::table('gastos')
                ->whereBetween('fechainicio', [$fechaInicioMes, $fechaActual])
                ->where('area', 'LIKE', '%' . $sucursal . '%')
                ->when($modogeneral != 'Todos', fn($q) => $q->where('modo', $modogeneral))
                ->when($filtroComprobante == 'Con', function ($q) {
                    $q->whereNotNull('rutaarchivo')
                        ->where('rutaarchivo', '!=', '');
                })
                ->when($filtroComprobante == 'Sin', function ($q) {
                    $q->where(function ($sub) {
                        $sub->whereNull('rutaarchivo')
                            ->orWhere('rutaarchivo', '');
                    });
                })
                ->orderBy('fechainicio', 'ASC')
                ->get();

            $sumador = $gastos->sum('cantidad');

            $conComprobante = $gastos->filter(fn($item) => !empty($item->rutaarchivo))->count();
            $sinComprobante = $gastos->filter(fn($item) => empty($item->rutaarchivo))->count();
        ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="border rounded p-3 bg-light">
                    <div class="text-muted small">Total registros</div>
                    <div class="fw-bold fs-5"><?php echo e($gastos->count()); ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-3 bg-light">
                    <div class="text-muted small">Con comprobante</div>
                    <div class="fw-bold fs-5 text-success"><?php echo e($conComprobante); ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-3 bg-light">
                    <div class="text-muted small">Sin comprobante</div>
                    <div class="fw-bold fs-5 text-danger"><?php echo e($sinComprobante); ?></div>
                </div>
            </div>
        </div>

        <div id="reporte-egresos">

            <div class="mb-3 d-none" id="titulo-reporte-egresos">
                <h4>Reporte de egresos</h4>
                <p>
                    Desde: <?php echo e($fechaInicioMes); ?> |
                    Hasta: <?php echo e($fechaActual); ?> |
                    Área: <?php echo e($sucursal ?: 'Todas'); ?> |
                    Comprobante: <?php echo e($filtroComprobante); ?> |
                    Modo: <?php echo e($modogeneral); ?>

                </p>
            </div>

            <div class="table-responsive">

                <table class="table table-row-bordered table-hover align-middle" id="tabla-egresos-reporte">

                    <thead class="fw-bold text-muted bg-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Tipo</th>
                            <th>Modo</th>
                            <th>Área</th>
                            <th>Responsable</th>
                            <th>Estado comprobante</th>
                            <th>Archivo</th>
                            <th>Monto</th>
                            <th class="no-export">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $gastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($item->fechainicio): ?>
                                        <?php echo e(\Carbon\Carbon::parse($item->fechainicio)->format('d/m/Y')); ?>

                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>

                                <td class="text-truncate" style="max-width:220px;">
                                    <?php echo e($item->empresa ?: 'SIN DETALLE'); ?>

                                </td>

                                <td>
                                    <span class="badge bg-light-primary text-dark">
                                        <?php echo e($item->tipo); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-light-secondary">
                                        <?php echo e($item->modo ?? '—'); ?>

                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    <?php echo e($item->area); ?>

                                </td>

                                <td>
                                    <?php echo e($item->nameuser); ?>

                                </td>

                                <td>
                                    <?php if($item->rutaarchivo): ?>
                                        <span class="badge bg-light-success text-dark">
                                            Con comprobante
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light-danger text-dark">
                                            Sin comprobante
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($item->rutaarchivo): ?>
                                        <button class="btn btn-sm btn-light-primary no-export"
                                            wire:click="verImagen('<?php echo e($item->rutaarchivo); ?>')">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <span class="d-none export-text">
                                            <?php echo e($item->rutaarchivo); ?>

                                        </span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>

                                <td class="fw-bold text-danger">
                                    Bs <?php echo e(number_format($item->cantidad, 2)); ?>

                                </td>

                                <td class="no-export">
                                    <button type="button" class="btn btn-sm btn-light-warning"
                                        wire:click="editarEgreso(<?php echo e($item->id); ?>)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    No existen egresos con los filtros seleccionados.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr class="fw-bold bg-dark text-white">
                            <td>TOTALES</td>
                            <td></td>
                            <td></td>
                            <td><?php echo e($modogeneral); ?></td>
                            <td></td>
                            <td></td>
                            <td><?php echo e($filtroComprobante); ?></td>
                            <td></td>
                            <td>Bs <?php echo e(number_format($sumador, 2)); ?></td>
                            <td class="no-export"></td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    <?php endif; ?>

    <?php if($imagenModal): ?>
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.7)">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Comprobante</h5>
                        <button class="btn-close" wire:click="$set('imagenModal', null)"></button>
                    </div>

                    <div class="modal-body text-center">
                        <img src="<?php echo e(asset('storage/' . $imagenModal)); ?>" class="img-fluid rounded shadow">
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

     <?php if($modalEditarEgreso): ?>
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.65); z-index: 9999;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-bold mb-1">
                                <i class="bi bi-pencil-square me-2"></i>
                                Editar egreso
                            </h5>
                            <p class="text-muted small mb-0">
                                Modifica los datos del gasto y reemplaza el comprobante si corresponde.
                            </p>
                        </div>

                        <button type="button" class="btn-close" wire:click="$set('modalEditarEgreso', false)">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Detalle</label>
                                <input type="text" class="form-control" wire:model.defer="editarDetalle"
                                    placeholder="Detalle del egreso">
                                <?php $__errorArgs = ['editarDetalle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipo</label>
                                <select class="form-select" wire:model.defer="editarTipo">
                                    <option value="">Seleccione...</option>
                                    <option value="General">General</option>
                                    <option value="Sueldo">Sueldo</option>
                                    <option value="Bono">Bono</option>
                                    <option value="Servicio">Servicio</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Compra">Compra</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <?php $__errorArgs = ['editarTipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Monto</label>
                                <input type="number" step="0.01" class="form-control"
                                    wire:model.defer="editarMonto" placeholder="0.00">
                                <?php $__errorArgs = ['editarMonto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fecha</label>
                                <input type="date" class="form-control" wire:model.defer="editarFecha">
                                <?php $__errorArgs = ['editarFecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Modo de pago</label>
                                <select class="form-select" wire:model.defer="editarModo">
                                    <option value="">Seleccione...</option>
                                    <option value="QR">QR</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                                <?php $__errorArgs = ['editarModo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Area</label>
                                <select class="form-select" wire:model.defer="editarArea">
                                    <option value="">Seleccione...</option>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>">
                                            <?php echo e($item->area); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Pertenece / destinatario</label>
                                <input type="text" class="form-control" wire:model.defer="editarPertenece"
                                    placeholder="Nombre del destinatario, si aplica">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Comprobante</label>

                                <?php if($editarRutaArchivo): ?>
                                    <div class="border rounded-3 p-3 mb-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center gap-2">
                                            <div>
                                                <div class="fw-semibold">Comprobante actual</div>
                                                <small class="text-muted"><?php echo e($editarRutaArchivo); ?></small>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-light-primary"
                                                    wire:click="verImagen('<?php echo e($editarRutaArchivo); ?>')">
                                                    <i class="bi bi-eye"></i>
                                                    Ver
                                                </button>

                                                <button type="button" class="btn btn-sm btn-light-danger"
                                                    wire:click="eliminarComprobanteEgreso">
                                                    <i class="bi bi-trash"></i>
                                                    Quitar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <input type="file" class="form-control" wire:model="editarComprobante"
                                    accept="image/*,application/pdf">

                                <small class="text-muted">
                                    Puedes subir imagen o PDF. Si subes uno nuevo, reemplazar el anterior.
                                </small>

                                <?php $__errorArgs = ['editarComprobante'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div>
                                        <small class="text-danger"><?php echo e($message); ?></small>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <div wire:loading wire:target="editarComprobante" class="text-primary small mt-2">
                                    Subiendo comprobante...
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" wire:click="$set('modalEditarEgreso', false)">
                            Cancelar
                        </button>

                        <button type="button" class="btn btn-primary" wire:click="actualizarEgreso"
                            wire:loading.attr="disabled" wire:target="actualizarEgreso,editarComprobante">
                            <span wire:loading.remove wire:target="actualizarEgreso">
                                Guardar cambios
                            </span>
                            <span wire:loading wire:target="actualizarEgreso">
                                Guardando...
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function exportarExcelEgresos() {
            let tabla = document.getElementById('tabla-egresos-reporte').cloneNode(true);

            tabla.querySelectorAll('.no-export').forEach(el => el.remove());

            tabla.querySelectorAll('.export-text').forEach(el => {
                el.classList.remove('d-none');
            });

            let html = `
                <html>
                    <head>
                        <meta charset="UTF-8">
                    </head>
                    <body>
                        <h3>Reporte de egresos</h3>
                        <p>
                            Desde: <?php echo e($fechaInicioMes); ?> |
                            Hasta: <?php echo e($fechaActual); ?> |
                            Área: <?php echo e($sucursal ?: 'Todas'); ?> |
                            Comprobante: <?php echo e($filtroComprobante); ?> |
                            Modo: <?php echo e($modogeneral); ?>

                        </p>
                        ${tabla.outerHTML}
                    </body>
                </html>
            `;

            let blob = new Blob([html], {
                type: 'application/vnd.ms-excel;charset=utf-8;'
            });

            let url = URL.createObjectURL(blob);
            let a = document.createElement('a');

            a.href = url;
            a.download = 'reporte_egresos_<?php echo e($filtroComprobante); ?>_<?php echo e($fechaInicioMes); ?>_<?php echo e($fechaActual); ?>.xls';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

         function imprimirReporteEgresos() {
        let tabla = document.getElementById('tabla-egresos-reporte').cloneNode(true);

        tabla.querySelectorAll('.no-export').forEach(el => el.remove());
        tabla.querySelectorAll('button').forEach(el => el.remove());
        tabla.querySelectorAll('.export-text').forEach(el => {
            el.classList.remove('d-none');
        });

        let ventana = window.open('', '_blank');

        ventana.document.write(`
            <html>
                <head>
                    <title>Reporte de egresos</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                            color: #111;
                        }

                        h3 {
                            text-align: center;
                            margin-bottom: 6px;
                        }

                        .subtitulo {
                            text-align: center;
                            margin-bottom: 18px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th, td {
                            border: 1px solid #ccc;
                            padding: 6px;
                            text-align: left;
                            vertical-align: top;
                        }

                        th {
                            background: #f2f2f2;
                            font-weight: bold;
                        }

                        .badge {
                            background: transparent !important;
                            color: #111 !important;
                            padding: 0 !important;
                        }

                        .bg-dark {
                            background: #111 !important;
                            color: #fff !important;
                        }
                    </style>
                </head>
                <body>
                   

                    <div class="subtitulo">
                        Desde: <?php echo e($fechaInicioMes); ?> |
                        Hasta: <?php echo e($fechaActual); ?> |
                        Área: <?php echo e($sucursal ?: 'Todas'); ?> |
                        Comprobante: <?php echo e($filtroComprobante); ?> |
                    </div>

                    ${tabla.outerHTML}

                    <script>
                        window.onload = function() {
                            window.print();
                        }
                    <\/script>
                </body>
            </html>
        `);

        ventana.document.close();
    }
    </script>

</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tesoreria/egreso-interno.blade.php ENDPATH**/ ?>