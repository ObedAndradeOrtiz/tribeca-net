<!DOCTYPE html>

<head>
    <html lang="es">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema Spa Miora</title>
    <link href="<?php echo e(asset('logos/LOGOSINFONDO.png')); ?>" rel="icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/core/libs.min.css')); ?>" />
    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/aos/dist/aos.css')); ?>" />
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hope-ui.min.css?v=2.0.0')); ?>" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.min.css?v=2.0.0')); ?>" />
    <!-- Dark Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dark.min.css')); ?>" />
    <!-- Customizer Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.min.css')); ?>" />
    <!-- RTL Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/rtl.min.css')); ?>" />
    <link href="<?php echo e(asset('assets/assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: #fff;
        }

        #preloader:before {
            content: "";
            position: fixed;
            top: calc(50% - 30px);
            left: calc(50% - 30px);
            border: 6px solid rgba(0, 68, 255, 0.692);
            border-top-color: #fff;
            border-bottom-color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: animate-preloader 1s linear infinite;
        }



        @keyframes animate-preloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <style>
        #miDiv {
            position: absolute;
            top: 200px;
            font-size: 32px;
            font-weight: bold;
        }

        #preloader-img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            /* Ajusta el tamaño de la imagen según tus necesidades */
            height: 500px;
            /* Ajusta el tamaño de la imagen según tus necesidades */
        }
    </style>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Styles -->
    <?php echo \Livewire\Livewire::styles(); ?>

</head>

<body class="font-sans antialiased">
    <?php if (isset($component)) { $__componentOriginalff9615640ecc9fe720b9f7641382872b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff9615640ecc9fe720b9f7641382872b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.banner','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff9615640ecc9fe720b9f7641382872b)): ?>
<?php $attributes = $__attributesOriginalff9615640ecc9fe720b9f7641382872b; ?>
<?php unset($__attributesOriginalff9615640ecc9fe720b9f7641382872b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff9615640ecc9fe720b9f7641382872b)): ?>
<?php $component = $__componentOriginalff9615640ecc9fe720b9f7641382872b; ?>
<?php unset($__componentOriginalff9615640ecc9fe720b9f7641382872b); ?>
<?php endif; ?>

    <div class="min-h-screen">
        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <?php echo e($header); ?>


                </div>
            </header>
        <?php endif; ?>
        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>

    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo \Livewire\Livewire::scripts(); ?>

    <?php echo $__env->yieldPushContent('js'); ?>
    <script>
        function convertirAMayusculas() {
            var input = document.getElementById("texto");
            input.value = input.value.toUpperCase();
        }
        Livewire.on('graficoActualizado', function(asistido, noasistido) {
            var ctx = document.getElementById('miGrafico').getContext('2d');
            if (window.myChart) {
                window.myChart.destroy();
            }

            window.myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Asistidos', 'No asistidos'],
                    datasets: [{
                        label: 'Citas',
                        data: [asistido, noasistido],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    // No hay escalas ya que es un gráfico circular
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('linkCopied', function(link) {
                copyToClipboard(link);
            });
        });

        function copyToClipboard(text) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }
    </script>
    <script>
        function actualizarGrafico(datos) {
            // Obtener el canvas del gráfico
            var canvas = document.getElementById('ingresodinamico');

            // Eliminar el gráfico anterior si existe
            if (window.barChart !== undefined && window.barChart !== null) {
                window.barChart.destroy();
            }

            // Crear un nuevo gráfico con los datos actualizados
            var densityCanvas = canvas.getContext("2d");
            var barChart = new Chart(densityCanvas, {
                type: 'bar',
                data: datos,
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.8,
                            categoryPercentage: 0.5
                        }]
                    }
                }
            });

            // Guardar el nuevo gráfico en una variable global para poder destruirlo más tarde si es necesario
            window.barChart = barChart;
        }

        Livewire.on('actualizarGrafico', datos => {
            console.log("Evento actualizado recibido en Livewire");

            actualizarGrafico(datos);
        });

        function actualizarGrafico2(datos) {
            // Obtener el canvas del gráfico
            var canvas = document.getElementById('ingresodinamico2');

            // Eliminar el gráfico anterior si existe
            if (window.barChart !== undefined && window.barChart !== null) {
                window.barChart.destroy();
            }

            // Crear un nuevo gráfico con los datos actualizados
            var densityCanvas = canvas.getContext("2d");
            var barChart = new Chart(densityCanvas, {
                type: 'bar',
                data: datos,
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.8,
                            categoryPercentage: 0.5
                        }]
                    }
                }
            });

            // Guardar el nuevo gráfico en una variable global para poder destruirlo más tarde si es necesario
            window.barChart = barChart;
        }

        Livewire.on('actualizarGrafico2', datos => {
            console.log("Evento actualizado recibido en Livewire");

            actualizarGrafico2(datos);
        });
        Livewire.on('copiarTabla', script => {
            copyToClipboard(script);
        });
        Livewire.on('alert', function(message) {
            Swal.fire(
                message,
                '',
                'success'
            )
        });
        Livewire.on('saved', function(message) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        });

        Livewire.on('error', function(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        });
        Livewire.on('activarUser', $id => {
            Swal.fire({
                title: '¿Desea activar al usuario?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('users.editar-user', 'activar', $id);
                    Swal.fire(
                        '¡Usuario Activado!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('rellamar', $id => {
            Swal.fire({
                title: '¿Sumar nueva llamada?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, sumar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('calls-center.editar-call', 'rellamarnumero', $id);
                    Swal.fire(
                        '¡Llamada sumada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('eliminarPagoCita', $id => {
            Swal.fire({
                title: '¿Desea eliminar este pago?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-pagos', 'eliminar', $id);
                    Swal.fire(
                        '¡Pago eliminado!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarUser', $id => {
            Swal.fire({
                title: '¿Desea desactivar al usuario?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('users.editar-user', 'inactivar', $id);
                    Swal.fire(
                        '¡Usuario Desactivado!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('eliminarTransaccion', $id => {
            Swal.fire({
                title: '¿Desea eliminar la transacción?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.marketing', 'deleteTransaccion', $id);
                    Swal.fire(
                        '¡Transacción eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarTarjeta', $id => {
            Swal.fire({
                title: '¿Desea eliminar la tarjeta?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.editar-tarjeta', 'editarTarjeta', $id);
                    Swal.fire(
                        '¡Tarjeta eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('inactivarCall', $id => {
            Swal.fire({
                title: '¿Desea desactivar la llamada?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('calls-center.editar-call', 'inactivar', $id);
                    Swal.fire(
                        '¡Lllamada Desactivada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('activarCall', $id => {
            Swal.fire({
                title: '¿Desea activar la llamada?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('calls-center.editar-call', 'activar', $id);
                    Swal.fire(
                        '¡Llamada Activada!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('rellamarOperativo', $id => {
            Swal.fire({
                title: '¿Remarketing a esta cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('operativos.editar-operativo', 'rellamarnum', $id);
                    Swal.fire(
                        '¡Remarketing de cita!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarOperativo', $id => {
            Swal.fire({
                title: '¿Desea desactivar la cita? \n Un administrador debe confirmar',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('operativos.editar-operativo', 'inactivar', $id);
                    Swal.fire(
                        '¡Cita Desactivada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('confirmarEliminar', $id => {
            Swal.fire({
                title: '¿Confirma que va eliminar la cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-confirmacion', 'inactivar', $id);
                    Swal.fire(
                        '¡Cita eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('inactivarCita', $id => {
            Swal.fire({
                title: '¿Desea eliminar la cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-citas', 'inactivar', $id);
                    Swal.fire(
                        '¡Cita eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarCuenta', $id => {
            Swal.fire({
                title: '¿Desea eliminar la cuenta?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.mark-comerciales', 'inactivar', $id);
                    Swal.fire(
                        '¡Cuenta eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });


        Livewire.on('convTarjeta', $id => {
            Swal.fire({
                title: '¿Desea convertir a principal esta tarjeta?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.editar-tarjeta', 'convPrincipal', $id);
                    Swal.fire(
                        '¡Tarjeta configurada!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('eliminarPublicidadTotal', $id => {
            Swal.fire({
                title: '¿Desea eliminar la publicidad?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.marketing', 'eliminarPublicidad', $id);
                    Swal.fire(
                        '¡Publicidad eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarCampana', $id => {
            Swal.fire({
                title: '¿Desea eliminar la campana?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('marketing.mark-campanas', 'deleteCampana', $id);
                    Swal.fire(
                        '¡Campana eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('eliminarProducto', $id => {
            Swal.fire({
                title: '¿Desea eliminar la venta?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-producto', 'eliminar', $id);
                    Swal.fire(
                        '¡Venta eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('eliminarProductoreg', $id => {
            Swal.fire({
                title: '¿Desea eliminar la venta?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.mis-registros', 'eliminar', $id);
                    Swal.fire(
                        '¡Venta eliminada!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('eliminarGasto', $id => {
            Swal.fire({
                title: '¿Desea eliminar el gasto?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-gastos', 'eliminar', $id);
                    Swal.fire(
                        '¡Gasto eliminado!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('eliminarGastoMicaja', $id => {
            Swal.fire({
                title: '¿Desea eliminar el gasto?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('tesoreria.micaja', 'eliminar', $id);
                    Swal.fire(
                        '¡Gasto eliminado!',
                        '',
                        'success'
                    )
                }
            })

        });

        Livewire.on('activarCita', $id => {
            Swal.fire({
                title: '¿Desea activar la cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('registros.reg-citas', 'activar', $id);
                    Swal.fire(
                        '¡Cita activada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('inactivarPago', $id => {
            Swal.fire({
                title: '¿Desea eliminar el pago?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('tesoreria.editar-pago-producto', 'eliminar', $id);
                    Swal.fire(
                        '¡Pago eliminado!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('activarOperativo', $id => {
            Swal.fire({
                title: '¿Desea activar la cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('operativos.editar-operativo', 'activar', $id);
                    Swal.fire(
                        '¡Cita Activada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('confimarOperativo', $id => {
            Swal.fire({
                title: '¿Confirmar cita?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('operativos.editar-operativo', 'confirmar', $id);
                    Swal.fire(
                        '¡Cita confirmada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('confimarPago', $id => {
            Swal.fire({
                title: '¿Confirmar el pago?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('cobranza.editar-cobranza', 'confirmar', $id);
                    Swal.fire(
                        '¡Cobranza confirmada!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('cambiar', $seleccion => {
            Livewire.emitTo('mmensajeria.chat-general', 'cambiar', $seleccion);
        });
        Livewire.on('datosActualizados', function(areasData, valoresData) {
            actualizarGraficaBarras(areasData, valoresData);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var boton = document.getElementById('boton');
            var lista = document.getElementById('lista');

            boton.addEventListener('click', function() {
                if (lista.classList.contains('hidden')) {
                    lista.classList.remove('hidden');

                } else {
                    lista.classList.add('hidden');

                }
            });
        });
    </script>

</body>
<!-- Library Bundle Script -->
<script src="<?php echo e(asset('assets/js/core/libs.min.js')); ?>"></script>

<!-- External Library Bundle Script -->
<script src="<?php echo e(asset('assets/js/core/external.min.js')); ?>"></script>

<!-- Widgetchart Script -->
<script src="<?php echo e(asset('assets/js/charts/widgetcharts.js')); ?>"></script>

<!-- mapchart Script -->
<script src="<?php echo e(asset('assets/js/charts/vectore-chart.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/charts/dashboard.js')); ?>"></script>

<!-- fslightbox Script -->
<script src="<?php echo e(asset('assets/js/plugins/fslightbox.js')); ?>"></script>

<!-- Settings Script -->
<script src="<?php echo e(asset('assets/js/plugins/setting.js')); ?>"></script>

<!-- Slider-tab Script -->
<script src="<?php echo e(asset('assets/js/plugins/slider-tabs.js')); ?>"></script>

<!-- Form Wizard Script -->
<script src="<?php echo e(asset('assets/js/plugins/form-wizard.js')); ?>"></script>

<!-- AOS Animation Plugin-->
<script src="<?php echo e(asset('assets/vendor/aos/dist/aos.js')); ?>"></script>

<!-- App Script -->
<script src="<?php echo e(asset('assets/js/hope-ui.js')); ?>" defer></script>


</html>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>