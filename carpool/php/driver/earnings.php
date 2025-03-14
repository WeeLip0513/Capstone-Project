<?php
session_start();
session_regenerate_id(true);
include("../../dbconn.php");

if (!isset($_SESSION['driverID'])) {
    echo json_encode(["error" => "Session expired. Please log in again."]);
    exit;
}

$driverID = $_SESSION['driverID'];
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;

if (!$startDate || !$endDate) {
    echo json_encode(["error" => "Invalid date range."]);
    exit;
}

// Fetch total earnings
$earning_sql = "SELECT SUM(driver_revenue) AS total_earnings FROM driver_transaction 
                WHERE driver_id = ? AND ride_completion_date BETWEEN ? AND ?";
$earning_stmt = $conn->prepare($earning_sql);
$earning_stmt->bind_param("iss", $driverID, $startDate, $endDate);
$earning_stmt->execute();
$earning_result = $earning_stmt->get_result();
$earning_data = $earning_result->fetch_assoc();
$total_earnings = $earning_data['total_earnings'] ?? 0;
$earning_stmt->close();

// Fetch withdrawn amount
$withdraw_sql = "SELECT SUM(driver_revenue) AS withdrawn_amount FROM driver_transaction 
                 WHERE driver_id = ? AND status IN ('requested', 'withdrawn') 
                 AND ride_completion_date BETWEEN ? AND ?";
$withdraw_stmt = $conn->prepare($withdraw_sql);
$withdraw_stmt->bind_param("iss", $driverID, $startDate, $endDate);
$withdraw_stmt->execute();
$withdraw_result = $withdraw_stmt->get_result();
$withdraw_data = $withdraw_result->fetch_assoc();
$withdrawn_amount = $withdraw_data['withdrawn_amount'] ?? 0;
$withdraw_stmt->close();

$available_balance = $total_earnings - $withdrawn_amount;

// Fetch earnings grouped by date
$chart_sql = "SELECT DATE(ride_completion_date) AS ride_date, SUM(driver_revenue) AS daily_revenue 
              FROM driver_transaction 
              WHERE driver_id = ? 
              AND ride_completion_date BETWEEN ? AND ?
              GROUP BY ride_date
              ORDER BY ride_date ASC";
$chart_stmt = $conn->prepare($chart_sql);
$chart_stmt->bind_param("iss", $driverID, $startDate, $endDate);
$chart_stmt->execute();
$chart_result = $chart_stmt->get_result();

$dates = [];
$revenues = [];
while ($row = $chart_result->fetch_assoc()) {
    $dates[] = $row['ride_date'];
    $revenues[] = (float)$row['daily_revenue'];
}
$chart_stmt->close();

$data = [
    "total_earnings" => number_format((float)$total_earnings, 2, '.', ''),
    "withdrawn_amount" => number_format((float)$withdrawn_amount, 2, '.', ''),
    "available_balance" => number_format((float)$available_balance, 2, '.', ''),
    "dates" => $dates,
    "revenues" => $revenues,
];

header('Content-Type: application/json');
echo json_encode($data);
?>
