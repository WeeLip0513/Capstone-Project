<?php
include("../../dbconn.php");

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$driver_id = $_SESSION['driverID'];

$data = json_decode(file_get_contents("php://input"), true);

// 🛠 Debugging: Log raw input
error_log("Received JSON: " . file_get_contents("php://input"));

if (!isset($data['ride_ids']) || !is_array($data['ride_ids'])) {
    echo json_encode(["error" => "Invalid ride details received!", "received_data" => $data]);
    exit;
}

$rideIds = $data['ride_ids']; // Array of ride IDs
$originalRides = []; // Store original ride details
$conflicts = []; // Store conflict ride details

foreach ($rideIds as $rideId) {
    // ✅ Fetch ride details including `slots`, `driver_id`, and `vehicle_id`
    $rideSql = "SELECT id, date, time, pick_up_point, drop_off_point, vehicle_id, driver_id, slots FROM ride WHERE id = ?";
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

    // ✅ Convert to DateTime and find the same weekday two weeks later
    $dateObj = new DateTime($rideDate);
    $dateObj->modify('+2 week'); // Move to the same day two weeks later
    $nextWeekDate = $dateObj->format('Y-m-d');

    // ✅ Adjust Time Range (-2 to +2 hours)
    $startTime = date("H:i", strtotime($rideTime . " -2 hours"));
    $endTime = date("H:i", strtotime($rideTime . " +2 hours"));

    // 🛠 Store ride details in `original_rides` (Including `slots`, `vehicle_id`, and `driver_id`)
    $originalRides[] = [
        "original_ride_id" => $rideId,
        "original_date" => $rideDate,
        "original_time" => $rideTime,
        "pick_up_point" => $ride['pick_up_point'],
        "drop_off_point" => $ride['drop_off_point'],
        "vehicle_id" => $ride['vehicle_id'],
        "driver_id" => $ride['driver_id'],
        "slots" => $ride['slots'], // ✅ Added slots
        "generated_next_week_date" => $nextWeekDate,
        "time_range" => ["start" => $startTime, "end" => $endTime]
    ];

    // 🛠 Log generated date and time range
    error_log("Original Ride ID: $rideId | Driver ID: " . $ride['driver_id'] . " | Vehicle ID: " . $ride['vehicle_id'] . " | Slots: " . $ride['slots'] . " | Original Date: $rideDate | Time: $rideTime | Next Week Date: $nextWeekDate | Time Range: $startTime - $endTime");

    // ✅ Check for conflicts within the time range (Include `slots`, `driver_id`, and `vehicle_id`)
    $conflictSql = "SELECT id AS conflict_id, date, time, pick_up_point, drop_off_point, vehicle_id, driver_id, slots 
                    FROM ride 
                    WHERE date = ? 
                    AND time BETWEEN ? AND ? 
                    AND driver_id = ?";

    $stmt = $conn->prepare($conflictSql);
    $stmt->bind_param("ssss", $nextWeekDate, $startTime, $endTime, $driverId);
    $stmt->execute();
    $conflictResult = $stmt->get_result();


    while ($conflict = $conflictResult->fetch_assoc()) {
        // ✅ Store conflicts separately in `conflicts` (Including `slots`, `vehicle_id`, and `driver_id`)
        $conflicts[] = [
            "conflict_id" => $conflict['conflict_id'],
            "date" => $conflict['date'],
            "time" => $conflict['time'],
            "pick_up_point" => $conflict['pick_up_point'],
            "drop_off_point" => $conflict['drop_off_point'],
            "vehicle_id" => $conflict['vehicle_id'],
            "driver_id" => $conflict['driver_id'],
            "slots" => $conflict['slots'], // ✅ Added slots
            "original_ride_id" => (int) $rideId // Link to the original ride
        ];
    }
}

// ✅ Response including `original_rides` and `conflicts` (Both contain `slots`, `vehicle_id`, and `driver_id`)
$response = [
    "original_rides" => $originalRides,
    "conflicts" => $conflicts
];

echo json_encode($response, JSON_PRETTY_PRINT);
mysqli_close($conn);
?>