<?php
session_start();
include("../../dbconn.php");
header("Content-Type: application/json");

// Ensure the passenger is authenticated (assuming you store passenger ID in session)
if (!isset($_SESSION['passenger_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Passenger not authenticated."
    ]);
    exit;
}

$passenger_id = $_SESSION['passenger_id'];

// Query to get rides that were canceled or refunded for this passenger.
// Adjust the query depending on your table structure.
$query = "SELECT r.id, r.pick_up_point, r.drop_off_point, r.date, r.day, r.time, r.price, pt.status 
          FROM ride r 
          JOIN passenger_transaction pt ON r.id = pt.ride_id 
          WHERE pt.passenger_id = ? AND pt.status IN ('canceled', 'refunded') 
          ORDER BY r.date DESC, r.time DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $passenger_id);
$stmt->execute();
$result = $stmt->get_result();

$rides = [];
while ($row = $result->fetch_assoc()) {
    $rides[] = $row;
}
$stmt->close();

echo json_encode([
    "success" => true,
    "rides" => $rides
]);
exit;
?>
