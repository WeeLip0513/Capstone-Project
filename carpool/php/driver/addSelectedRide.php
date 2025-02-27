<?php
include("../../dbconn.php"); // Include the database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Get the JSON data sent from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    $response = [];
    
    foreach ($data as $ride) {
        $newDate = $ride['newDate']; // The newly generated date for this week
        $day = $ride['day']; // Pass the day
        $time = date("H:i", strtotime($ride['formatted_time'])); // Convert to 24-hour format
        $pickup = $ride['pick_up_point'];
        $dropoff = $ride['drop_off_point'];
        $slots = $ride['slots_available'];
        $vehicleID = $ride['vehicle_id'];
        $driverID = $ride['driver_id'];
        $price = $ride['price'];
        $status = 'upcoming';

        // Prepare the SQL statement
        $sql = "INSERT INTO ride (date, day, time, pick_up_point, drop_off_point, slots_available, price, status, driver_id, vehicle_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssidssi", $newDate, $day, $time, $pickup, $dropoff, $slots, $price, $status, $driverID, $vehicleID);

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
            $response[] = [
                "status" => "error",
                "message" => "Failed to add ride: " . mysqli_error($conn)
            ];
        }
        
        mysqli_stmt_close($stmt);
    }

    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "No rides received!"]);
}

mysqli_close($conn);
?>
