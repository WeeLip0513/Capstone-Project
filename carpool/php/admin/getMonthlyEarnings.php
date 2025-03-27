<?php
include '../../dbconn.php'; // Make sure your database connection is here

header('Content-Type: application/json');

// Get earnings for the current month
function getMonthlyEarnings($conn) {
    $query = "
        SELECT 
            SUM(driver_revenue) AS driver_revenue, 
            SUM(app_revenue) AS app_revenue
        FROM driver_transaction
        WHERE DATE_FORMAT(ride_completion_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode([
            "driverRevenue" => $data['driver_revenue'] ?? 0,
            "appRevenue" => $data['app_revenue'] ?? 0
        ]);
    } else {
        echo json_encode(["error" => "Database query failed"]);
    }
}

// Call function
getMonthlyEarnings($conn);
?>
