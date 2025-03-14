<?php 
include("../../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Fetch rides along with driver and vehicle details
    $sql = "SELECT 
                r.pick_up_point, r.drop_off_point, r.date, r.time, r.slots_available, r.slots,
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

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='ride-container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $totalSlots = $row['slots']; 
            $occupiedSlots = $totalSlots - $row['slots_available']; // Calculate occupied slots

            echo "<div class='ride-card'>
                <div class='ride-header'>
                    <strong><i class='fas fa-map-marker-alt' style='margin-right:10px;'></i> " . ucwords(str_replace("_", " ", $row['pick_up_point'])) . "</strong>
                    <button class='book-ride'>Book Ride</button>
                </div>
                <div class='ride-header'>
                    <strong><i class='fas fa-flag-checkered'></i> " . ucwords(str_replace("_", " ", $row['drop_off_point'])) . "</strong>
                </div>
                <div class='ride-info'>
                    <div class = 'ride-column'>
                        <p><i class='fas fa-calendar-alt'></i> " . $row['date'] . "</p>
                        <p style='margin-left:45px;'><i class='fas fa-clock'></i> " . $row['time'] . "</p>
                    </div>
                    <p><i class='fas fa-user-tie'></i> " . $row['firstname'] . " " . $row['lastname'] . "</p>
                    <p><i class='fa-solid fa-car'></i> " . $row['brand'] . " " . $row['model'] . " " . $row['color'] . " " . $row['plate_no'] . "</p>
                    <p>Passengers: " . generatePassengerIcons($totalSlots, $occupiedSlots) . "</p>
                </div>
            </div>";  
        }
        echo "<div class='ride-container'>";
    } else {
        echo "<p>No rides available for the selected criteria.</p>";
    }
}

// Function to generate passenger icons dynamically
function generatePassengerIcons($totalSlots, $occupiedSlots) {
    $icons = "";
    for ($i = 0; $i < $totalSlots; $i++) {
        $color = ($i < $occupiedSlots) ? '#007bff' : 'lightgray'; // Blue for occupied, gray for available
        $icons .= "<i class='fa fa-user' style='color: $color; font-size: 20px; margin-right: 5px;'></i>";
    }

    // If no one is on board, show the message
    if ($occupiedSlots == 0) {
        $icons .= "<div class='availability-message' style='margin-top: 5px; font-size: 14px; color: white;'>
                    Be the first person to get on board.
                  </div>";
    }

    return $icons;
}
?>
