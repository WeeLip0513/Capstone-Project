<?php
session_start();
include("../../dbconn.php");

// Check if session variables exist
if (!isset($_SESSION['rideID']) || !isset($_SESSION['driverID'])) {
    echo json_encode(["success" => false, "error" => "Session data missing."]);
    exit();
}

$ride_id = $_SESSION['rideID'];
$driver_id = $_SESSION['driverID'];

// Get passenger count & price per passenger from the database
$sql = "SELECT slots, slots_available, price FROM ride WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(["success" => false, "error" => "Ride not found."]);
    exit();
}

$slots = $row['slots'];
$slots_available = $row['slots_available'];
$price = $row['price'];

$passenger_count = $slots - $slots_available;

// Calculate earnings
$total_earning = $passenger_count * $price;
$driver_revenue = $total_earning * 0.8; // 80% to driver
$app_revenue = $total_earning * 0.2; // 20% to app

$status = "active";
$today = date("Y-m-d"); // Format: YYYY-MM-DD

// Store transaction in the database
$sql = "INSERT INTO driver_transaction (driver_id, ride_id, driver_revenue, app_revenue, status, ride_completion_date) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiddss", $driver_id, $ride_id, $driver_revenue, $app_revenue, $status, $today);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "driver_revenue" => number_format($driver_revenue, 2)]);
} else {
    echo json_encode(["success" => false, "error" => "Database error."]);
}

// Close connections
$stmt->close();
$conn->close();
?>
