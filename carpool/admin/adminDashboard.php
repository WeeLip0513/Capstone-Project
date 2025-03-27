<?php 
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<?php
    $sql = "SELECT d.id, d.firstname, d.lastname, d.phone_no, d.status, u.email 
        FROM driver d
        INNER JOIN user u ON d.user_id = u.id 
        WHERE d.status = 'pending' LIMIT 5";
    $results = mysqli_query($conn, $sql);
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
    <script src="../js/admin/currentTime.js"></script>

</head>
<body>
    <div class="dashboard-container">
        <div class="welcome">
            <h1>DASHBOARD</h1>
            <h3>Welcome to admin dashboard</h3>
        </div>
        <div class="first-row-container">
            <div class="first-row-item-one">
                <div class="current">
                    <div id="current-day"></div>
                    <div id="current-date"></div>
                    <div id="current-time"></div>
                </div>
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
                    <div class="table-container">
                        <table>
                            <tr>
                                <th>Driver ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                            <?php
                            if(mysqli_num_rows($results)>0){
                                while($row=mysqli_fetch_assoc($results)){
                                    echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td>".$row['firstname']."</td>";
                                    echo "<td>".$row['lastname']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".$row['phone_no']."</td>";
                                    echo "<td>".$row['status']."</td>";
                                    echo "<td><a href='adminViewDriver.php?id=".$row['id']."'>View driver</a></td>";
                                    echo"</tr>";
                                }
                        }else{
                            echo "<tr><td colspan='7'>No pending drivers found</td></tr>";
                        }
                        mysqli_close($conn);
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="third-row-container">
            <div class="third-row-item">
                <div class="content-popular-routes">
                    <h3>Popular Routes</h3>
                </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>