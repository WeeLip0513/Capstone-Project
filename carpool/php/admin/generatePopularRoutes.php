<?php 
include("../../dbconn.php");  
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['year']) && isset($_GET['month'])) {
    $year = $_GET['year'];
    $month = $_GET['month'];
    
    // Simplified query using only the ride table
    $query = "SELECT pick_up_point, drop_off_point, COUNT(*) AS route_count
              FROM ride
              WHERE status = 'completed'
              AND YEAR(date) = ?
              AND MONTH(date) = ?
              GROUP BY pick_up_point, drop_off_point
              ORDER BY route_count DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();
    
    function getLocationName($location) {
        $locationMapping = [
            'apu' => 'APU (Asia Pacific University)',
            'sri_petaling' => 'Sri Petaling',
            'lrt_bukit_jalil' => 'LRT Bukit Jalil',
            'pav_bukit_jalil' => 'Pavilion Bukit Jalil'
        ];
        return $locationMapping[$location] ?? ucwords(str_replace("_", " ", $location));
    }
    
    while ($row = $result->fetch_assoc()) {
        $routes[] = [
            'route' => getLocationName($row['pick_up_point']) . " → " . getLocationName($row['drop_off_point']),
            'count' => (int)$row['route_count']
        ];
    }
    
    
    header('Content-Type: application/json');
    echo json_encode($routes);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Year and month parameters are required']);
    exit;
}
?>