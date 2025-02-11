<?php
require 'auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Статистика посещений</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Статистика посещений</h1>
    
    <div style="width: 800px;">
        <canvas id="hourlyChart"></canvas>
    </div>
    
    <div style="width: 600px;">
        <canvas id="citiesChart"></canvas>
    </div>

    <script>
        async function loadData(url) {
            const response = await fetch(url);
            return await response.json();
        }

        async function initCharts() {
            const [hourlyData, citiesData] = await Promise.all([
                loadData('api/hourly.php'),
                loadData('api/cities.php')
            ]);

            new Chart(document.getElementById('hourlyChart'), {
                type: 'line',
                data: {
                    labels: hourlyData.map(d => new Date(d.hour).toLocaleString()),
                    datasets: [{
                        label: 'Посещений/час',
                        data: hourlyData.map(d => d.visits),
                        borderColor: '#36a2eb'
                    }]
                }
            });

            new Chart(document.getElementById('citiesChart'), {
                type: 'pie',
                data: {
                    labels: citiesData.map(d => d.city),
                    datasets: [{
                        data: citiesData.map(d => d.count),
                        backgroundColor: ['#ff6384', '#4bc0c0', '#ff9f40', '#9966ff']
                    }]
                }
            });
        }
        
        initCharts();
    </script>
</body>
</html>