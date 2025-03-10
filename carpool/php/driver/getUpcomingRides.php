<?php
session_start();
header('Content-Type: application/json');
require_once '../../dbconn.php';

if (!isset($_SESSION['driverID'])) {
    echo json_encode([]); // Return empty array instead of an error
    exit;
}

$driver_id = $_SESSION['driverID'];

if ($conn->connect_error) {
    echo json_encode([]); // Prevent breaking the JS if DB fails
    exit;
}

// Get today's date and the start of next week (next Sunday)
$today = date('Y-m-d'); // Start from today
$startOfNextWeek = date('Y-m-d', strtotime('next sunday'));

$sql = "SELECT id, date, DATE_FORMAT(date, '%W') AS day, 
               TIME_FORMAT(time, '%h:%i %p') AS time, pick_up_point, drop_off_point, 
               slots, slots_available
        FROM ride
        WHERE driver_id = ? 
        AND status = 'upcoming' 
        AND date >= ?  -- Include today
        AND date < ?   -- Only rides before next Sunday
        ORDER BY date, time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $driver_id, $today, $startOfNextWeek);
$stmt->execute();
$result = $stmt->get_result();

$rides = [];
while ($row = $result->fetch_assoc()) {
    $rides[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($rides); // Ensures JS always gets an array
?>
