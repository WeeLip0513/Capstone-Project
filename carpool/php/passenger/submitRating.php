<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../dbconn.php"); // Make sure this sets up $conn

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
error_log("Debug: Received data: " . print_r($data, true));

// Check required parameters
if (!isset($data['passenger_id'], $data['ride_id'], $data['ride_rating'])) {
    $error = 'Missing required parameters';
    error_log("Debug Error: " . $error);
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
}

$passengerId = (int)$data['passenger_id'];
$rideId = (int)$data['ride_id'];
$ride_rating = (int)$data['ride_rating'];

// 1. Update the passenger_transaction with the rating
$sql = "UPDATE passenger_transaction pt
        JOIN ride r ON pt.ride_id = r.id
        SET pt.ride_rating = $ride_rating 
        WHERE pt.passenger_id = $passengerId 
          AND pt.ride_id = $rideId 
          AND pt.status = 'complete'
          AND r.status = 'completed'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error updating passenger_transaction: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
error_log("Debug: Updated passenger_transaction rows: " . mysqli_affected_rows($conn));

// 2. Calculate the average rating for the current ride using an array
$sql = "SELECT pt.ride_rating 
        FROM passenger_transaction pt
        JOIN ride r ON pt.ride_id = r.id
        WHERE pt.ride_id = $rideId 
          AND pt.status = 'complete'
          AND r.status = 'completed'
          AND pt.ride_rating IS NOT NULL";
$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error retrieving ratings for ride: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
$ratings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ratings[] = $row['ride_rating'];
}
$rideAvgRating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : null;
error_log("Debug: Calculated ride average rating: " . $rideAvgRating);

// 3. Retrieve the driver_id for this ride
$sql = "SELECT driver_id FROM ride WHERE id = $rideId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error retrieving driver_id: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
$row = mysqli_fetch_assoc($result);
if (!$row) {
    $error = "No ride found for ride_id: $rideId";
    error_log("Debug Error: " . $error);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
}
$driverId = $row['driver_id'];
error_log("Debug: Retrieved driver_id: " . $driverId);

// 4. Calculate the overall driver rating by gathering all ratings for rides of this driver
$sql = "SELECT pt.ride_rating 
        FROM passenger_transaction pt
        JOIN ride r ON pt.ride_id = r.id
        WHERE r.driver_id = $driverId 
          AND pt.status = 'complete' 
          AND r.status = 'completed'
          AND pt.ride_rating IS NOT NULL";
$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error retrieving driver ratings: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
$driverRatings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $driverRatings[] = $row['ride_rating'];
}
$overallDriverRating = count($driverRatings) > 0 ? array_sum($driverRatings) / count($driverRatings) : null;
error_log("Debug: Calculated overall driver rating: " . $overallDriverRating);

// 5. Update the driver's rating in the driver table
// Handle the possibility of a null overall rating if no ratings exist.
if ($overallDriverRating === null) {
    $updateRating = "NULL";
} else {
    $updateRating = $overallDriverRating;
}
$sql = "UPDATE driver
        SET rating = $updateRating
        WHERE id = $driverId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error updating driver rating: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
error_log("Debug: Updated driver record rows: " . mysqli_affected_rows($conn));
// 0. Ensure the passenger transaction status is updated to 'complete'
$sql = "UPDATE passenger_transaction 
        SET status = 'complete' 
        WHERE passenger_id = $passengerId 
          AND ride_id = $rideId 
          AND status != 'complete'"; // Prevent unnecessary updates

$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error updating passenger_transaction status: " . mysqli_error($conn));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}
error_log("Debug: Updated passenger_transaction status to complete for ride_id: " . $rideId);

echo json_encode([
    'success' => true, 
    'rideAvgRating' => $rideAvgRating, 
    'overallDriverRating' => $overallDriverRating
]);

mysqli_close($conn);
?>
