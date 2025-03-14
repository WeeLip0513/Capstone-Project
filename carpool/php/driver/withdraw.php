<?php
session_start();
include("../../dbconn.php");

// Read raw POST data
$json = file_get_contents("php://input");

// Log received JSON for debugging
file_put_contents("log.txt", $json . PHP_EOL, FILE_APPEND);

// Decode JSON
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON data", "received" => $jsonData]);
    exit();
}

// Ensure the request is a POST request with JSON data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the raw POST data
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    // Check if JSON decoding was successful
    if (!$data) {
        echo json_encode(["success" => false, "message" => "Invalid JSON data"]);
        exit();
    }

    // Retrieve necessary data from the JSON request
    $bank = trim($data["bank"] ?? "");
    $accountName = trim($data["accountName"] ?? "");
    $accountNumber = trim($data["accountNumber"] ?? "");
    $withdrawAmount = floatval($data["withdrawAmount"] ?? 0);
    $month = trim($data["month"] ?? "");
    
    // Check if driver is logged in
    if (!isset($_SESSION["driverID"])) {
        echo json_encode(["success" => false, "message" => "Driver not authenticated"]);
        exit();
    }

    $driverID = $_SESSION["driverID"];

    // Validate required fields
    if (empty($bank) || empty($accountName) || empty($accountNumber) || empty($month) || $withdrawAmount <= 0) {
        echo json_encode(["success" => false, "message" => "Missing or invalid input fields"]);
        exit();
    }

    // Start database transaction
    $conn->begin_transaction();

    try {
        // Update driving_transaction records for the given month and driverID
        $updateQuery = "UPDATE driving_transaction 
                        SET status = 'requested' 
                        WHERE driver_id = ? AND DATE_FORMAT(transaction_date, '%Y-%m') = ? AND status = 'active'";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $driverID, $month);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $insertQuery = "INSERT INTO withdraw_request (driver_id, bank, name, account_number, amount, status, date) 
                            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";

            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssds", $driverID, $bank, $accountName, $accountNumber, $withdrawAmount);
            $stmt->execute();

            // Commit the transaction
            $conn->commit();

            echo json_encode(["success" => true, "message" => "Withdrawal request submitted successfully"]);
        } else {
            throw new Exception("No transactions found for the given month.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error processing withdrawal: " . $e->getMessage()]);
    }

    // Close the statement
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
