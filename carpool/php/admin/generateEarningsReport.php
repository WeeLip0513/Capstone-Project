<?php
session_start();
include("../../dbconn.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Validate input
$year = isset($_GET['year']) ? intval($_GET['year']) : null;

if (!$year) {
    echo json_encode(['error' => 'Invalid year']);
    exit;
}

// Query to get total earnings per month for the given year
$sql = "SELECT 
            MONTH(ride_completion_date) AS month,
            SUM(driver_revenue) AS total_driver_revenue,
            SUM(app_revenue) AS total_app_revenue
        FROM driver_transaction 
        WHERE YEAR(ride_completion_date) = $year
        GROUP BY MONTH(ride_completion_date)
        ORDER BY MONTH(ride_completion_date)";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
