<?php
session_start();
include("dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpnumber = trim($_POST["tpnumber"]);
    $password = trim($_POST["password"]);

    // Validate TP Number Format (TP + 6 digits)
    if (!preg_match('/^TP\d{6}$/', $tpnumber)) {
        echo "<script>alert('Invalid TP Number format. Must be TP + 6 digits.'); window.history.back();</script>";
        exit();
    }

    // Check user in database
    $query = "SELECT * FROM users WHERE tpnumber = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tpnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["tpnumber"] = $user["tpnumber"];
            $_SESSION["role"] = $user["role"];

            // Redirect based on role
            if ($user["role"] == "admin") {
                header("Location: admin_dashboard.php");
            } elseif ($user["role"] == "driver") {
                header("Location: driver_dashboard.php");
            } else {
                header("Location: passenger_dashboard.php");
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











<!-- session_start();
include("dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $tpnumber = trim($_POST['tpnumber']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
            die("Invalid name. Only letters and spaces allowed.");
        }
        if (!preg_match("/^TP\d{6}$/", $tpnumber)) {
            die("Invalid TP number format.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            die("Password must be at least 8 characters with uppercase, lowercase, number, and special character.");
        }

 
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $checkUser = "SELECT * FROM users WHERE tpnumber = ?";
        $stmt = $conn->prepare($checkUser);
        $stmt->bind_param("s", $tpnumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            die("TP Number already registered.");
        }

    
        $query = "INSERT INTO users (name, tpnumber, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $tpnumber, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    if (isset($_POST['login'])) {
        $tpnumber = trim($_POST['tpnumber']);
        $password = trim($_POST['password']);

        $query = "SELECT * FROM users WHERE tpnumber = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $tpnumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['tpnumber'] = $row['tpnumber'];
                $_SESSION['name'] = $row['name'];
                header("Location: homepage.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "TP Number not registered.";
        }

        $stmt->close();
    }
}

$conn->close(); -->


