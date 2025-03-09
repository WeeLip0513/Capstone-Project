<?php
header("Content-Type: application/json");
require_once "../../dbconn.php"; // Ensure database connection is correct

$response = ["success" => false, "message" => ""];

// Function to calculate fare
function calculateFare($pickup, $dropoff, $time)
{
    $fares = [
        "lrt_bukit_jalil-apu" => 4,
        "apu-lrt_bukit_jalil" => 4,
        "apu-pav_bukit_jalil" => 7,
        "pav_bukit_jalil-apu" => 7,
        "apu-sri_petaling" => 7,
        "sri_petaling-apu" => 7,
        "pav_bukit_jalil-sri_petaling" => 7,
        "sri_petaling-pav_bukit_jalil" => 7,
    ];

    // Format input to match keys
    $routeKey = strtolower("$pickup-$dropoff");

    if (!isset($fares[$routeKey])) {
        return "Invalid route selected.";
    }

    $fare = $fares[$routeKey];

    // Apply peak hour surcharge (18:00 - 20:00)
    $hour = (int) date("H", strtotime($time));
    if ($hour >= 18 && $hour < 20) {
        $fare *= 1.2; // Increase by 20%
    }

    return round($fare, 2);
}

// Get and decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// ✅ Debugging: Log received JSON in PHP error log (Check `error_log`)
error_log("Received JSON: " . json_encode($data, JSON_PRETTY_PRINT));

if (!isset($data["rides"]) || empty($data["rides"])) {
    $response["message"] = "No rides provided.";
    echo json_encode($response);
    exit;
}

try {
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO ride (date, time, day, pick_up_point, drop_off_point, price, driver_id, vehicle_id, slots, slots_available, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    foreach ($data["rides"] as $ride) {
        $fare = calculateFare($ride["pickup"], $ride["dropoff"], $ride["time"]);
        
        if (!is_numeric($fare)) {
            throw new Exception("Invalid route: " . $fare);
        }

        // Extract day of the week
        $dateObj = new DateTime($ride["date"]);
        $day = $dateObj->format('l');

        // Ensure slots are set
        $slots = isset($ride["slots"]) ? (int) $ride["slots"] : 0;
        $status = 'upcoming';

        // ✅ Debugging: Log ride details before insertion
        error_log("Inserting ride: " . json_encode([
            "date" => $ride["date"],
            "time" => $ride["time"],
            "day" => $day,
            "pickup" => $ride["pickup"],
            "dropoff" => $ride["dropoff"],
            "fare" => $fare,
            "driver_id" => $ride["driver_id"],
            "vehicle_id" => $ride["vehicle_id"],
            "slots" => $slots
        ], JSON_PRETTY_PRINT));

        // Bind parameters
        $stmt->bind_param(
            "sssssdiiiis",
            $ride["date"],      
            $ride["time"],      
            $day,              
            $ride["pickup"],    
            $ride["dropoff"],   
            $fare,              
            $ride["driver_id"],  
            $ride["vehicle_id"], 
            $slots,              
            $slots,
            $status
        );

        if (!$stmt->execute()) {
            throw new Exception("Error inserting ride: " . $stmt->error);
        }
    }

    $stmt->close();
    $response["success"] = true;
    $response["message"] = "Rides added successfully.";

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
} finally {
    if ($conn) {
        $conn->close();
    }
}

echo json_encode($response);
exit;
?>
