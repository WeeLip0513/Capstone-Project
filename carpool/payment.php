<?php
session_start();
include("../../dbconn.php");
require __DIR__ . "/../../payment/vendor/autoload.php";

function getLocationName($location) {
    $locationMapping = [
        'apu' => 'APU (Asia Pacific University)',
        'sri_petaling' => 'Sri Petaling',
        'lrt_bukit_jalil' => 'LRT Bukit Jalil',
        'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
    ];
    return $locationMapping[$location] ?? ucwords(str_replace("_", " ", $location));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'proceed_to_payment') {
    $stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    
    $ride_ids = implode(',', array_map('intval', $_SESSION['cart']));
    $sql = "SELECT r.id, r.pick_up_point, r.drop_off_point, r.price FROM ride r WHERE r.id IN ($ride_ids)";
    $result = mysqli_query($conn, $sql);
    
    $line_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $line_items[] = [
            "quantity" => 1,
            "price_data" => [
                "currency" => "myr",
                "unit_amount" => $row['price'] * 100,
                "product_data" => [
                    "name" => "Ride from " . getLocationName($row['pick_up_point']) . " to " . getLocationName($row['drop_off_point'])
                ]
            ]
        ];
    }

    try {
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "http://localhost/Capstone-Project/carpool/checkoutPage.php",
            "cancel_url" => "http://localhost/Capstone-Project/carpool/passenger/passengerPage.php",
            "locale" => "auto",
            "line_items" => $line_items
        ]);
        
        echo json_encode(['success' => true, 'checkout_url' => $checkout_session->url]);
    } catch (Exception $e) {
        error_log("Stripe error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Payment processing failed']);
    }
    exit;
}