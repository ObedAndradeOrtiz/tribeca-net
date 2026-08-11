<div>
    <div>

        <?php
            use Illuminate\Support\Facades\Cache;

            $rolesderol = Cache::remember('roles_' . Auth::id(), 60, function () {
                return DB::table('roles_vistas')
                    ->where('namerol', Auth::user()->rol)
                    ->where('estado', 'Activo')
                    ->get();
            });

            $permisos = $rolesderol->pluck('vista')->toArray();
        ?>

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta content="SISTEMA" name="description" />
            <meta content="Obed Andrade +59177035251" name="author" />

            <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" />
            <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" />
            <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" />
            <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" />
        </head>
        <style>
            .sub-menu {
                display: none;
                padding-left: 15px;
            }

            .sub-menu.show {
                display: block;
            }

            /* animación suave opcional */
            .sub-menu {
                transition: all 0.3s ease;
            }
        </style>

        <body data-sidebar="dark">

            <div id="layout-wrapper">

                <!-- HEADER -->
                <header id="page-topbar">
                    <div class="navbar-header">
                        <div class="d-flex">

                            <div class="navbar-brand-box">
                                <a href="/" class="logo logo-dark">tribeca</a>
                                <a href="/" class="logo logo-light"></a>
                            </div>


                            <div class="px-4 py-4 d-none d-sm-block">
                                
                                <div>Usuario: <?php echo e(Auth::user()->name); ?></div>
                            </div>

                        </div>
                    </div>
                </header>

                <!-- SIDEBAR -->
                <div class="vertical-menu">
                    <div data-simplebar class="h-100">

                        <div id="sidebar-menu">
                            <ul class="metismenu list-unstyled" id="side-menu">

                                <li class="menu-title">Inicio</li>

                                <li>
                                    <a href="/dashboard"><i class="mdi mdi-view-dashboard"></i> Panel inicial</a>
                                </li>

                                <?php if(in_array('Administrador', $permisos)): ?>
                                    <li>
                                        <a href="/tesoreria"><i class="mdi mdi-finance"></i>Tesorería</a>
                                    </li>
                                <?php endif; ?>

                                <?php if(in_array('Recepcion', $permisos)): ?>
                                    <li>
                                        <a href="/recepcion"><i class="mdi mdi-shield-account"></i>Administración</a>
                                    </li>
                                <?php endif; ?>

                                
                                <li><a href="/gastos"><i class="mdi mdi-cash-remove"></i>Crear gasto</a></li>

                                <li class="menu-title">Gestión</li>

                                <li><a href="/clientes"><i class="mdi mdi-account-multiple"></i>Copropietarios</a></li>

                                <li>
                                    <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                        <i class="mdi mdi-office-building"></i> Areas comunes

                                    </a>
                                    <ul class="sub-menu">
                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a href="/dashboard/<?php echo e($area->id); ?>" ><?php echo e($area->area); ?></a></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if(in_array('Administrador', $permisos)): ?>
                                            <li><a href="/areas">Configuración</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>

                                <?php if(in_array('Tratamientos', $permisos)): ?>
                                    <li>
                                        <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                            <i class="mdi mdi-bed"></i> Departamentos
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a href="/tipohabitacion">Tipos</a></li>
                                            <li><a href="/habitaciones">Departamentos</a></li>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                        <i class="mdi mdi-account"></i> Usuarios
                                    </a>
                                    <ul class="sub-menu">
                                        <?php if(in_array('Administrador', $permisos)): ?>
                                            <li><a href="/administrador">Roles</a></li>
                                            <li><a href="/usuarios">Personal interno</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>

                                

                                <li class="menu-title">Reportes</li>

                                <?php if(in_array('Administrador', $permisos)): ?>
                                    <li>
                                        <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                            <i class="mdi mdi-chart-line"></i> Estadísticas
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a href="/estadisticas">General</a></li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <li><a href="/registros"><i class="mdi mdi-history"></i> Registros</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO -->
                <div class="main-content" style="margin-top: 5rem;">
                    <div>
                        <div wire:loading class="p-3 text-center">
                            <div class="spinner-border text-primary"></div>
                        </div>

                        <?php switch($presionado):
                            case (0): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-0');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (2): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.lista-roles', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-1');
} else {
    $response = \Livewire\Livewire::mount('roles.lista-roles', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (3): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.lista-call', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-2');
} else {
    $response = \Livewire\Livewire::mount('calls-center.lista-call', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (4): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.lista-operativo', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-3');
} else {
    $response = \Livewire\Livewire::mount('operativos.lista-operativo', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (5): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calendario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-4');
} else {
    $response = \Livewire\Livewire::mount('calendario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (6): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('empresas.lista-empresas', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-5');
} else {
    $response = \Livewire\Livewire::mount('empresas.lista-empresas', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (7): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.lista-clientes', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-6');
} else {
    $response = \Livewire\Livewire::mount('clientes.lista-clientes', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (8): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.lista-user', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-7');
} else {
    $response = \Livewire\Livewire::mount('users.lista-user', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (9): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.list-area', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-8');
} else {
    $response = \Livewire\Livewire::mount('area.list-area', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (10): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-9');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (11): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cobranza.lista-cobranza', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-10');
} else {
    $response = \Livewire\Livewire::mount('cobranza.lista-cobranza', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (12): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.lista-tratamientos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-11');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.lista-tratamientos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (13): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('recepcionista.lista-recepcion', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-12');
} else {
    $response = \Livewire\Livewire::mount('recepcionista.lista-recepcion', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (15): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.lista-inventario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-13');
} else {
    $response = \Livewire\Livewire::mount('inventario.lista-inventario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (16): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mensajeria.ver-chats', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-14');
} else {
    $response = \Livewire\Livewire::mount('mensajeria.ver-chats', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (17): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-15');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (18): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.lista-registros', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-16');
} else {
    $response = \Livewire\Livewire::mount('registros.lista-registros', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (19): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('estadistica.lista-estadistica', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-17');
} else {
    $response = \Livewire\Livewire::mount('estadistica.lista-estadistica', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (20): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.lista-inmuebles', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-18');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.lista-inmuebles', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (21): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.marketing', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-19');
} else {
    $response = \Livewire\Livewire::mount('marketing.marketing', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (25): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('rh.listarh', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-20');
} else {
    $response = \Livewire\Livewire::mount('rh.listarh', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (26): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.comprar-secundario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-21');
} else {
    $response = \Livewire\Livewire::mount('inventario.comprar-secundario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (27): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-22');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (28): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.compra-productos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-23');
} else {
    $response = \Livewire\Livewire::mount('inventario.compra-productos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (29): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('reportes.mi-registro', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-24');
} else {
    $response = \Livewire\Livewire::mount('reportes.mi-registro', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (30): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo,'lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-25');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo,'lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (31): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo,'lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-26')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-26');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-26');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-26');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo,'lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-26', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php case (32): ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipos.lista-tipo', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-27')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-27');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-27');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-27');
} else {
    $response = \Livewire\Livewire::mount('tipos.lista-tipo', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-27', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php break; ?>

                            <?php default: ?>
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l3628737155-28')) {
    $componentId = $_instance->getRenderedChildComponentId('l3628737155-28');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3628737155-28');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3628737155-28');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l3628737155-28', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php endswitch; ?>

                    </div>
                </div>

                <!-- FOOTER -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> SISTEMA TRIBECA SOHO
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    document.querySelectorAll(".toggle-submenu").forEach(item => {
                        item.addEventListener("click", function() {

                            let submenu = this.nextElementSibling;

                            // cerrar otros (opcional tipo acordeón)
                            document.querySelectorAll(".sub-menu").forEach(menu => {
                                if (menu !== submenu) {
                                    menu.classList.remove("show");
                                }
                            });

                            // toggle actual
                            submenu.classList.toggle("show");
                        });
                    });

                });
            </script>
            <!-- SCRIPTS (NO TOCADOS) -->
            

        </body>
    </div>
</div>
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/components/panel-show.blade.php ENDPATH**/ ?>