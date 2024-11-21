import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('myChart').getContext('2d');

    // Los datos dinámicos se pasan desde el blade
    const data = JSON.parse(document.getElementById('chart-data').textContent);

    new Chart(ctx, {
        type: 'bar', // Cambiar a 'line', 'pie', etc. según el gráfico
        data: {
            labels: data.labels,
            datasets: data.datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: data.datasets.label
                }
            }
        }
    });
});
