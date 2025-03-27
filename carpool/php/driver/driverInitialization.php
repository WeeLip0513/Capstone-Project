<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../../dbconn.php");

$_SESSION['id'] = 11;
$userID = $_SESSION['id'] ?? null;

if (!$userID) {
    die("Error: User ID not found in session.");
}

// Get the driver's ID and current cancel count
$query = "SELECT id, cancel_count, status, penalty_end_date FROM driver WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();
$stmt->close();

if (!$driver) {
    die("Error: Driver record not found.");
}

// Store driver ID in session
$_SESSION['driverID'] = $driver['id'];
$driverID = $_SESSION['driverID'];
$cancelCount = $driver['cancel_count'];
$penaltyEndDate = $driver['penalty_end_date'];
$driverStatus = $driver['status'];

// Get current date and time
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

// Fetch all today's rides for the driver
$query = "SELECT id, time FROM ride WHERE driver_id = ? AND date = ? AND status = 'upcoming'";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $driverID, $currentDate);
$stmt->execute();
$result = $stmt->get_result();

$ridesToCancel = [];

while ($ride = $result->fetch_assoc()) {
    $rideTime = strtotime($ride['time']);
    $timeDifference = $rideTime - strtotime($currentTime);

    // If ride time is 30 minutes after the current time
    if ($timeDifference <= 1800 && $timeDifference > 0) { 
        $ridesToCancel[] = $ride['id'];
    }
}

$stmt->close();

if (!empty($ridesToCancel)) {
    // Convert array to comma-separated string for SQL
    $rideIDs = implode(",", $ridesToCancel);

    // Cancel the rides
    $updateRidesQuery = "UPDATE ride SET status = 'canceled' WHERE id IN ($rideIDs)";
    $conn->query($updateRidesQuery);

    // Increment cancel_count for the driver
    $newCancelCount = $cancelCount + 1;

    if ($cancelCount >= 3) {
        // If cancel_count is already 3+, just update the count
        $updateDriverQuery = "UPDATE driver SET cancel_count = ? WHERE id = ?";
        $stmt = $conn->prepare($updateDriverQuery);
        $stmt->bind_param("ii", $newCancelCount, $driverID);
    } else {
        // If cancel_count is going from <3 to 3, set penalty_end_date
        if ($newCancelCount >= 3) {
            $penaltyEndDate = date("Y-m-d", strtotime("+1 month"));
            $restrictDriverQuery = "UPDATE driver SET cancel_count = ?, status = 'restricted', penalty_end_date = ? WHERE id = ?";
            $stmt = $conn->prepare($restrictDriverQuery);
            $stmt->bind_param("isi", $newCancelCount, $penaltyEndDate, $driverID);
        } else {
            // Just increment cancel_count normally
            $updateDriverQuery = "UPDATE driver SET cancel_count = ? WHERE id = ?";
            $stmt = $conn->prepare($updateDriverQuery);
            $stmt->bind_param("ii", $newCancelCount, $driverID);
        }
    }

    $stmt->execute();
    $stmt->close();

    // echo "✅ Auto-canceled " . count($ridesToCancel) . " rides.";
} else {
    echo "✅ No rides needed cancellation.";
}

$conn->close();
?>
