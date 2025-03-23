<?php
session_start();
include("../../dbconn.php");

// Get parameters
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;
$month = isset($_GET['month']) ? intval($_GET['month']) : 0;

// Validate input
if ($year <= 0 || $month <= 0 || $month > 12) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid year or month']);
    exit;
}

// Determine number of days in the month
function getDaysInMonth($month, $year) {
    switch ($month) {
        case 2: // February
            return ((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0)) ? 29 : 28;
        case 4: // April
        case 6: // June
        case 9: // September
        case 11: // November
            return 30;
        default:
            return 31;
    }
}

$daysInMonth = getDaysInMonth($month, $year);

// Initialize data arrays
$days = range(1, $daysInMonth);
$passengers = array_fill(0, $daysInMonth, 0);
$drivers = array_fill(0, $daysInMonth, 0);

// Format dates for SQL
$startDate = sprintf("%04d-%02d-01", $year, $month);
$endDate = sprintf("%04d-%02d-%02d", $year, $month, $daysInMonth);

// Query for passenger registrations
$passengerQuery = "SELECT DAY(registration_date) as day, COUNT(*) as count 
                  FROM passenger 
                  WHERE registration_date BETWEEN ? AND ?
                  GROUP BY DAY(registration_date)";
                  
$stmt = $conn->prepare($passengerQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $day = intval($row['day']);
    if ($day >= 1 && $day <= $daysInMonth) {
        $passengers[$day - 1] = intval($row['count']);
    }
}

// Query for driver registrations
$driverQuery = "SELECT DAY(registration_date) as day, COUNT(*) as count 
               FROM driver 
               WHERE registration_date BETWEEN ? AND ?
               GROUP BY DAY(registration_date)";
               
$stmt = $conn->prepare($driverQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $day = intval($row['day']);
    if ($day >= 1 && $day <= $daysInMonth) {
        $drivers[$day - 1] = intval($row['count']);
    }
}

// Return data as JSON
$response = [
    'days' => $days,
    'passengers' => $passengers,
    'drivers' => $drivers
];

header('Content-Type: application/json');
echo json_encode($response);
?>