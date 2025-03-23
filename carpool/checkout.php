

<?php
session_start();
require __DIR__ . "/dbconn.php";
require __DIR__ . "/payment/vendor/autoload.php";

$stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Validate user session
if (!isset($_SESSION['passenger_id'])) {
    die("Unauthorized access");
}

$stmt = $conn->prepare("
    SELECT id, payment_method, status, passenger_id, ride_id, amount 
    FROM passenger_transaction 
    WHERE passenger_id = 1 AND status = 'unpaid'
");
$stmt->bind_param("i", $_SESSION['passenger_id']);
$stmt->execute();
$transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($transactions)) {
    die("No transactions to process");
}

// Prepare Stripe line items
$line_items = [];
foreach ($transactions as $t) {
    $line_items[] = [
        'quantity' => 1,
        'price_data' => [
            'currency' => 'myr',
            'unit_amount' => $t['amount'],
            'product_data' => [
                'name' => "Ride #" . $t['ride_id']
            ]
        ]
    ];
}

// Create Stripe session
try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'mode' => 'payment',
        'payment_method_types' => ['card'],
        'success_url' => 'http://localhost/Capstone-Project/carpool/payment_success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/Capstone-Project/carpool/payment_cancel.php',
        'line_items' => $line_items,
        'metadata' => [
            'passenger_id' => $_SESSION['passenger_id']
        ]
    ]);

    // Store transaction-session relationship
    foreach ($transactions as $t) {
        $stmt = $conn->prepare("
            UPDATE passenger_transaction 
            SET payment_method = 'stripe', 
                status = 'pending'
            WHERE id = ?
        ");
        $stmt->bind_param("i", $t['id']);
        $stmt->execute();
    }

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    exit;

} catch (Exception $e) {
    error_log("Stripe error: " . $e->getMessage());
    die("Payment processing error");
}
?>