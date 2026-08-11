<div>

    <!-- ❌ ELIMINADO (NO NECESARIO Y LENTO)
    script click automático -->

    <div class="px-4 py-3">

        <!-- 🔥 TÍTULO -->
        <h4 class="mb-4 fw-bold text-dark">
            REGISTRO DE GASTO
        </h4>

        <form>

            <!-- 🔥 FILA PRINCIPAL -->
            <div class="row g-3">

                <!-- SUCURSAL -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Area</label>
                    <select class="form-select" wire:model="sucursal">
                        <option value="">Seleccione</option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- TIPO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tipo de egreso</label>
                    <select class="form-select" wire:model="tipogasto">
                        <option value="">Seleccionar</option>
                        <option value="AGUA POTABLE">AGUA POTABLE</option>
                        <option value="ALQUILER">ALQUILER</option>
                        <option value="GAS">GAS</option>
                        <option value="IMPUESTOS">IMPUESTOS</option>
                        <option value="LUZ ELECTRICA">LUZ ELECTRICA</option>
                        <option value="INTERNET/TEL">INTERNET/TEL</option>
                        <option value="ADELANTO AL PERSONAL">ADELANTO AL PERSONAL</option>
                        <option value="MATERIAL CAFETERIA">MATERIAL CAFETERIA</option>
                        <option value="MATERIAL ESCRITORIO">MATERIAL ESCRITORIO</option>
                        <option value="MATERIAL LIMPIEZA">MATERIAL LIMPIEZA</option>
                        <option value="MATERIAL DE PROCEDIMIENTOS">MATERIAL DE PROCEDIMIENTOS</option>
                        <option value="MATERIAL PARA EVENTOS">MATERIAL PARA EVENTOS</option>
                        <option value="MATERIAL PARA MANTENIMIENTO">MATERIAL PARA MANTENIMIENTO</option>
                        <option value="MANTENIMIENTO DE EQUIPOS">MANTENIMIENTO DE EQUIPOS</option>
                        <option value="MANTENIMIENTO DE SUCURSAL">MANTENIMIENTO DE SUCURSAL</option>
                        <option value="COMPRA DE EQUIPO">COMPRA DE EQUIPO</option>
                        <option value="COMPRA DE MUEBLE">COMPRA DE MUEBLE</option>
                        <option value="MERIENDAS">MERIENDAS</option>
                        <option value="PUBLICIDAD">PUBLICIDAD</option>
                        <option value="SERVICIOS PROFESIONALES">SERVICIOS PROFESIONALES</option>
                        <option value="TRAMITES">TRAMITES</option>
                        <option value="TRANSPORTE">TRANSPORTE</option>
                        <option value="SUELDO">PAGO SUELDO</option>
                    </select>
                </div>

                <!-- FECHA -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Fecha</label>
                    <input type="date" class="form-control" wire:model="fechagasto">
                </div>

                <!-- CARTERA -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Cartera</label>
                    <select class="form-select" wire:model="cartera">
                        <option value="Caja">Caja central</option>
                        <option value="Externo">Externo</option>
                    </select>
                </div>

                <!-- MONTO -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Monto (Bs)</label>
                    <input type="number" class="form-control" wire:model="montoegreso">
                </div>

                <!-- DESTINATARIO -->
                <?php if($tipogasto == 'SUELDO' || $tipogasto == 'Bono'): ?>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Destinatario</label>
                        <select class="form-select" wire:model="destinario">
                            <option>Seleccionar usuario</option>
                            <?php $__currentLoopData = $usersl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($area->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- MÉTODO -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Método de pago</label>
                    <select class="form-select" wire:model="modopago">
                        <option value="Qr">QR</option>
                        <option value="Efectivo">Efectivo</option>
                    </select>
                </div>

            </div>

            <!-- 🔥 COMENTARIO -->
            <div class="mt-3 row">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Detalle (Opcional)</label>
                    <input type="text" class="form-control" wire:model="comentario">
                </div>
            </div>

            <!-- 🔥 USUARIO -->
            <div class="mt-3 row">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Registrado por</label>
                    <input type="text" class="form-control" disabled value="<?php echo e(Auth::user()->name); ?>">
                </div>
            </div>

        </form>
    </div>

    <!-- 🔥 BOTÓN -->
    <div class="px-4 pb-3 text-end">
        <button class="px-4 shadow-sm btn btn-success" wire:click="confirmar">
            <i class="mdi mdi-content-save"></i> Guardar
        </button>
    </div>

</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/tesoreria/egreso.blade.php ENDPATH**/ ?>