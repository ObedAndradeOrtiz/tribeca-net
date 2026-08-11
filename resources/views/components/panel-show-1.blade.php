<div>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta content="SISTEMA" name="description" />
            <meta content="Obed Andrade +59177035251" name="author" />

            <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" />
            <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
            <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" />
            <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
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
                                {{-- <div>Sucursal: {{ Auth::user()->sucursal }}</div> --}}
                                <div>Usuario: {{ Auth::user()->name }}</div>
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

                                @if (in_array('Administrador', $permisos))
                                    <li>
                                        <a href="/tesoreria"><i class="mdi mdi-finance"></i>Tesorería</a>
                                    </li>
                                @endif

                                @if (in_array('Recepcion', $permisos))
                                    <li>
                                        <a href="/recepcion"><i class="mdi mdi-shield-account"></i>Administración</a>
                                    </li>
                                @endif

                                {{-- <li><a href="/vender"><i class="mdi mdi-store"></i> Ventas</a></li> --}}
                                <li><a href="/gastos"><i class="mdi mdi-cash-remove"></i>Crear gasto</a></li>

                                <li class="menu-title">Gestión</li>

                                <li><a href="/clientes"><i class="mdi mdi-account-multiple"></i>Copropietarios</a></li>

                                <li>
                                    <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                        <i class="mdi mdi-office-building"></i> Areas comunes

                                    </a>
                                    <ul class="sub-menu">
                                        @foreach ($areas as $area)
                                            <li><a href="/dashboard/{{ $area->id }}" >{{ $area->area }}</a></li>
                                        @endforeach

                                        @if (in_array('Administrador', $permisos))
                                            <li><a href="/areas">Configuración</a></li>
                                        @endif
                                    </ul>
                                </li>

                                @if (in_array('Tratamientos', $permisos))
                                    <li>
                                        <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                            <i class="mdi mdi-bed"></i> Departamentos
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a href="/tipohabitacion">Tipos</a></li>
                                            <li><a href="/habitaciones">Departamentos</a></li>
                                        </ul>
                                    </li>
                                @endif

                                <li>
                                    <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                        <i class="mdi mdi-account"></i> Usuarios
                                    </a>
                                    <ul class="sub-menu">
                                        @if (in_array('Administrador', $permisos))
                                            <li><a href="/administrador">Roles</a></li>
                                            <li><a href="/usuarios">Personal interno</a></li>
                                        @endif
                                    </ul>
                                </li>

                                @if (in_array('Administrador', $permisos))
                                    <li>
                                        <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                            <i class="mdi mdi-clipboard-list"></i> Inventarios
                                        </a>
                                        <ul class="sub-menu">
                                           
                                            <li><a href="/inventario-inmueble">Activos</a></li>
                                        </ul>
                                    </li>
                                @endif 

                                <li class="menu-title">Reportes</li>

                                @if (in_array('Administrador', $permisos))
                                    <li>
                                        <a href="javascript:void(0);" class="has-arrow toggle-submenu">
                                            <i class="mdi mdi-chart-line"></i> Estadísticas
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a href="/estadisticas">General</a></li>
                                        </ul>
                                    </li>
                                @endif
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
                                <livewire:estadistica.lista-estadistica lazy />
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

                            @default
                                <livewire:panel-inicio.ver-panel lazy />
                        @endswitch

                    </div>
                </div>

                <!-- FOOTER -->
                {{-- <footer class="footer mt-4">
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
                </footer> --}}

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
          

        </body>
    </div>
</div>
