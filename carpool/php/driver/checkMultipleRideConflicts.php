<?php
include("../../dbconn.php");

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$driver_id = $_SESSION['driverID'];

$data = json_decode(file_get_contents("php://input"), true);

// 🛠 Debugging: Log raw input
error_log("🔍 DEBUG: Received JSON: " . json_encode($data));

if (!isset($data['ride_ids']) || !is_array($data['ride_ids'])) {
    echo json_encode(["error" => "Invalid ride details received!", "received_data" => $data]);
    exit;
}

$rideIds = $data['ride_ids']; // Array of ride IDs
$originalRides = []; // Store original ride details
$conflicts = []; // Store conflict ride details

foreach ($rideIds as $rideId) {
    // ✅ Fetch ride details
    $rideSql = "SELECT id, date, time, pick_up_point, drop_off_point, vehicle_id, driver_id, slots 
                FROM ride WHERE id = ?";
    $stmt = $conn->prepare($rideSql);
    $stmt->bind_param("i", $rideId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        continue; // Skip if ride not found
    }

    $ride = $result->fetch_assoc();
    $rideDate = $ride['date'];
    $rideTime = $ride['time'];

    // ✅ Generate same weekday two weeks later
    $dateObj = new DateTime($rideDate);
    $dateObj->modify('+2 week');
    $nextWeekDate = $dateObj->format('Y-m-d');

    // ✅ Adjust Time Range (-2 to +2 hours)
    $startTime = date("H:i:s", strtotime($rideTime . " -2 hours"));
    $endTime = date("H:i:s", strtotime($rideTime . " +2 hours"));

    // 🛠 Store original ride details
    $originalRides[] = [
        "original_ride_id" => $rideId,
        "original_date" => $rideDate,
        "original_time" => $rideTime,
        "pick_up_point" => $ride['pick_up_point'],
        "drop_off_point" => $ride['drop_off_point'],
        "vehicle_id" => $ride['vehicle_id'],
        "driver_id" => $ride['driver_id'],
        "slots" => $ride['slots'],
        "generated_next_week_date" => $nextWeekDate,
        "time_range" => ["start" => $startTime, "end" => $endTime]
    ];

    // 🛠 Log the original ride details
    error_log("🔍 DEBUG: Original Ride ID: $rideId | Driver ID: " . $ride['driver_id'] . " | Vehicle ID: " . $ride['vehicle_id'] . 
        " | Slots: " . $ride['slots'] . " | Original Date: $rideDate | Time: $rideTime | Next Week Date: $nextWeekDate | Time Range: $startTime - $endTime");

    // ✅ Check for conflicts
    $conflictSql = "SELECT id AS conflict_id, date, time, pick_up_point, drop_off_point, vehicle_id, driver_id, slots 
                    FROM ride 
                    WHERE date = ? 
                    AND time BETWEEN ? AND ? 
                    AND driver_id = ?";
                    
    $stmt = $conn->prepare($conflictSql);
    if (!$stmt) {
        error_log("❌ ERROR: Conflict SQL Prepare Failed: " . $conn->error);
        continue;
    }

    // ✅ Fix: Use "sssi" (last parameter should be integer)
    $stmt->bind_param("sssi", $nextWeekDate, $startTime, $endTime, $driver_id);
    $stmt->execute();
    $conflictResult = $stmt->get_result();

    $conflictCount = $conflictResult->num_rows;
    error_log("🔍 DEBUG: Found $conflictCount conflicts for ride ID: $rideId");

    while ($conflict = $conflictResult->fetch_assoc()) {
        $conflicts[] = [
            "conflict_id" => $conflict['conflict_id'],
            "date" => $conflict['date'],
            "time" => $conflict['time'],
            "pick_up_point" => $conflict['pick_up_point'],
            "drop_off_point" => $conflict['drop_off_point'],
            "vehicle_id" => $conflict['vehicle_id'],
            "driver_id" => $conflict['driver_id'],
            "slots" => $conflict['slots'],
            "original_ride_id" => (int) $rideId
        ];
        error_log("🔍 DEBUG: Conflict found: " . json_encode($conflict));
    }
}

// ✅ Return full debug data
$response = [
    "original_rides" => $originalRides,
    "conflicts" => $conflicts
];

echo json_encode($response, JSON_PRETTY_PRINT);
mysqli_close($conn);
?>
