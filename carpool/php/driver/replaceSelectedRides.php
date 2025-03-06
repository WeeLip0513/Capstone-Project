<?php
include("../../dbconn.php");

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🛠 Debugging: Log raw input
error_log("Received JSON: " . file_get_contents("php://input"));

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['replace_ride_ids']) || !is_array($data['replace_ride_ids']) ||
    !isset($data['new_ride_data']) || !is_array($data['new_ride_data'])) {
    echo json_encode(["error" => "Invalid ride details received!", "received_data" => $data]);
    exit;
}

$replaceRideIds = $data['replace_ride_ids']; // Conflict ride IDs
$newRideData = $data['new_ride_data']; // New ride details

// ✅ Function to calculate the fare
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

    $routeKey = strtolower("$pickup-$dropoff");

    if (!isset($fares[$routeKey])) {
        return null;
    }

    $fare = $fares[$routeKey];
    $hour = (int) date("H", strtotime($time));

    if ($hour >= 18 && $hour < 20) {
        $fare *= 1.2;
    }

    return number_format($fare, 2, '.', '');
}

mysqli_begin_transaction($conn);

try {
    foreach ($replaceRideIds as $index => $conflictRideId) {
        if (!isset($newRideData[$index])) {
            continue;
        }

        $newRide = $newRideData[$index];
        $newFare = calculateFare($newRide['pickup'], $newRide['dropoff'], $newRide['time']);

        if ($newFare === null) {
            throw new Exception("Invalid route: {$newRide['pickup']} to {$newRide['dropoff']}");
        }

        $updateSql = "UPDATE ride 
                      SET date = ?, time = ?, pick_up_point = ?, drop_off_point = ?, fare = ? 
                      WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssssds", 
            $newRide['date'], 
            $newRide['time'], 
            $newRide['pickup'], 
            $newRide['dropoff'], 
            $newFare, 
            $conflictRideId
        );
        $stmt->execute();
    }

    mysqli_commit($conn);
    echo json_encode(["success" => true, "message" => "Rides updated successfully."]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["error" => "Transaction failed!", "message" => $e->getMessage()]);
}

mysqli_close($conn);
?>
