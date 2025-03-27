<?php
session_start();
include("headerHomepage.php");

$conn = mysqli_connect("localhost", "root", "", "carpool");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   

    $tpnumber = mysqli_real_escape_string($conn, $_POST['tp_number']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $checkUserQuery = "SELECT * FROM user WHERE tpnumber = '$tpnumber'";
    $result = mysqli_query($conn, $checkUserQuery);
    echo "<script>alert('TP Number: " . $tpnumber . $checkUserQuery. "');</script>";

    // Debugging step: check for SQL errors first
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // tpnumber matches, insert feedback
        $insertFeedbackQuery = "INSERT INTO feedback (tp_number, feedback_message) VALUES ('$tpnumber', '$feedback')";

        if (mysqli_query($conn, $insertFeedbackQuery)) {
            echo "<script>alert('Feedback submitted successfully!'); window.location.href='support.php';</script>";
        } else {
            die("Error inserting feedback: " . mysqli_error($conn));
        }
    }else {
            // tpnumber doesn't match, redirect to login
           
            header("Location: loginpage.php");
            exit;
        }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/feedback.css">
    <script src="scripts.js" defer></script>

</head>
<body>
    <div class="container">
        <!-- Page Description Section -->
        <section class="page-header">
            <h2>Drive Together, Thrive Together</h2>
            <p class="subtext">Share the Journey, Shape the Future.</p>
        </section>
        <section class="page-description">
                <!-- Paragraph 1 -->
                <p class="first-page-description">
                <strong class="small-header">Welcome to the APU Carpool Support Page</strong>
                We're here to assist you with any questions or issues while using our carpooling platform. 
                Our support team is ready to help with booking rides,<br> managing profiles, and ensuring your safety during carpooling.
                </p>
                <p class="page-description">
                <strong class="small-header">We Value Your Feedback</strong>
                We value your feedback as it helps us enhance the platform for the Asia Pacific University community. 
                Whether you have suggestions for new features,<br> need help with an issue, or want to share your thoughts, 
                this is the place to do it!
                </p>
                <p class="page-description">
                <strong class="small-header">Explore Our FAQ</strong>
                Check our FAQ for quick answers or use the feedback form to contact us. We're committed to making your carpooling 
                experience smooth, safe, and convenient for everyone in the APU community.
                </p>
                <p class="page-description">
                <strong class="small-header">Thank You for Choosing APU Carpool</strong>
                Together, we can make campus transportation more convenient, sustainable, and community-focused!
                </p>
        </section>
        <section class="feedback">
            <div class="feedback-box">
                <!-- Left side: Feedback Form -->
                <div class="form-container">
                <form action="support.php" method="POST">
                    <h2>Feedback</h2>
                    <p class="subtext">We’d love to hear your thoughts! Let us know how we can improve your experience.</p>

                    <!-- Container for all input fields -->
                    <div class="input-container">

                        <!-- TP Number -->
                        <div class="form-group">
                        <label for="tp_number">TP Number:</label>
                        <input 
                            type="text" 
                            id="tp_number" 
                            name="tp_number" 
                            placeholder="TP123456" 
                            required 
                            pattern="^TP\d{6}$"
                        >
                        </div>

                        <!-- Feedback Message -->
                        <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea 
                            id="feedback" 
                            name="feedback" 
                            placeholder="Write your feedback here......." 
                            required
                        ></textarea>
                        </div>

                    </div> <!-- End of .input-container -->

                    <!-- Container for the submit button -->
                    <div class="button-container">
                        <button type="submit" class="submit-button">Submit Feedback</button>
                    </div>
                    </form>
                </div>
            </div>
        </section>
         <!-- FAQ Section -->
        <section id="faq-section">
        <div class="faq-container">
            <h1>Frequently Asked Questions</h1>
            
            <!-- FAQ #1 -->
            <details>
            <summary>
                What is the APU Carpool System?
                <!-- Inline SVG arrow -->
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>The APU Carpool System connects students, faculty, and staff to share rides to and from campus, reducing travel costs and environmental impact.</p>
            </details>

            <!-- FAQ #2 -->
            <details>
            <summary>
                How does APU Carpool work?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>Users register with their APU credentials, indicate whether they can offer a ride or need one, and then match based on routes and schedules.</p>
            </details>

            <!-- FAQ #3 -->
            <details>
            <summary>
                Who can join the APU Carpool System?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>All current APU students, faculty, and staff with valid APU ID are eligible to use the carpool system.</p>
            </details>

            <!-- FAQ #4 -->
            <details>
            <summary>
                Is there a fee to use the system?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>The platform is free to use. Any cost-sharing for fuel or parking is arranged directly between drivers and riders.</p>
            </details>

            <!-- FAQ #5 -->
            <details>
            <summary>
                How do I become a driver?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>Select the "Driver" option during registration, provide your vehicle details, and post your available seats along with your travel schedule.</p>
            </details>

            <!-- FAQ #6 -->
            <details>
            <summary>
                Can I schedule rides for specific times?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>Yes, drivers post their departure times and routes, and riders can request a trip that fits their schedule.</p>
            </details>

            <!-- FAQ #7 -->
            <details>
            <summary>
                How is safety ensured in the carpool?
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
                </svg>
            </summary>
            <p>All users are verified with APU credentials, and feedback/rating systems help monitor user reliability. Follow campus safety guidelines at all times.</p>
            </details>
        </div>
        </section>
    </div>
    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(e){
            e.preventDefault(); // prevents page reload

            let formData = new FormData(this);

            fetch('support.php', {  // adjust the path to your PHP script
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);  // Display the alert message from PHP
                document.getElementById('feedbackForm').reset(); // Reset form after submission (optional)
            })
            .catch(error => {
                alert('An error occurred: ' + error);
            });
        });
</script>
</body>
</html>
