<div class="card shadow-sm">

    <!-- 🔥 HEADER -->
    <div class="card-header border-0 pt-5">

        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-building me-2"></i> Gestión de Departamentos
            </h3>
            <span class="text-muted small">
                Administración de departamentos, ocupación y accesos
            </span>
        </div>

    </div>

    <!-- 🔥 BODY -->
    <div class="card-body pt-0">

        <!-- 🔥 TABS -->
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">

            <li class="nav-item">
                <a class="nav-link <?php echo e($opcion == 'departamento' ? 'active' : ''); ?>"
                    wire:click="$set('opcion','departamento')">
                    <i class="bi bi-building me-1"></i>
                    Lista de Departamentos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo e($opcion == 'ocupacion' ? 'active' : ''); ?>"
                    wire:click="$set('opcion','ocupacion')">
                    <i class="bi bi-people me-1"></i>
                    Gestión de ocupación
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo e($opcion == 'acceso' ? 'active' : ''); ?>" wire:click="$set('opcion','acceso')">
                    <i class="bi bi-shield-check me-1"></i>
                    Gestión de acceso a áreas
                </a>
            </li>

        </ul>

        <!-- 🔥 CONTENIDO -->
        <div class="tab-content">
            <?php switch($opcion):
                case ('departamento'): ?>
                    <!-- ===================== TAB 1 ===================== -->
                    <div class="">

                        <!-- TU CÓDIGO ORIGINAL -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>
                                    <h5 class="fw-bold mb-1">

                                    </h5>
                                    <span class="text-muted small">

                                    </span>
                                </div>

                                <!-- BOTÓN CREAR -->
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.crear-tratamiento')->html();
} elseif ($_instance->childHasBeenRendered('l381761563-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l381761563-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l381761563-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l381761563-0');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.crear-tratamiento');
    $html = $response->html();
    $_instance->logRenderedChild('l381761563-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                            </div>
                            <!-- HEADER -->


                            <!-- BUSCADOR -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" class="form-control ps-10" wire:model.debounce.500ms="busqueda"
                                            placeholder="Buscar departamento...">
                                    </div>
                                </div>
                            </div>

                            <!-- TABLA -->
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-hover align-middle">

                                    <thead class="fw-bold text-muted">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Costo</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $__empty_1 = true; $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>

                                                <td class="fw-semibold">
                                                    <?php echo e($lista->nombre); ?>

                                                </td>

                                                <td>
                                                    <span class="badge bg-light-primary text-dark">
                                                        <?php echo e($lista->TIPO); ?>

                                                    </span>
                                                </td>

                                                <td style="max-width: 250px;">
                                                    <span class="text-muted d-block text-truncate">
                                                        <?php echo e($lista->descripcion ?: 'SIN DATOS'); ?>

                                                    </span>
                                                </td>

                                                <td class="fw-bold text-success">
                                                    Bs <?php echo e(number_format($lista->costo, 2)); ?>

                                                </td>

                                                <td>
                                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                        'badge',
                                                        'bg-success' => $lista->estado == 'Activo',
                                                        'bg-danger' => $lista->estado == 'Inactivo',
                                                        'bg-warning' => $lista->estado == 'Pendiente',
                                                    ]); ?>">
                                                        <?php echo e($lista->estado); ?>

                                                    </span>
                                                </td>

                                                <td>
                                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.vista-tratamiento', ['idtratamiento' => $lista->id])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('tratamientos.vista-tratamiento', ['idtratamiento' => $lista->id]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                </td>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-5">
                                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                    No hay departamentos registrados
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                <?php break; ?>

                <?php case ('ocupacion'): ?>
                    <!-- ===================== TAB 2 ===================== -->
                    <div class="">

                        <div>

                            <!-- 🔥 HEADER + BOTÓN -->
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>
                                    <h5 class="fw-bold mb-1">

                                    </h5>
                                    <span class="text-muted small">

                                    </span>
                                </div>

                                <!-- BOTÓN CREAR -->
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                                    data-bs-target="#modalOcupacion" wire:click="$set('modalOcupacion',true)">
                                    <i class="bi bi-person-plus"></i>
                                    Registrar persona
                                </button>

                            </div>

                            <!-- 🔥 TABLA -->
                            <div class="table-responsive">

                                <table class="table table-row-bordered table-hover align-middle">

                                    <thead class="fw-bold text-muted bg-light">
                                        <tr>
                                            <th>Departamento</th>
                                            <th>Nombre</th>
                                            <th>CI</th>
                                            <th>Edad</th>
                                            <th>Tipo</th>
                                            <th>Fecha de inicio</th>
                                            <th>Fecha desalojo</th>
                                            <th>Estado</th>
                                            <th class="text-end">Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $__empty_1 = true; $__currentLoopData = $ocupaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>

                                                <!-- DEPARTAMENTO -->
                                                <td class="fw-semibold">
                                                    <?php
                                                        $depto = \App\Models\Tratamiento::find($o->tratamiento_id);
                                                    ?>
                                                    <?php echo e($depto->nombre ?? '---'); ?>

                                                </td>

                                                <!-- NOMBRE -->
                                                <td><?php echo e($o->nombre); ?></td>

                                                <!-- CI -->
                                                <td><?php echo e($o->ci); ?></td>

                                                <!-- EDAD -->
                                                <td><?php echo e($o->edad ?? '-'); ?></td>

                                                <!-- TIPO -->
                                                <td>
                                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                        'badge',
                                                        'bg-primary' => $o->tipo == 'dueno',
                                                        'bg-warning text-dark' => $o->tipo == 'inquilino',
                                                        'bg-info text-dark' => $o->tipo == 'habitante',
                                                    ]); ?>">
                                                        <?php echo e(strtoupper($o->tipo)); ?>

                                                    </span>

                                                    <?php if($o->tipo == 'habitante' && $o->parentesco): ?>
                                                        <div class="text-muted small">
                                                            <?php echo e($o->parentesco); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- FECHA INICIO -->
                                                <td>
                                                    <?php echo e(\Carbon\Carbon::parse($o->fecha_inicio)->format('d/m/Y')); ?>

                                                </td>

                                                <!-- FECHA FIN -->
                                                <td>
                                                    <?php if($o->fecha_fin): ?>
                                                        <span class="text-danger">
                                                            <?php echo e(\Carbon\Carbon::parse($o->fecha_fin)->format('d/m/Y')); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- ESTADO -->
                                                <td>
                                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                        'badge',
                                                        'bg-success' => $o->estado == 'Activo',
                                                        'bg-danger' => $o->estado == 'Inactivo',
                                                    ]); ?>">
                                                        <?php echo e($o->estado); ?>

                                                    </span>
                                                </td>

                                                <!-- ACCIONES -->
                                                <td class="text-end">

                                                    <button class="btn btn-sm btn-light-warning"
                                                        wire:click="editarOcupacion(<?php echo e($o->id); ?>)">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                </td>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-5">
                                                    <i class="bi bi-person-lines-fill fs-2 d-block mb-2"></i>
                                                    No hay registros de ocupación
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                <?php break; ?>

                <?php case ('acceso'): ?>
                    <!-- ===================== TAB 3 ===================== -->
                    <div class="">

                        <div class="card shadow-sm">
                            <!-- BUSCADOR -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" class="form-control ps-10" wire:model.debounce.500ms="busqueda"
                                            placeholder="Buscar departamento...">
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">

                                <table class="table table-bordered align-middle text-center">

                                    <thead class="bg-light fw-bold">

                                        <tr>
                                            <th class="text-start">Departamento</th>

                                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th>
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    <?php echo e($area->area); ?>

                                                </th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php $__empty_1 = true; $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>

                                                <!-- NOMBRE DEPTO -->
                                                <td class="text-start fw-semibold">
                                                    <?php echo e($t->nombre); ?>

                                                </td>

                                                <!-- AREAS -->
                                                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td>

                                                        <div class="form-check d-flex justify-content-center">

                                                            <input type="checkbox" class="form-check-input"
                                                                wire:click="toggleArea(<?php echo e($t->id); ?>, <?php echo e($area->id); ?>)"
                                                                <?php echo e(isset($permisos[$t->id][$area->id]) ? 'checked' : ''); ?>>

                                                        </div>

                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                            <tr>
                                                <td colspan="<?php echo e(count($areas) + 1); ?>" class="text-muted py-5">
                                                    No hay departamentos
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>
                <?php break; ?>

            <?php endswitch; ?>
        </div>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'modalOcupacion']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'modalOcupacion']); ?>

            <!-- HEADER -->
            <div class="px-6 pt-5 pb-3 border-bottom">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-person-plus me-2"></i>
                    Registrar ocupante
                </h4>
                <span class="text-muted small">
                    Datos del residente del departamento
                </span>
            </div>

            <!-- BODY -->
            <div class="px-6 py-4">

                <div class="row g-4">

                    <!-- DEPARTAMENTO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Departamento</label>
                        <select class="form-select" wire:model.defer="departamento_id">
                            <option value="">Seleccionar</option>
                            <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>"><?php echo e($t->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- TIPO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tipo de ocupación</label>
                        <select class="form-select" wire:model.defer="tipo">
                            <option value="">Seleccionar</option>
                            <option value="dueno">Dueño principal</option>
                            <option value="inquilino">Inquilino</option>
                            <option value="habitante">Habitante</option>
                        </select>
                    </div>

                    <!-- NOMBRE -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre completo</label>
                        <input type="text" class="form-control" wire:model.defer="nombre">
                    </div>

                    <!-- CI -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Carnet de identidad</label>
                        <input type="text" class="form-control" wire:model.defer="ci">
                    </div>

                    <!-- EDAD -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Edad</label>
                        <input type="number" class="form-control" wire:model.defer="edad">
                    </div>

                    <!-- TEL -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" class="form-control" wire:model.defer="telefono">
                    </div>

                    <!-- ESTADO -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Estado</label>
                        <select class="form-select" wire:model.defer="estado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <!-- FECHA INICIO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha inicio</label>
                        <input type="date" class="form-control" wire:model.defer="fecha_inicio">
                    </div>

                    <!-- PARENTESCO -->
                    <?php if($tipo == 'habitante'): ?>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Parentesco</label>
                            <select class="form-select" wire:model.defer="parentesco">
                                <option value="">Seleccionar</option>
                                <option>Esposo</option>
                                <option>Esposa</option>
                                <option>Hijo</option>
                                <option>Hija</option>
                                <option>Primo</option>
                                <option>Prima</option>
                                <option>Tío</option>
                                <option>Tía</option>
                                <option>Abuelo</option>
                                <option>Abuela</option>
                                <option>Otro</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Imágenes del ocupante</label>

                        <input type="file" class="form-control" multiple wire:model="imagenes">

                        <span class="text-muted small">
                            Puede subir varias imágenes (documentos, rostro, etc.)
                        </span>
                    </div>
                    <?php if($imagenes): ?>
                        <div class="row mt-3">
                            <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3 text-center">

                                    <img src="<?php echo e($img->temporaryUrl()); ?>" class="img-fluid rounded shadow mb-2"
                                        style="height:120px; object-fit:cover;">

                                    <button class="btn btn-sm btn-danger"
                                        wire:click="quitarImagen(<?php echo e($index); ?>)">
                                        Quitar
                                    </button>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($imagenesExistentes): ?>
                        <div class="row mt-3">

                            <?php $__currentLoopData = $imagenesExistentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3 text-center">

                                    <img src="<?php echo e(asset('storage/' . $img->ruta)); ?>"
                                        class="img-fluid rounded shadow mb-2" style="height:120px; object-fit:cover;">

                                    <button class="btn btn-sm btn-danger"
                                        wire:click="eliminarImagen(<?php echo e($img->id); ?>)">
                                        Eliminar
                                    </button>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-4 border-top d-flex justify-content-end gap-2">

                <button class="btn btn-light" wire:click="$set('modalOcupacion',false)">
                    Cancelar
                </button>

                <button class="btn btn-success d-flex align-items-center gap-2"
                    wire:click="<?php echo e($editando ? 'actualizarOcupacion' : 'guardarOcupacion'); ?>">

                    <i class="bi bi-check-circle"></i>
                    Guardar
                </button>

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
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/livewire/tratamientos/lista-tratamientos.blade.php ENDPATH**/ ?>