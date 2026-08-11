<div class="mt-4">
    <div class="col-md-12">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-26DzREYbjnO5tV7aSb3lVX4w2IlM9VzqUhZhmCZ8y+93S+OP6TGNcRTW2UfyM0lIatHsguP2pYjB+xWYzqOMdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <div class="card ">
            <div class="row">
                <div class="flex-wrap">
                    <div class="mt-2 ml-4 mr-4">
                        <div class="d-flex">
                            <h3>REGISTROS</h3>
                            <div class="ml-4 form-group" style="margin-right: 5%;">
                                <label>Tipo de registro: </label>
                                <select wire:model="botonRecepcion">
                                    <option value="clientes">AGENDADOS</option>
                                    <option value="citas">INGRESOS DE AGENDADOS</option>
                                    <option value="producto">VENTAS DE PRODUCTOS</option>
                                    <option value="traspaso">TRASPASO DE PRODUCTOS</option>
                                    <option value="creacion">CREACIÓN DE PRODUCTOS</option>
                                    <option value="modificacion">MODIFICACIÓN DE PRODUCTOS</option>
                                    <option value="compras">COMPRAS</option>
                                    <option value="gastos"> GASTOS</option>
                                    <option value="llamada"> LLAMADAS</option>

                                </select>
                            </div>
                        </div>

                        
                        
                    </div>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <?php if($botonRecepcion == 'llamada'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-llamadas')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-0');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-llamadas');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <?php if($botonRecepcion == 'clientes'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-citas')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-1');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-citas');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'citas'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-pagos')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-2');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-pagos');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'producto'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-producto')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-3');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-producto');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'gastos'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-gastos')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-4');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-gastos');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'traspaso'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-traspaso')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-5');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-traspaso');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'creacion'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-crear')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-6');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-crear');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'modificacion'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-edicion')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-7');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-edicion');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php if($botonRecepcion == 'compras'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('registros.reg-compras')->html();
} elseif ($_instance->childHasBeenRendered('l2660013722-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l2660013722-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2660013722-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2660013722-8');
} else {
    $response = \Livewire\Livewire::mount('registros.reg-compras');
    $html = $response->html();
    $_instance->logRenderedChild('l2660013722-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    
                </form>
            </div>
        </div>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
        <script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/registros/lista-registros.blade.php ENDPATH**/ ?>