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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body>
    <div class="summary-report-container">
        <h2>SUMMARY REPORT</h2>
        <h3>Observe The Growth Of New Users, See the Rise, Know Your Users.</h3>
        <div class="summary-report-form">
            <h4>Select Year & Month: </h4>
            <div class="summary-report-selection">
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
            <div id="sumaryReport"></div>
            <canvas id="summaryReportChart"></canvas>
        </div>
        <div class="summary-description">
            <h3>Description : </h3>
            <div id="summaryDes"></div>
        </div>
    </div>
</body>
</html>