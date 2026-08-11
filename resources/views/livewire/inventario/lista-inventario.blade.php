<div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.mini.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <div class="card">
        <div class="card-header d-flex justify-content-between ">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>
            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda">
            <div class="justify-end">
                @livewire('inventario.crear-producto')
            </div>

            <br>
        </div>
        <style>

        </style>


        <style>
            .boton-container {
                display: flex;
                /* justify-content: space-between; */
            }

            .boton {
                padding: 10px 20px;
                font-size: 16px;
                /* Utilizamos unidades de medida relativas */
                width: 30%;
            }

            /* Aplicamos estilos diferentes para pantallas más pequeñas */
            @media screen and (max-width: 600px) {
                .boton {
                    font-size: 9px;
                    width: 22%;
                }
            }
        </style>
        <div class="card-header d-flex justify-content-between ">
            <div class="form-group" style="margin-right: 5%;">
                <label>Vista de inventarios: </label>
                <select wire:model="vistaproductos">
                    <option value="">Todos</option>
                    <option value="saldo">Solo con saldo</option>
                </select>
            </div>
            <div class="form-group" style="margin-right: 5%;">
                <label>Sucursal: </label>
                <select wire:model="sucursal">

                    <option value="">Todas</option>
                    @foreach ($areas as $lista)
                        <option value="{{ $lista->area }}">{{ $lista->area }}</option>
                    @endforeach
                </select>
            </div>
            <button class="ml-2 mr-2 btn btn-warning"id="descargarExcelSaldos">Exportar solo saldos</button>
            <button class="ml-2 mr-2 btn btn-success"id="descargarExcel">Exportar a
                Excel</button>
            @livewire('inventario.carga-masiva')

        </div>

        <div class="px-4 card-body">
            <div class="table-responsive" wire:loading.lazy>

                <table id="mitabla-i" class="table table-striped" role="grid" data-bs-toggle="data-table">
                    <thead>
                        <tr class="ligth">

                            <th>Identificacion</th>
                            <th>SUCURSAL</th>
                            <th>PRODUCTO</th>
                            <th>DESCRIPCION</th>
                            <th>STOCK</th>
                            <th>PRECIO</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            td {
                                max-width: 200px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }
                        </style>
                        @foreach ($productoslist as $lista)
                            <tr>

                                <td>{{ $lista->id }}</td>
                                <td>{{ $lista->sucursal }}</td>
                                <td>{{ $lista->nombre }}</td>
                                <td>{{ $lista->descripcion }}</td>
                                <td>{{ $lista->cantidad }}</td>
                                <td>{{ $lista->precio }}</td>
                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        @livewire('inventario.editar-producto', ['producto' => $lista], key($lista->id))
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $productoslist->links() }}
            </div>
        </div>
    </div>
    <div id="sucursalData" data-sucursal="<?php echo htmlspecialchars($sucursal); ?>"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
    <script>
        document.getElementById('descargarExcelSaldos').addEventListener('click', function() {
            var sucursal = document.getElementById('sucursalData').getAttribute('data-sucursal');
            var fecha = @json($fecha);
            var url = 'https://spamiora.ddns.net/api/saldos/' + encodeURIComponent(sucursal);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tratamientos = data.map(item => ({
                        nombre: item.nombre,
                        cantidad: item.cantidad,
                        precio: item.precio
                    }));

                    const workbook = XLSX.utils.book_new();
                    const worksheet = XLSX.utils.json_to_sheet(tratamientos);
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'INVENTARIO' + sucursal);
                    const excelBuffer = XLSX.write(workbook, {
                        bookType: 'xlsx',
                        type: 'array'
                    });
                    const blob = new Blob([excelBuffer], {
                        type: 'application/octet-stream'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    var cad = 'SALDOSINVENTARIO' + sucursal + '-' + fecha + '.xlsx';
                    a.download = cad;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <script>
        document.getElementById('descargarExcel').addEventListener('click', function() {
            var sucursal = document.getElementById('sucursalData').getAttribute('data-sucursal');
            var fecha = @json($fecha);
            var url = 'https://spamiora.ddns.net/api/habitaciones/' + encodeURIComponent(sucursal);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tratamientos = data.map(item => ({
                        nombre: item.nombre,
                        cantidad: item.cantidad,
                        precio: item.precio
                    }));

                    const workbook = XLSX.utils.book_new();
                    const worksheet = XLSX.utils.json_to_sheet(tratamientos);
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'INVENTARIO' + sucursal);
                    const excelBuffer = XLSX.write(workbook, {
                        bookType: 'xlsx',
                        type: 'array'
                    });
                    const blob = new Blob([excelBuffer], {
                        type: 'application/octet-stream'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    var cad = 'INVENTARIO-' + sucursal + '-' + fecha + '.xlsx';
                    a.download = cad;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    {{-- <script>
        function exportToExcel() {
            const table = document.getElementById('mitabla-i');
            const data = [];
            // Recorrer las filas del cuerpo de la tabla
            for (let i = 0; i < table.rows.length; i++) {
                const row = [];
                const cells = table.rows[i].querySelectorAll(
                    'td:nth-child(n+3):not(:last-child)'); // Excluir las primeras dos columnas y la última columna
                // Recorrer las celdas de datos de la fila y agregar los textos a la matriz de datos
                for (let j = 0; j < cells.length; j++) {
                    row.push(cells[j].innerText);
                }
                data.push(row);
            }
            // Agregar encabezados personalizados
            const headers = ["Nombre", "Cantidad", "Precio"];
            data.unshift(headers);
            // Eliminar la primera fila si está en blanco
            if (data.length > 0 && data[0].length === 0) {
                data.shift();
            }
            // Crear un libro de Excel utilizando SheetJS
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            // Convertir el libro de Excel en un archivo binario
            const wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                type: 'binary'
            });
            const buf = new ArrayBuffer(wbout.length);
            const view = new Uint8Array(buf);
            for (let i = 0; i < wbout.length; i++) view[i] = wbout.charCodeAt(i) & 0xFF;
            // Crear una instancia de Blob para almacenar los datos del XLSX
            const blob = new Blob([buf], {
                type: 'application/octet-stream'
            });
            // Utilizar FileSaver.js para guardar el archivo
            saveAs(blob, 'tabla_excel.xlsx');
        }
    </script> --}}
    <style>
        # {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }

        # .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #52b1e5;

            border-radius: 50%;

            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div id="">
        <div class="spinner"></div>
    </div>
    <script>
        // resources/js/app.js (o cualquier otro archivo JavaScript principal)

        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.sent', function() {
                document.getElementById('').style.display = 'flex';
            });

            Livewire.hook('message.processed', function() {
                document.getElementById('').style.display = 'none';
            });
        });
    </script>
</div>
