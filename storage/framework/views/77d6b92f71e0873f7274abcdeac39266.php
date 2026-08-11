<!DOCTYPE html>

<head>
    <html lang="es">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TRIBECA SOHO | SISTEMA</title>
    
    <meta charset="utf-8" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <?php if(isset($header)): ?>
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>
        <main>
            <?php echo e($slot); ?>

        </main>
    </div>
    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo \Livewire\Livewire::scripts(); ?>

    <?php echo $__env->yieldPushContent('js'); ?>
    
    <script>
        let map;

        // Función para inicializar el mapa
        function initMap() {
            if (!map) {
                map = L.map('map');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);
                map.on('load', function() {
                    // Desaparecer el preloader
                    const verchat = document.querySelector('.verchat');

                    // Cambiar el estilo display para hacerlo visible
                    verchat.style.display = 'no';

                });
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 13);
                    // Desaparecer el preloader
                    const verchat = document.querySelector('.verchat');

                    // Cambiar el estilo display para hacerlo visible
                    verchat.style.display = 'no';
                }, function() {
                    map.setView([51.505, -0.09], 13); // Vista predeterminada
                });
            }
        }

        // Escuchar actualizaciones de Livewire para reiniciar el mapa
        Livewire.on('refreshMap', () => {
            map.remove();
            initMap();
        });

        // Lógica para la selección del área
        let isSelecting = false;
        let points = []; // Array para las coordenadas seleccionadas
        let polygon = null; // Polígono en el mapa



        map.on('click', function(e) {
            if (isSelecting) {
                const latLng = [e.latlng.lat, e.latlng.lng];
                points.push(latLng);
                L.circle(latLng, {
                    radius: 5,
                    color: 'black',
                    fillColor: 'black',
                    fillOpacity: 1
                }).addTo(map);
            }
        });
    </script>
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
                        label: 'Pedidos',
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
                options: {}
            });
        });
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
        Livewire.on('sacarboton', datos => {
            console.log("Evento actualizado recibido en Livewire");
            sacarboton();
        });

        function sacarboton() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        }

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
        Livewire.on('inactivarTrataminetoCliente', $id => {
            Swal.fire({
                title: '¿Desea eliminar tratamiento?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('operativos.accion.eliminar', 'eliminarTratamientoVista', $id);
                    // Swal.fire(
                    //     '¡Tratamiento eliminado!',
                    //     '',
                    //     'success'
                    // )
                    return;
                }
            })
        });

        Livewire.on('borrarTipoHabitacion', $id => {
            Swal.fire({
                title: '¿Desea eliminar este tipo de habitación?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('tipos.lista-tipo', 'eliminarTipo', $id);
                    Swal.fire(
                        '¡Tipo de departamento eliminado!',
                        '',
                        'success'
                    )
                }
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
        Livewire.on('borrarRoles', $id => {
            Swal.fire({
                title: '¿Desea eliminar este rol?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('roles.lista-roles', 'borrarRol', $id);
                    Swal.fire(
                        '¡Rol eliminado!',
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
        Livewire.on('updateIframe', function() {
            // Obtén el iframe por su ID
            var iframe = document.getElementById('calendarioIframe');
            // Actualiza la URL del iframe para recargarlo
            iframe.src = iframe.src;
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
                title: '¿Remarketing?',
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
                        '¡Pedido Desactivado!',
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
    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>
<?php /**PATH /home/guislain/tribeca.guislaincorp.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>