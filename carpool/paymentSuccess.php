<?php
session_start();
require __DIR__ . "/dbconn.php";
require __DIR__ . "/payment/vendor/autoload.php";

$stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
\Stripe\Stripe::setApiKey($stripe_secret_key);

try {
    $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
    
    if ($session->payment_status === 'paid') {
        // Get associated transactions
        $stmt = $conn->prepare("
            SELECT transaction_id 
            FROM stripe_sessions 
            WHERE session_id = ?
        ");
        $stmt->bind_param("s", $_GET['session_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Update each transaction
        while ($row = $result->fetch_assoc()) {
            $update = $conn->prepare("
                UPDATE passenger_transaction 
                SET status = 'paid' 
                WHERE id = ?
            ");
            $update->bind_param("i", $row['transaction_id']);
            $update->execute();
        }
        
        header("Location: passengerPage.php?payment=success");
        exit;
    }
} catch (Exception $e) {
    error_log("Payment verification failed: " . $e->getMessage());
}

header("Location: passengerPage.php?payment=error");