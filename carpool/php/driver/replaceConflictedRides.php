<?php
header("Content-Type: application/json");
require_once "../../dbconn.php"; // Ensure your database connection file is correct
require_once "fareCalculator.php"; // Include fare calculation function

$response = ["success" => false, "message" => ""];

// Get and decode JSON input
$data = json_decode(file_get_contents("php://input"), true);
error_log("Received JSON: " . json_encode($data, JSON_PRETTY_PRINT));

if (!isset($data["rides"]) || empty($data["rides"])) {
    error_log("❌ Invalid input: No rides provided.");
    $response["message"] = "Invalid input data.";
    echo json_encode($response);
    exit;
}

try {
    // Prepare SQL statement for updating rides
    $stmt = $conn->prepare("UPDATE ride 
                            SET date = ?, time = ?, pick_up_point = ?, drop_off_point = ?, vehicle_id = ?, driver_id = ?, 
                                slots = ?, slots_available = ?, status = ?, price = ?, day = ? 
                            WHERE id = ?");

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    // Loop through rides and update them
    foreach ($data["rides"] as $ride) {

        // Calculate fare using fareCalculator.php
        $fare = calculateFare($ride["pickup"], $ride["dropoff"], $ride["time"]);
        if (!is_numeric($fare)) {
            throw new Exception("Invalid fare calculation: " . $fare);
        }

        // Extract day of the week
        $dateObj = new DateTime($ride["date"]);
        $day = $dateObj->format('l');

        // Ensure slots are set
        $slots = isset($ride["slots"]) ? (int) $ride["slots"] : 0;
        $slots_available = $slots; // Assuming all slots are available after update
        $status = "upcoming"; // Always set status to 'upcoming'

        // ✅ Debugging: Log ride details before update
        error_log("Updating ride: " . json_encode([
            "ride_id" => $ride["ride_id"],
            "date" => $ride["date"],
            "time" => $ride["time"],
            "day" => $day,
            "pickup" => $ride["pickup"],
            "dropoff" => $ride["dropoff"],
            "fare" => $fare,
            "driver_id" => $ride["driver_id"],
            "vehicle_id" => $ride["vehicle_id"],
            "slots" => $slots,
            "slots_available" => $slots_available,
            "status" => $status
        ], JSON_PRETTY_PRINT));

        // Bind parameters
        $stmt->bind_param("ssssiiiisdsi",
            $ride["date"],        // New date
            $ride["time"],        // New time
            $ride["pickup"],      // New pickup point
            $ride["dropoff"],     // New dropoff point
            $ride["vehicle_id"],  // New vehicle ID
            $ride["driver_id"],   // Updated driver ID
            $slots,               // Updated slots
            $slots_available,     // Updated slots available
            $status,              // Always 'upcoming'
            $fare,                // Calculated fare
            $day,                 // Day of the week
            $ride["ride_id"]      // Ride ID to update
        );

        if (!$stmt->execute()) {
            throw new Exception("Error updating ride ID " . $ride["ride_id"] . ": " . $stmt->error);
        }
    }

    $stmt->close();
    $response["success"] = true;
    $response["message"] = "Rides updated successfully.";

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
} finally {
    if ($conn) {
        $conn->close();
    }
}

echo json_encode($response);
?>
