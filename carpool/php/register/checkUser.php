<?php
include("../../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpNumber = mysqli_real_escape_string($conn, $_POST["tpnumber"]);
    $license = mysqli_real_escape_string($conn, $_POST["license"]);

    // 🚀 Check if TP Number exists in APU table (MUST exist in APU)
    $queryApu = "SELECT tpnumber FROM apu WHERE tpnumber = '$tpNumber'";
    $resultApu = mysqli_query($conn, $queryApu);
    $tpExistsInApu = mysqli_num_rows($resultApu) > 0; // ✅ Must be in APU

    // 🚀 Check if TP Number exists in User (Already Registered?)
    $queryUser = "SELECT tpnumber FROM user WHERE tpnumber = '$tpNumber'";
    $resultUser = mysqli_query($conn, $queryUser);
    $tpAlreadyRegistered = mysqli_num_rows($resultUser) > 0;

    // 🚀 Check if License Number already exists in Driver (Already Registered?)
    $queryDriver = "SELECT license_no FROM driver WHERE license_no = '$license'";
    $resultDriver = mysqli_query($conn, $queryDriver);
    $licenseAlreadyRegistered = mysqli_num_rows($resultDriver) > 0;

    // 🚀 JSON response
    echo json_encode([
        "tpDoesNotExist" => !$tpExistsInApu,  // ❌ TP NOT in APU? Block user
        "tpAlreadyRegistered" => $tpAlreadyRegistered, // ⚠️ TP ALREADY REGISTERED?
        "licenseAlreadyRegistered" => $licenseAlreadyRegistered // ⚠️ LICENSE ALREADY REGISTERED?
    ]);
}

mysqli_close($conn);
?>
