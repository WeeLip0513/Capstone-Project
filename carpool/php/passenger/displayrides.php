<?php 
include("../../dbconn.php");

function getLocationName($location) {
    $locationMapping = [
        'apu' => 'APU (Asia Pacific University)',
        'sri_petaling' => 'Sri Petaling',
        'lrt_bukit_jalil' => 'LRT Bukit Jalil',
        'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
    ];

    return $locationMapping[$location] ?? ucwords(str_replace("_", " ", $location));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "SELECT 
                r.pick_up_point, r.drop_off_point, r.date, r.time, r.slots_available, r.slots,r.price,
                d.firstname, d.lastname, 
                v.brand, v.model, v.color, v.plate_no
            FROM ride r
            JOIN driver d ON r.driver_id = d.id
            JOIN vehicle v ON r.vehicle_id = v.id
            WHERE r.pick_up_point = ? 
            AND r.drop_off_point = ? 
            AND r.date = ? 
            AND r.time = ? 
            AND r.status = 'upcoming'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $pickup, $dropoff, $date, $time);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ridesDisplayed = false;

    echo "<div class='ride-container'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $totalSlots = $row['slots']; 
        $slotsAvailable = $row['slots_available']; 

        if ($slotsAvailable == 0) {
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

        echo "<div class='ride-card'>
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
                            <p>". getLocationName($row['drop_off_point']) ."</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-calendar'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Date & Time</h4>
                            <p>". $row['date'] . " at " .$row['time']."</p>
                        </div>
                    </div>
                    <div class='detail-item'>
                        <div class='detail-icon'>
                            <i class='fas fa-user-tie'></i>
                        </div>
                        <div class='detail-text'>
                            <h4>Driver</h4>
                            <p>". $row['firstname'] . " " . $row['lastname'] . "</p>
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
                            <p>RM " . $row['price'] . "</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class='ride-footer'>
                <p>". generatePassengerIcons($totalSlots, $occupiedSlots) ."</p>
                <button class='book-ride'>Add To Ride</button>
            </div>
        </div>";  
    }
    echo "</div>";

    if (!$ridesDisplayed) {
        echo "<p style='color:#007bff;'>No rides available for the selected criteria.</p>";
    }
}

// Function to generate passenger icons
function generatePassengerIcons($totalSlots, $occupiedSlots) {
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
