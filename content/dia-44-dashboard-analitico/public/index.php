<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Analítico // ByChoke</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Dashboard Analítico de Minerales</h1>
                <p class="text-xs text-slate-400">Datos dinámicos asíncronos consumidos desde backend PHP</p>
            </div>
            <button onclick="loadChartData()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">
                Recargar Datos
            </button>
        </div>

        <div class="relative w-full h-[400px]">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>

    <script>
        let myChart = null;

        async function loadChartData() {
            try {
                // Hacer fetch al endpoint PHP
                const response = await fetch('api.php');
                const data = await response.json();

                const ctx = document.getElementById('analyticsChart').getContext('2d');
                
                if (myChart) {
                    myChart.destroy();
                }

                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error al cargar datos del gráfico:', error);
            }
        }

        // Cargar al inicio
        document.addEventListener('DOMContentLoaded', loadChartData);
    </script>
</body>
</html>
