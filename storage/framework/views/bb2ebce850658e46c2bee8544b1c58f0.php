<div>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.mini.min.js"></script>
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
} elseif ($_instance->childHasBeenRendered('l3198032933-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3198032933-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3198032933-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3198032933-0');
} else {
    $response = \Livewire\Livewire::mount('inmuebles.crear-inmuebles');
    $html = $response->html();
    $_instance->logRenderedChild('l3198032933-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
        <div class="flex flex-row justify-end px-2 py-2 mt-4 mr-4">
            
            <button class="ml-2 mr-2 btn btn-success"id="descargarExcel">Exportar a
                Excel</button>

            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventario.carga-masiva-activos')->html();
} elseif ($_instance->childHasBeenRendered('l3198032933-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3198032933-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3198032933-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3198032933-1');
} else {
    $response = \Livewire\Livewire::mount('inventario.carga-masiva-activos');
    $html = $response->html();
    $_instance->logRenderedChild('l3198032933-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between ">
            <div class="form-group" style="margin-right: 5%;">
                <label>Sucursal: </label>
                <select wire:model="sucursal">
                    <option value="">Seleccione sucursal</option>
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
                            <th>SUCURSAL</th>
                            <th>AREA</th>
                            <th>TIPO</th>
                            <th>NOMBRE</th>
                            <th>DETALLE</th>
                            <th>ESTADO</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO</th>
                            <th>FECHA ADQUIRIDO</th>
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
                                <td><?php echo e($lista->sucursal); ?></td>
                                <td><?php echo e($lista->area); ?></td>
                                <td><?php echo e($lista->tipo); ?></td>
                                <td><?php echo e($lista->nombre); ?></td>
                                <td><?php echo e($lista->descripcion); ?></td>
                                <td><?php echo e($lista->estado); ?></td>
                                <td><?php echo e($lista->cantidad); ?></td>
                                <td><?php echo e($lista->precio); ?></td>
                                <td><?php echo e($lista->fecha); ?></td>
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
    <div id="sucursalData" data-sucursal="<?php echo htmlspecialchars($sucursal); ?>"></div>
    <script>
        document.getElementById('descargarExcel').addEventListener('click', function() {
            var sucursal = document.getElementById('sucursalData').getAttribute('data-sucursal');
            var fecha = <?php echo json_encode($fecha, 15, 512) ?>;
            var url = 'https://spamiora.ddns.net/api/inmuebles/' + encodeURIComponent(sucursal);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tratamientos = data.map(item => ({
                        sucursal: item.sucursal,
                        area: item.area,
                        tipo: item.tipo,
                        nombre: item.nombre,
                        detalle: item.descripcion,
                        estado: item.estado,
                        cantidad: item.cantidad,
                        precio: item.precio,
                        fecha: item.fecha,
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
<?php /**PATH D:\1.DIGIPROJECTS\9.TRIBECA\1.CODE\public_html\resources\views/livewire/inmuebles/lista-inmuebles.blade.php ENDPATH**/ ?>