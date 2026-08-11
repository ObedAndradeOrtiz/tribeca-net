<div>
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">

                </div>
            </div>
            <ul class="nav justify-content-center nav-pills">
                <li class="nav-item" style="flex: 1;">
                    <label class="nav-link <?php echo e($tipoingreso === 'ingresoexterno' ? 'nav-link active' : 'nav-link'); ?>"
                        wire:click="$set('tipoingreso','ingresoexterno')">Caja general</label>
                </li>
                <li class="nav-item" style="flex: 1;">
                    <label class="nav-link <?php echo e($tipoingreso === 'gastointerno' ? 'nav-link active' : 'nav-link'); ?>"
                        wire:click="$set('tipoingreso','gastointerno')">Panel Gastos</label>
                </li>
            </ul>

            <?php if($tipoingreso == 'ingresoexterno'): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.menu')->html();
} elseif ($_instance->childHasBeenRendered('l744168887-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l744168887-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l744168887-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l744168887-0');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.menu');
    $html = $response->html();
    $_instance->logRenderedChild('l744168887-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>

            <?php if($tipoingreso == 'gastointerno'): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tesoreria.egreso-interno')->html();
} elseif ($_instance->childHasBeenRendered('l744168887-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l744168887-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l744168887-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l744168887-1');
} else {
    $response = \Livewire\Livewire::mount('tesoreria.egreso-interno');
    $html = $response->html();
    $_instance->logRenderedChild('l744168887-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
        </div>
    </div>



</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('myButton').click();
        }, 1);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
        // Obtener el elemento de la tabla
        var table = document.getElementById("miTabla-users");

        // Crear un libro de Excel
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });

        // Guardar el libro de Excel en un archivo
        XLSX.writeFile(wb, "caja-usuarios.xlsx");
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project-1\resources\views/livewire/tesoreria/lista-tesoreria.blade.php ENDPATH**/ ?>