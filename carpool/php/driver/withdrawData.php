<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../dbconn.php");
session_start();

$driver_id = $_SESSION["driverID"];
$month = $_GET['month'] ?? ''; // Get the month from the request
// $month = "mar";

header('Content-Type: application/json');

// Validate month input to prevent SQL injection
$validMonths = [
    "jan" => "01", "feb" => "02", "mar" => "03", "apr" => "04", "may" => "05", "jun" => "06",
    "jul" => "07", "aug" => "08", "sep" => "09", "oct" => "10", "nov" => "11", "dec" => "12"
];

if (!isset($validMonths[$month])) {
    echo json_encode(["error" => "Invalid month"]);
    exit;
}

$selectedMonth = $validMonths[$month];

// Prepare the SQL query with a WHERE condition for the month
$sql = "SELECT bank, account_number, name, amount, DATE_FORMAT(date, '%Y-%m-%d') AS withdraw_date 
        FROM withdraw_record 
        WHERE driver_id = ? AND DATE_FORMAT(date,'%m') = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ii", $driver_id, $selectedMonth); // "ii" means two integers
    $stmt->execute();
    $result = $stmt->get_result();

    $withdrawals = [];

    while ($row = $result->fetch_assoc()) {
        $withdrawals[] = $row;
    }

    echo json_encode($withdrawals);

    $stmt->close();
} else {
    echo json_encode(["error" => "Query failed"]);
}

$conn->close();

?>
