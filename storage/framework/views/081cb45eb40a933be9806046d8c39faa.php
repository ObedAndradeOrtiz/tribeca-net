<div>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.mini.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <div class="card">
        <div class="card-header d-flex justify-content-between ">
            <div class="header-title">
                <h4 class="card-title"></h4>
            </div>
            <input type="text" class="form-control" id="exampleInputDisabled1" wire:model="busqueda">
            <div class="justify-end">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.crear-producto')->html();
} elseif ($_instance->childHasBeenRendered('l804979217-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l804979217-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l804979217-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l804979217-0');
} else {
    $response = \Livewire\Livewire::mount('inventario.crear-producto');
    $html = $response->html();
    $_instance->logRenderedChild('l804979217-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>

            <br>
        </div>
        <style>

        </style>
        <div class="flex flex-row justify-end px-2 py-2 mt-4 mr-4">
            <button class="ml-2 mr-2 btn btn-warning"id="descargarExcelSaldos">Exportar solo saldos</button>
            <button class="ml-2 mr-2 btn btn-success"id="descargarExcel">Exportar a
                Excel</button>

            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.carga-masiva')->html();
} elseif ($_instance->childHasBeenRendered('l804979217-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l804979217-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l804979217-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l804979217-1');
} else {
    $response = \Livewire\Livewire::mount('inventario.carga-masiva');
    $html = $response->html();
    $_instance->logRenderedChild('l804979217-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>

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

                            <th>Identificacion</th>
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
    $html = \Livewire\Livewire::mount('inventario.editar-producto', ['producto' => $lista])->html();
} elseif ($_instance->childHasBeenRendered($lista->id)) {
    $componentId = $_instance->getRenderedChildComponentId($lista->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($lista->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($lista->id);
} else {
    $response = \Livewire\Livewire::mount('inventario.editar-producto', ['producto' => $lista]);
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
            var fecha = <?php echo json_encode($fecha, 15, 512) ?>;
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
            var fecha = <?php echo json_encode($fecha, 15, 512) ?>;
            var url = 'https://spamiora.ddns.net/api/tratamientos/' + encodeURIComponent(sucursal);
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
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/inventario/lista-inventario.blade.php ENDPATH**/ ?>