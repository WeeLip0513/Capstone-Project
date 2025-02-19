<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../dbconn.php"); // Ensure database connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpNumber = $_POST["txtTP"];
    $password = $_POST["txtPass"];
    $fName = $_POST["txtFname"];
    $lName = $_POST["txtLname"];
    $email = $_POST["txtEmail"];
    $phone = $_POST["txtPhone"];
    $license = $_POST["txtLicense"];
    $licenseExp = $_POST["txtExpDate"];
    $date = date("Y-m-d");

    $checkApuSQL = "SELECT * FROM apu WHERE tpnumber = '$tpNumber'";
    $apuResult = mysqli_query($conn, $checkApuSQL);

    if (mysqli_num_rows($apuResult) == 0) {
        echo "<script>alert('Error: TP Number does not exist in APU records!'); window.history.back();</script>";
        exit();
    }

    // Set upload folder
    $targetDirFront = "../../image/licenses/front";
    $targetDirBack = "../../image/licenses/back";

    // Ensure directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Handling License Front Photo
    $frontFileName = basename($_FILES["license_photo"]["name"]);
    $frontTargetFilePath = $targetDirFront . $frontFileName;
    $frontFileType = strtolower(pathinfo($frontTargetFilePath, PATHINFO_EXTENSION));

    // Handling License Back Photo
    $backFileName = basename($_FILES["license_photo_back"]["name"]);
    $backTargetFilePath = $targetDirBack . $backFileName;
    $backFileType = strtolower(pathinfo($backTargetFilePath, PATHINFO_EXTENSION));

    $allowedTypes = array("jpg", "jpeg", "png");

    if (in_array($frontFileType, $allowedTypes) && in_array($backFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["license_photo"]["tmp_name"], $frontTargetFilePath) &&
            move_uploaded_file($_FILES["license_photo_back"]["tmp_name"], $backTargetFilePath)) {

            // Insert into User Table
            $insertUserSQL = "INSERT INTO user (tpnumber, password, role) VALUES ('$tpNumber', '$password', 'driver')";
            if (mysqli_query($conn, $insertUserSQL)) {
                $user_id = mysqli_insert_id($conn); // Get the newly created user ID

                // Insert into Driver Table
                $insertDriverSQL = "INSERT INTO driver (email, firstname, lastname, phone_no, license_no, license_expiry_date, license_photo_front, license_photo_back, user_id, rating, status, registration_date) 
                                    VALUES ('$email', '$fName', '$lName', '$phone', '$license', '$licenseExp', '$frontTargetFilePath', '$backTargetFilePath', '$user_id', '5', 'pending', '$date')";

                if (mysqli_query($conn, $insertDriverSQL)) {
                    $driver_id = mysqli_insert_id($conn);

                    $vehicleType = $_POST["vehicleType"];
                    $vehicleBrand = $_POST["vehicleBrand"];
                    $vehicleModel = $_POST["vehicleModel"];
                    $vehicleYear = $_POST["vehicleYear"];
                    $vehicleColor = $_POST["vehicleColor"];
                    $seatNum = $_POST["seatNo"];
                    $plateNo = $_POST["plateNo"];

                    // Insert into Vehicle Table
                    $insertVehicleSQL = "INSERT INTO vehicle (type, year, brand, model, color, plate_no, seat_no, driver_id)
                                         VALUES ('$vehicleType', '$vehicleYear', '$vehicleBrand', '$vehicleModel', '$vehicleColor', '$plateNo', '$seatNum', '$driver_id')";

                    if (mysqli_query($conn, $insertVehicleSQL)) {
                        echo "<script>alert('Driver Registered Successfully!'); window.location.href='../../successPage.php';</script>";
                    } else {
                        echo "Error inserting vehicle: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting driver: " . mysqli_error($conn);
                }
            } else {
                echo "Error inserting user: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading license photos.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, and PNG allowed.";
    }

    mysqli_close($conn);
}
?>
