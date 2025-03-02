<?php
session_start();
include("dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpnumber = trim($_POST["tpnumber"]);
    $password = trim($_POST["password"]);

    // Validate TP Number Format (TP + 6 digits)
    if(!preg_match('/^TP\d{6}$/', $tpnumber)){
        echo "<script>alert('Invalid TP Number format. Must be TP + 6 digits.'); window.history.back();</script>";
        exit();
    }

    // Check user in database
    $query = "SELECT tpnumber, password, role FROM user WHERE tpnumber = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tpnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if ($password === $user["password"]) {
            $_SESSION["tpnumber"] = $user["tpnumber"];
            $_SESSION["role"] = $user["role"];

            // Redirect based on role
            if ($user["role"] == "admin") {
                header("Location: homepage.php");
            } elseif ($user["role"] == "driver") {
                header("Location: driverPage.php");
            } else {
                header("Location: driverRegistration.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found. Please check your TP Number.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>