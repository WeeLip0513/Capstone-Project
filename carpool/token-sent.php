<?php

date_default_timezone_set("Asia/Kuala_Lumpur");

$conn = require __DIR__ . "/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30); 

    $stmt = $conn->prepare("UPDATE user SET 
        reset_token_hash = ?,
        reset_token_expires_at = ?
        WHERE email = ?");

    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    if ($stmt->execute() && $conn->affected_rows > 0) {
        $mail = require __DIR__ . "/php/login/mailer.php";
        $mail->setFrom("noreply@example.com", "noreply@gmail.com"); // noreply sender
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        // $mail->Body = "Click to reset: http://localhost/Capstone-Project/carpool/reset-password.php?token=$token";
        $mail->Body = <<<END

        Click <a href="http://localhost/Capstone-Project/reset-password.php?token=$token">here</a>
        to reset your password

        END;

        $mail->send();
    }

    // Generic response
    header("Location: /password-reset-sent");
    exit();
}



// *Enable error reporting*
// error_reporting(E_ALL);
// ini_set('display_errors', 1);  

// // Add back POST method check
// if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//     die("Invalid request method");
// }

// // Validate email input
// $email = $_POST['email'] ?? '';
// if (empty($email)) {
//     die("Email is required");
// }

// // Check if email exists in database FIRST
// $check_sql = "SELECT id FROM user WHERE email = ?";
// $check_stmt = $conn->prepare($check_sql);
// $check_stmt->bind_param("s", $email);
// $check_stmt->execute();
// $check_result = $check_stmt->get_result();

// if ($check_result->num_rows === 0) {
//     die("Email not found in our system");
// }

// // Generate token
// $token = bin2hex(random_bytes(16));
// $token_hash = hash("sha256", $token);
// $expiry = date("Y-m-d H:i:s", time() + 1800);  // 30 minutes

// // 5. Update statement
// $update_sql = "UPDATE user 
//                SET reset_token_hash = ?,
//                    reset_token_expires_at = ?
//                WHERE email = ?";
// $update_stmt = $conn->prepare($update_sql);
// $update_stmt->bind_param("sss", $token_hash, $expiry, $email);

// if (!$update_stmt->execute()) {
//     die("Database error: " . $update_stmt->error);
// }

// // Check affected rows after successful execution
// if ($conn->affected_rows > 0) {
//     $mail = require __DIR__ . "/mailer.php";

//     // Fix email addresses
//     $mail->setFrom("your-real-email@gmail.com");  // Must match SMTP credentials
//     $mail->addAddress($email);  // Use variable, not string 'email'

//     $mail->Subject = "Password Reset";
//     $mail->Body = "Reset link: http://localhost/Capstone-Project/carpool/reset-password.php?token=$token";

//     try {
//         $mail->send();
//         echo "Password reset link sent to your email!";
//     } catch (Exception $e) {
//         echo "Error: Failed to send email. Mailer error: " . $mail->ErrorInfo;
//     }
// } else {
//     echo "Error: Failed to update record. Email might not exist or token already generated.";
// }
?>