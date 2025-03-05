<?php
header('Content-Type: application/json'); // Ensure JSON output
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Buffer output to catch unexpected HTML

include('../../dbconn.php'); // Database connection

// Read and decode JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Debugging: Log input received
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON received", "raw_input" => $json]);
    exit;
}

// Extract required fields
$ride_id = $data['ride_id'] ?? null;
$date = $data['date'] ?? null;
$hour = $data['hour'] ?? null;
$minute = $data['minute'] ?? null;
$pickup = $data['pickup'] ?? null;
$dropoff = $data['dropoff'] ?? null;
$vehicle = $data['vehicle'] ?? null;
$seatNo = $data['seatNo'] ?? null;

// Validate inputs
if (!$ride_id || !$date || !$hour || !$minute || !$pickup || !$dropoff || !$vehicle || !$seatNo) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Convert to MySQL time format
$time = "$hour:$minute";

// Prepare SQL statement
$sql = "UPDATE ride SET date=?, time=?, pick_up_point=?, drop_off_point=?, vehicle_id=?, slots_available=? WHERE id=?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssssiii", $date, $time, $pickup, $dropoff, $vehicle, $seatNo, $ride_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Ride replaced successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database update failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
ob_end_flush(); // Ensure no extra HTML is output
?>
