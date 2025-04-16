<?php
ob_start();
header('Content-Type: application/json');
include("../../dbconn.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Check if user is authenticated
    if (!isset($_SESSION['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not authenticated'
        ]);
        exit;
    }

    // Retrieve user_id from session
    $user_id_from_session = intval($_SESSION['id']);

    // Check if cart exists and is not empty
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Cart is empty.'
        ]);
        exit;
    }

    // Validate that all rides in the cart are still available for booking
    $ride_ids = implode(',', array_map('intval', $_SESSION['cart']));
    $status_check_sql = "SELECT id FROM ride WHERE id IN ($ride_ids) AND (status = 'upcoming')";
    $status_result = mysqli_query($conn, $status_check_sql);
    
    if (mysqli_num_rows($status_result) != count($_SESSION['cart'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Some rides are no longer available for booking'
        ]);
        exit;
    }

    // Look up passenger ID using user_id
    $lookup_sql = "SELECT id FROM passenger WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $lookup_sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id_from_session);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $passenger_id = $row['id']; 
        $_SESSION['passenger_id'] = $passenger_id;
    } else {
        throw new Exception("No passenger record found for user_id = $user_id_from_session");
    }

    // Proceed to payment logic
    if (isset($_POST['action']) && $_POST['action'] == 'proceed_to_payment') {
        require_once '../../payment/vendor/autoload.php';
        
        $stripe_secret_key = "YOUR SECRET KEY";
        \Stripe\Stripe::setApiKey($stripe_secret_key);

        // Fetch ride details for rides in the cart
        $sql = "SELECT r.id, r.pick_up_point, r.drop_off_point, r.price FROM ride r WHERE r.id IN ($ride_ids)";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'SQL error: ' . mysqli_error($conn)
            ]);
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

            // Insert into passenger_transaction
            $insert_sql = "INSERT INTO passenger_transaction (payment_method, status, passenger_id, ride_id, amount) 
                           VALUES ('', 'pending', ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "iid", $passenger_id, $ride_id, $amount);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Transaction insert failed: " . mysqli_stmt_error($stmt));
            }
            $transaction_ids[] = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
        }

        error_log("Line items: " . json_encode($line_items));

        // Create a Stripe Checkout session
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "http://localhost/Capstone-Project/carpool/php/passenger/paymentSuccess.php?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "http://localhost/Capstone-Project/carpool/php/passenger/paymentCancel.php?session_id={CHECKOUT_SESSION_ID}",
            "locale" => "auto",
            "line_items" => $line_items
        ]);

        // Store the Stripe session ID with each transaction ID
        foreach ($transaction_ids as $transaction_id) {
            $insert_session_sql = "INSERT INTO stripe_sessions (session_id, transaction_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $insert_session_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed for stripe_sessions: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "si", $checkout_session->id, $transaction_id);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Insert stripe session failed: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }

        echo json_encode([
            'success' => true,
            'checkout_url' => $checkout_session->url
        ]);
        exit;
    }

} catch (Exception $e) {
    ob_clean();
    error_log("Error in payment processing: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Payment processing failed: ' . $e->getMessage()
    ]);
    exit;
}

// Helper function for location name mapping
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
