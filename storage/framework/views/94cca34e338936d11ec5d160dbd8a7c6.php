<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">GASTO SEMANAL (SUCURSALES)</h4>
    <div>
        <canvas id="densityCanvassg"></canvas>
    </div>
    <script>
        var lunes = {
            label: 'LUNES',
            data: <?php echo json_encode($sumalunes, 15, 512) ?>,
            backgroundColor: 'rgba(255, 0, 0, 0.6)', // Rojo oscuro
            borderColor: 'rgba(255, 0, 0, 1)', // Rojo brillante
        };

        var martes = {
            label: 'MARTES',
            data: <?php echo json_encode($sumamartes, 15, 512) ?>,
            backgroundColor: 'rgba(0, 128, 0, 0.6)', // Verde oscuro
            borderColor: 'rgba(0, 128, 0, 1)', // Verde brillante
        };

        var miercoles = {
            label: 'MIÉRCOLES',
            data: <?php echo json_encode($sumamiercoles, 15, 512) ?>,
            backgroundColor: 'rgba(0, 0, 128, 0.6)', // Azul oscuro
            borderColor: 'rgba(0, 0, 128, 1)', // Azul brillante
        };

        var jueves = {
            label: 'JUEVES',
            data: <?php echo json_encode($sumajueves, 15, 512) ?>,
            backgroundColor: 'rgba(255, 0, 255, 0.6)', // Magenta oscuro
            borderColor: 'rgba(255, 0, 255, 1)', // Magenta brillante
        };


        var viernes = {
            label: 'VIERNES',
            data: <?php echo json_encode($sumaviernes, 15, 512) ?>,
            backgroundColor: 'rgba(255, 165, 0, 0.6)', // Naranja oscuro
            borderColor: 'rgba(255, 165, 0, 1)', // Naranja brillante
        };

        var sabado = {
            label: 'SÁBADO',
            data: <?php echo json_encode($sumasabado, 15, 512) ?>,
            backgroundColor: 'rgba(128, 0, 128, 0.6)', // Púrpura oscuro
            borderColor: 'rgba(128, 0, 128, 1)', // Púrpura brillante
        };

        var domingo = {
            label: 'DOMINGO',
            data: <?php echo json_encode($sumadomingo, 15, 512) ?>,
            backgroundColor: 'rgba(0, 128, 128, 0.6)', // Verdeazulado oscuro
            borderColor: 'rgba(0, 128, 128, 1)', // Verdeazulado brillante
        };


        var planetData = {
            labels: <?php echo json_encode($areaslist, 15, 512) ?>,
            datasets: [lunes, martes, miercoles, jueves, viernes, sabado, domingo]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvassg");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>
</div>
<?php /**PATH /home/hotelroj/public_html/resources/views/livewire/estadistica/sucursal-gasto-semanal.blade.php ENDPATH**/ ?>