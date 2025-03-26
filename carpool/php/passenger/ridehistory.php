<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include("../../dbconn.php");

$response = [];

try {
    // Prepare SQL to fetch completed rides
    $stmt = $conn->prepare("SELECT * FROM ride WHERE status = 'completed'");
    $stmt->execute();
    
    // Fetch results using mysqli method
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $rides = [];
        while ($ride = $result->fetch_assoc()) {
            $rides[] = $ride;
        }
        $response = [
            'status' => 'success',
            'rides' => $rides
        ];
    } else {
        $response = [
            'status' => 'empty',
            'message' => 'No completed rides found.'
        ];
    }
} catch(Exception $e) {
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