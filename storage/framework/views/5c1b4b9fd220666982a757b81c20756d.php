<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <h4 class="mt-4 ml-2">CITAS ASISTIDAS MES ACTUAL</h4>


    <div>
        <canvas id="densityCanvacma"></canvas>
    </div>
    <script>
        var semana1 = {
            label: "<?php echo e($inicioSemana1); ?> al <?php echo e($finSemana1); ?>",
            data: <?php echo json_encode($suma1, 15, 512) ?>,
            backgroundColor: 'rgba(255, 0, 0, 0.6)', // Rojo oscuro
            borderColor: 'rgba(255, 0, 0, 1)', // Rojo brillante
        };

        var semana2 = {
            label: "<?php echo e($inicioSemana2); ?> al <?php echo e($finSemana2); ?>",
            data: <?php echo json_encode($suma2, 15, 512) ?>,
            backgroundColor: 'rgba(0, 128, 0, 0.6)', // Verde oscuro
            borderColor: 'rgba(0, 128, 0, 1)', // Verde brillante
        };

        var semana3 = {
            label: "<?php echo e($inicioSemana3); ?> al <?php echo e($finSemana3); ?>",
            data: <?php echo json_encode($suma3, 15, 512) ?>,
            backgroundColor: 'rgba(0, 0, 128, 0.6)', // Azul oscuro
            borderColor: 'rgba(0, 0, 128, 1)', // Azul brillante
        };

        var semana4 = {
            label: "<?php echo e($inicioSemana4); ?> al <?php echo e($finSemana4); ?>",
            data: <?php echo json_encode($suma4, 15, 512) ?>,
            backgroundColor: 'rgba(255, 0, 255, 0.6)', // Magenta oscuro
            borderColor: 'rgba(255, 0, 255, 1)', // Magenta brillante
        };
        var semana5 = {
            label: "<?php echo e($inicioSemana5); ?> al <?php echo e($finSemana5); ?>",
            data: <?php echo json_encode($suma5, 15, 512) ?>,
            backgroundColor: 'rgba(255, 165, 0, 0.6)', // Naranja oscuro
            borderColor: 'rgba(255, 165, 0, 1)', // Naranja brillante
        };


        var planetData = {
            labels: <?php echo json_encode($areaslist, 15, 512) ?>,
            datasets: [semana1, semana2, semana3, semana4, semana5]
        };
        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 0.5
                }],

            }
        };
        var densityCanvas = document.getElementById("densityCanvacma");
        var barChart = new Chart(densityCanvas, {
            type: 'bar',
            data: planetData,
            options: chartOptions
        });
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/estadistica/citas-mensual.blade.php ENDPATH**/ ?>