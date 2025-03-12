<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../dbconn.php"); // Ensure database connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Securely fetch user inputs
    $tpNumber = mysqli_real_escape_string($conn, $_POST["tpnumber"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $fName = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lName = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phoneNo"]);
    $date = date("Y-m-d");

    // Check if user exists in APU records
    $checkApuSQL = "SELECT * FROM apu WHERE tpnumber = '$tpNumber'";
    $apuResult = mysqli_query($conn, $checkApuSQL);

    // Check if user has already registered
    $checkUserSQL = "SELECT * FROM user WHERE tpnumber = '$tpNumber'";
    $userResult = mysqli_query($conn, $checkUserSQL);

    if (mysqli_num_rows($apuResult) == 0) {
        echo "<script>alert('Error: TP Number does not exist in APU records!'); window.history.back();</script>";
        exit();
    }

    if (mysqli_num_rows($userResult) > 0) {
        echo "<script>alert('Error: You have already registered! Please proceed to login.'); window.location.href='../../loginpage.php';</script>";
        exit();
    }

    // Insert into User Table
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insertUserSQL = "INSERT INTO user (tpnumber, password, email, role) VALUES ('$tpNumber', '$hashedPassword', '$email', 'passenger')";

    if (mysqli_query($conn, $insertUserSQL)) {
        $user_id = mysqli_insert_id($conn);

        // Insert into Driver Table
        $insertPassengerSQL = "INSERT INTO passenger (firstname, lastname, phone_no, user_id, registration_date) 
                                VALUES ('$fName', '$lName', '$phone', '$user_id', '$date')";

        if (mysqli_query($conn, $insertPassengerSQL)) {
            $passenger_id = mysqli_insert_id($conn);
            echo "<script>alert('Passenger Registered!'); window.location.href = '/Capstone-Project/carpool/loginpage.php'</script>";
        } else {
            echo "<script>alert('Error inserting passenger: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error inserting user: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }


    mysqli_close($conn);
}
?>