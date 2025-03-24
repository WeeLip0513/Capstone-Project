<?php
include("../../dbconn.php");
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get raw JSON input
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!isset($_SESSION["driverID"])) {
        echo json_encode(["success" => false, "message" => "Driver not authenticated."]);
        exit;
    }

    $driver_id = $_SESSION["driverID"];
    $month = strtolower($data["month"]); // Convert to lowercase for consistency
    $bank = $data["bank"];
    $account_name = $data["accountName"];
    $account_number = $data["accountNumber"];
    $withdraw_amount = $data["withdrawAmount"];

    // Validate input
    if (empty($month) || empty($bank) || empty($account_name) || empty($account_number) || empty($withdraw_amount)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // Map month names to numerical format
    $monthMap = [
        "jan" => "01", "feb" => "02", "mar" => "03", "apr" => "04", "may" => "05", "jun" => "06",
        "jul" => "07", "aug" => "08", "sep" => "09", "oct" => "10", "nov" => "11", "dec" => "12"
    ];

    // Convert month abbreviation to numeric format
    if (!isset($monthMap[$month])) {
        echo json_encode(["success" => false, "message" => "Invalid month format."]);
        exit;
    }
    $numericMonth = $monthMap[$month];

    // Update driver_transaction status to 'withdrawn'
    $updateSql = "UPDATE driver_transaction 
                  SET status = 'withdrawn' 
                  WHERE driver_id = ? 
                  AND DATE_FORMAT(transaction_date, '%m') = ? 
                  AND status = 'active'";

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("is", $driver_id, $numericMonth);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Withdrawal request processed successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update withdrawal status."]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
