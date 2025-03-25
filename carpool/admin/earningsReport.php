<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earnings Report</title>
    <link rel="stylesheet" href="../css/adminPage/earningsReport.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="earnings-report-container">
        <h2>EARNINGS REPORT</h2>
        <h3>Report of Earnings each year.</h3>
        <div class="earnings-report-form">
            <h4>Select Year : </h4>
            <div class="earnings-report-selection">
                <select name = "year" id="yearSelect" required>
                    <option value="">Year</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
            <button onclick="loadChart(document.getElementById('yearSelect').value)">Load Data</button>            </div>
        </div>
        <div class="chart-container">
            <canvas id="earningsBarChart"></canvas>
        </div>
    </div>
<script>
let earningsChart = null;

function loadChart(year) {
    if (!year) {
        alert("Please select a year.");
        return;
    }

    fetch(`../php/admin/generateEarningsReport.php?year=${year}`)
        .then(response => response.json())
        .then(data => {
            renderChart(data, year);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Failed to load data. Please try again.');
        });
}

// Helper function to get month names
function getMonthName(monthIndex) {
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    return monthNames[monthIndex - 1];
}

function renderChart(data, year) {
    const ctx = document.getElementById('earningsBarChart').getContext('2d');

    // Destroy existing chart if it exists
    if (earningsChart) {
        earningsChart.destroy();
    }

    // Prepare labels and data arrays
    const labels = [];
    const driverRevenue = [];
    const appRevenue = [];

    // Initialize data array with zero for all months
    for (let i = 1; i <= 12; i++) {
        labels.push(getMonthName(i));
        driverRevenue.push(0);
        appRevenue.push(0);
    }

    // Populate data from fetched result
    data.forEach(item => {
        const monthIndex = parseInt(item.month);
        driverRevenue[monthIndex - 1] = parseFloat(item.total_driver_revenue);
        appRevenue[monthIndex - 1] = parseFloat(item.total_app_revenue);
    });

    // Create bar chart
    earningsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Driver Revenue',
                    data: driverRevenue,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'App Revenue',
                    data: appRevenue,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Revenue Breakdown for ${year}`,
                    font: { size: 20
                            }
                },
                legend: { position: 'top' }
            },
            scales: {
                x: {
                    title: {display: true,
                            text: 'Month',
                            font: {
                                size: 16,
                                weight: 'bold'
                                }
                        }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, 
                            text: 'Revenue (RM)',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                     }
                }
            }
        }
    });
}
</script>
</body>
</html>