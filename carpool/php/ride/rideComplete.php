<?php
include '../config.php'; // Ensure this file contains database connection details

if (!isset($_SESSION['rideID']) || !isset($_SESSION['driverID'])) {
    echo json_encode(["success" => false, "error" => "Session data missing."]);
    exit();
}

$ride_id = $_SESSION['rideID'];
$driver_id = $_SESSION['driverID'];

// Get passenger count, price per passenger, and driver's status from the database
$sql = "SELECT slots, slots_available, price FROM ride WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Ride not found."]);
    exit();
}

$ride = $result->fetch_assoc();
$slots = $ride['slots'];
$slots_available = $ride['slots_available'];
$price = $ride['price'];

$passenger_count = $slots - $slots_available;

// Get driver's status
$sql = "SELECT status FROM driver WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();
$driver_status = $driver['status'];

// Calculate earnings based on driver's status
$driver_revenue = $passenger_count * $price * 0.8; // 80% if normal
$app_revenue = $passenger_count * $price * 0.2; // 20% to the app

if ($driver_status === "restricted") {
    $penalty = $driver_revenue * 0.2; // Deduct additional 20% for restricted drivers
    $driver_revenue -= $penalty;
    $app_revenue += $penalty; // Add the deducted amount to app revenue
}

// Insert earnings into driver_transaction table
$sql = "INSERT INTO driver_transaction (driver_id, ride_id, driver_revenue, app_revenue, status, ride_completion_date) 
        VALUES (?, ?, ?, ?, 'completed', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iidds", $driver_id, $ride_id, $driver_revenue, $app_revenue, $status);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "driver_revenue" => $driver_revenue, "app_revenue" => $app_revenue]);
} else {
    echo json_encode(["success" => false, "error" => "Database error."]);
}

$stmt->close();
$conn->close();
?>
