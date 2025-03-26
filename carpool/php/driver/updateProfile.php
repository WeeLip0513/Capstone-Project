<?php
error_reporting(0);
session_start();
include(__DIR__ . '../../dbconn.php'); // Use absolute path

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userID = $_SESSION['id'];
$fieldName = $_POST['fieldName'];

// Validate field name
$allowedFields = ['firstname', 'lastname', 'phone_no', 'email'];
if (!in_array($fieldName, $allowedFields)) {
    echo json_encode(['success' => false, 'message' => 'Invalid field name']);
    exit;
}

$fieldValue = $_POST['fieldValue'];

if ($fieldName === 'email') {
    $sql = "UPDATE user SET email = ? WHERE id = ?";
} else {
    $sql = "UPDATE driver SET $fieldName = ? WHERE user_id = ?";
}

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "si", $fieldValue, $userID);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
}

// Close database connection
mysqli_close($conn);
?>
