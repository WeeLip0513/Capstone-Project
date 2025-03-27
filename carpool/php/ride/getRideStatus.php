<?php
header("Content-Type: application/json");

// Include database connection
require_once "../../dbconn.php";  // Adjust path if needed

// Check if ride_id is provided
if (!isset($_GET["ride_id"])) {
    echo json_encode(["error" => "No ride_id provided"]);
    exit;
}

$ride_id = intval($_GET["ride_id"]); // Ensure ride_id is an integer

// Fetch ride status
$sql = "SELECT status FROM ride WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["status" => $row["status"]]);
} else {
    echo json_encode(["error" => "Ride not found"]);
}

$stmt->close();
$conn->close();
?>
