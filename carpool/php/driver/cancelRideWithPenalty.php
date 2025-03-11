<?php
session_start();
include("../../dbconn.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if driverID exists in the session
    if (!isset($_SESSION["driverID"])) {
        echo json_encode(["status" => "error", "message" => "Driver not authenticated."]);
        exit;
    }

    $driverId = $_SESSION["driverID"];
    $rideId = $_POST["ride_id"] ?? null;

    if (!$rideId) {
        echo json_encode(["status" => "error", "message" => "Ride ID is required."]);
        exit;
    }

    try {
        // Start transaction
        $conn->begin_transaction();

        // Increase cancel_count
        $stmt = $conn->prepare("UPDATE driver SET cancel_count = cancel_count + 1 WHERE id = ?");
        $stmt->bind_param("i", $driverId);
        $stmt->execute();

        // Get updated cancel_count
        $stmt = $conn->prepare("SELECT cancel_count FROM driver WHERE id = ?");
        $stmt->bind_param("i", $driverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $driverData = $result->fetch_assoc();
        $cancelCount = $driverData["cancel_count"];

        // If cancel_count is 3 or more, set penalty_end_date to (today + 1 month)
        if ($cancelCount >= 3) {
            $penaltyEndDate = date("Y-m-d", strtotime("+1 month"));
            $stmt = $conn->prepare("UPDATE driver SET penalty_end_date = ? WHERE id = ?");
            $stmt->bind_param("si", $penaltyEndDate, $driverId);
            $stmt->execute();
        }

        // Update ride status to "canceled"
        $stmt = $conn->prepare("UPDATE ride SET status = 'canceled' WHERE id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode(["status" => "success", "message" => "Ride canceled successfully."]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Error canceling ride: " . $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
