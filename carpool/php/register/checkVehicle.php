<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plateNo = isset($_POST["plateNo"]) ? mysqli_real_escape_string($conn, $_POST["plateNo"]) : "";

    if (empty($plateNo)) {
        echo json_encode(["error" => "Missing plate number"]);
        exit;
    }

    $query = "SELECT * FROM vehicle WHERE plate_no = '$plateNo'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(["error" => mysqli_error($conn)]);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["exists" => true]);
    } else {
        echo json_encode(["exists" => false]);
    }
}

mysqli_close($conn);
?>
