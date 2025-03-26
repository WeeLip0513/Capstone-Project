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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body>
    <div class="popularRoutes-report-container">
        <h2>POPULAR ROUTES REPORT</h2>
        <h3>Check Out The Most Popular Routes, Find the Routes That Drive Demand.</h3>
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
            <canvas id="popularRoutesChart"></canvas>
            <div class="summary-description">
                <h3>Description : </h3>
                <div id="summaryDes"></div>
            </div>
        </div>
    </div>
    <script>
    function loadChart(year, month) {
        // Validate inputs
        if (!year || !month) {
            alert("Please select both year and month.");
            return;
        }

        // Clear previous chart and summary
        const summaryElement = document.getElementById('popularRoutesSummary');
        const summaryDesContainer = document.querySelector('.summary-description');
        const summaryDesElement = document.getElementById('summaryDes');
        const chartCanvas = document.getElementById('popularRoutesChart');
        const chartContext = chartCanvas.getContext('2d');

        // Clear previous content
        summaryElement.innerHTML = '';
        summaryDesElement.innerHTML = ''; // Clear the description
        chartContext.clearRect(0, 0, chartCanvas.width, chartCanvas.height);

        // Hide description container by default
        summaryDesContainer.style.display = 'none';

        // Destroy previous chart if it exists
        if (window.popularRoutesChart instanceof Chart) {
            window.popularRoutesChart.destroy();
        }

        // Fetch data
        fetch(`../php/admin/generatePopularRoutes.php?year=${year}&month=${month}`)
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Get month name for display
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const monthName = monthNames[month - 1];

                // Check if data is an error object or empty
                if (data.error || !data || data.length === 0) {
                    summaryElement.innerHTML = `No rides found for ${monthName} ${year}. 
                        This could be due to:
                        No rides were completed during this period,
                        No data has been recorded for this month,
                        There might be a data collection issue.`;
                    
                    summaryElement.style.color = 'white';
                    // Ensure description container remains hidden
                    summaryDesContainer.style.display = 'none';
                    return;
                }

                // Find max and min routes
                const maxRoute = data.reduce((max, route) => 
                    route.count > max.count ? route : max
                );
                const minRoute = data.reduce((min, route) => 
                    route.count < min.count ? route : min
                );

                // Create summary text
                const summaryText = `In <strong><span style="color:#2b8dff">${monthName} ${year}</span></strong>, 
                     the most popular route was <strong><span style="color:#2b8dff">"${maxRoute.route}"</span></strong> 
                     with <strong>${maxRoute.count}</strong> rides, 
                     and the least popular route was <strong><span style="color:#2b8dff;">"${minRoute.route}"</span></strong>
                     with <strong>${minRoute.count}</strong> rides.`;

                document.getElementById('summaryDes').innerHTML = summaryText;
                    
                // Show description container and set text
                summaryDesContainer.style.display = 'block';
                summaryElement.style.color = 'white';
                summaryElement.style.fontStyle = 'normal';

                // Prepare data for chart
                const labels = data.map(route => route.route);
                const counts = data.map(route => route.count);

                renderChart(labels, counts, month, year);
            })
            .catch(error => {
                console.error("Error loading data:", error);
                
                // Get month name for display
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const monthName = monthNames[month - 1];

                // Display error message
                summaryElement.innerHTML = `Error retrieving data for ${monthName} ${year}. 
                    Please try again later or contact system administrator if the problem persists.
                    Error details: ${error.message}`;
                
                // Hide description container on error
                summaryDesContainer.style.display = 'none';
                summaryElement.style.color = 'red';
                summaryElement.style.fontStyle = 'italic';
            });
    }
    function renderChart(labels, counts, month, year) {
        const ctx = document.getElementById('popularRoutesChart').getContext('2d');

        // Get month name for display
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        const monthName = monthNames[month - 1];

        // Destroy previous chart instance if exists
        if (window.popularRoutesChart instanceof Chart) {
            window.popularRoutesChart.destroy();
        }

        window.popularRoutesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Rides',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    categoryPercentage: 0.8, // Adjusts spacing between bars
                    barPercentage: 0.8// Adjusts width of each bar
                }]
            },
            options: {
                indexAxis: 'y', // Horizontal bar chart
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Popular Routes - ${monthName} ${year}`,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: { 
                            display: true, 
                            text: 'Number of Rides',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    },
                    y: {
                        title: { 
                            display: true, 
                            text: 'Routes',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    }    
    function autoLoadCurrentMonthChart() {
        // Get current date
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-indexed

        // Set the year and month dropdowns to current values
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');

        // Set year
        yearSelect.value = currentYear;

        // Set month
        monthSelect.value = currentMonth;

        // Trigger chart loading
        loadChart(currentYear, currentMonth);
    }

    // Add event listener to run when the page loads
    document.addEventListener('DOMContentLoaded', autoLoadCurrentMonthChart);
</script>
</body>
</html>