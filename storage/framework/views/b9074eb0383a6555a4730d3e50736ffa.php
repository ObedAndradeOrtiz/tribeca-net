<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
          REGISTRO DE  GASTO
        </div>
        <div class="mt-4 text-sm text-gray-600">
            <form>
                <!-- Sucursal y Tipo de egreso -->
                <div class="row">
                    <div class="col-md-3 form-group mr-3">
                        <label class="form-label" for="">Seleccione sucursal:</label>
                        <select class="mb-3 shadow-none form-select form-select-sm" wire:model="sucursal">
                            <option value="">Seleccione sucursal</option>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="">Tipo de egreso:</label>
                        <select class="mb-3 shadow-none form-select form-select-sm" wire:model="tipogasto">
                            <option>Seleccionar:</option>
                            <option value="AGUA POTABLE">AGUA POTABLE</option>
                            <option value="ALQUILER">ALQUILER</option>
                            <option value="GAS">GAS</option>
                            <option value="IMPUESTOS">IMPUESTOS</option>
                            <option value="LUZ ELECTRICA">LUZ ELECTRICA</option>
                            <option value="INTERNET/TEL">INTERNET/TEL</option>
                            <option value="Dra. PAOLA">Dra. PAOLA</option>
                            <option value="Sr. ALEXANDRE">Sr. ALEXANDRE</option>
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
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de egreso:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model="fechagasto">
                    </div>
                </div>
                <!-- Cartera de egreso y Monto del egreso -->
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="">Cartera de egreso:</label>
                        <select class="mb-3 shadow-none form-select form-select-sm" wire:model="cartera">
                            <option value="Caja">Caja central</option>
                            <option value="Externo">Externo</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="">Monto del egreso:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="montoegreso">
                    </div>
                    <?php if($tipogasto == 'SUELDO' || $tipogasto == 'Bono'): ?>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="">Seleccionar destinario:</label>
                            <select class="mb-3 shadow-none form-select form-select-sm" wire:model="destinario">
                                <option>Seleccionar usuario</option>
                                <?php $__currentLoopData = $usersl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($area->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="">Método de pago:</label>
                        <select class="mb-3 shadow-none form-select form-select-sm" wire:model="modopago">
                            <option value="Qr">QR</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="form-label" for="">Especifique el egreso (Opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="comentario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="form-label" for="exampleInputDisabled1">Registrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled
                            value="<?php echo e(Auth::user()->name); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
        <label type="submit" class="btn btn-success" style="background-color: green;" wire:click="confirmar">Guardar</label>
    </div>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/tesoreria/egreso.blade.php ENDPATH**/ ?>