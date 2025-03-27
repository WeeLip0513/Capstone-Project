<?php 
session_start();
include("../dbconn.php"); 
include("adminsidebar.php");

$sql = "SELECT id, tp_number, feedback_message FROM feedback";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <link rel="stylesheet" href="../css/adminPage/adminFeedback.css">
</head>
<body>
    <div class="feedback-container">
        <div class="feedback-title">
            <h2>USER FEEDBACKS</h2>
            <h4>Preview User Feedbacks For Better Enhancement.</h4>
        </div>
        <div class="feedback-table">
            <table>
                <tr>
                    <th>Feedback ID</th>
                    <th>TP Number</th>
                    <th>Feedback Message</th>
                </tr>
                <?php
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
                        echo"<tr>";
                        echo"<td>".$row['id']."</td>";
                        echo"<td>".$row['tp_number']."</td>";
                        echo"<td>".$row['feedback_message']."</td>";
                    }
                }else{
                    echo "<tr><td colspan='7'>No feedbacks found</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>
</html>