<div>

    <style>
        .fixed-button-x {

            right: 0px;
            bottom: 18%;
            padding: 15px;
            /* Igual padding en todas las direcciones */
            background-color: green;
            color: white;
            border: none;
            border-radius: 5%;
            /* Hace que el botón sea redondo */
            cursor: pointer;
            z-index: 9999;
            width: 150px;
            margin: 1%;
            height: 25px;
            /* Asegura que el botón esté delante de otros elementos */
        }

        @media (max-width: 900px) {
            .fixed-button-x {
                width: 50px;
            }

            .fixed-button-x span {
                display: none;
                /* Oculta la palabra "REGISTRO" */
            }
        }
    </style>
    <button class="fixed-button-x" style="display: flex; align-items: center;" wire:click="$set('openAreaGasto',true)"><i
            class="icon">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z"
                    fill="currentColor"></path>
            </svg>
        </i><span style="margin-left: 5px;">GASTO</span></button>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'openAreaGasto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'openAreaGasto']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Añadir gasto interno
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <label class="form-label" for="">Seleccione sucursal: </label>
                    <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="sucursal">
                        <option value="">Seleccione sucursal
                        </option>
                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->area); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label class="form-label" for="">Tipo de egreso: </label>
                    <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model.="tipogasto">
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
                        <option value="OTRO">OTRO</option>
                    </select>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de egreso:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model="fechagasto">
                    </div>
                    <label class="form-label" for="">Metodo de pago: </label>
                    <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="modopago">
                        <option value="Qr">QR</option>
                        <option value="Efectivo">Efectivo</option>
                    </select>
                    <label class="form-label" for="">Cartera de egreso: </label>
                    <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="cartera">
                        <option value="Caja">Caja central</option>
                        <option value="Externo">Externo</option>
                    </select>

                    <div class="form-group">
                        <label class="form-label" for="">Monto del egreso:</label>
                        <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="montoegreso">
                    </div>
                    <?php if($tipogasto == 'SUELDO'): ?>
                        <div class="mb-2 form-group">
                            <label class="form-label" for="">Seleccionar destinario: </label>
                            <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="destinario">
                                <option>Seleccionar usuario </option>
                                <?php $__currentLoopData = $usersl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($area->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if($tipogasto == 'Bono'): ?>
                        <div class="mb-2 form-group">
                            <label class="form-label" for="">Seleccionar destinario: </label>
                            <select class="mb-3 shadow-none form-select form-select-smmt-5" wire:model="destinario">
                                <option>Seleccionar usuario </option>
                                <?php $__currentLoopData = $usersl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($area->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="form-label" for="">Especifique el egreso (Opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="comentario">
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
            <label type="submit" class="btn btn-success" wire:click="confirmar">Guardar</label>
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
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/tesoreria/egreso.blade.php ENDPATH**/ ?>