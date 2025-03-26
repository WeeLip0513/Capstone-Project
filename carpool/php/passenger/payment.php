<?php
include("../../dbconn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$passenger_id = isset($_SESSION['passenger_id']) ? intval($_SESSION['passenger_id']) : intval($_SESSION['id']);

require_once '../../payment/vendor/autoload.php';
$stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
\Stripe\Stripe::setApiKey($stripe_secret_key);

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    exit;
}

$ride_ids = implode(',', array_map('intval', $_SESSION['cart']));
$sql = "SELECT r.id, r.pick_up_point, r.drop_off_point, r.price FROM ride r WHERE r.id IN ($ride_ids)";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo json_encode(['success' => false, 'message' => 'SQL error: ' . mysqli_error($conn)]);
    exit;
}

$line_items = [];
$transaction_ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $line_items[] = [
        "quantity" => 1,
        "price_data" => [
            "currency" => "myr",
            "unit_amount" => intval($row['price'] * 100),
            "product_data" => [
                "name" => "Ride from " . getLocationName($row['pick_up_point']) . " to " . getLocationName($row['drop_off_point'])
            ]
        ]
    ];
    $ride_id = $row['id'];
    $amount = $row['price'];
    $insert_sql = "INSERT INTO passenger_transaction (payment_method, status, passenger_id, ride_id, amount) 
                   VALUES ('', 'pending', ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($stmt, "iid", $passenger_id, $ride_id, $amount);
    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => false, 'message' => 'Transaction insert failed: ' . mysqli_error($conn)]);
        exit;
    }
    $transaction_ids[] = mysqli_insert_id($conn);
}

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost/Capstone-Project/carpool/php/passenger/paymentSuccess.php?session_id={CHECKOUT_SESSION_ID}",
        "cancel_url" => "http://localhost/Capstone-Project/carpool/php/passenger/paymentCancel.php?session_id={CHECKOUT_SESSION_ID}",
        "locale" => "auto",
        "line_items" => $line_items
    ]);

    // Store the Stripe session ID with transaction IDs in a separate table
    foreach ($transaction_ids as $transaction_id) {
        $insert_session_sql = "INSERT INTO stripe_sessions (session_id, transaction_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_session_sql);
        mysqli_stmt_bind_param($stmt, "si", $checkout_session->id, $transaction_id);
        mysqli_stmt_execute($stmt);
    }

    echo json_encode(['success' => true, 'checkout_url' => $checkout_session->url]);
} catch (Exception $e) {
    error_log("Stripe error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Payment processing failed: ' . $e->getMessage()]);
}
exit;

// Helper function for location name mapping (you can duplicate this if needed)
function getLocationName($location) {
    $locationMapping = [
        'apu' => 'APU (Asia Pacific University)',
        'sri_petaling' => 'Sri Petaling',
        'lrt_bukit_jalil' => 'LRT Bukit Jalil',
        'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
    ];
    return isset($locationMapping[$location]) ? $locationMapping[$location] : ucwords(str_replace("_", " ", $location));
}
?>

<!-- 4242 4242 4242 4242 -->
 <!-- 4000 0000 0000 0002 -->
