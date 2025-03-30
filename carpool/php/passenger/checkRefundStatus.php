<?php
include("../../dbconn.php");
session_start(); // Ensure session is started

header("Content-Type: application/json"); // Ensure JSON response

// Debug: Log request method
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Invalid request method.");
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

// Debug: Log received POST data
error_log("Received POST Data: " . print_r($_POST, true));

// Check if passenger_id is received from POST request
if (!isset($_POST['passenger_id']) || empty($_POST['passenger_id'])) {
    error_log("Passenger ID missing.");
    echo json_encode(["status" => "error", "message" => "Passenger ID is missing"]);
    exit();
}

$passengerID = intval($_POST['passenger_id']); // Sanitize input

// Debug: Log Passenger ID
error_log("Passenger ID: " . $passengerID);

// Retrieve the latest pending or refunded transaction for the passenger
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

// Debug: Log SQL Query Result
error_log("SQL Query Result: " . print_r($row, true));

if (!$row) {
    error_log("No transaction found.");
    echo json_encode(["status" => "no_transaction"]);
    exit();
}

$transactionID = $row['id'];
$status = $row['status'];
$chargeID = $row['charge_id'] ?? null; // Use null if charge_id is not available
$sessionID = $row['session_id'];

// Debug: Log Transaction Details
error_log("Transaction ID: $transactionID, Status: $status, Charge ID: $chargeID, Session ID: $sessionID");

if ($status === 'refunded') {
    echo json_encode(["status" => "refunded"]);
    exit();
}

// Include Stripe's PHP library and set the API key
require_once '../../payment/vendor/autoload.php';
\Stripe\Stripe::setApiKey("sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq");

try {
    if (!$chargeID) {  // Only retrieve if charge_id is missing
        // Retrieve Stripe session to obtain the payment intent ID
        $checkout_session = \Stripe\Checkout\Session::retrieve($sessionID);
        $payment_intent_id = $checkout_session->payment_intent;
    
        // Retrieve Payment Intent to access its charges
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
    
        if (!empty($payment_intent->charges->data)) {
            $chargeID = $payment_intent->charges->data[0]->id; // ✅ Correct way to get charge_id
        } elseif (isset($payment_intent->latest_charge)) {
            $chargeID = $payment_intent->latest_charge;
        } else {
            throw new Exception("No charge found for Payment Intent.");
        }
    }

    // Debug: Log Charge ID
    error_log("Charge ID Retrieved: " . $chargeID);

    // Retrieve refunds associated with the charge
    $refunds = \Stripe\Refund::all(['charge' => $chargeID]);

    foreach ($refunds->autoPagingIterator() as $refund) {
        if ($refund->status === 'succeeded') {
            // Update the database to mark refund as completed
            $update = "UPDATE passenger_transaction SET status = 'refunded' WHERE id = ?";
            $stmt_update = $conn->prepare($update);
            $stmt_update->bind_param("i", $transactionID);
            $stmt_update->execute();
            $stmt_update->close();

            error_log("Refund successful for Transaction ID: $transactionID");

            echo json_encode(["status" => "refunded"]);
            exit();
        }
    }

    // If no refund exists, initiate a new refund
    $refund = \Stripe\Refund::create([
        'charge' => $chargeID,
    ]);

    error_log("Refund Status: " . $refund->status);

    if ($refund->status === 'succeeded') {
        $update = "UPDATE passenger_transaction SET status = 'refunded' WHERE id = ?";
    } elseif ($refund->status === 'pending') {
        $update = "UPDATE passenger_transaction SET status = 'pending' WHERE id = ?";
    } else {
        error_log("Refund failed: " . $refund->status);
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
    error_log("Stripe API Error: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "Stripe API Error: " . $e->getMessage()]);
    exit();
}
?>
