<!doctype html>
<html lang="es" dir="ltr">
<head>
    @livewireStyles
</head>
<body>
    @yield('content')

    <main>
        <div wire:ignore> {{ $slot }}</div>
    </main>
    @livewireScripts
    <script>
        Livewire.on('alert', function(message) {
            Swal.fire(
                message,
                '',
                'success'
            )
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
        Livewire.on('inactivarOperativo', $id => {
            Swal.fire({
                title: '¿Desea desactivar la cita?',
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
                        '¡Operativo Desactivado!',
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
                        '¡Operativo Activado!',
                        '',
                        'success'
                    )
                }
            })

        });
        Livewire.on('confimarOperativo', $id => {
            Swal.fire({
                title: '¿Operativo exitoso?',
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
                        '¡Operativo a la espera de clientes!',
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
    </script>
</body>

</html>
