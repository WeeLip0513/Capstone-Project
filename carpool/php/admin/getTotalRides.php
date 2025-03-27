<?php
include("../../dbconn.php");

function getCompletedRides($year, $month) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM ride WHERE status = 'completed' AND YEAR(date) = ? AND MONTH(date) = ?");
    $stmt->bind_param("ii", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['total'] ?? 0;
}

$currentYear = date("Y");
$currentMonth = date("m");
$previousYear = ($currentMonth == 1) ? $currentYear - 1 : $currentYear;
$previousMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;

$response = [
    "currentRides" => getCompletedRides($currentYear, $currentMonth),
    "previousRides" => getCompletedRides($previousYear, $previousMonth)
];

header('Content-Type: application/json');
echo json_encode($response);
?>
