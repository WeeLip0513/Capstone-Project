<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Routes Report</title>
    <link rel="stylesheet" href="../css/adminPage/popularRoute.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="popularRoutes-report-container">
        <h2>POPULAR ROUTES REPORT</h2>
        <h3>Check out the most popular routes.</h3>
        <div class="popularRoutes-report-form">
            <h4>Select Year & Month: </h4>
            <div class="popularRoutes-report-selection">
                <select name = "year" id="yearSelect" required>
                    <option value="">Year</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>

                <select name = "month" id="monthSelect" required>
                    <option value="">Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <button onclick="loadChart(document.getElementById('yearSelect').value, document.getElementById('monthSelect').value)">Load Data</button>
            </div>
        </div>
        <div class="chart-container">
            <div id="popularRoutesSummary" class="chart-summary"></div>
                <div class="chart-not-display"></div>
            <canvas id="popularRoutesChart"></canvas>
        </div>
    </div>
    <script>
    function loadChart(year, month) {
        if (!year || !month) {
            alert("Please select both year and month.");
            return;
        }

        fetch(`../php/admin/generatePopularRoutes.php?year=${year}&month=${month}`)
            .then(response => response.json())
            .then(data => {
                const summaryContainer = document.getElementById('popularRoutesSummary');
                const chartContainer = document.getElementById('popularRoutesChart');

                if (data.length === 0) {
                    summaryContainer.textContent = `No records found for ${getMonthName(month)} ${year}. There may have been no rides during this period.`;
                    chartContainer.style.display = "none"; // Hide chart if no data
                    return;
                }

                chartContainer.style.display = "block"; // Show chart if data exists
                const labels = data.map(route => route.route);
                const counts = data.map(route => route.count);

                // Find most and least popular routes
                const maxIndex = counts.indexOf(Math.max(...counts));
                const minIndex = counts.indexOf(Math.min(...counts));

                const maxRoute = labels[maxIndex];
                const minRoute = labels[minIndex];

                summaryContainer.textContent = `In ${getMonthName(month)} ${year}, the most popular route was "${maxRoute}", while the least popular was "${minRoute}".`;

                renderChart(labels, counts, month, year);
            })
            .catch(error => console.error("Error loading data:", error));
    }

    function renderChart(labels, data, month, year) {
        const ctx = document.getElementById('popularRoutesChart').getContext('2d');

        // Destroy previous chart instance if exists
        if (window.popularRoutesChart instanceof Chart) {
            window.popularRoutesChart.destroy();
        }

        window.popularRoutesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Completed Rides',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Horizontal bar chart
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Popular Routes - ${getMonthName(month)} ${year}`,
                        font: { size: 20 }
                    },
                    legend: { position: 'top' }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Rides',
                            font: { weight: 'bold', size: 16 }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Routes',
                            font: { weight: 'bold', size: 16 }
                        }
                    }
                }
            }
        });
    }

    function getMonthName(month) {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        return monthNames[month - 1];
    }
</script>
</body>
</html>