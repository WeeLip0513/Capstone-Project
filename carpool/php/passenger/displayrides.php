<?php 
include("../../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Fetch rides along with driver and vehicle details
    $sql = "SELECT 
                r.pick_up_point, r.drop_off_point, r.date, r.time, r.slots_available, 
                d.firstname, d.lastname, 
                v.brand, v.model, v.color, v.plate_no
            FROM ride r
            JOIN driver d ON r.driver_id = d.id
            JOIN vehicle v ON r.vehicle_id = v.id
            WHERE r.pick_up_point = ? 
            AND r.drop_off_point = ? 
            AND r.date = ? 
            AND r.time = ? AND r.status = 'upcoming'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $pickup, $dropoff, $date, $time);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='ride-card'>
                    <div class='ride-header'>
                        <strong>{$row['pick_up_point']} ➡️ {$row['drop_off_point']}</strong>
                        <button class='book-ride'>Book Ride</button>
                    </div>
                    <div class='ride-info'>
                        <p>📅 {$row['date']} ⏰ {$row['time']}</p>
                        <p>👨‍✈️ {$row['firstname']} {$row['lastname']}</p>
                        <p>🚗 {$row['brand']} {$row['model']} {$row['color']} {$row['plate_no']}</p>
                        <p>🪑 Slots Available: {$row['slots_available']}</p>
                    </div>
                </div>";
        }
    } else {
        echo "<p>No rides available for the selected criteria.</p>";
    }
}
?>
