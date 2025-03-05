<?php
header('Content-Type: application/json'); // Sending JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering to catch errors

// Database connection
include('../../dbconn.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ride_ids']) || !is_array($data['ride_ids'])) {
    echo json_encode(["error" => "Missing or invalid ride IDs"]);
    exit;
}

$rideIds = array_map('intval', $data['ride_ids']); // Sanitize input

if (empty($rideIds)) {
    echo json_encode(["error" => "No valid ride IDs provided"]);
    exit;
}

// Prepare placeholders for SQL IN clause
$placeholders = implode(',', array_fill(0, count($rideIds), '?'));

// Fetch selected rides' details
$sql = "SELECT id, date, time, pick_up_point, drop_off_point FROM ride WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("i", count($rideIds)), ...$rideIds);
$stmt->execute();
$result = $stmt->get_result();

$selectedRides = [];
while ($row = $result->fetch_assoc()) {
    $selectedRides[] = $row;
}

if (empty($selectedRides)) {
    echo json_encode([]);
    exit;
}

$conflicts = [];

foreach ($selectedRides as $ride) {
    $rideId = $ride['id'];
    $rideDate = $ride['date'];
    $rideTime = $ride['time'];
    $pickup = $ride['pick_up_point'];
    $dropoff = $ride['drop_off_point'];

    // Check for conflicting rides within ±2 hours
    $conflictSql = "SELECT id, date, time, pick_up_point, drop_off_point 
                    FROM ride 
                    WHERE date = ? 
                    AND ABS(TIME_TO_SEC(TIMEDIFF(time, ?))) <= 7200
                    AND id NOT IN ($placeholders)"; // Exclude selected rides

    $stmt = $conn->prepare($conflictSql);
    $stmt->bind_param("ss" . str_repeat("i", count($rideIds)), $rideDate, $rideTime, ...$rideIds);
    $stmt->execute();
    $conflictResult = $stmt->get_result();

    while ($conflict = $conflictResult->fetch_assoc()) {
        $conflicts[] = [
            "ride_id" => $conflict['id'],
            "ride_date" => $conflict['date'],
            "ride_time" => $conflict['time'],
            "pickup" => $conflict['pick_up_point'],
            "dropoff" => $conflict['drop_off_point']
        ];
    }
}

// Clear unwanted output before sending JSON
ob_end_clean();
echo json_encode($conflicts);
exit;
?>
