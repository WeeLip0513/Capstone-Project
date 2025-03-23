<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Report</title>
    <link rel="stylesheet" href="../css/adminPage/userReport.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body>
    <div class="user-report-container">
        <h2>USER REPORT</h2>
        <h3>Select to display the growth of new users.</h3>
        <div class="user-report-form">
            <h4>Select Year & Month: </h4>
            <div class="user-report-selection">
                <select name = "year" id="yearSelect" required>
                    <option value="">Year</option>
                    <option value="2025">2025</option>
                    <option value="2025">2024</option>
                    <option value="2025">2023</option>
                    <option value="2025">2022</option>
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
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>
    <script>
        let chart = null;

        function loadChart(year, month) {
            if (!year || !month) {
                alert("Please select both year and month");
                return;
            }

            // Fetch data via AJAX
            fetch(`../php/admin/generateUserReport.php?year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    renderChart(data, year, month);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert("Error loading data. Please try again.");
                });
        }

        function renderChart(data, year, month) {
            const ctx = document.getElementById('userGrowthChart').getContext('2d');
            
            // Destroy previous chart if exists
            if (chart) {
                chart.destroy();
            }
            
            // Get month name for display
            const monthNames = ["January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"];
            const monthName = monthNames[month - 1];
            
            // Create the chart
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.days,
                    datasets: [
                        {
                            label: 'Passengers',
                            data: data.passengers,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.1
                        },
                        {
                            label: 'Drivers',
                            data: data.drivers,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `New User Registrations - ${monthName} ${year}`,
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of New Users',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                stepSize: 5,
                                callback: function(value) {
                                    // Only show multiples of 5
                                    return value % 5 === 0 ? value : '';
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day of Month',
                                font: {
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