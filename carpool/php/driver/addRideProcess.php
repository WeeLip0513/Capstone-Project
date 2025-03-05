<?php
session_start(); // Start session if not already started
include("../../dbconn.php"); // Include database connection

function calculateFare($pickup, $dropoff, $time)
{
    // Define base fares for routes
    $fares = [
        "lrt_bukit_jalil-apu" => 4,
        "apu-lrt_bukit_jalil" => 4,
        "apu-pav_bukit_jalil" => 7,
        "pav_bukit_jalil-apu" => 7,
        "apu-sri_petaling" => 7,
        "sri_petaling-apu" => 7,
        "pav_bukit_jalil-sri_petaling" => 7,
        "sri_petaling-pav_bukit_jalil" => 7,
    ];

    // Format input to match keys
    $routeKey = strtolower("$pickup-$dropoff");

    // Check if the route exists in fares array
    if (!isset($fares[$routeKey])) {
        return "Invalid route selected.";
    }

    // Get base fare
    $fare = $fares[$routeKey];

    // Convert time to hours and check if it's peak hour (18:00 - 20:00)
    $hour = (int) date("H", strtotime($time));

    if ($hour >= 18 && $hour < 20) {
        $fare *= 1.2; // Increase by 20% during peak hours
    }

    return $fare;
}

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