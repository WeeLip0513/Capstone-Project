<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("../../dbconn.php");

// Function to map location names
function getLocationName($location) {
    $locationMapping = [
        'apu' => 'APU',
        'sri_petaling' => 'Sri Petaling',
        'lrt_bukit_jalil' => 'LRT Bukit Jalil',
        'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
    ];
    
    return $locationMapping[$location] ?? ucwords(str_replace("_", " ", $location));
}

// Validate and sanitize input
if (isset($_GET['year']) && isset($_GET['month'])) {
    $year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
    $month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);

    // Additional input validation
    if ($year === false || $month === false || $year < 2000 || $year > 2050 || $month < 1 || $month > 12) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'message' => 'Invalid year or month provided'
        ]);
        exit;
    }

    // Prepare query
    $query = "SELECT pick_up_point, drop_off_point, COUNT(*) AS route_count
              FROM ride
              WHERE status = 'completed'
              AND YEAR(date) = ?
              AND MONTH(date) = ?
              GROUP BY pick_up_point, drop_off_point
              ORDER BY route_count DESC";

    // Prepare and execute statement
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'message' => 'Error preparing statement: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("ii", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if query was successful
    if ($result === false) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'message' => 'Error executing query: ' . $stmt->error
        ]);
        exit;
    }

    // Fetch routes
    $routes = [];
    while ($row = $result->fetch_assoc()) {
        $routes[] = [
            'route' => getLocationName($row['pick_up_point']) . " ↔ " . getLocationName($row['drop_off_point']),
            'count' => (int)$row['route_count']
        ];
    }

    // Close statement
    $stmt->close();

    // Set headers and return JSON
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($routes);
    exit;
} else {
    // Missing parameters
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode([
        'error' => true,
        'message' => 'Year and month parameters are required'
    ]);
    exit;
}
?>