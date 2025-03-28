<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $tp_number = $_POST['tp_number'] ?? '';
    $feedback_message = $_POST['feedback_message'] ?? '';

    if (empty($tp_number) || empty($feedback_message)) {
        echo json_encode([
            "success" => false,
            "message" => "Please fill in all fields.",
            "tp" => $tp_number,
            "feedback" => $feedback_message
        ]);
        exit;
    }

    // Connect and insert into DB
    $conn = new mysqli("localhost", "root", "", "carpool");
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Connection failed."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO feedback (tp_number, feedback_message) VALUES (?, ?)");
    $stmt->bind_param("ss", $tp_number, $feedback_message);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Feedback submitted successfully!",
            "tp" => $tp_number,
            "feedback" => $feedback_message
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error."]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
include("headerHomepage.php");
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
                <p class="page-description-one">
                <strong class="small-header">Welcome to the APU Carpool Support Page</strong>
                We're here to assist you with any questions or issues while using our carpooling platform. 
                Our support team is ready to help with booking rides,<br> managing profiles, and ensuring your safety during carpooling.
                </p>
                <p class="page-description-one">
                <strong class="small-header">We Value Your Feedback</strong>
                We value your feedback as it helps us enhance the platform for the Asia Pacific University community. 
                Whether you have suggestions for new features,<br> need help with an issue, or want to share your thoughts, 
                this is the place to do it!
                </p>
                <p class="page-description-one">
                <strong class="small-header">Explore Our FAQ</strong>
                Check our FAQ for quick answers or use the feedback form to contact us. We're committed to making your carpooling 
                experience smooth, safe, and convenient for everyone in the APU community.
                </p>
                <p class="page-description-one">
                <strong class="small-header">Thank You for Choosing APU Carpool</strong>
                Together, we can make campus transportation more convenient, sustainable, and community-focused!
                </p>
        </section>
        <section id="feedback-section" class="feedback-section">
    <div class="feedback-container">
        <form id="feedbackForm" action="support.php" method="POST" class="feedback-form">
            <h3>Feedback</h3>
            <p class="feedback-subtext">We’d love to hear your thoughts. Your feedback helps us improve the carpool experience for everyone!</p>
            
            <div class="form-group">
                <label for="tp_number">TP Number</label>
                <input 
                    type="text" 
                    id="tp_number" 
                    name="tp_number" 
                    placeholder="Enter your TP number (e.g., TP123456)" 
                    required 
                    pattern="^TP\d{6}$"
                    title="TP Number must start with 'TP' followed by 6 digits"
                >
                <small>Your APU TP number is required to submit feedback</small>
            </div>
            
            <div class="form-group">
                <label for="feedback">Your Feedback</label>
                <div class="feedback-input-wrapper">
                    <textarea 
                    id="feedback" 
                    name="feedback_message" 
                    placeholder="Tell us what you think about our carpooling service..." 
                    maxlength="100"
                    required
                    ></textarea>
                    <div id="char-count">0/100</div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-submit">
                Submit Feedback <span class="btn-icon">→</span>
            </button>
        </form>
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
        //submit form
        document.getElementById('feedbackForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('support.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
            alert(data.message); 
            this.reset();
            } else {
            alert(data.message); 
            }
        })

        .catch(err => {
            alert("Error submitting feedback.");
            console.error(err);
        });
        }); 
        //word count
        const feedbackInput = document.getElementById("feedback");
        const charCount = document.getElementById("char-count");

        feedbackInput.addEventListener("input", () => {
            const currentLength = feedbackInput.value.length;
            charCount.textContent = `${currentLength}/100`;
        });

        //faq section
        const faqs = document.querySelectorAll("details");

        faqs.forEach((faq) => {
            faq.addEventListener("toggle", () => {
            if (faq.open) {
                faqs.forEach((otherFaq) => {
                if (otherFaq !== faq) {
                    otherFaq.removeAttribute("open");
                }
                });
            }
            });
        });
    </script>
</body>
</html>
<?php include('footer.php'); ?>
