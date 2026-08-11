<div>
    @php
        use Illuminate\Support\Facades\Cache;

        $rolesderol = Cache::remember('roles_' . Auth::id(), 60, function () {
            return DB::table('roles_vistas')
                ->where('namerol', Auth::user()->rol)
                ->where('estado', 'Activo')
                ->get();
        });

        $permisos = $rolesderol->pluck('vista')->toArray();
    @endphp

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
                                    {{ Auth::user()->sucursal }}
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
                                    @livewire('tesoreria.micaja')

                                </div>
                            </div>
                            <div class="app-navbar flex-shrink-0">
                                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                        data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                        data-kt-menu-placement="bottom-end">
                                        @if (Auth::user()->path)
                                            <img src="{{ asset('storage/' . Auth::user()->path) }}" alt="Foto de perfil"
                                                width="150" class="rounded-circle">
                                        @else
                                            <img alt="Logo" src="assets/media/avatars/blank.png" />
                                        @endif
                                    </div>

                                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
                                        data-kt-menu="true">

                                        <div class="px-3 menu-item">
                                            <div class="px-3 menu-content d-flex align-items-center">

                                                <div class="symbol symbol-50px me-5">
                                                    @if (Auth::user()->path)
                                                        <img src="{{ asset('storage/' . Auth::user()->path) }}"
                                                            alt="Foto de perfil" width="150" class="rounded-circle">
                                                    @else
                                                        <img alt="Logo" src="assets/media/avatars/blank.png" />
                                                    @endif

                                                </div>


                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">
                                                        {{ Auth::user()->name }}
                                                        <span
                                                            class="px-2 py-1 badge badge-light-success fw-bold fs-8 ms-2">Pro</span>
                                                    </div>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->rol }}</a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="my-2 separator"></div>
                                        <div class="px-5 menu-item">
                                            <a href="{{ route('profile.show') }}" class="px-5 menu-link">Mi
                                                perfil</a>
                                        </div>
                                        <div class="px-5 menu-item">
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf
                                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
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

                                {{-- PANEL --}}
                                <div class="menu-item">
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Panel general</span>
                                    </div>
                                </div>

                                {{-- INICIO --}}
                                <div class="menu-item">
                                    <a class="menu-link active==" href="/dashboard">
                                        <span class="menu-icon">
                                            <i class="bi bi-speedometer2 fs-3"></i>
                                        </span>
                                        <span class="menu-title">Panel inicial</span>
                                    </a>
                                </div>



                                {{-- ADMINISTRACIÓN --}}
                                @if (in_array('Recepcion', $permisos))
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
                                @endif

                                {{-- GASTOS --}}
                                <div class="menu-item">
                                    <a class="menu-link" href="/gastos">
                                        <span class="menu-icon">
                                            <i class="bi bi-wallet2 fs-3"></i>
                                        </span>
                                        <span class="menu-title">Egresos</span>
                                    </a>
                                </div>

                                {{-- GESTIÓN --}}
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase fs-7">Gestión</span>
                                    </div>
                                </div>

                                {{-- COPROPIETARIOS --}}
                                <div class="menu-item">
                                    <a class="menu-link" href="/clientes">
                                        <span class="menu-icon">
                                            <i class="bi bi-people fs-3"></i>
                                        </span>
                                        <span class="menu-title">Copropietarios</span>
                                    </a>
                                </div>

                                {{-- AREAS COMUNES --}}
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-building fs-3"></i>
                                        </span>
                                        <span class="menu-title">Areas comunes</span>
                                        <span class="menu-arrow"></span>
                                    </span>

                                    <div class="menu-sub menu-sub-accordion">

                                        @foreach ($areas as $area)
                                            <div class="menu-item">
                                                <a class="menu-link" href="/dashboard/{{ $area->id }}">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">{{ $area->area }}</span>
                                                </a>
                                            </div>
                                        @endforeach

                                        @if (in_array('Administrador', $permisos))
                                            <div class="menu-item">
                                                <a class="menu-link" href="/areas">
                                                    <span class="menu-bullet"><span
                                                            class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">Configuración</span>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                {{-- DEPARTAMENTOS --}}
                                @if (in_array('Tratamientos', $permisos))
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
                                @endif
                                @if (in_array('Administrador', $permisos))
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
                                @endif
                                {{-- USUARIOS --}}
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-person fs-3"></i>
                                        </span>
                                        <span class="menu-title">Usuarios</span>
                                        <span class="menu-arrow"></span>
                                    </span>

                                    <div class="menu-sub menu-sub-accordion">
                                        @if (in_array('Administrador', $permisos))
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
                                        @endif
                                    </div>
                                </div>

                                {{-- INVENTARIOS --}}
                                @if (in_array('Administrador', $permisos))
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
                                @endif

                                {{-- REPORTES --}}
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase fs-7">Reportes</span>
                                    </div>
                                </div>


                                {{-- ESTADÍSTICAS --}}
                                @if (in_array('Administrador', $permisos))
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
                                @endif

                                {{-- REGISTROS --}}
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

                                    @switch($presionado)
                                        @case(0)
                                            <livewire:panel-inicio.ver-panel lazy />
                                        @break

                                        @case(2)
                                            <livewire:roles.lista-roles lazy />
                                        @break

                                        @case(3)
                                            <livewire:calls-center.lista-call lazy />
                                        @break

                                        @case(4)
                                            {{-- <livewire:operativos.lista-operativo lazy /> --}}
                                            <livewire:operativos.pagos-table lazy />
                                        @break

                                        @case(5)
                                            <livewire:calendario lazy />
                                        @break

                                        @case(6)
                                            <livewire:empresas.lista-empresas lazy />
                                        @break

                                        @case(7)
                                            <livewire:clientes.lista-clientes lazy />
                                        @break

                                        @case(8)
                                            <livewire:users.lista-user lazy />
                                        @break

                                        @case(9)
                                            <livewire:area.list-area lazy />
                                        @break

                                        @case(10)
                                            <livewire:tesoreria.lista-tesoreria lazy />
                                        @break

                                        @case(11)
                                            <livewire:cobranza.lista-cobranza lazy />
                                        @break

                                        @case(12)
                                            <livewire:tratamientos.lista-tratamientos lazy />
                                        @break

                                        @case(13)
                                            <livewire:operativos.pagos-table lazy />
                                            {{-- <livewire:recepcionista.lista-recepcion lazy /> --}}
                                        @break

                                        @case(15)
                                            <livewire:inventario.lista-inventario lazy />
                                        @break

                                        @case(16)
                                            <livewire:mensajeria.ver-chats lazy />
                                        @break

                                        @case(17)
                                            <livewire:tesoreria.lista-tesoreria lazy />
                                        @break

                                        @case(18)
                                            <livewire:registros.lista-registros lazy />
                                        @break

                                        @case(19)
                                            <livewire:tesoreria.estadisticas-auditoria lazy />
                                        @break

                                        @case(20)
                                            <livewire:inmuebles.lista-inmuebles lazy />
                                        @break

                                        @case(21)
                                            <livewire:marketing.marketing lazy />
                                        @break

                                        @case(25)
                                            <livewire:rh.listarh lazy />
                                        @break

                                        @case(26)
                                            <livewire:inventario.comprar-secundario lazy />
                                        @break

                                        @case(27)
                                            <livewire:tesoreria.egreso lazy />
                                        @break

                                        @case(28)
                                            <livewire:inventario.compra-productos lazy />
                                        @break

                                        @case(29)
                                            <livewire:reportes.mi-registro lazy />
                                        @break

                                        @case(30)
                                            <livewire:operativos.pagos-cliente :idoperativo="$idoperativo" lazy />
                                        @break

                                        @case(31)
                                            <livewire:operativos.informacion-cliente :idoperativo="$idoperativo" lazy />
                                        @break

                                        @case(32)
                                            <livewire:tipos.lista-tipo lazy />
                                        @break

                                        @case(33)
                                            <livewire:operativos.mantenimientos lazy />
                                        @break

                                        @case(34)
                                            <livewire:tesoreria.estado-departamentos lazy />
                                        @break

                                        @case(35)
                                            <livewire:tesoreria.informe-ingresos-egresos lazy />
                                        @break

                                        @default
                                            <livewire:panel-inicio.ver-panel lazy />
                                    @endswitch
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
