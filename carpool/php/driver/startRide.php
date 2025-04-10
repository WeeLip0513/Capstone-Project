<?php
include("../../dbconn.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rideId = $_POST["ride_id"] ?? null;

    if (!$rideId) {
        echo json_encode(["status" => "error", "message" => "Ride ID is required."]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE ride SET status = 'active' WHERE id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Ride started successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No ride found or already active."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error starting ride: " . $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
