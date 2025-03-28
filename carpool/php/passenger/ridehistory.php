<?php
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
session_start();
header('Content-Type: application/json');
include("../../dbconn.php");

$response = [];

$passengerId = $_SESSION['passenger_id'] ?? null;

if (!$passengerId) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No passenger ID found'
    ]);
    exit;
}

try {
    // Prepare SQL to fetch completed rides
    // $stmt = $conn->prepare("SELECT * FROM ride WHERE status = 'completed'");
    // $stmt->execute();

    // Fetch results using mysqli method
    // $result = $stmt->get_result();

    $sql = "SELECT 
                r.id, 
                r.pick_up_point, 
                r.drop_off_point, 
                r.date, 
                r.time, 
                r.price, 
                r.status FROM passenger_transaction pt 
                JOIN ride r ON pt.ride_id = r.id 
                WHERE pt.passenger_id=? 
                AND pt.status='complete' AND r.status='completed' 
                ORDER BY r.date DESC, r.time DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $passengerId);
    $stmt->execute();
    $result = $stmt->get_result();

    $rides = [];
    while ($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }

    if (!empty($rides)) {
        $response = [
            'status' => 'success',
            'rides' => $rides
        ];
    } else {
        $response = [
            'status' => 'empty',
            'message' => 'No completed rides found with payment.'
        ];
    }

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Error loading rides: ' . $e->getMessage()
    ];
}

// Output JSON response
echo json_encode($response);

// Close connection
$stmt->close();
$conn->close();
?>