<?php 
session_start();
include("../dbconn.php"); 
include("adminsidebar.php");

if(isset($_GET['id'])){
    $driver_id = $_GET['id'];

    // $sql = "SELECT * FROM driver WHERE id = ?";
    $sql = "SELECT d.*, u.email FROM driver d
            INNER JOIN user u ON d.user_id = u.id 
            WHERE d.id = ?";
    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"i",$driver_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
    } else{
        echo"<script>alert('Driver not found!'); window.location.href='adminDriverApproval.php';</script>";
        exit();
    }
}else{
    echo "<script>alert('No driver selected!'); window.location.href='adminDriverApproval.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/adminPage/viewDriver.css">
</head>
<body>
    <div class="driver-profile-container">
        <div class="form-title">
        <h2>Driver Approval Form</h2>
        </div>
        <div class="driver-form">
            <div class="column">
                <div class="firstname">
                    <h4>First Name:</h4><br>
                    <p><?php echo htmlspecialchars($row['firstname']);?></p>
                </div>
                <div class="lastname">
                    <h4>Last Name:</h4><br>
                    <p><?php echo htmlspecialchars($row['lastname']);?></p>
                </div>
            </div>
            <div class="column">
                <div class="email">
                    <h4>Email:</h4><br>
                    <p><?php echo htmlspecialchars($row['email']);?></p>
                </div>
                <div class="phone_no">
                    <h4>Phone Number:</h4><br>
                    <p><?php echo htmlspecialchars($row['phone_no']);?></p>
                </div>
            </div>
            <div class="column">
                <div class="license-expiry-date">
                    <h4>License Expiry Date:</h4><br>
                    <p><?php echo htmlspecialchars($row['license_expiry_date']);?></p>
                </div>
                <div class="reg-date">
                    <h4>Registration Date:</h4><br>
                    <p><?php echo htmlspecialchars($row['registration_date']);?></p>
                </div>
            </div>
            <div class="column">
                <div class="license-photo-front">
                    <h4>License Front:</h4><br>
                    <div class="license-image">
                        <?php 
                        $frontImgPath = $row['license_photo_front'];
                        $frontLicensePath = str_replace("../../", "../", $frontImgPath);
                        ?>
                        <img src="<?php echo $frontLicensePath; ?>" alt="License Front">                    
                    </div>
                </div>
                <div class="license-photo-back">
                    <h4>License Back:</h4><br>
                    <div class="license-image">
                        <?php 
                        $backImgPath = $row['license_photo_back'];
                        $backLicensePath = str_replace("../../", "../", $backImgPath);
                        ?>
                        <img src="<?php echo $backLicensePath; ?>" alt="License Back">                    
                    </div>
                </div>
            </div>
            <div class="approval-actions">
                <form action="php/admin/driver_approval_action.php" method="post">
                    <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
                    <button type="submit" name="action" value="approve" class="approve-btn">Approve Driver</button>
                    <button type="submit" name="action" value="reject" class="reject-btn">Reject Application</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>