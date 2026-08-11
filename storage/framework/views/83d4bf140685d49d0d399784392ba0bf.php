<div>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.mini.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hope-ui.min.css?v=2.0.0')); ?>" />
    <div class="card">
        <div class="card-header d-flex justify-content-between ">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>
            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda">
            <div class="justify-end">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.crear-inmuebles')->html();
} elseif ($_instance->childHasBeenRendered('l59737348-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l59737348-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l59737348-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l59737348-0');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.crear-inmuebles');
    $html = $response->html();
    $_instance->logRenderedChild('l59737348-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
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
                <label>Sucursal: </label>
                <select wire:model="sucursal">
                    <option>Seleccione sucursal</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="px-4 card-body">
            <div class="table-responsive" wire:loading.lazy>

                <table id="mitabla-i" class="table table-striped" role="grid" data-bs-toggle="data-table">
                    <thead>
                        <tr class="ligth">

                            <th>ID</th>
                            <th>SUCURSAL</th>
                            <th>NOMBRE</th>
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
                        <?php $__currentLoopData = $productoslist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td><?php echo e($lista->id); ?></td>
                                <td><?php echo e($lista->sucursal); ?></td>
                                <td><?php echo e($lista->nombre); ?></td>
                                <td><?php echo e($lista->cantidad); ?></td>
                                <td><?php echo e($lista->precio); ?></td>
                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inmuebles.editar-inmuebles', ['producto' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('inmuebles.editar-inmuebles', ['producto' => $lista]);
    $html = $response->html();
    $_instance->logRenderedChild($lista->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($productoslist->links()); ?>

            </div>
        </div>
    </div>
    <script>
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
    </script>
    <style>
        #preloader {
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

        #preloader .spinner {
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
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <script>
        // resources/js/app.js (o cualquier otro archivo JavaScript principal)

        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.sent', function() {
                document.getElementById('preloader').style.display = 'flex';
            });

            Livewire.hook('message.processed', function() {
                document.getElementById('preloader').style.display = 'none';
            });
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/inmuebles/lista-inmuebles.blade.php ENDPATH**/ ?>