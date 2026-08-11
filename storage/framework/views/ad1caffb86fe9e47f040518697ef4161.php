<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">LLAMADAS REALIZADAS/ AGENDADAS / ASITENCIA(DIARIO)</h4>
    <div style="height: 300px;">
        <canvas style="height: 100%; width: 100%;" id="densityCanvasllama" ></canvas>
    </div>

    <script>
        var llamadas = {
            label: 'LLAMADAS',
            data: <?php echo json_encode($llamadas, 15, 512) ?>,
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderColor: 'rgba(0, 99, 132, 1)',
        };
        var agendados = {
            label: 'AGENDADOS',
            data: <?php echo json_encode($agendados, 15, 512) ?>,
            backgroundColor: 'rgba(99, 132, 0, 0.6)',
            borderColor: 'rgba(99, 132, 0, 1)',
        };

        var asistidos = {
            label: 'ASISTIDOS',
            data: <?php echo json_encode($asistidos, 15, 512) ?>,
            backgroundColor: 'rgba(0, 0, 128, 0.6)', // Azul oscuro
            borderColor: 'rgba(0, 0, 128, 1)', // Azul brillante
        };
        var remarketing = {
            label: 'REMARKETING',
            data: <?php echo json_encode($remarketing, 15, 512) ?>,
            backgroundColor: 'rgba(255, 165, 0, 0.6)', // Naranja oscuro
            borderColor: 'rgba(255, 165, 0, 1)', // Naranja brillante
        };

        var planetData = {
            labels: <?php echo json_encode($areaslist, 15, 512) ?>,
            datasets: [llamadas, agendados, asistidos, remarketing]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvasllama");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/estadistica/llamadas-diario.blade.php ENDPATH**/ ?>