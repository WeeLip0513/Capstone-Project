<?php
include("../../dbconn.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json"); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data) {
        echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
        exit;
    }

    if (!isset($_SESSION["driverID"])) {
        echo json_encode(["success" => false, "message" => "Driver not authenticated"]);
        exit;
    }

    $driver_id = $_SESSION["driverID"];
    $month = strtolower(trim($data["month"])); // Convert to lowercase & trim whitespace
    $bank = trim($data["bank"]);
    $account_name = trim($data["accountName"]);
    $account_number = trim($data["accountNumber"]);
    $withdraw_amount = floatval($data["withdrawAmount"]);

    // Validate input
    if (empty($bank) || empty($account_name) || empty($account_number) || $withdraw_amount <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid withdrawal details"]);
        exit;
    }

    // Month conversion
    $monthMap = [
        "jan" => "01", "feb" => "02", "mar" => "03", "apr" => "04", "may" => "05", "jun" => "06",
        "jul" => "07", "aug" => "08", "sep" => "09", "oct" => "10", "nov" => "11", "dec" => "12"
    ];

    if (!isset($monthMap[$month])) {
        echo json_encode(["success" => false, "message" => "Invalid month format"]);
        exit;
    }

    $numericMonth = $monthMap[$month];

    // Update driver_transaction status
    $updateSql = "UPDATE driver_transaction 
                  SET status = 'withdrawn' 
                  WHERE driver_id = ? 
                  AND DATE_FORMAT(ride_completion_date, '%m') = ? 
                  AND status = 'completed'";

    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "SQL Error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("is", $driver_id, $numericMonth);
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Failed to update withdrawal status"]);
        exit;
    }
    $stmt->close();

    // Insert withdrawal record
    $insertSql = "INSERT INTO withdraw_record (driver_id, amount, bank, name, account_number, date) 
                  VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($insertSql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "SQL Error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("idsss", $driver_id, $withdraw_amount, $bank, $account_name, $account_number);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Withdrawal request processed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to record withdrawal"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
