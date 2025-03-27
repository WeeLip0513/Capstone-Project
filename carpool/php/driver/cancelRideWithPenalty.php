<?php
session_start();
include("../../dbconn.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

        // Get the current cancel_count
        $stmt = $conn->prepare("SELECT cancel_count, penalty_end_date FROM driver WHERE id = ?");
        $stmt->bind_param("i", $driverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $driverData = $result->fetch_assoc();
        $stmt->close();

        if (!$driverData) {
            echo json_encode(["status" => "error", "message" => "Driver not found."]);
            exit;
        }

        $currentCancelCount = $driverData["cancel_count"];
        $penaltyEndDate = $driverData["penalty_end_date"];

        // Increase cancel_count
        $newCancelCount = $currentCancelCount + 1;
        $stmt = $conn->prepare("UPDATE driver SET cancel_count = ? WHERE id = ?");
        $stmt->bind_param("ii", $newCancelCount, $driverId);
        $stmt->execute();
        $stmt->close();

        // If cancel_count reaches 3 (but wasn't already 3+), set penalty_end_date
        if ($currentCancelCount < 3 && $newCancelCount >= 3) {
            $newPenaltyEndDate = date("Y-m-d", strtotime("+1 month"));
            $stmt = $conn->prepare("UPDATE driver SET penalty_end_date = ?, status = 'restricted' WHERE id = ?");
            $stmt->bind_param("si", $newPenaltyEndDate, $driverId);
            $stmt->execute();
            $stmt->close();
        }

        // Update ride status to "canceled"
        $stmt = $conn->prepare("UPDATE ride SET status = 'canceled' WHERE id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Show alert if the driver got restricted
        if ($currentCancelCount < 3 && $newCancelCount >= 3) {
            echo "<script>
                alert('⚠️ WARNING: Your status has been changed to RESTRICTED due to too many RIDE CANCELLATIONS!');
                window.location.href = 'your_redirect_page.php';
            </script>";
        }

        echo json_encode(["status" => "success", "message" => "Ride canceled successfully."]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Error canceling ride: " . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
