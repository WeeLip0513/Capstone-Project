<?php 
session_start();
include("../dbconn.php"); 
include("adminsidebar.php");
?>

<?php
    $sql = "SELECT d.id, d.firstname, d.lastname, d.phone_no, d.status, u.email 
        FROM driver d
        INNER JOIN user u ON d.user_id = u.id 
        WHERE d.status = 'pending'";
    $results = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Pending Table</title>
    <link rel="stylesheet" href="../css/adminPage/driverApproval.css">
</head>
<body>
    <div class="driver-list-container">
        <div class="driver-list-title">        
            <h2>DRIVER PENDING LIST</h2>
            <h4>Select "View Driver" button to go through pending driver application.</h4>
        </div>
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
</body>
</html>