<?php
include("../../dbconn.php");
session_start();
header("Content-Type: application/json");

require_once '../../payment/vendor/autoload.php';
\Stripe\Stripe::setApiKey("sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq");

// Step 1: Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

if (!isset($_POST['passenger_id']) || empty($_POST['passenger_id'])) {
    echo json_encode(["status" => "error", "message" => "Passenger ID is missing"]);
    exit();
}

$passengerID = intval($_POST['passenger_id']);

// Step 2: Get latest passenger transaction
$query = "SELECT pt.id, pt.status, ss.session_id
          FROM passenger_transaction pt
          LEFT JOIN stripe_sessions ss ON pt.id = ss.transaction_id
          WHERE pt.passenger_id = ? ORDER BY pt.id DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $passengerID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    echo json_encode(["status" => "no_transaction"]);
    exit();
}

$transactionID = $row['id'];
$status = $row['status'];
$sessionID = $row['session_id'];
$chargeID = $row['charge_id'] ?? null;

// Step 3: Prevent refund if ride is already completed
$checkRideStatusQuery = "SELECT ride_status FROM rides WHERE transaction_id = ?";
$rideStatusStmt = $conn->prepare($checkRideStatusQuery);
$rideStatusStmt->bind_param("i", $transactionID);
$rideStatusStmt->execute();
$rideResult = $rideStatusStmt->get_result();
$rideData = $rideResult->fetch_assoc();
$rideStatusStmt->close();

if ($rideData && strtolower($rideData['ride_status']) === 'completed') {
    echo json_encode(["status" => "error", "message" => "Ride is completed, refund not allowed"]);
    exit();
}

// Step 4: Check if already refunded
if ($status === 'refunded') {
    echo json_encode(["status" => "refunded"]);
    exit();
}

try {
    if (!$chargeID) {
        $checkout_session = \Stripe\Checkout\Session::retrieve($sessionID);
        $payment_intent_id = $checkout_session->payment_intent;
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        
        if (!empty($payment_intent->charges->data)) {
            $chargeID = $payment_intent->charges->data[0]->id;
        } elseif (isset($payment_intent->latest_charge)) {
            $chargeID = $payment_intent->latest_charge;
        } else {
            throw new Exception("No charge found for Payment Intent.");
        }
    }

    // Step 5: Check for existing refunds
    $refunds = \Stripe\Refund::all(['charge' => $chargeID]);

    foreach ($refunds->autoPagingIterator() as $refund) {
        if ($refund->status === 'succeeded') {
            $update = "UPDATE passenger_transaction SET status = 'refunded' WHERE id = ?";
            $stmt_update = $conn->prepare($update);
            $stmt_update->bind_param("i", $transactionID);
            $stmt_update->execute();
            $stmt_update->close();

            echo json_encode(["status" => "refunded"]);
            exit();
        }
    }

    // Step 6: Issue a new refund
    $refund = \Stripe\Refund::create(['charge' => $chargeID]);

    if ($refund->status === 'succeeded') {
        $update = "UPDATE passenger_transaction SET status = 'refunded' WHERE id = ?";
    } elseif ($refund->status === 'requesting') {
        $update = "UPDATE passenger_transaction SET status = 'requesting' WHERE id = ?";
    } else {
        echo json_encode(["status" => "error", "message" => "Refund failed, status: " . $refund->status]);
        exit();
    }

    $stmt_update = $conn->prepare($update);
    $stmt_update->bind_param("i", $transactionID);
    $stmt_update->execute();
    $stmt_update->close();

    echo json_encode(["status" => $refund->status]);
    exit();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Stripe API Error: " . $e->getMessage()]);
    exit();
}
?>
