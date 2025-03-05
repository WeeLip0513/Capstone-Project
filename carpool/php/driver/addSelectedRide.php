<?php
include("../../dbconn.php"); // Include the database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Get the JSON data sent from JavaScript
$requestData = json_decode(file_get_contents("php://input"), true);

// 🔍 Debugging: Log to PHP error log instead of a file
error_log("🔎 Received Data: " . print_r($requestData, true));

if (!isset($requestData['rides']) || !is_array($requestData['rides'])) {
    echo json_encode(["status" => "error", "message" => "No valid rides received!"]);
    exit;
}

$rides = $requestData['rides'];
$response = [];

foreach ($rides as $ride) {
    // Ensure all required fields exist before using them
    $newDate = $ride['newDate'] ?? null;
    $day = $ride['day'] ?? null;
    $time = isset($ride['formatted_time']) ? date("H:i", strtotime($ride['formatted_time'])) : null;
    $pickup = $ride['pick_up_point'] ?? null;
    $dropoff = $ride['drop_off_point'] ?? null;
    $slots = $ride['slots_available'] ?? null;
    $vehicleID = $ride['vehicle_id'] ?? null;
    $driverID = $ride['driver_id'] ?? null;
    $price = $ride['price'] ?? null;
    $status = 'upcoming';

    if (!$newDate || !$day || !$time || !$pickup || !$dropoff || !$slots || !$vehicleID || !$driverID || !$price) {
        error_log("⚠️ Missing ride details: " . print_r($ride, true));
        $response[] = [
            "status" => "error",
            "message" => "Missing required ride details"
        ];
        continue; // Skip this ride and move to the next
    }

    // ✅ FIXED SQL Query - Corrected "slots" column
    $sql = "INSERT INTO ride (date, day, time, pick_up_point, drop_off_point, slots_available, slots, price, status, driver_id, vehicle_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssiidssi", $newDate, $day, $time, $pickup, $dropoff, $slots, $slots, $price, $status, $driverID, $vehicleID);

    if (mysqli_stmt_execute($stmt)) {
        $response[] = [
            "status" => "success",
            "message" => "Ride added successfully",
            "date" => $newDate,
            "day" => $day,
            "pickup" => $pickup,
            "dropoff" => $dropoff
        ];
    } else {
        error_log("❌ SQL Error: " . mysqli_error($conn));
        $response[] = [
            "status" => "error",
            "message" => "Failed to add ride: " . mysqli_error($conn)
        ];
    }
    
    mysqli_stmt_close($stmt);
}

echo json_encode($response);
mysqli_close($conn);
?>
