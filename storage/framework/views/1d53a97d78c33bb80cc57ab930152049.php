<div>
    <?php

    ?>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link <?php if($opcion == 0): ?> active <?php endif; ?>" data-toggle="tab"
                wire:click="setOpcion(0)">Caja</a></li>
        <li class="nav-item"><a class="nav-link <?php if($opcion == 1): ?> active <?php endif; ?>" data-toggle="tab"
                wire:click="setOpcion(1)">Detalle</a>
        </li>
        <li class="nav-item"><a class="nav-link <?php if($opcion == 1): ?> active <?php endif; ?>" data-toggle="tab"
                wire:click="setOpcion(2)">Funciones</a>
        </li>
    </ul>
    <div class="mt-3 tab-content" style="overflow-y: auto;">
        <?php if($opcion == 0): ?>
            <div class="tab-pane fade show active" id="righttab-statistics" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Fechas:</h3>
                            <button class="btn btn-warning" wire:click='actualizar'>Actualizar</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center row">
                            <div class="col-6 border-right d-flex flex-column align-items-center">
                                <label class="mb-0">Inicio</label>
                                <div class="font-weight-bold">
                                    <input style="width: 100%;font-size:10px;" type="date" id="fecha-inicio"
                                        wire:model="fechaInicioMes" class="text-start">
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column align-items-center">
                                <label class="mb-0">Fin</label>
                                <div class="font-weight-bold">
                                    <input style="width: 100%;font-size:10px;" type="date" id="fecha-actual"
                                        wire:model="fechaActual" class="text-start">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>Ingreso suc.: <?php echo e(Auth::user()->sucursal); ?></div>
                        <div class="text-center h1 text-success">Bs.
                            <?php echo e($total_inventario_g + $total_monto_g + $total_inventario_qr); ?>

                        </div>
                        <?php if($existecaja == false): ?>
                            <button style="width: 100%"wire:click="registrarcaja" class="btn btn-primary">Cerrar
                                caja</button>
                        <?php else: ?>
                            <label for="" style="font-size:15px;"><strong>CAJA CERRADA</strong></label>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <ul class=" list-unstyled">
                            <li class="">
                                <div class="clearfix">
                                    <div class="float-left"><strong>Bs. <?php echo e($total_monto_g); ?></strong></div>
                                    <div class="float-right"><small class="text-muted">Ingreso
                                            hospedaje</small>
                                    </div>
                                </div>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar bg-azure" role="progressbar" style="width: 100%"
                                        aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li>
                                <div class="clearfix">
                                    <div class="float-left"><strong>Bs.
                                            <?php echo e($total_inventario_g + $total_inventario_qr); ?></strong></div>
                                    <div class="float-right"><small class="text-muted">Ingreso
                                            productos</small>
                                    </div>

                                </div>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar bg-azure" role="progressbar" style="width: 100%"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li>
                                <div class="clearfix">
                                    <div class="float-left"><strong>Bs. <?php echo e($gastoarea_g); ?></strong></div>
                                    <div class="float-right"><small class="text-muted">Gastos</small>
                                    </div>

                                </div>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar bg-red" role="progressbar" style="width: 100%"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li>
                                <div class="clearfix">
                                    <div class="float-left"><strong>Bs.
                                            <?php echo e($total_inventario_g + $total_monto_g + $total_inventario_qr - $gastoarea_g); ?></strong>
                                    </div>
                                    <div class="float-right"><small class="text-muted">Cuadre general</small>
                                    </div>

                                </div>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar bg-green" role="progressbar" style="width: 100%"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li>
                                <div class="clearfix">
                                    <div class="float-left"><strong>Bs.
                                            <?php echo e($total_monto_cita_efectivo + $total_inventario_g - $gastoarea_g); ?></strong>
                                    </div>
                                    <div class="float-right"><small class="text-muted">Dinero en caja</small>
                                    </div>

                                </div>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar bg-green" role="progressbar" style="width: 100%"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if($opcion == 1): ?>
            <div class="tab-pane fade show active" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingreso hospedaje</h3>
                        <div class="card-options">
                            <a href="#"><i class="fa fa-file-excel-o" data-toggle="tooltip"
                                    title="Export Excel"></i></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center row">
                            <div class="col-6 border-right">
                                <label class="mb-0">QR</label>
                                <div class="font-10 font-weight-bold">Bs. <?php echo e($total_monto_cita_qr); ?></div>
                            </div>
                            <div class="col-6">
                                <label class="mb-0">Efectivo</label>
                                <div class="font-10 font-weight-bold">Bs.<?php echo e($total_monto_cita_efectivo); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Prod. Vendidos</h3>
                        <div class="card-options">
                            <a href="#"><i class="fa fa-file-excel-o" data-toggle="tooltip"
                                    title="Export Excel"></i></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center row">
                            <div class="col-6 border-right">
                                <label class="mb-0">QR</label>
                                <div class="font-10 font-weight-bold">Bs. <?php echo e($total_inventario_qr_g); ?></div>
                            </div>
                            <div class="col-6">
                                <label class="mb-0">Efectivo</label>
                                <div class="font-10 font-weight-bold">Bs.<?php echo e($total_inventario_g); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingreso total</h3>
                    </div>
                    <div class="card-footer">
                        <div class="text-center row">
                            <div class="col-6 border-right">
                                <label class="mb-0">QR</label>
                                <div class="font-10 font-weight-bold">Bs.
                                    <?php echo e($total_inventario_qr_g + $total_monto_cita_qr); ?></div>
                            </div>
                            <div class="col-6">
                                <label class="mb-0">Efectivo</label>
                                <div class="font-10 font-weight-bold">
                                    Bs.<?php echo e($total_inventario_g + $total_monto_cita_efectivo); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-yellow"><i class="fa fa-sun-o"></i> </div>
                        <div class="content">
                            <span>Turno mañana</span>
                            <h6 class="mb-0 number"><?php echo e($turnomanana); ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-pink"><i class="fa fa-moon-o"></i> </div>
                        <div class="content">
                            <span>Turno tarde</span>
                            <h6 class="mb-0 number"><?php echo e($turnotarde); ?></h6>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if($opcion == 2): ?>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Fechas:</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center row">
                        <div class="col-6 border-right d-flex flex-column align-items-center">
                            <label class="mb-0">Inicio</label>
                            <div class="font-weight-bold">
                                <input style="width: 100%;font-size:10px;" type="date" id="fecha-inicio"
                                    wire:model="fechaInicioMes" class="text-start">
                            </div>
                        </div>
                        <div class="col-6 d-flex flex-column align-items-center">
                            <label class="mb-0">Fin</label>
                            <div class="font-weight-bold">
                                <input style="width: 100%;font-size:10px;" type="date" id="fecha-actual"
                                    wire:model="fechaActual" class="text-start">
                            </div>
                        </div>
                    </div>
                    <button style="width: 100%;" class="mt-4 btn btn-warning" wire:click="imprimirResultado">Imprimir
                        registro actual</button>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/tesoreria/micaja.blade.php ENDPATH**/ ?>