<?php
header('Content-Type: application/json'); // Tell the browser we are sending JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering to catch errors

// Database connection
include('../../dbconn.php');

$date = $_POST['date'] ?? '';
$hour = $_POST['hour'] ?? '';
$minute = $_POST['minute'] ?? '';

if (!$date || !$hour || !$minute) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// Convert to time format
$selectedTime = "$hour:$minute:00";

// Query to find conflicting rides within ±2 hours
$sql = "SELECT id, date, time, pick_up_point, drop_off_point FROM ride WHERE date = ? AND ABS(TIME_TO_SEC(TIMEDIFF(time, ?))) <= 7200";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $date, $selectedTime);
$stmt->execute();
$result = $stmt->get_result();

$conflicts = [];
while ($row = $result->fetch_assoc()) {
    $conflicts[] = [
        "ride_id" => $row['id'],  // Add ride ID
        "ride_date" => $row['date'],
        "ride_time" => $row['time'],
        "pickup" => $row['pick_up_point'],
        "dropoff" => $row['drop_off_point']
    ];
}

// Clear unwanted output before sending JSON
ob_end_clean();
echo json_encode($conflicts);
exit;
?>
