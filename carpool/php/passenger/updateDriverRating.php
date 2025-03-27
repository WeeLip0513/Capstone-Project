<?php
session_start();
include("../../dbconn.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['id'])) {
    $response['message'] = 'User not authenticated';
    echo json_encode($response);
    exit;
}

$driver_id = isset($_POST['driver_id']) ? intval($_POST['driver_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

if ($driver_id <= 0 || $rating < 1 || $rating > 5) {
    $response['message'] = 'Invalid driver or rating';
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("SELECT rating, rating_count FROM driver WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $response['message'] = 'Driver not found';
    echo json_encode($response);
    exit;
}

$row = $result->fetch_assoc();
$current_avg = floatval($row['rating_avg']);
$current_count = intval($row['rating_count']);

$new_count = $current_count + 1;
$new_avg = (($current_avg * $current_count) + $rating) / $new_count;
$update = $conn->prepare("UPDATE driver SET rating = ?, rating_count = ? WHERE id = ?");
$update->bind_param("dii", $new_avg, $new_count, $driver_id);
if ($update->execute()) {
    $response['success'] = true;
    $response['message'] = 'Driver rating updated successfully';
} else {
    $response['message'] = 'Failed to update driver rating: ' . $conn->error;
}

echo json_encode($response);
exit;
?>
