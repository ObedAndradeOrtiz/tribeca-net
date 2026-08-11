<div>
    <?php
    $rolesderol = DB::table('roles_vistas')
        ->where('namerol', 'LIKE', '%' . Auth::user()->rol)
        ->where('estado', 'Activo')
        ->get();
    ?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="SISTEMA" name="description" />
        <meta content="Obed Andrade +59177348087" name="author" />
        <!-- Bootstrap Css -->
        <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- App Css -->
        <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Custom Css -->
        <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
    </head>

    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    
                                </span>
                                <span class="logo-lg">
                                    
                                </span>
                            </a>
                            <a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    
                                </span>
                                <span class="logo-lg">
                                    
                                </span>
                            </a>
                        </div>
                        <button type="button"
                            class="px-3 btn btn-sm font-size-24 header-item waves-effect vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>
                        <div class="py-4 d-none d-sm-block">
                            <div>
                                Sucursal: <?php echo e(Auth::user()->sucursal); ?>

                            </div>
                            <div>
                                Usuario: <?php echo e(Auth::user()->name); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">
                <div data-simplebar class="h-100">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <!-- Inicio -->
                            <li class="menu-title">Inicio</li>
                            <li>
                                <a href="/dashboard" class="waves-effect">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span>Panel</span>
                                </a>
                            </li>
                            <?php if($rolesderol->contains('vista', 'Administrador')): ?>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-finance"></i>
                                    <span>Tesorería</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if($rolesderol->contains('vista', 'Recepcion')): ?>
                            <li>
                                <a href="/recepcion" class="waves-effect">
                                    <i class="mdi mdi-headset"></i>
                                    <span>Recepción</span>
                                </a>
                            </li>
                        <?php endif; ?>
                            <li><a class="waves-effect" href="/vender"><i class="mdi mdi-store"></i>Ventas</a></li>
                            <li><a class="waves-effect" href="/gastos"><i class="mdi mdi-cash-remove"></i>Gastos</a></li>


                            <!-- Gestión -->
                            <li class="menu-title">Gestión</li>
                            <li>
                                <a href="/clientes" class="waves-effect">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span>Clientes</span>
                                </a>
                            </li>


                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-office-building"></i>

                                    <span>Sucursales</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="/dashboard/<?php echo e($area->id); ?>">
                                                <?php echo e($area->area); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($rolesderol->contains('vista', 'Administrador')): ?>
                                        <li><a href="/areas">
                                                Configuración
                                            </a></li>
                                    <?php endif; ?>

                                </ul>
                            </li>

                            <?php if($rolesderol->contains('vista', 'Tratamientos')): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-bed"></i>
                                        <span>Habitaciones</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="/tipohabitacion">Tipos</a></li>
                                        <li><a href="/habitaciones">Habitaciones</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account"></i>
                                    <span>Usuarios</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if($rolesderol->contains('vista', 'Administrador')): ?>
                                        <li><a href="/administrador">Roles</a></li>
                                        <li><a href="/usuarios">Personal interno</a></li>
                                    <?php endif; ?>

                                </ul>
                            </li>


                            <?php if($rolesderol->contains('vista', 'Inventario')): ?>

                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-clipboard-list"></i>
                                        <span>Inventarios</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="/comprar">Compra de productos</a></li>
                                        <li><a href="/inventario">Inventario de productos</a></li>
                                        <li><a href="/inventario-inmueble">Inventario de activos</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <!-- Reportes y Estadísticas -->
                            <li class="menu-title">Reportes y Estadísticas</li>

                            <?php if($rolesderol->contains('vista', 'Administrador')): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-chart-line"></i>
                                        <span>Estadísticas</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="/estadisticas">Estadística general</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a href="/registros" class="waves-effect">
                                    <i class="mdi mdi-history"></i>
                                    <span>Registros</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account"></i>
                                    <span>Perfil</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="<?php echo e(route('profile.show')); ?>">Configuraciones</a></li>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                            <?php echo csrf_field(); ?>
                                            <a class="" href="<?php echo e(route('logout')); ?>"
                                                @click.prevent="$root.submit();">
                                                Cerran sesión </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>

                            <!-- Administración -->
                            

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>

            <!-- Left Sidebar End -->

            <div class="main-content" style="margin-top: 5rem;">
                <div>
                    <?php if($presionado == 0): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-0');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <?php if($presionado == 2): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.lista-roles')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-1');
} else {
    $response = \Livewire\Livewire::mount('roles.lista-roles');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 3): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.lista-call')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-2');
} else {
    $response = \Livewire\Livewire::mount('calls-center.lista-call');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 4): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.lista-operativo')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-3');
} else {
    $response = \Livewire\Livewire::mount('operativos.lista-operativo');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 5): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calendario')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-4');
} else {
    $response = \Livewire\Livewire::mount('calendario');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 6): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('empresas.lista-empresas')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-5');
} else {
    $response = \Livewire\Livewire::mount('empresas.lista-empresas');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 7): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.lista-clientes')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-6');
} else {
    $response = \Livewire\Livewire::mount('clientes.lista-clientes');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 8): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.lista-user')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-7');
} else {
    $response = \Livewire\Livewire::mount('users.lista-user');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 9): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.list-area')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-8');
} else {
    $response = \Livewire\Livewire::mount('area.list-area');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 10): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-9');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 11): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cobranza.lista-cobranza')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-10');
} else {
    $response = \Livewire\Livewire::mount('cobranza.lista-cobranza');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 12): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.lista-tratamientos')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-11');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.lista-tratamientos');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 13): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('recepcionista.lista-recepcion')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-12');
} else {
    $response = \Livewire\Livewire::mount('recepcionista.lista-recepcion');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 15): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.lista-inventario')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-13');
} else {
    $response = \Livewire\Livewire::mount('inventario.lista-inventario');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 16): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mensajeria.ver-chats')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-14');
} else {
    $response = \Livewire\Livewire::mount('mensajeria.ver-chats');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 17): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-15');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 18): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.lista-registros')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-16');
} else {
    $response = \Livewire\Livewire::mount('registros.lista-registros');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 19): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.lista-estadistica')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-17');
} else {
    $response = \Livewire\Livewire::mount('estadistica.lista-estadistica');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 20): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.lista-inmuebles')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-18');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.lista-inmuebles');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 21): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.marketing')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-19');
} else {
    $response = \Livewire\Livewire::mount('marketing.marketing');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 25): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('rh.listarh')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-20');
} else {
    $response = \Livewire\Livewire::mount('rh.listarh');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 26): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.comprar-secundario')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-21');
} else {
    $response = \Livewire\Livewire::mount('inventario.comprar-secundario');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 27): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-22');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 28): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.compra-productos')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-23');
} else {
    $response = \Livewire\Livewire::mount('inventario.compra-productos');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 29): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('reportes.mi-registro')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-24');
} else {
    $response = \Livewire\Livewire::mount('reportes.mi-registro');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 30): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo])->html();
} elseif ($_instance->childHasBeenRendered('l412157062-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-25');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo]);
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 31): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo])->html();
} elseif ($_instance->childHasBeenRendered('l412157062-26')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-26');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-26');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-26');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo]);
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-26', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($presionado == 32): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipos.lista-tipo')->html();
} elseif ($_instance->childHasBeenRendered('l412157062-27')) {
    $componentId = $_instance->getRenderedChildComponentId('l412157062-27');
    $componentTag = $_instance->getRenderedChildComponentTagName('l412157062-27');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l412157062-27');
} else {
    $response = \Livewire\Livewire::mount('tipos.lista-tipo');
    $html = $response->html();
    $_instance->logRenderedChild('l412157062-27', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> SISTEMA<span class="d-none d-sm-inline-block"> - Desarrollado
                                por Andrasoft.</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">

                <div class="px-3 py-4 rightbar-title d-flex align-items-center">

                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="mb-0 text-center">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch"
                            checked />
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                            data-bsStyle="assets/css/bootstrap-dark.min.css"
                            data-appStyle="assets/css/app-dark.min.css" />
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="mb-5 form-check form-switch">
                        <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch"
                            data-appStyle="assets/css/app-rtl.min.css" />
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>


                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        
    </body>
</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/components/panel-show.blade.php ENDPATH**/ ?>