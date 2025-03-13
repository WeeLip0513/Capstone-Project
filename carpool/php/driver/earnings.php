<?php
session_start();
session_regenerate_id(true); // Refresh session to prevent session fixation

include("../../dbconn.php"); // Include database connection

if (!isset($_SESSION['driverID'])) {
    echo json_encode(["error" => "Session expired. Please log in again."]);
    exit;
}

$driverID = $_SESSION['driverID'];

// SQL Query to fetch earnings data
$earning_sql = "SELECT driver_revenue, ride_completion_date 
                FROM driver_transaction 
                WHERE driver_id = ? 
                AND status = 'active'";

$earning_stmt = $conn->prepare($earning_sql);
$earning_stmt->bind_param("i", $driverID);
$earning_stmt->execute();
$result = $earning_stmt->get_result();

// Process Data: Group earnings by date
$earnings_data = [];
$dates_array = []; // Store dates to find earliest/latest

while ($row = $result->fetch_assoc()) {
    $date = $row['ride_completion_date'];
    $revenue = $row['driver_revenue'];

    if (!isset($earnings_data[$date])) {
        $earnings_data[$date] = 0;
    }
    $earnings_data[$date] += $revenue;
    $dates_array[] = $date;
}

// Ensure dates are sorted in ascending order
ksort($earnings_data);

$earliest_date = !empty($dates_array) ? min($dates_array) : null;
$latest_date = !empty($dates_array) ? max($dates_array) : null;

// Prepare JSON response
$data = [
    "dates" => array_keys($earnings_data),
    "revenues" => array_values($earnings_data),
    "earliest_date" => $earliest_date,
    "latest_date" => $latest_date
];

header('Content-Type: application/json');
echo json_encode($data);
?>
