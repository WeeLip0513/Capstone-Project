<?php
session_start();

$conn = require __DIR__ . '/../../dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpnumber = trim($_POST["tpnumber"]);
    $password = trim($_POST["password"]);

    if (!preg_match('/^TP\d{6}$/', $tpnumber)) {
        echo "<script>alert('Invalid TP Number format. Must be TP + 6 digits.'); window.history.back();</script>";
        exit();
    }

    $query = "SELECT id, tpnumber, password, role FROM user WHERE tpnumber = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tpnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            if ($user["role"] == "driver") {
                $driver_query = "SELECT id, status FROM driver WHERE user_id = ?";
                $driver_stmt = $conn->prepare($driver_query);
                $driver_stmt->bind_param("s", $user["id"]);
                $driver_stmt->execute();
                $driver_result = $driver_stmt->get_result();

                if ($driver_result->num_rows == 1) {
                    $driver = $driver_result->fetch_assoc();

                    if ($driver["status"] == "rejected") {
                        // Begin transaction to ensure atomic deletion
                        // Begin transaction to ensure atomic deletion
                        $conn->begin_transaction();
                        try {
                            // Delete vehicle reference based on driver id
                            $delete_vehicle = $conn->prepare("DELETE FROM vehicle WHERE driver_id = ?");
                            $delete_vehicle->bind_param("i", $driver["id"]);
                            if (!$delete_vehicle->execute()) {
                                $error_msg = "Delete vehicle error: " . $delete_vehicle->error;
                                error_log($error_msg);
                                throw new Exception($error_msg);
                            }

                            // Delete driver record from driver table using user_id
                            $delete_driver = $conn->prepare("DELETE FROM driver WHERE user_id = ?");
                            $delete_driver->bind_param("i", $user["id"]);
                            if (!$delete_driver->execute()) {
                                $error_msg = "Delete driver error: " . $delete_driver->error;
                                error_log($error_msg);
                                throw new Exception($error_msg);
                            }

                            // Delete user record from user table
                            $delete_user = $conn->prepare("DELETE FROM user WHERE id = ?");
                            $delete_user->bind_param("i", $user["id"]);
                            if (!$delete_user->execute()) {
                                $error_msg = "Delete user error: " . $delete_user->error;
                                error_log($error_msg);
                                throw new Exception($error_msg);
                            }

                            $conn->commit();

                            echo "<script>alert('Your driver application has been rejected. Please register again.');</script>";
                            $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Capstone-Project/carpool/";
                            header("Location: " . $base_url . "loginpage.php?action=signup");
                            exit();
                        } catch (Exception $e) {
                            $conn->rollback();
                            // For debugging only - show the actual error message in an alert
                            error_log("Deletion error: " . $e->getMessage());
                            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
                            exit();
                        }
                    }

                    if ($driver["status"] == "restricted") {
                        // Set session and allow login, but show alert message.
                        $_SESSION["tpnumber"] = $user["tpnumber"];
                        $_SESSION["role"] = $user["role"];
                        $_SESSION["id"] = $user["id"];

                        $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Capstone-Project/carpool/";
                        echo "<script>alert('Your driver application is restricted!'); window.location.href = '" . $base_url . "driver/driverPage.php';</script>";
                        exit();
                    }

                    if ($driver["status"] == "approved") {
                        // Allow login for approved drivers
                        $_SESSION["tpnumber"] = $user["tpnumber"];
                        $_SESSION["role"] = $user["role"];
                        $_SESSION["id"] = $user["id"];

                        $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Capstone-Project/carpool/";
                        header("Location: " . $base_url . "driver/driverPage.php");
                        exit();
                    }

                    // If driver status is pending or any other status not handled above:
                    echo "<script>alert('Your driver apllication is not approved yet. Please wait for approval.'); window.history.back();</script>";
                    exit();
                }
            }

            // For admin and passenger roles
            $_SESSION["tpnumber"] = $user["tpnumber"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["id"] = $user["id"];

            $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Capstone-Project/carpool/";
            if ($user["role"] == "admin") {
                header("Location: " . $base_url . "admin/adminDashboard.php");
            } elseif ($user["role"] == "passenger") {
                header("Location: " . $base_url . "passenger/passengerPage.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found. Please check your TP Number.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>