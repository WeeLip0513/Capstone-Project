<?php
include("../../dbconn.php");

$sql = "SELECT id, date, time, driver_id 
        FROM ride 
        WHERE date = '2025-04-02' 
        AND time BETWEEN '14:00' AND '18:00' 
        AND driver_id = 10";

$result = mysqli_query($conn, $sql); // ✅ Correct order

if (!$result) {
    die("Query Failed: " . mysqli_error($conn)); // Debugging
}

// Fetch and display results
$rides = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rides[] = $row;
}

// Output JSON response
echo json_encode($rides, JSON_PRETTY_PRINT);

mysqli_close($conn);
