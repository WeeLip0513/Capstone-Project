<?php
include("dbconn.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $vehicle = $_POST['vehicle'];
    $slots = $_POST['seatNo'];

    // Combine hour and minute to form time
    $time = $hour . ":" . $minute;

    // Insert data into the rides table
    $sql = "INSERT INTO rides (day, time, pickup, dropoff, vehicle) 
            VALUES ('$day', '$time', '$pickup', '$dropoff', '$vehicle')";

    if (mysqli_query($conn, $sql)) {
        echo "Ride added successfully!";
        header("Location: driverPage.php?success=1"); // Redirect to driver page with success message
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
