<?php
include("../../dbconn.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["id"]; // Ensure session contains user ID

    if (!$user_id) {
        echo "Error: No user ID found in session.";
        exit();
    }

    // Step 1: Get Driver ID
    $getDriverSQL = "SELECT id FROM driver WHERE user_id = ?";
    $stmt = $conn->prepare($getDriverSQL);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($driver_id);
    $stmt->fetch();
    $stmt->close();

    if (!$driver_id) {
        echo "Error: Driver not found for this user.";
        exit();
    }

    // Step 2: Check for upcoming rides
    $checkRidesSQL = "SELECT COUNT(*) FROM ride WHERE driver_id = ? AND status = 'upcoming'";
    $stmt = $conn->prepare($checkRidesSQL);
    $stmt->bind_param("i", $driver_id);
    $stmt->execute();
    $stmt->bind_result($rideCount);
    $stmt->fetch();
    $stmt->close();

    if ($rideCount > 0) {
        echo "Error: You have upcoming rides. Cancel them first.";
        exit();
    }

    // Step 3: Delete vehicle(s)
    $deleteVehicleSQL = "DELETE FROM vehicle WHERE driver_id = ?";
    $stmt = $conn->prepare($deleteVehicleSQL);
    $stmt->bind_param("i", $driver_id);
    if (!$stmt->execute()) {
        echo "Error deleting vehicle: " . $stmt->error;
        exit();
    }
    $stmt->close();

    // Step 4: Delete driver
    $deleteDriverSQL = "DELETE FROM driver WHERE id = ?";
    $stmt = $conn->prepare($deleteDriverSQL);
    $stmt->bind_param("i", $driver_id);
    if (!$stmt->execute()) {
        echo "Error deleting driver: " . $stmt->error;
        exit();
    }
    $stmt->close();

    // Step 5: Delete user
    $deleteUserSQL = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($deleteUserSQL);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        echo "Error deleting user: " . $stmt->error;
        exit();
    }
    $stmt->close();

    // Step 6: Destroy session and return success
    session_destroy();
    echo "success";
    exit();
}
?>
