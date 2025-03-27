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

// Get the start of this week (last Sunday) and the end of next week (next Saturday)
$startOfThisWeek = date('Y-m-d', strtotime('last sunday')); // Start from last Sunday
$endOfNextWeek = date('Y-m-d', strtotime('next saturday +7 days')); // End of next week (next Saturday)

$sql = "SELECT id, date, DATE_FORMAT(date, '%W') AS day, 
               TIME_FORMAT(time, '%h:%i %p') AS time, pick_up_point, drop_off_point, 
               slots, slots_available
        FROM ride
        WHERE driver_id = ? 
        AND status = 'upcoming' 
        AND date >= ?  -- From the start of this week
        AND date <= ?  -- Until the end of next week (inclusive)
        ORDER BY date, time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $driver_id, $startOfThisWeek, $endOfNextWeek);
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
