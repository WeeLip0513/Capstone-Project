<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../dbconn.php"); // Ensure this file correctly connects to your database

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

  // File Upload Handling
  $targetDir = "../../image/licences/"; // Set upload folder
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true); // Create folder if not exists
  }

  $fileName = basename($_FILES["license_photo"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
  $allowedTypes = array("jpg", "jpeg", "png");

  if (in_array($fileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES["license_photo"]["tmp_name"], $targetFilePath)) {
        // Insert User
        $insertUserSQL = "INSERT INTO user (tpnumber, password, role) VALUES ('$tpNumber', '$password', 'driver')";
        if (mysqli_query($conn, $insertUserSQL)) {
            $user_id = mysqli_insert_id($conn); // Get the newly created user ID
            
            // Insert Driver Data
            $insertDriverSQL = "INSERT INTO driver (email,firstname, lastname, phone_no, license_no, license_expiry_date, license_photo, user_id, rating, pending, registration_date) 
                                VALUES ('$email','$fName', '$lName', '$phone', '$license', '$licenseExp', '$targetFilePath', '$user_id', '5', 'pending', '$date')";
            
            if (mysqli_query($conn, $insertDriverSQL)) {
                echo "<script>alert('Driver Registered Successfully!'); window.location.href='successPage.php';</script>";
            } else {
                echo "Error inserting driver: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting user: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading license photo.";
    }
} else {
    echo "Invalid file type. Only JPG, JPEG, and PNG allowed.";
}

mysqli_close($conn);
}

?>