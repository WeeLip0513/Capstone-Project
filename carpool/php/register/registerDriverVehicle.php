<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../dbconn.php"); // Ensure database connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Securely fetch user inputs
    $tpNumber = mysqli_real_escape_string($conn, $_POST["txtTP"]);
    $password = mysqli_real_escape_string($conn, $_POST["txtPass"]);
    $fName = mysqli_real_escape_string($conn, $_POST["txtFname"]);
    $lName = mysqli_real_escape_string($conn, $_POST["txtLname"]);
    $email = mysqli_real_escape_string($conn, $_POST["txtEmail"]);
    $phone = mysqli_real_escape_string($conn, $_POST["txtPhone"]);
    $license = mysqli_real_escape_string($conn, $_POST["txtLicense"]);
    $licenseExp = mysqli_real_escape_string($conn, $_POST["txtExpDate"]);
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
        echo "<script>alert('Error: You have already registered! Please proceed to login.'); window.location.href='../../login.php';</script>";
        exit();
    }

    // Check if license number already exists
    $checkLicenseSQL = "SELECT * FROM driver WHERE license_no = '$license'";
    $licenseResult = mysqli_query($conn, $checkLicenseSQL);
    if (mysqli_num_rows($licenseResult) > 0) {
        echo "<script>alert('Error: License number already exists.'); window.history.back();</script>";
        exit();
    }

    // Process vehicle inputs
    $vehicleType = mysqli_real_escape_string($conn, $_POST["vehicleType"]);
    $vehicleBrand = mysqli_real_escape_string($conn, $_POST["vehicleBrand"]);
    $vehicleModel = mysqli_real_escape_string($conn, $_POST["vehicleModel"]);
    $vehicleYear = intval($_POST["vehicleYear"]);
    $vehicleColor = mysqli_real_escape_string($conn, $_POST["vehicleColor"]);
    $seatNum = intval($_POST["seatNo"]);
    $plateNo = mysqli_real_escape_string($conn, $_POST["plateNo"]);

    // Check if plate number already exists
    $checkPlateSQL = "SELECT * FROM vehicle WHERE plate_no = '$plateNo'";
    $plateResult = mysqli_query($conn, $checkPlateSQL);
    if (mysqli_num_rows($plateResult) > 0) {
        echo "<script>alert('Error: Plate number already exists.'); window.history.back();</script>";
        exit();
    }

    // Set upload directories
    $targetDirFront = "../../image/licenses/front/";
    $targetDirBack = "../../image/licenses/back/";

    if (!is_dir($targetDirFront)) mkdir($targetDirFront, 0777, true);
    if (!is_dir($targetDirBack)) mkdir($targetDirBack, 0777, true);

    // Handling License Photos
    $allowedTypes = array("jpg", "jpeg", "png");

    $frontFileName = basename($_FILES["license_photo"]["name"]);
    $frontTargetFilePath = $targetDirFront . $frontFileName;
    $frontFileType = strtolower(pathinfo($frontTargetFilePath, PATHINFO_EXTENSION));

    $backFileName = basename($_FILES["license_photo_back"]["name"]);
    $backTargetFilePath = $targetDirBack . $backFileName;
    $backFileType = strtolower(pathinfo($backTargetFilePath, PATHINFO_EXTENSION));

    if (!in_array($frontFileType, $allowedTypes) || !in_array($backFileType, $allowedTypes)) {
        echo "<script>alert('Error: Invalid file type. Only JPG, JPEG, and PNG allowed.'); window.history.back();</script>";
        exit();
    }

    if (move_uploaded_file($_FILES["license_photo"]["tmp_name"], $frontTargetFilePath) &&
        move_uploaded_file($_FILES["license_photo_back"]["tmp_name"], $backTargetFilePath)) {

        // Insert into User Table
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertUserSQL = "INSERT INTO user (tpnumber, password, email, role) VALUES ('$tpNumber', '$hashedPassword', '$email', 'driver')";

        if (mysqli_query($conn, $insertUserSQL)) {
            $user_id = mysqli_insert_id($conn); 

            // Insert into Driver Table
            $insertDriverSQL = "INSERT INTO driver (firstname, lastname, phone_no, license_no, license_expiry_date, license_photo_front, license_photo_back, user_id, rating, status, registration_date) 
                                VALUES ('$fName', '$lName', '$phone', '$license', '$licenseExp', '$frontTargetFilePath', '$backTargetFilePath', '$user_id', '5', 'pending', '$date')";

            if (mysqli_query($conn, $insertDriverSQL)) {
                $driver_id = mysqli_insert_id($conn);

                // Insert into Vehicle Table
                $insertVehicleSQL = "INSERT INTO vehicle (type, year, brand, model, color, plate_no, seat_no, driver_id)
                                    VALUES ('$vehicleType', '$vehicleYear', '$vehicleBrand', '$vehicleModel', '$vehicleColor', '$plateNo', '$seatNum', '$driver_id')";

                if (mysqli_query($conn, $insertVehicleSQL)) {
                    echo "<script>alert('Driver Registered Successfully!'); window.location.href='../login/login.php';</script>";
                } else {
                    echo "<script>alert('Error inserting vehicle: " . mysqli_error($conn) . "'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Error inserting driver: " . mysqli_error($conn) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error inserting user: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error uploading license photos.'); window.history.back();</script>";
    }

    mysqli_close($conn);
}
?>
