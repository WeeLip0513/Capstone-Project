<?php
header('Content-Type: application/json'); // Tell the browser we are sending JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../dbconn.php'); // Include database connection

// Check if required fields are present
if (!isset($_POST['date'], $_POST['hour'], $_POST['minute'])) {
    die(json_encode(["error" => "Missing required fields"]));
}

$date = $_POST['date'];
$hour = $_POST['hour'];
$minute = $_POST['minute'];
$selectedTime = "$hour:$minute:00"; // Convert to time format

// Log incoming request for debugging
file_put_contents('debug.log', "Checking conflict for: Date=$date, Time=$selectedTime\n", FILE_APPEND);

// SQL Query: Find conflicting rides within ±2 hours
$sql = "SELECT id, date, time, pick_up_point, drop_off_point 
        FROM ride 
        WHERE date = ? 
        AND ABS(TIME_TO_SEC(TIMEDIFF(time, ?))) <= TIME_TO_SEC('02:00:00')";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(["error" => "SQL prepare failed: " . $conn->error]));
}

$stmt->bind_param("ss", $date, $selectedTime);
$stmt->execute();
$result = $stmt->get_result();

$conflicts = [];
while ($row = $result->fetch_assoc()) {
    $conflicts[] = [
        "ride_id" => $row['id'],
        "ride_date" => $row['date'],
        "ride_time" => $row['time'],
        "pickup" => $row['pick_up_point'],
        "dropoff" => $row['drop_off_point']
    ];
}

$stmt->close();
$conn->close();

// Debugging: Log SQL results
file_put_contents('debug.log', "Conflicts Found: " . json_encode($conflicts) . "\n", FILE_APPEND);

// Return JSON response
echo json_encode($conflicts);
exit;
?>
