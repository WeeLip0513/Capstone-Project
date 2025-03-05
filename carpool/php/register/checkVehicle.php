<?php
header('Content-Type: application/json');

$plateNo = $_POST['plateNo'] ?? '';

if ($plateNo === '') {
    echo json_encode(["exists" => false, "error" => "No plate number provided"]);
    exit;
}

// Database connection
include("../../dbconn.php");

if ($conn->connect_error) {
    echo json_encode(["exists" => false, "error" => "Database connection failed"]);
    exit;
}

// Query database
$stmt = $conn->prepare("SELECT COUNT(*) FROM vehicle WHERE plate_no = ?");
$stmt->bind_param("s", $plateNo);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$conn->close();

// Return result
echo json_encode(["exists" => $count > 0]);
?>
