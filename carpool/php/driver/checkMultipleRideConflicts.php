<?php
include("../../dbconn.php");

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['date']) || !isset($data['time'])) {
    echo json_encode(["error" => "Invalid ride details received!"]);
    exit;
}

$newRideDate = $data['date']; // Date of the new ride
$newRideTime = $data['time']; // Time of the new ride (HH:MM format)

// ✅ Convert to DateTime and find the same weekday next week
$dateObj = new DateTime($newRideDate);
$dateObj->modify('+1 week'); // Move to the same day next week
$nextWeekDate = $dateObj->format('Y-m-d'); // Fixed format (Y-m-d)

// ✅ Adjust Time Range (-2 to +2 hours)
$startTime = date("H:i", strtotime($newRideTime . " -2 hours")); // Convert to HH:MM
$endTime = date("H:i", strtotime($newRideTime . " +2 hours"));   // Convert to HH:MM

// ✅ Debugging Logs
$debugInfo = [
    "input_date" => $newRideDate,
    "input_time" => $newRideTime,
    "generated_next_week_date" => $nextWeekDate,
    "time_range" => ["start" => $startTime, "end" => $endTime]
];

// ✅ Check if a conflicting ride exists next week within the time range (IGNORE pickup and dropoff)
$conflictSql = "SELECT id, date, time, pick_up_point, drop_off_point 
                FROM ride 
                WHERE date = ? 
                AND time BETWEEN ? AND ?"; 

$stmt = $conn->prepare($conflictSql);
$stmt->bind_param("sss", $nextWeekDate, $startTime, $endTime);
$stmt->execute();
$conflictResult = $stmt->get_result();

$conflicts = [];
while ($conflict = $conflictResult->fetch_assoc()) {
    $conflicts[] = $conflict;
}

// ✅ Response including Debug Info & SQL Results
$response = [
    "debug_info" => $debugInfo,
    "conflicts" => $conflicts
];

echo json_encode($response, JSON_PRETTY_PRINT);
mysqli_close($conn);
?>
