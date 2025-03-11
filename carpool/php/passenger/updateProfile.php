<?php
error_reporting(0); // Suppress warnings and errors
session_start(); // Start the session
include(__DIR__ . '/../../dbconn.php'); // Use absolute path

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userID = $_SESSION['id'];
$fieldName = $_POST['fieldName'];
$fieldValue = $_POST['fieldValue'];

// Validate the field name
$allowedFields = ['firstname', 'lastname', 'phone_no', 'email'];
if (!in_array($fieldName, $allowedFields)) {
    echo json_encode(['success' => false, 'message' => 'Invalid field name']);
    exit;
}

// Prepare the SQL query based on the field name
if ($fieldName === 'email') {
    // Update email in the user table
    $sql = "UPDATE user SET email = ? WHERE id = ?";
} else {
    // Update firstname, lastname, or phone_no in the passenger table
    $sql = "UPDATE passenger SET $fieldName = ? WHERE user_id = ?";
}

// Prepare the SQL statement
if (!$stmt = mysqli_prepare($conn, $sql)) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
    exit;
}

// Bind parameters based on the field name
if ($fieldName === 'email') {
    mysqli_stmt_bind_param($stmt, "si", $fieldValue, $userID);
} else {
    mysqli_stmt_bind_param($stmt, "si", $fieldValue, $userID);
}

// Execute the SQL statement
if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($conn)]);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>