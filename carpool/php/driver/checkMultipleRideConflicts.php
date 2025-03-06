<?php
include("../../dbconn.php");

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

// 🛠 Debugging: Log raw input
error_log("Received JSON: " . file_get_contents("php://input"));

if (!isset($data['ride_ids']) || !is_array($data['ride_ids'])) {
    echo json_encode(["error" => "Invalid ride details received!", "received_data" => $data]);
    exit;
}

$rideIds = $data['ride_ids']; // Array of ride IDs
$conflicts = [];
$debugDates = []; // Store generated dates for debugging

foreach ($rideIds as $rideId) {
    // ✅ Fetch ride details from DB
    $rideSql = "SELECT id, date, time, pick_up_point, drop_off_point FROM ride WHERE id = ?";
    $stmt = $conn->prepare($rideSql);
    $stmt->bind_param("s", $rideId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        continue; // Skip if ride not found
    }

    $ride = $result->fetch_assoc();
    $rideDate = $ride['date'];
    $rideTime = $ride['time'];

    // ✅ Convert to DateTime and find the same weekday next week
    $dateObj = new DateTime($rideDate);
    $dateObj->modify('+2 week'); // Move to the same day next week
    $nextWeekDate = $dateObj->format('Y-m-d');

    // ✅ Adjust Time Range (-2 to +2 hours)
    $startTime = date("H:i", strtotime($rideTime . " -2 hours"));
    $endTime = date("H:i", strtotime($rideTime . " +2 hours"));

    // 🛠 Log generated date and time range
    $debugDates[] = [
        "original_ride_id" => $rideId, // The newly generated ride ID
        "original_date" => $rideDate,
        "original_time" => $rideTime,
        "generated_next_week_date" => $nextWeekDate,
        "time_range" => ["start" => $startTime, "end" => $endTime]
    ];
    error_log("Original Ride ID: $rideId | Original Date: $rideDate | Time: $rideTime | Next Week Date: $nextWeekDate | Time Range: $startTime - $endTime");

    // ✅ Check for conflicts within the time range
    $conflictSql = "SELECT id AS conflict_id, date, time, pick_up_point, drop_off_point 
                    FROM ride 
                    WHERE date = ? 
                    AND time BETWEEN ? AND ?";

    $stmt = $conn->prepare($conflictSql);
    $stmt->bind_param("sss", $nextWeekDate, $startTime, $endTime);
    $stmt->execute();
    $conflictResult = $stmt->get_result();

    while ($conflict = $conflictResult->fetch_assoc()) {
        // ✅ Link the conflict with the original ride ID
        $conflict['original_ride_id'] = $rideId; // Rename new_ride_id → original_ride_id
        $conflicts[] = $conflict;
    }
}

// ✅ Response including Conflicts and Debug Info
$response = [
    "conflicts" => $conflicts, // Includes both conflict_id and original_ride_id
    "debug_generated_dates" => $debugDates // Debugging info
];

echo json_encode($response, JSON_PRETTY_PRINT);
mysqli_close($conn);
?>
