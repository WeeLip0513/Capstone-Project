<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report</title>
    <link rel="stylesheet" href="../css/adminPage/summaryReport.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="summary-report-container">
        <h2>SUMMARY REPORT</h2>
        <h3>Track Growth, Analyze Trends, Make Informed Decisions.</h3>
        <div class="summary-report-form">
            <h4>Select Year & Month: </h4>
            <div class="summary-report-selection">
                <select name="year" id="yearSelect" required>
                    <option value="">Year</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>

                <select name="month" id="monthSelect" required>
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
                <button onclick="loadChart()">Load Data</button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="summaryReportChart"></canvas>
        </div>
        <div class="summary-description">
            <h3>Description:</h3>
            <div id="summaryDes"></div>
        </div>
    </div>

    <script>
        let chart = null;

        async function fetchCarpoolSummary(year, month) {
            try {
                const routesResponse = await fetch(`../php/admin/generatePopularRoutes.php?year=${year}&month=${month}`);
                const routes = await routesResponse.json();

                const earningsResponse = await fetch(`../php/admin/generateEarningsReport.php?year=${year}`);
                const earnings = await earningsResponse.json();

                const usersResponse = await fetch(`../php/admin/generateUserReport.php?year=${year}&month=${month}`);
                const users = await usersResponse.json();

                const monthEarnings = earnings.find(e => e.month == month);

                return {
                    newDrivers: users.drivers.reduce((a, b) => a + b, 0),
                    newPassengers: users.passengers.reduce((a, b) => a + b, 0),
                    driverRevenue: monthEarnings ? monthEarnings.total_driver_revenue : 0,
                    appRevenue: monthEarnings ? monthEarnings.total_app_revenue : 0,
                    mostPopularRoute: routes.length > 0 ? routes[0] : null  
                };
            } catch (error) {
                console.error('Error fetching carpool summary:', error);
                return null;
            }
        }

        function createCarpoolSummaryPieChart(summaryData, year, month) {
            const labels = ['New Drivers', 'New Passengers', 'Driver Revenue (RM)', 'App Revenue (RM)'];
            const data = [
                summaryData.newDrivers,
                summaryData.newPassengers,
                summaryData.driverRevenue,
                summaryData.appRevenue
            ];
            const backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'];

            if (summaryData.mostPopularRoute) {
                labels.push(`Most Popular Route: ${summaryData.mostPopularRoute.route}`);
                data.push(summaryData.mostPopularRoute.count);
                backgroundColors.push('#9966FF');
            }

            if (chart) {
                chart.destroy();
            }

            const ctx = document.getElementById('summaryReportChart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allows resizing
                    plugins: {
                        title: {
                            display: true,
                            text: `APool Summary - ${month}/${year}`,
                            font: {
                                size: 20,
                            }
                        }
                    }
                }
            });
        }

        async function generateCarpoolSummary(year, month) {
            if (!year || !month) {
                alert("Please select both year and month.");
                return;
            }

            const summaryData = await fetchCarpoolSummary(year, month);
            
            if (summaryData) {
                createCarpoolSummaryPieChart(summaryData, year, month);
                displaySummaryDetails(summaryData);
            } else {
                console.error('Failed to fetch carpool summary data');
            }
        }

        function displaySummaryDetails(summaryData) {
            document.getElementById('summaryDes').innerHTML = `
                <p><strong>New Drivers:</strong> ${summaryData.newDrivers}</p>
                <p><strong>New Passengers:</strong> ${summaryData.newPassengers}</p>
                <p><strong>Driver Revenue:</strong> RM${summaryData.driverRevenue}</p>
                <p><strong>App Revenue:</strong> RM${summaryData.appRevenue}</p>
                ${summaryData.mostPopularRoute ? `<p><strong>Most Popular Route:</strong> ${summaryData.mostPopularRoute.route} (${summaryData.mostPopularRoute.count} trips)</p>` : ''}
            `;
        }

        function loadChart() {
            const year = document.getElementById('yearSelect').value;
            const month = document.getElementById('monthSelect').value;
            generateCarpoolSummary(year, month);
        }

        function autoLoadCurrentMonthChart() {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1;

            document.getElementById('yearSelect').value = currentYear;
            document.getElementById('monthSelect').value = currentMonth;

            generateCarpoolSummary(currentYear, currentMonth);
        }

        document.addEventListener('DOMContentLoaded', autoLoadCurrentMonthChart);
    </script>

    <style>
        .chart-container {
            width: 100%;
            max-width: 600px;
            height: 400px;
            margin: auto;
        }
        #summaryReportChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</body>
</html>
