<div>
    <div class="px-4 section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Inicio</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><?php echo e(Auth::user()->sucursal); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 4): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-habitacion" wire:click="setOpcion(4)">Departamentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($opcion == 0): ?> active <?php endif; ?>" data-toggle="tab"
                            href="#admin-Dashboard" wire:click="setOpcion(0)">Registrados(<?php echo e($agendados); ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PANEL DE REGISTRO DE PAGOS: </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Búsqueda: </label>
                        <input type="text" class="form-control" wire:model="busqueda"
                            placeholder="Buscar departamento...">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div style="margin-right: 1%; ">
                                <label for="fecha-inicio">Desde:</label>
                                <input style="" type="date" id="fecha-inicio" class="form-control"
                                    wire:model="fechaInicioMes">
                            </div>
                            <div style="margin-right: 1%; ">
                                <label for="fecha-actual">Hasta:</label>
                                <input style="" type="date" id="fecha-actual" class="form-control"
                                    wire:model="fechaActual">
                            </div>
                        </div>
                    </div>

                </div>
                <?php if($opcion == 0): ?>


                    <div class="table-responsive">
                        <table class="table mb-0 table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>COPROPIETARIO</th>
                                    <th>COMENTARIO</th>
                                    <th>HOSPEDAJE</th>
                                    <th>DEPARTAMENTO(S)</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $llamadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="text-muted">Nombre:<?php echo e($lista->empresa); ?></div>
                                            <div class="text-muted">Teléfono:<?php echo e($lista->telefono); ?></div>
                                            <div class="text-muted">CI:<?php echo e($lista->ci); ?></div>
                                        </td>
                                        <td>
                                            <?php echo e($lista->comentario); ?>

                                        </td>
                                        <td>
                                            <div class="text-muted">Hora de entrada:  <?php echo e($lista->hora); ?></div>
                                            <div class="text-muted">Fecha de entrada:  <?php echo e($lista->fecha); ?></div>
                                            <div class="text-muted">Fecha de salida:  <?php echo e($lista->fechafin); ?></div>
                                        </td>
                                        <?php
                                            $historial = DB::table('historial_clientes')
                                                ->where('idoperativo', $lista->id)
                                                ->get();
                                        ?>
                                        <td>
                                            <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($historia->nombretratamiento . '/'); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('operativos.editar-operativo', ['operativo' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($llamadas->links()); ?>

                    </div>
                <?php endif; ?>
                <?php if($opcion == 4): ?>
                    <div class="">
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado => $titulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $habitacionesEstado = $habitaciones->where('estado', $estado);
                            ?>

                            <?php if($habitacionesEstado->count() > 0): ?>
                                <h2 class="mt-2"><?php echo e($titulo); ?></h2>
                                <div class="row">
                                    <?php $__currentLoopData = $habitacionesEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $habitacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2 col-3">
                                            <div class="card"
                                                style="width:80%; background-color:
                                             <?php echo e($habitacion->estado == 'Activo'
                                                 ? '#28a745'
                                                 : ($habitacion->estado == 'Ocupado'
                                                     ? '#ffc107'
                                                     : ($habitacion->estado == 'mantenimiento'
                                                         ? '#dc3545'
                                                         : ($habitacion->estado == 'limpieza'
                                                             ? '#007bff'
                                                             : ($habitacion->estado == 'reservado'
                                                                 ? '#ff9800'
                                                                 : ''))))); ?>;">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo e($habitacion->nombre); ?></h5>
                                                    <p>Capacidad: <?php echo e($habitacion->capacidad); ?> mt2</p>
                                                    <div style="display:flex;">

                                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.crear-cliente', ['idhabitacion' => $habitacion->id])->html();
} elseif ($_instance->childHasBeenRendered($habitacion->id)) {
    $componentId = $_instance->getRenderedChildComponentId($habitacion->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($habitacion->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($habitacion->id);
} else {
    $response = \Livewire\Livewire::mount('clientes.crear-cliente', ['idhabitacion' => $habitacion->id]);
    $html = $response->html();
    $_instance->logRenderedChild($habitacion->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/recepcionista/lista-recepcion.blade.php ENDPATH**/ ?>