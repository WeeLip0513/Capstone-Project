<?php
session_start();
session_regenerate_id(true);
include("../../dbconn.php");

if (!isset($_SESSION['driverID'])) {
    echo json_encode(["error" => "Session expired. Please log in again."]);
    exit;
}

$driverID = $_SESSION['driverID'];
$month = isset($_GET['month']) ? $_GET['month'] : null;

if (!$month) {
    echo json_encode(["error" => "Invalid month selection."]);
    exit;
}

$monthMap = [
    "jan" => "01", "feb" => "02", "mar" => "03", "apr" => "04", "may" => "05", "jun" => "06",
    "jul" => "07", "aug" => "08", "sep" => "09", "oct" => "10", "nov" => "11", "dec" => "12"
];

if (!isset($monthMap[$month])) {
    echo json_encode(["error" => "Invalid month selection."]);
    exit;
}

$year = date("Y");
$startDate = "$year-{$monthMap[$month]}-01";
$endDate = date("Y-m-t", strtotime($startDate));

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
  "total" => (float)$total_earnings,
  "withdrawn" => (float)$withdrawn_amount,
  "balance" => (float)$available_balance,
  "range" => date("d-m-Y", strtotime($startDate)) . " <br> ~ <br> " . date("d-m-Y", strtotime($endDate)), 
  "earnings" => array_map(function($date, $revenue) {
      return ["date" => $date, "amount" => $revenue];
  }, $dates, $revenues)
];


header('Content-Type: application/json');
echo json_encode($data);
?>
