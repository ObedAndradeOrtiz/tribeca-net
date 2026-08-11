<div style="overflow-x: hidden;">
    <?php
    $rolesderol = DB::table('roles_vistas')
        ->where('namerol', 'LIKE', '%' . Auth::user()->rol)
        ->where('estado', 'Activo')
        ->get();
    ?>

    <body class="font-muli theme-cyan gradient">

        <div id="main_content">
            <div id="header_top" class="header_top">
                <div class="container">
                    <div class="hleft">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i
                                    class="fe fe-align-center"></i></a>


                            <a href="/comprar" class="nav-link icon">
                                <div>
                                    <i class="fa fa-credit-card-alt" aria-hidden="true" title="NUEVA COMPRA"></i><label
                                        style="font-size: 8px;">Comprar</label>
                                </div>
                            </a>
                            <a href="/vender" class="nav-link icon">
                                <div>
                                    <i class="fa fa-cart-plus" aria-hidden="true" title="AGREGAR VENTA"></i><label
                                        style="font-size: 8px;">Venta</label>
                                </div>
                            </a>


                            <a href="/gastos" class="nav-link icon">
                                <div>
                                    <i class="fa fa-money" aria-hidden="true" title="AGREGAR GASTO"></i><label
                                        style="font-size: 8px;">Gasto</label>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="hright">
                        <a id="myButton" href="javascript:void(0)" class="nav-link icon right_tab"><i
                                class="fe fe-align-right"></i></a>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                document.getElementById('myButton').click();
                            }, 1);
                        });
                    </script>
                </div>
            </div>
            <div class="user_div">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.micaja')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.micaja');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            <div id="left-sidebar" class="sidebar">
                <h5 class="brand-name">HOTEL ROJAS<a href="javascript:void(0)" class="float-right menu_option"><i
                            class="icon-grid font-16" data-toggle="tooltip" data-placement="left"
                            title="Grid & List Toggle"></i></a></h5>
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu-uni">Personal</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu-admin">Administrador</a>
                    </li>
                </ul>
                <div class="mt-3 tab-content">
                    <div class="tab-pane fade show active" id="menu-uni" role="tabpanel">
                        <nav class="sidebar-nav">
                            <ul class="metismenu">
                                <li class=""><a href="/dashboard"><i
                                            class="fa fa-dashboard"></i><span>Inicio</span></a></li>
                                <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->vista == 'Empleados'): ?>
                                        <li><a href="/usuarios"><i
                                                    class="fa fa-user-circle-o"></i><span>Usuarios</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($item->vista == 'Clientes'): ?>
                                        <li><a href="/clientes"><i class="fa fa-users"></i><span>Clientes</span></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <li class="g_heading">Asistencia</li>
                                <?php if(Auth::user()->rol == 'Jefe Marketing y Publicidad' || Auth::user()->rol == 'Editor'): ?>
                                    <li><a href="/estadisticas"><i class="fa fa-line-chart" aria-hidden="true"></i>
                                            <?php echo e(__('Estadisticas')); ?>

                                        </a>
                                        
                                <?php endif; ?>
                                <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if($item->vista == 'Recepcion'): ?>
                                        <li><a href="/recepcion"><i class="fa fa-calendar"></i><span>Agenda</span></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                
                            </ul>
                        </nav>
                    </div>
                    <div class="tab-pane fade" id="menu-admin" role="tabpanel">
                        <nav class="sidebar-nav">
                            <ul class="metismenu">
                                <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->vista == 'Administrador'): ?>
                                        <li><a href="/administrador"><i class="fa fa-user-plus" aria-hidden="true"></i>
                                                <?php echo e(__('Administrador')); ?>

                                        </li></a>
                                        <li><a href="/registros"><i class="fa fa-server" aria-hidden="true"></i>
                                                <?php echo e(__('Registros')); ?>

                                        </li></a>
                                        <li><a href="/estadisticas"><i class="fa fa-line-chart" aria-hidden="true"></i>
                                                <?php echo e(__('Estadísticas')); ?>

                                        </li></a>
                                        
                                        <li><a href="/tesoreria"><i class="fa fa-university" aria-hidden="true"></i>
                                                <?php echo e(__('Tesorería')); ?>

                                        </li></a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->vista == 'Tratamientos'): ?>
                                        <li><a href="/habitaciones"><i class="fa fa-bed" aria-hidden="true"></i>
                                                <?php echo e(__('Habitaciones')); ?>

                                        </li></a>
                                    <?php endif; ?>
                                    <?php if($item->vista == 'Inventario'): ?>
                                        <li><a href="/inventario"><i class="fa fa-bookmark" aria-hidden="true"></i>
                                                <?php echo e(__('Inventario')); ?>

                                        </li></a>
                                        <li><a href="/inventario-inmueble"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i>
                                                <?php echo e(__('Activos')); ?>

                                        </li></a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(Auth::user()->rol == 'Contador'): ?>
                                    <li><a href="/tesoreria"><i class="fa fa-university" aria-hidden="true"></i>
                                            <?php echo e(__('Tesorería')); ?>

                                    </li></a>
                                    <li><a href="/registros"><i class="fa fa-server" aria-hidden="true"></i>
                                            <?php echo e(__('Registros')); ?>

                                    </li></a>
                                    <li><a href="/estadisticas">
                                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                                            <?php echo e(__('Estadisticas')); ?>

                                    </li></a>
                                    
                                <?php endif; ?>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="section-body" id="page_top">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="left">
                                <div class="input-group">
                                    Sistema de: <?php echo e(Auth::user()->sucursal); ?>

                                </div>
                            </div>
                            <div class="right">
                                <ul class="nav nav-pills">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false">Cambiar de
                                            suc.</a>
                                        <div class="dropdown-menu">
                                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a class="dropdown-item" href="/dashboard/<?php echo e($area->id); ?>">
                                                    <?php echo e($area->area); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $rolesderol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($item->vista == 'Administrador'): ?>
                                                    <a class="dropdown-item" href="/areas">
                                                        Configuración
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </li>
                                </ul>
                                <div class="notification d-flex">
                                    <div>
                                        <a href="javascript:void(0)" class="ml-3 chip" data-toggle="dropdown">
                                            <?php echo e(Auth::user()->rol); ?></a>
                                    </div>
                                    <div class="dropdown d-flex">
                                        <a href="javascript:void(0)" class="ml-3 chip" data-toggle="dropdown">

                                            <?php echo e(explode(' ', Auth::user()->name)[0]); ?></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i
                                                    class="dropdown-icon fe fe-user"></i> Perfil</a>
                                            <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                                <?php echo csrf_field(); ?>
                                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                                    @click.prevent="$root.submit();">
                                                    <i class="dropdown-icon fe fe-log-out"></i> Cerran sesión </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <?php if($presionado == 0): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-1');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <?php if($presionado == 2): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.lista-roles')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-2');
} else {
    $response = \Livewire\Livewire::mount('roles.lista-roles');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 3): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.lista-call')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-3');
} else {
    $response = \Livewire\Livewire::mount('calls-center.lista-call');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 4): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.lista-operativo')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-4');
} else {
    $response = \Livewire\Livewire::mount('operativos.lista-operativo');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 5): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calendario')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-5');
} else {
    $response = \Livewire\Livewire::mount('calendario');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 6): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('empresas.lista-empresas')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-6');
} else {
    $response = \Livewire\Livewire::mount('empresas.lista-empresas');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 7): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.lista-clientes')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-7');
} else {
    $response = \Livewire\Livewire::mount('clientes.lista-clientes');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 8): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.lista-user')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-8');
} else {
    $response = \Livewire\Livewire::mount('users.lista-user');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 9): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.list-area')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-9');
} else {
    $response = \Livewire\Livewire::mount('area.list-area');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 10): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-10');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 11): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cobranza.lista-cobranza')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-11');
} else {
    $response = \Livewire\Livewire::mount('cobranza.lista-cobranza');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 12): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.lista-tratamientos')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-12');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.lista-tratamientos');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 13): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('recepcionista.lista-recepcion')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-13');
} else {
    $response = \Livewire\Livewire::mount('recepcionista.lista-recepcion');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 15): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.lista-inventario')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-14');
} else {
    $response = \Livewire\Livewire::mount('inventario.lista-inventario');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 16): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mensajeria.ver-chats')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-15');
} else {
    $response = \Livewire\Livewire::mount('mensajeria.ver-chats');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 17): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-16');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 18): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.lista-registros')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-17');
} else {
    $response = \Livewire\Livewire::mount('registros.lista-registros');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 19): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.lista-estadistica')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-18');
} else {
    $response = \Livewire\Livewire::mount('estadistica.lista-estadistica');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 20): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.lista-inmuebles')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-19');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.lista-inmuebles');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 21): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.marketing')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-20');
} else {
    $response = \Livewire\Livewire::mount('marketing.marketing');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 25): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('rh.listarh')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-21');
} else {
    $response = \Livewire\Livewire::mount('rh.listarh');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 26): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.comprar-secundario')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-22');
} else {
    $response = \Livewire\Livewire::mount('inventario.comprar-secundario');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 27): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-23');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 28): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.compra-productos')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-24');
} else {
    $response = \Livewire\Livewire::mount('inventario.compra-productos');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 29): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('reportes.mi-registro')->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-25');
} else {
    $response = \Livewire\Livewire::mount('reportes.mi-registro');
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 30): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo])->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-26')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-26');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-26');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-26');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo]);
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-26', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 31): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo])->html();
} elseif ($_instance->childHasBeenRendered('l2825212240-27')) {
    $componentId = $_instance->getRenderedChildComponentId('l2825212240-27');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2825212240-27');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2825212240-27');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo]);
    $html = $response->html();
    $_instance->logRenderedChild('l2825212240-27', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                </div>
                <div class="section-body">
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/components/panel-show.blade.php ENDPATH**/ ?>