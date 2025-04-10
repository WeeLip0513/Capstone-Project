<?php
session_start();
include("../../dbconn.php");
include("../../payment/vendor/autoload.php");

$stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
\Stripe\Stripe::setApiKey($stripe_secret_key);

/* Update rides after successful payment */
function updateRidesAfterPayment($conn, $session_id) {
    // Get all transaction IDs linked to this session
    $stmt = $conn->prepare("SELECT transaction_id  FROM stripe_sessions WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        // Get ride information
        $ride_stmt = $conn->prepare("
            SELECT pt.ride_id, r.slots_available 
            FROM passenger_transaction pt
            JOIN ride r ON pt.ride_id = r.id
            WHERE pt.id = ?
        ");
        $ride_stmt->bind_param("i", $row['transaction_id']);
        $ride_stmt->execute();
        $ride_result = $ride_stmt->get_result();
        $ride_data = $ride_result->fetch_assoc();
        
        if ($ride_data) {
            // Update ride status and reduce available slots
            $new_slots = max(0, $ride_data['slots_available'] - 1); // Ensure slots don't go below 0
            
            $update_ride = $conn->prepare("
                UPDATE ride 
                SET slots_available = ?, 
                    status = CASE 
                        WHEN ? = 0 THEN 'full' 
                        ELSE 'upcoming' 
                    END
                WHERE id = ?
            ");
            $update_ride->bind_param("iii", $new_slots, $new_slots, $ride_data['ride_id']);
            $update_ride->execute();
        }
    }
}

/* cancelTransactions */
function cancelTransactionsForSession($conn, $session_id) {
    $stmt = $conn->prepare("SELECT transaction_id FROM stripe_sessions WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $update = $conn->prepare("UPDATE passenger_transaction SET status = 'canceled' WHERE id = ?");
        $update->bind_param("i", $row['transaction_id']);
        $update->execute();
    }
}

try {
    if (!isset($_GET['session_id'])) {
        throw new Exception("No session ID provided");
    }
    
    $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);

    if ($session->payment_status === 'paid') {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        $payment_method = isset($paymentIntent->payment_method_types[0]) ? $paymentIntent->payment_method_types[0] : '';

        // Get transactions for this session
        $stmt = $conn->prepare("SELECT transaction_id FROM stripe_sessions WHERE session_id = ?");
        $stmt->bind_param("s", $_GET['session_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Update each transaction to complete
        while ($row = $result->fetch_assoc()) {
            $update = $conn->prepare("UPDATE passenger_transaction SET status = 'complete', payment_method = ? WHERE id = ?");
            $update->bind_param("si", $payment_method, $row['transaction_id']);
            $update->execute();
        }
        
        // Update rides (reduce slots, update status)
        updateRidesAfterPayment($conn, $_GET['session_id']);
        $_SESSION['cart'] = [];
        header("Location: ../../passenger/passengerPage.php?payment=success");
        exit;
    } else {
        // Payment not successful, so update transactions to canceled
        cancelTransactionsForSession($conn, $_GET['session_id']);
        $_SESSION['cart'] = [];
        header("Location: ../../passenger/passengerPage.php?payment=error");
        exit;
    }
} catch (Exception $e) {
    error_log("Payment verification failed: " . $e->getMessage());
    // transactions fails 
    if (isset($_GET['session_id'])) {
        cancelTransactionsForSession($conn, $_GET['session_id']);
    }
    $_SESSION['cart'] = [];
    header("Location: ../../passenger/passengerPage.php?payment=cancel");
    exit;
}
?>
