<?php

include("../../dbconn.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['rideID'])) {
  die("Session rideID is not set!");
}

$ride_id = $_SESSION['rideID'];

echo $ride_id;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['status'])) {
        $status = $_POST['status'];

        // Prepare and execute the SQL query to update the ride status
        $stmt = $conn->prepare("UPDATE ride SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $ride_id);

        if ($stmt->execute()) {
            echo "Ride status updated to: " . htmlspecialchars($status);
        } else {
            echo "Error updating status: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "No status received!";
    }
} else {
    echo "Invalid request!";
}

$conn->close();

?>
