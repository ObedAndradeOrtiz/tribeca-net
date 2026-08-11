<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">INGRESOS Y GASTOS DE CAJA DIARIO (SUCURSALES)</h4>
    <div>
        <canvas id="densityCanvas"></canvas>
    </div>


    <script>
        var densityData = {
            label: 'EFECTIVO',
            data: <?php echo json_encode($sumasucursales, 15, 512) ?>,
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderColor: 'rgba(0, 99, 132, 1)',
        };
        var gravityData = {
            label: 'GASTOS',
            data: <?php echo json_encode($sumagastos, 15, 512) ?>,
            backgroundColor: 'rgba(99, 132, 0, 0.6)',
            borderColor: 'rgba(99, 132, 0, 1)',
        };

        var planetData = {
            labels: <?php echo json_encode($areaslist, 15, 512) ?>,
            datasets: [densityData, gravityData]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvas");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/estadistica/sucursal-diario.blade.php ENDPATH**/ ?>