<?php
ob_start();
header('Content-Type: application/json');
include("../../dbconn.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Check that the driver is authenticated
    if (!isset($_SESSION['driver_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Driver not authenticated'
        ]);
        exit;
    }
    
    // Ensure a Stripe session id is provided via GET
    if (!isset($_GET['session_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Stripe session id is missing'
        ]);
        exit;
    }
    
    $session_id = $_GET['session_id'];
    error_log("DEBUG: Received session_id: " . $session_id);
    
    // Retrieve the stripe_sessions record to obtain the transaction ids
    $query = "SELECT * FROM stripe_sessions WHERE session_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $session_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$stripeSession = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'success' => false,
            'message' => 'No Stripe session found for the provided ID'
        ]);
        exit;
    }
    $transaction_ids = explode(",", $stripeSession['transaction_id']);  // Assuming multiple transaction IDs are stored as a comma-separated list
    error_log("DEBUG: Found transaction_ids: " . json_encode($transaction_ids));
    mysqli_stmt_close($stmt);
    
    // Include Stripe's PHP library and set the API key
    require_once '../../payment/vendor/autoload.php';
    $stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    
    // Retrieve the Stripe Checkout session to obtain the payment intent ID
    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    error_log("DEBUG: Retrieved checkout_session: " . json_encode($checkout_session));
    $payment_intent_id = $checkout_session->payment_intent;
    error_log("DEBUG: Payment intent id: " . $payment_intent_id);
    
    // Retrieve the Payment Intent to access its charges
    $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
    error_log("DEBUG: Payment Intent object: " . json_encode($payment_intent));

    if (!empty($payment_intent->charges->data)) {
        // Use the first charge in the list (can also loop over charges if needed)
        $charge_id = $payment_intent->charges->data[0]->id;
    } else if (isset($payment_intent->latest_charge)) {
        // Fallback to latest_charge property if available
        $charge_id = $payment_intent->latest_charge;
    } else {
        throw new Exception("No charge found for Payment Intent.");
    }
    
    error_log("DEBUG: Charge id: " . $charge_id);
    
    // Refund each transaction related to the session
    $refund_success = true;
    $refund_message = '';
    
    foreach ($transaction_ids as $transaction_id) {
        // Create a refund using the Stripe API
        $refund = \Stripe\Refund::create([
            'charge' => $charge_id,
        ]);
        error_log("DEBUG: Refund created, status: " . $refund->status);

        if ($refund->status == 'succeeded') {
            // Update the passenger_transaction table for the corresponding transaction only
            $update1 = "UPDATE passenger_transaction SET status = 'refunded' WHERE id = ?";
            $stmt_update1 = mysqli_prepare($conn, $update1);
            mysqli_stmt_bind_param($stmt_update1, "i", $transaction_id);
            $execute_success = mysqli_stmt_execute($stmt_update1);
            if (!$execute_success) {
                error_log("DEBUG: Error updating passenger_transaction for transaction_id " . $transaction_id);
            }
            mysqli_stmt_close($stmt_update1);
        } elseif ($refund->status == 'requesting') {
            $update2 = "UPDATE passenger_transaction SET status = 'requesting' WHERE id = ?";
            $stmt_update2 = mysqli_prepare($conn, $update2);
            mysqli_stmt_bind_param($stmt_update2, "i", $transaction_id);
            $execute_success = mysqli_stmt_execute($stmt_update2);
            if (!$execute_success) {
                error_log("DEBUG: Error updating passenger_transaction for transaction_id " . $transaction_id);
            }
            mysqli_stmt_close($stmt_update2);
        } else {
            $refund_success = false;
            $refund_message = 'Refund failed for transaction_id ' . $transaction_id . ', status: ' . $refund->status;
            break;
        }
    }

    if ($refund_success) {
        echo json_encode([
            'success' => true,
            'message' => 'Refund processed successfully for all transactions'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $refund_message
        ]);
    }
    exit;

} catch (Exception $e) {
    ob_clean();
    error_log("Refund error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Refund error: ' . $e->getMessage()
    ]);
    exit;
}
?>
