<?php
require __DIR__ . "/payment/vendor/autoload.php";

$stripe_secret_key = "sk_test_51R4itsICYgzkaiaB2pjFAClhJIHxtD74dimmn0DkCl9OEHAyQUb4eM797FyOgFmrj58R3xvNHGnyzn5xE3a25xj800PCRUFhvq";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/Capstone-Project/carpool/checkoutPage.php",
    "cancel_url" => "http://localhost/Capstone-Project/carpool/passenger/passengerPage.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "myr",
                "unit_amount" => 2000,
                "product_data" => [
                    "name" => "T-shirt"
                ]
            ]
        ],
        [
            "quantity" => 2,
            "price_data" => [
                "currency" => "myr",
                "unit_amount" => 700,
                "product_data" => [
                    "name" => "Hat"
                ]
            ]
        ]
    ]
]);
http_response_code(303);
header("Location: " . $checkout_session->url);
?> 