<?php
include("../../dbconn.php");


// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart in session if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// $passenger_id = 1;
// $_SESSION['passenger_id'] = $passenger_id;

$passenger_id = isset($_SESSION['passenger_id']) ? intval($_SESSION['passenger_id']) : intval($_SESSION['id']);

// Query for rides with status "complete"
$sql = "SELECT ride_id FROM passenger_transaction 
        WHERE passenger_id = ? AND status = 'complete'";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    error_log("SQL Prepare Error: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $passenger_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$booked_rides = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Cast ride_id to string for consistency
    $booked_rides[] = (string)$row['ride_id'];
}
error_log("Booked rides returned: " . print_r($booked_rides, true));


// If this request is only to check booked rides, return JSON.
if (isset($_POST['action']) && $_POST['action'] === 'check_booked_rides') {
    echo json_encode(['success' => true, 'bookedRides' => $booked_rides]);
    exit;
}

function getLocationName($location)
{
    $locationMapping = [
        'apu' => 'APU (Asia Pacific University)',
        'sri_petaling' => 'Sri Petaling',
        'lrt_bukit_jalil' => 'LRT Bukit Jalil',
        'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
    ];

    return $locationMapping[$location] ?? ucwords(str_replace("_", " ", $location));
}

// cart function
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add_to_cart') {
        $ride_id = $_POST['ride_id'];

        // Check if ride already in cart
        if (!in_array($ride_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $ride_id;

            // Update ride status to pending in database
            // $sql = "UPDATE ride SET status = 'pending' WHERE id = ?";
            // $stmt = mysqli_prepare($conn, $sql);
            // if (!$stmt) {
            //     die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($conn)]));
            // }
            // mysqli_stmt_bind_param($stmt, "i", $ride_id);
            // if (!mysqli_stmt_execute($stmt)) {
            //     die(json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_stmt_error($stmt)]));
            // }

            echo json_encode(['success' => true, 'message' => 'Ride added to cart', 'cart_count' => count($_SESSION['cart'])]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ride already in cart']);
        }
        exit;
    } elseif ($_POST['action'] == 'get_cart_items') {
        // Fetch cart items details
        if (empty($_SESSION['cart'])) {
            echo json_encode(['success' => false, 'message' => 'Cart is empty']);
            exit;
        }

        $ride_ids = implode(',', array_map('intval', $_SESSION['cart']));
        $sql = "SELECT 
                    r.id, r.pick_up_point, r.drop_off_point, r.date, r.time, r.price,
                    d.firstname, d.lastname,
                    v.brand, v.model, v.color, v.plate_no
                FROM ride r
                JOIN driver d ON r.driver_id = d.id
                JOIN vehicle v ON r.vehicle_id = v.id
                WHERE r.id IN ($ride_ids)";

        $result = mysqli_query($conn, $sql);

        $cart_items = [];
        $total_price = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
            $total_price += $row['price'];
        }

        echo json_encode([
            'success' => true,
            'items' => $cart_items,
            'total_price' => $total_price
        ]);
        exit;
    } elseif ($_POST['action'] == 'remove_from_cart') {
        $ride_id = $_POST['ride_id'];

        // Remove ride from cart
        $key = array_search($ride_id, $_SESSION['cart']);
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array

            // Update ride status back to upcoming
            // $sql = "UPDATE ride SET status = 'pending' WHERE id = ?";
            // $stmt = mysqli_prepare($conn, $sql);
            // mysqli_stmt_bind_param($stmt, "i", $ride_id);
            // mysqli_stmt_execute($stmt);

            echo json_encode(['success' => true, 'message' => 'Ride removed from cart', 'cart_count' => count($_SESSION['cart'])]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ride not found in cart']);
        }
        exit;
    } 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get filter values if provided; default to empty strings
    $pickup  = $_POST['pickup']  ?? "";
    $dropoff = $_POST['dropoff'] ?? "";
    $date    = $_POST['date']    ?? "";
    $time    = $_POST['time']    ?? "";

    if ($pickup !== "" && $dropoff !== "" && $pickup === $dropoff) {
        echo "<p style='color:red;'>Pickup point and drop-off point cannot be the same.</p>";
        exit;
    }

    $sql = "SELECT 
                r.id, r.pick_up_point, r.drop_off_point, r.date, r.time, r.slots_available, r.slots, r.price,
                d.firstname, d.lastname, 
                v.brand, v.model, v.color, v.plate_no
            FROM ride r
            JOIN driver d ON r.driver_id = d.id
            JOIN vehicle v ON r.vehicle_id = v.id
            WHERE r.status = 'upcoming'";

    $params = [];
    $types = '';

    if ($pickup !== "") {
        $sql .= " AND r.pick_up_point = ?";
        $params[] = $pickup;
        $types .= 's';
    }
    if ($dropoff !== "") {
        $sql .= " AND r.drop_off_point = ?";
        $params[] = $dropoff;
        $types .= 's';
    }
    // ** COMMENT IT**
    if ($date !== "") {
        $sql .= " AND r.date = ?";
        $params[] = $date;
        $types .= 's';
    }
     // ** REMEMBER UNCOMMENT IN PRESENTATION**
    // if ($date === "") {
    //     $today = date('Y-m-d');
    //     $sql .= " AND r.date >= ?";
    //     $params[] = $today;
    //     $types .= 's';
    // } else {
    //     $sql .= " AND r.date = ?";
    //     $params[] = $date;
    //     $types .= 's';
    // }
    if ($time !== "") {
        $sql .= " AND r.time = ?";
        $params[] = $time;
        $types .= 's';
    }

    $stmt = mysqli_prepare($conn, $sql);
    if ($params) {
        // splat operator (...) to unpack the parameters
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ridesDisplayed = false;

    echo "<div class='ride-container'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $totalSlots = $row['slots'];
        $slotsAvailable = $row['slots_available'];

        if ($slotsAvailable == 0){
            continue;
        }

        $occupiedSlots = $totalSlots - $slotsAvailable;
        $ridesDisplayed = true;

        $occupancyRate = $occupiedSlots / $totalSlots;
        if ($occupancyRate >= 0.7) {
            $statusText = "Few Seats Left";
            $statusColor = "rgba(234, 179, 8, 0.2)";
            $statusTextColor = "#EAB308";
        } else {
            $statusText = "Available";
            $statusColor = "rgba(16, 185, 129, 0.2)";
            $statusTextColor = "#10B981";
        }

        $currentRideID = (string) $row['id'];
        $booked_rides_str = array_map('strval', $booked_rides);
        $booked = in_array($currentRideID, $booked_rides_str);

        if ($booked) {
            $buttonText = "Booked";
            $buttonClass = "book-ride booked";
            $disabled = "disabled";
        } else {
            $cart_items_str = array_map('strval', $_SESSION['cart']);
            $inCart = in_array($currentRideID, $cart_items_str);
            $buttonText = $inCart ? "In Cart" : "Add To Ride";
            $buttonClass = $inCart ? "book-ride in-cart" : "book-ride";
            $disabled = "";
        }

        echo "<div class='ride-card' data-ride-id='" . $row['id'] . "'>
            <div class='ride-header'>
                <div class='ride-title'>
                    <i class='fas fa-map-marker-alt'></i>
                    <p>" . getLocationName($row['pick_up_point']) . "</p>
                </div>
                <div class='status-tag' style='background-color: $statusColor; color: $statusTextColor;'>$statusText</div>
            </div>
            <div class='ride-content'>
                <div class='ride-details'>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-location-arrow'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Drop-off</h4>
                            <p>" . getLocationName($row['drop_off_point']) . "</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-calendar'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Date & Time</h4>
                            <p>" . $row['date'] . " at " . $row['time'] . "</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-user-tie'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Driver</h4>
                            <p>" . $row['firstname'] . " " . $row['lastname'] . "</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-car'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Vehicle</h4>
                            <p>" . $row['brand'] . " " . $row['model'] . " " . $row['color'] . " " . $row['plate_no'] . "</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-dollar-sign'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Price</h4>
                            <p class='price-value'>RM " . $row['price'] . "</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class='ride-footer'>
                <p>" . generatePassengerIcons($totalSlots, $occupiedSlots) . "</p>
                <button class='$buttonClass' data-ride-id='" . $row['id'] . "' $disabled>$buttonText</button>
            </div>
        </div>";
    }
    echo "</div>";

    if (!$ridesDisplayed) {
        echo "<p style='color:#007bff;'>No rides available for the selected criteria.</p>";
    }
}

// Function to generate passenger icons
function generatePassengerIcons($totalSlots, $occupiedSlots)
{
    $icons = "<div class='passenger-container'>";
    for ($i = 0; $i < $totalSlots; $i++) {
        $color = ($i < $occupiedSlots) ? '#007bff' : 'lightgray';
        $icons .= "<div class='passenger-icons' style='background-color: $color;'>
                    <i class='fa fa-user'></i>
                    </div>";
    }
    $icons .= "<p style='margin-left:8px;'>$occupiedSlots / $totalSlots </p></div>";
    return $icons;
}






?>