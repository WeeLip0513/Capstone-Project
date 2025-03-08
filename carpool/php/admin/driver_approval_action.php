<?php
session_start();
include("../../dbconn.php");

if(isset($_POST['action']) && isset($_POST['driver_id'])) {
    $driver_id = $_POST['driver_id'];
    $action = $_POST['action'];
    
    // Prepare statement
    if($action == 'approve') {
        $status = 'approved';
        $message = "Driver application approved successfully!";
    } else if($action == 'reject') {
        $status = 'rejected';
        $message = "Driver application rejected!";
    } else {
        echo "<script>alert('Invalid action!'); window.location.href='../../adminDriverApproval.php';</script>";
        exit();
    }
    
    // Update driver status
    $sql = "UPDATE driver SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $driver_id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>alert('$message'); window.location.href='../../admin/adminDriverApproval.php';</script>";
    } else {
        echo "<script>alert('Error updating driver status!'); window.location.href='../../admin/adminDriverApproval.php';</script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Invalid request!'); window.location.href='../../admin/adminDriverApproval.php';</script>";
}

mysqli_close($conn);
?>