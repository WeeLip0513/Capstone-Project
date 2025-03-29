<?php
session_start();
include("../../dbconn.php");

if (!isset($_SESSION['id'])) {
    echo json_encode(["success" => false, "message" => "No session found!"]);
    exit();
}

$userID = $_SESSION['id'];

// Get passenger ID
$stmt = $conn->prepare("SELECT id FROM passenger WHERE user_id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    echo json_encode(["success" => false, "message" => "Passenger record not found!"]);
    exit();
}

$passengerID = $row['id'];

// Check if the passenger has a completed payment for an upcoming ride
$stmt = $conn->prepare("SELECT pt.ride_id, r.status FROM passenger_transaction pt 
                        JOIN ride r ON pt.ride_id = r.id 
                        WHERE pt.passenger_id = ? AND pt.status = 'complete'");
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if ($row['status'] != 'completed') {
        echo json_encode(["success" => false, "message" => "You cannot delete your account while you have an active ride upcoming."]);
        exit();
    }
}
$stmt->close();

// Check if the passenger is enrolled in any upcoming rides
$stmt = $conn->prepare("SELECT ride_id FROM passenger_transaction WHERE passenger_id = ?");
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $rideID = $row['ride_id'];

    // Check ride status
    $rideStmt = $conn->prepare("SELECT status FROM ride WHERE id = ?");
    $rideStmt->bind_param("i", $rideID);
    $rideStmt->execute();
    $rideResult = $rideStmt->get_result();
    $rideRow = $rideResult->fetch_assoc();
    $rideStmt->close();

    if ($rideRow && $rideRow['status'] != 'completed') {
        echo json_encode(["success" => false, "message" => "You cannot delete your account because you are enrolled in an active ride (Ride ID: " . $rideID . ")."]);
        exit();
    }
}
$stmt->close();

// Delete related Stripe sessions
$stmt = $conn->prepare("DELETE FROM stripe_sessions WHERE transaction_id IN 
                    (SELECT id FROM passenger_transaction WHERE passenger_id = ?)");
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$stmt->close();

// Delete passenger transactions
$stmt = $conn->prepare("DELETE FROM passenger_transaction WHERE passenger_id = ?");
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$stmt->close();

// Delete passenger record
$stmt = $conn->prepare("DELETE FROM passenger WHERE id = ?");
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$stmt->close();

// Delete user account
$stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();

// Destroy session
session_destroy();
echo json_encode(["success" => true, "message" => "Account deleted successfully!"]);
?>
