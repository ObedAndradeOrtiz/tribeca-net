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
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    </head>


    <body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
        data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true"
        data-kt-app-sidebar-push-footer="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="false"
        class="app-default">

        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">

            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

                <div id="kt_app_header" class="app-header">

                    <div class="app-header-logo d-flex align-items-center ps-lg-10 gap-4 gap-lg-6">
                        <a href="/" class="d-flex align-items-center text-decoration-none">

                            <i class="bi bi-building fs-2 text-black me-2"></i>

                            <span class="fw-bold fs-4 text-gray-800 theme-light-show">
                                TRIBECA SOHO
                            </span>

                            <span class="fw-bold fs-4 text-white theme-dark-show">
                                TRIBECA SOHO
                            </span>

                        </a>
                    </div>
                    <div class="app-header-wrapper">
                        <div class="app-container container-fluid">



                            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">
                            </div>
                            <div class="d-flex align-items-center ms-1 ms-lg-3">
                                <small class="my-1 text-muted fs-7 fw-semibold ms-1">
                                    <?php echo e(Auth::user()->sucursal); ?>

                                </small>
                            </div>
                            <div class="d-flex align-items-center ms-1 ms-lg-3">
                                <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px position-relative"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <i class="ki-outline ki-notification-bing text-warning fs-1"></i>
                                </div>

                                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                                    data-kt-menu="true" id="kt_menu_notifications">
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.micaja')->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.micaja');
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                </div>
                            </div>
                            <div class="app-navbar flex-shrink-0">
                                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                        data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                        data-kt-menu-placement="bottom-end">
                                        <?php if(Auth::user()->path): ?>
                                            <img src="<?php echo e(asset('storage/' . Auth::user()->path)); ?>" alt="Foto de perfil"
                                                width="150" class="rounded-circle">
                                        <?php else: ?>
                                            <img alt="Logo" src="assets/media/avatars/blank.png" />
                                        <?php endif; ?>
                                    </div>

                                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
                                        data-kt-menu="true">

                                        <div class="px-3 menu-item">
                                            <div class="px-3 menu-content d-flex align-items-center">

                                                <div class="symbol symbol-50px me-5">
                                                    <?php if(Auth::user()->path): ?>
                                                        <img src="<?php echo e(asset('storage/' . Auth::user()->path)); ?>"
                                                            alt="Foto de perfil" width="150" class="rounded-circle">
                                                    <?php else: ?>
                                                        <img alt="Logo" src="assets/media/avatars/blank.png" />
                                                    <?php endif; ?>

                                                </div>


                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">
                                                        <?php echo e(Auth::user()->name); ?>

                                                        <span
                                                            class="px-2 py-1 badge badge-light-success fw-bold fs-8 ms-2">Pro</span>
                                                    </div>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7"><?php echo e(Auth::user()->email); ?></a>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7"><?php echo e(Auth::user()->rol); ?></a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="my-2 separator"></div>
                                        <div class="px-5 menu-item">
                                            <a href="<?php echo e(route('profile.show')); ?>" class="px-5 menu-link">Mi
                                                perfil</a>
                                        </div>
                                        <div class="px-5 menu-item">
                                            <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                                <?php echo csrf_field(); ?>
                                                <a href="<?php echo e(route('logout')); ?>" @click.prevent="$root.submit();"
                                                    class="px-5 menu-link">
                                                    Cerran sesión
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="app-navbar-item ms-1 ms-lg-3 me-n4 d-flex d-lg-none">
                                    <button id="kt_app_sidebar_mobile_toggle"
                                        class="btn btn-icon w-35px h-35px w-md-40px h-md-40px">
                                        <i class="ki-outline ki-burger-menu-2 fs-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="app-wrapper d-flex" id="kt_app_wrapper">

                    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
                        data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

                        <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-2"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                            data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-offset="5px">

                            <div id="kt_app_sidebar_menu"
                                class="menu menu-sub-indention menu-rounded menu-column fw-semibold fs-6 py-4 py-lg-6 px-2 px-lg-6"
                                data-kt-menu="true">

                                
                                <div class="menu-item">
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Panel general</span>
                                    </div>
                                </div>

                                
                                <div class="menu-item">
                                    <a class="menu-link active==" href="/dashboard">
                                        <span class="menu-icon">
                                            <i class="bi bi-speedometer2 fs-3"></i>
                                        </span>
                                        <span class="menu-title">Panel inicial</span>
                                    </a>
                                </div>



                                
                                <?php if(in_array('Recepcion', $permisos)): ?>
                                    <div class="menu-item">
                                        <a class="menu-link" href="/recepcion">
                                            <span class="menu-icon">
                                                <i class="bi bi-receipt fs-3"></i>
                                            </span>
                                            <span class="menu-title">Expensas</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="/mantenimientos">
                                            <span class="menu-icon">
                                                <i class="bi bi-wrench-adjustable fs-3"></i>
                                            </span>
                                            <span class="menu-title">Mantenimientos</span>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="menu-item">
                                    <a class="menu-link" href="/gastos">
                                        <span class="menu-icon">
                                            <i class="bi bi-wallet2 fs-3"></i>
                                        </span>
                                        <span class="menu-title">Egresos</span>
                                    </a>
                                </div>

                                
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase fs-7">Gestión</span>
                                    </div>
                                </div>

                                
                                <div class="menu-item">
                                    <a class="menu-link" href="/clientes">
                                        <span class="menu-icon">
                                            <i class="bi bi-people fs-3"></i>
                                        </span>
                                        <span class="menu-title">Copropietarios</span>
                                    </a>
                                </div>

                                
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-building fs-3"></i>
                                        </span>
                                        <span class="menu-title">Areas comunes</span>
                                        <span class="menu-arrow"></span>
                                    </span>

                                    <div class="menu-sub menu-sub-accordion">

                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="menu-item">
                                                <a class="menu-link" href="/dashboard/<?php echo e($area->id); ?>">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title"><?php echo e($area->area); ?></span>
                                                </a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if(in_array('Administrador', $permisos)): ?>
                                            <div class="menu-item">
                                                <a class="menu-link" href="/areas">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Configuración</span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                                
                                <?php if(in_array('Tratamientos', $permisos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="bi bi-door-open fs-3"></i>
                                            </span>
                                            <span class="menu-title">Departamentos</span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link" href="/tipohabitacion">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Tipos</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link" href="/habitaciones">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Departamentos</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link" href="/estado-departamentos">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Estado departamentos</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if(in_array('Administrador', $permisos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="bi bi-cash-stack fs-3"></i>
                                            </span>

                                            <span class="menu-title">Tesoreria</span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-accordion">

                                            <div class="menu-item">
                                                <a class="menu-link" href="/reporte-completo">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Reporte ingresos y egresos</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-person fs-3"></i>
                                        </span>
                                        <span class="menu-title">Usuarios</span>
                                        <span class="menu-arrow"></span>
                                    </span>

                                    <div class="menu-sub menu-sub-accordion">
                                        <?php if(in_array('Administrador', $permisos)): ?>
                                            <div class="menu-item">
                                                <a class="menu-link" href="/administrador">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Roles</span>
                                                </a>
                                            </div>

                                            <div class="menu-item">
                                                <a class="menu-link" href="/usuarios">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Personal interno</span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                
                                <?php if(in_array('Administrador', $permisos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="bi bi-box-seam fs-3"></i>
                                            </span>
                                            <span class="menu-title">Inventarios</span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link" href="/inventario-inmueble">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Activos / Inmuebles</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase fs-7">Reportes</span>
                                    </div>
                                </div>


                                
                                <?php if(in_array('Administrador', $permisos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="bi bi-graph-up fs-3"></i>
                                            </span>
                                            <span class="menu-title">Estadísticas</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link" href="/estadisticas">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Generales</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>

                                
                                <div class="menu-item">
                                    <a class="menu-link" href="/registros">
                                        <span class="menu-icon">
                                            <i class="bi bi-clock-history fs-3"></i>
                                        </span>
                                        <span class="menu-title">Registros</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content">
                                <div id="kt_app_content_container" class="app-container container-fluid">

                                    <?php switch($presionado):
                                        case (0): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-1');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (2): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.lista-roles', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-2');
} else {
    $response = \Livewire\Livewire::mount('roles.lista-roles', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (3): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calls-center.lista-call', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-3');
} else {
    $response = \Livewire\Livewire::mount('calls-center.lista-call', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (4): ?>
                                            
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-table', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-4');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-table', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (5): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('calendario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-5');
} else {
    $response = \Livewire\Livewire::mount('calendario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (6): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('empresas.lista-empresas', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-6');
} else {
    $response = \Livewire\Livewire::mount('empresas.lista-empresas', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (7): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes.lista-clientes', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-7');
} else {
    $response = \Livewire\Livewire::mount('clientes.lista-clientes', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (8): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.lista-user', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-8');
} else {
    $response = \Livewire\Livewire::mount('users.lista-user', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (9): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('area.list-area', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-9');
} else {
    $response = \Livewire\Livewire::mount('area.list-area', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (10): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-10');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (11): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cobranza.lista-cobranza', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-11');
} else {
    $response = \Livewire\Livewire::mount('cobranza.lista-cobranza', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (12): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tratamientos.lista-tratamientos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-12');
} else {
    $response = \Livewire\Livewire::mount('tratamientos.lista-tratamientos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (13): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-table', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-13');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-table', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            
                                        <?php break; ?>

                                        <?php case (15): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.lista-inventario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-14');
} else {
    $response = \Livewire\Livewire::mount('inventario.lista-inventario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (16): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mensajeria.ver-chats', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-15');
} else {
    $response = \Livewire\Livewire::mount('mensajeria.ver-chats', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (17): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-16');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.lista-tesoreria', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (18): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.lista-registros', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-17');
} else {
    $response = \Livewire\Livewire::mount('registros.lista-registros', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (19): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.estadisticas-auditoria', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-18');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.estadisticas-auditoria', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (20): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.lista-inmuebles', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-19');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.lista-inmuebles', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (21): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marketing.marketing', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-20');
} else {
    $response = \Livewire\Livewire::mount('marketing.marketing', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (25): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('rh.listarh', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-21');
} else {
    $response = \Livewire\Livewire::mount('rh.listarh', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (26): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.comprar-secundario', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-22');
} else {
    $response = \Livewire\Livewire::mount('inventario.comprar-secundario', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (27): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-23');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (28): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.compra-productos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-24');
} else {
    $response = \Livewire\Livewire::mount('inventario.compra-productos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (29): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('reportes.mi-registro', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-25');
} else {
    $response = \Livewire\Livewire::mount('reportes.mi-registro', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (30): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo,'lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-26')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-26');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-26');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-26');
} else {
    $response = \Livewire\Livewire::mount('operativos.pagos-cliente', ['idoperativo' => $idoperativo,'lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-26', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (31): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo,'lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-27')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-27');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-27');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-27');
} else {
    $response = \Livewire\Livewire::mount('operativos.informacion-cliente', ['idoperativo' => $idoperativo,'lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-27', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (32): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tipos.lista-tipo', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-28')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-28');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-28');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-28');
} else {
    $response = \Livewire\Livewire::mount('tipos.lista-tipo', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-28', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (33): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('operativos.mantenimientos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-29')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-29');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-29');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-29');
} else {
    $response = \Livewire\Livewire::mount('operativos.mantenimientos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-29', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (34): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.estado-departamentos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-30')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-30');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-30');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-30');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.estado-departamentos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-30', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php case (35): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.informe-ingresos-egresos', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-31')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-31');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-31');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-31');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.informe-ingresos-egresos', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-31', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php break; ?>

                                        <?php default: ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1144315466-32')) {
    $componentId = $_instance->getRenderedChildComponentId('l1144315466-32');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1144315466-32');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1144315466-32');
} else {
    $response = \Livewire\Livewire::mount('panel-inicio.ver-panel', ['lazy' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1144315466-32', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    <?php endswitch; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var hostUrl = "assets/";
        </script>
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="assets/js/widgets.bundle.js"></script>
        <script src="assets/js/custom/widgets.js"></script>
        <script src="assets/js/custom/apps/chat/chat.js"></script>
    </body>
</div>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/components/panel-show.blade.php ENDPATH**/ ?>