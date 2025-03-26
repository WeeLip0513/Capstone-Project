<?php
error_reporting(0);
session_start();

// Database connection
include '../../dbconn.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $license_no = trim($_POST['license_no']);
    $license_exp = $_POST['license_exp'];
    $driver_id = $_SESSION['driverID']; // Assuming driver_id is stored in session

    // Directories for storing images
    $front_dir = '../../image/licenses/front/';
    $back_dir = '../../image/licenses/back/';

    // Ensure directories exist
    if (!file_exists($front_dir)) mkdir($front_dir, 0777, true);
    if (!file_exists($back_dir)) mkdir($back_dir, 0777, true);

    $front_photo = $_FILES['license_photo_front'];
    $back_photo = $_FILES['license_photo_back'];

    // Validate inputs
    if (empty($license_no) || empty($license_exp) || !$front_photo || !$back_photo) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    // Process front photo
    $front_ext = pathinfo($front_photo['name'], PATHINFO_EXTENSION);
    $front_filename = '../../image/licenses/front/' . uniqid('front_') . '.' . $front_ext;
    move_uploaded_file($front_photo['tmp_name'], $front_filename);

    // Process back photo
    $back_ext = pathinfo($back_photo['name'], PATHINFO_EXTENSION);
    $back_filename = '../../image/licenses/back/' . uniqid('back_') . '.' . $back_ext;
    move_uploaded_file($back_photo['tmp_name'], $back_filename);

    // Update database
    $stmt = $conn->prepare("UPDATE driver SET license_no = ?, license_expiry_date = ?, license_photo_front = ?, license_photo_back = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $license_no, $license_exp, $front_filename, $back_filename, $driver_id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'License updated successfully';
    } else {
        $response['message'] = 'Database update failed';
    }
    
    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
