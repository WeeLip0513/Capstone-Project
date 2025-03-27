<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin/Dashboard</title>
    <link rel="stylesheet" href="../css/adminPage/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- <script src ="../js/admin/popularRoutes.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/admin/dashboard.js"></script>

</head>
<body>
    <div class="dashboard-container">
        <div class="welcome">
            <h1>DASHBOARD</h1>
            <h3>Welcome to admin dashboard</h3>
        </div>
        <div class="first-row-container">
            <div class="first-row-item-one">
                <h3>Manage and monitor ride-sharing activities effortlessly.</h3>
            </div>
            <div class="first-row-item">
                <div class="content">
                    <i class="fa fa-users"></i>
                    <div id="new-users"></div>
                    <h3>Total Users</h3>
                    <div id="percentage-users"></div>
                </div>
            </div>
            <div class="first-row-item">
                <div class="content">
                    <i class="fa fa-drivers-license"></i>
                    <div id="new-drivers"></div>
                    <h3>New Drivers</h3>
                    <div id="percentage-drivers"></div>
                </div>
            </div>
            <div class="first-row-item">
                <div class="content">
                    <i class="fas fa-user-alt"></i>
                    <div id="new-passengers"></div>
                    <h3>New Passengers</h3>
                    <div id="percentage-passengers"></div>
                </div>
            </div>
            <div class="first-row-item">
                <div class="content">
                    <i class="fa fa-car"></i>
                    <div id="total-rides"></div>
                    <h3>Total Rides</h3>
                    <div id="percentage-rides"></div>
                </div>
            </div>
        </div>
        <div class="second-row-container">
            <div class="second-row-item-one">
                <div class="content-earnings">
                    <h3>Earnings Breakdown</h3>
                    <div id="earnings-chart-container">
                        <canvas id="earnings-chart"></canvas>
                    </div>
                    <div id="earnings-text" class="earnings-description">
                        <div id="earnings-label"></div>
                        <div id="earnings-percentage"></div>
                    </div>
                </div>
            </div>
            <div class="second-row-item-two">
                <div class="content-driver-pending">
                    <h3>Driver Pending List</h3>
                </div>
            </div>
        </div>
        <div class="third-row-container">
            <div class="third-row-item">
                <h3>Popular Routes</h3>
                </div>
            </div>
        </div>
    </div>

</body>
</html>