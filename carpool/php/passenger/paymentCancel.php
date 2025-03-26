<?php
include("../../dbconn.php");

// Start session early
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$passenger_id = isset($_SESSION['passenger_id']) ? intval($_SESSION['passenger_id']) : intval($_SESSION['id']);

// Update all pending transactions for this passenger to "canceled"
$sql = "UPDATE passenger_transaction 
        SET status = 'canceled' 
        WHERE passenger_id = ? AND status = 'pending'";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    error_log("Prepare failed: " . mysqli_error($conn));
    echo json_encode(['success' => false, 'message' => 'SQL prepare error']);
    exit;
}
mysqli_stmt_bind_param($stmt, "i", $passenger_id);
if (!mysqli_stmt_execute($stmt)) {
    error_log("Execute failed: " . mysqli_stmt_error($stmt));
    echo json_encode(['success' => false, 'message' => 'SQL execute error']);
    exit;
}

// Clear the cart
$_SESSION['cart'] = [];

// Redirect back to the passenger page with an error parameter
header("Location: ../../passenger/passengerPage.php?payment=error");
exit;
?>
