<?php
session_start(); // Start session if not already started
include("../../dbconn.php"); // Include database connection
include("fareCalculator.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $date = $_POST['txtDate']; // Ensure the input field name matches
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $vehicle = $_POST['vehicle'];
    $slots = $_POST['seatNo'];
    $driver_id = $_SESSION['driverID'];
    $status = "upcoming";

    // echo $date;
    // echo $hour;
    // echo $minute;
    // echo $pickup;
    // echo $dropoff;
    // echo $vehicle;
    // echo $slots;
    // echo $driver_id;

    // Convert date to day of the week
    $dayOfWeek = strtolower(date("l", strtotime($date)));


    // Format time
    $time = $hour . ":" . $minute;

    // Calculate fare
    $price = calculateFare($pickup, $dropoff, $time);

    // echo $price;

    // Insert data into the rides table
    $sql = "INSERT INTO ride (date, day, time, pick_up_point, drop_off_point, price, slots_available, slots, status, vehicle_id, driver_id) 
            VALUES ('$date', '$dayOfWeek', '$time', '$pickup', '$dropoff', '$price', '$slots', '$slots', '$status', '$vehicle', '$driver_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Ride Added Successfully!');
        window.location.href = '../../driver/driverPage.php'; // Change to the actual filename
    </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>