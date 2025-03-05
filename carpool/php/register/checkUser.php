<?php
header("Content-Type: application/json"); // Ensure JSON response
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../../dbconn.php");

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}

// Validate required input fields
if (!isset($_POST["tpnumber"]) || !isset($_POST["license"]) || !isset($_POST["email"])) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// Sanitize Input
$tpNumber = mysqli_real_escape_string($conn, $_POST["tpnumber"]);
$license = mysqli_real_escape_string($conn, $_POST["license"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);

// Check if TP Number exists in APU table (Must exist)
$queryApu = "SELECT tpnumber FROM apu WHERE tpnumber = '$tpNumber'";
$resultApu = mysqli_query($conn, $queryApu);
$tpExistsInApu = mysqli_num_rows($resultApu) > 0;

// Check if TP Number is already registered in User table
$queryUser = "SELECT tpnumber FROM user WHERE tpnumber = '$tpNumber'";
$resultUser = mysqli_query($conn, $queryUser);
$tpAlreadyRegistered = mysqli_num_rows($resultUser) > 0;

// Check if License Number is already registered in Driver table
$queryDriver = "SELECT license_no FROM driver WHERE license_no = '$license'";
$resultDriver = mysqli_query($conn, $queryDriver);
$licenseAlreadyRegistered = mysqli_num_rows($resultDriver) > 0;

// Check if Email is already registered in User table
$queryEmail = "SELECT email FROM user WHERE email = '$email'";
$resultEmail = mysqli_query($conn, $queryEmail);
$emailAlreadyRegistered = mysqli_num_rows($resultEmail) > 0;

// Prepare Response
$response = [
    "tpDoesNotExist" => !$tpExistsInApu,  // TP should exist in APU table
    "tpAlreadyRegistered" => $tpAlreadyRegistered, // Check TP registration
    "licenseAlreadyRegistered" => $licenseAlreadyRegistered, // Check License registration
    "emailAlreadyRegistered" => $emailAlreadyRegistered // Check Email registration
];

// Send JSON Response
echo json_encode($response);
mysqli_close($conn);
?>
