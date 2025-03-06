<?php
$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$conn = require $_SERVER['DOCUMENT_ROOT'] . '/Capstone-Project/carpool/dbconn.php';

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo "<script>alert('token not found.'); window.location.href = '/Capstone-Project/carpool/loginpage.php';</script>";
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo "<script>alert('token has expired.'); window.location.href = '/Capstone-Project/carpool/loginpage.php';</script>";
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

// echo "<script>alert('Password updated. You can now login.'); window.history.back();</script>";
echo "<script>
        alert('Password updated successfully!');
        const timerElement = document.createElement('div');
        timerElement.style.position = 'fixed';
        timerElement.style.top = '20px';
        timerElement.style.right = '20px';
        timerElement.style.padding = '10px';
        timerElement.style.background = '#d4edda';
        timerElement.style.border = '1px solid #c3e6cb';
        timerElement.style.borderRadius = '5px';
        document.body.appendChild(timerElement);

        // Start countdown
        let seconds = 10;
        timerElement.textContent = `Redirecting to login in \${seconds} seconds...`;

        const interval = setInterval(() => {
            seconds--;
            timerElement.textContent = `Redirecting to login in \${seconds} seconds...`;
            
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = '/Capstone-Project/carpool/loginpage.php';
            }
        }, 1000);
      </script>";
?>