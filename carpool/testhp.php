<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="feedback-improved.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    /* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f9f9f9;
}

.container {
    scroll-snap-type: y mandatory;
    overflow-y: scroll;
    height: 100vh;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.container::-webkit-scrollbar {
    display: none;
}

section {
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    scroll-snap-align: start;
    padding: 40px 20px;
}

/* Page Header Styles */
.page-header {
    background-color: #000;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.page-header h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 80px;
    font-weight: 700;
    margin-bottom: 20px;
    opacity: 0;
    animation: fadeInUp 1s forwards 0.3s;
}

.page-header .subtext {
    font-size: 26px;
    color: #a0a0a0;
    opacity: 0;
    animation: fadeInUp 1s forwards 0.6s;
}

/* Page Description Styles */
.page-description {
    background-color: #000;
    color: #fff;
    padding: 60px 20px;
    gap: 30px;
    align-items: flex-start;
}

.description-item {
    width: 100%;
    max-width: 1000px;
    background: rgba(33, 33, 33, 0.7);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    transform: translateY(30px);
    opacity: 0;
    animation: fadeInUp 0.8s forwards;
    transition: all 0.3s ease;
}

.description-item:nth-child(1) { animation-delay: 0.1s; }
.description-item:nth-child(2) { animation-delay: 0.3s; }
.description-item:nth-child(3) { animation-delay: 0.5s; }
.description-item:nth-child(4) { animation-delay: 0.7s; }

.description-item:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.small-header {
    display: block;
    font-size: 35px;
    color: #2b63ff;
    margin-bottom: 15px;
    font-family: 'Kanit', sans-serif;
}

/* Improved Feedback Section Styles */
.feedback-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
    padding: 80px 20px;
}

.section-header {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 60px;
    opacity: 0;
    animation: fadeInUp 0.8s forwards;
}

.section-title {
    font-family: 'Kanit', sans-serif;
    font-size: 48px;
    font-weight: 700;
    color: #333;
    margin-bottom: 16px;
}

.section-subtitle {
    font-size: 18px;
    color: #666;
}

.feedback-container {
    display: flex;
    flex-direction: column;
    max-width: 1200px;
    margin: 0 auto;
    gap: 40px;
}

@media (min-width: 768px) {
    .feedback-container {
        flex-direction: row;
        align-items: center;
    }
}

/* Feedback Form Styles */
.feedback-form-container {
    flex: 1;
    opacity: 0;
    animation: fadeInLeft 0.8s forwards 0.3s;
}

.feedback-card {
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 40px;
    transition: all 0.4s ease;
    transform: translateY(0);
}

.feedback-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.feedback-title {
    font-family: 'Kanit', sans-serif;
    font-size: 42px;
    font-weight: 700;
    color: #333;
    margin-bottom: 30px;
    text-align: center;
}

.feedback-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-group label {
    font-weight: 500;
    font-size: 16px;
    color: #555;
}

.form-group input,
.form-group textarea {
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #2b63ff;
    box-shadow: 0 0 0 3px rgba(43, 99, 255, 0.2);
    outline: none;
}

.form-group input:hover,
.form-group textarea:hover {
    border-color: #2b63ff;
}

.form-group textarea {
    min-height: 150px;
    resize: vertical;
}

.button-container {
    margin-top: 20px;
    text-align: center;
}

.submit-button {
    background-color: #2b63ff;
    color: white;
    border: none;
    border-radius: 50px;
    padding: 16px 40px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(43, 99, 255, 0.3);
}

.submit-button:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(43, 99, 255, 0.4);
    background-color: #1a52e5;
}

.submit-button:active {
    transform: scale(0.98);
}

.submit-button.submitting {
    background-color: #1a52e5;
    opacity: 0.8;
    pointer-events: none;
}

/* Image Container Styles */
.image-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    animation: fadeInRight 0.8s forwards 0.5s;
}

.image-wrapper {
    width: 100%;
    max-width: 500px;
    aspect-ratio: 1;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transition: all 0.5s ease;
}

.image-wrapper:hover {
    transform: scale(1.05) rotate(2deg);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.image-wrapper:hover img {
    transform: scale(1.1);
}

/* FAQ Section Styles */
.faq-section {
    background-color: #f0f4f8;
    padding: 80px 20px;
}

.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    background-color: #fff;
    border-radius: 12px;
    margin-bottom: 16px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    opacity: 0;
    animation: fadeInUp 0.6s forwards;
    animation-delay: calc(0.1s * var(--i, 1));
}

.faq-item:nth-child(1) { --i: 1; }
.faq-item:nth-child(2) { --i: 2; }
.faq-item:nth-child(3) { --i: 3; }
.faq-item:nth-child(4) { --i: 4; }
.faq-item:nth-child(5) { --i: 5; }
.faq-item:nth-child(6) { --i: 6; }

.faq-question {
    padding: 20px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
}

.faq-question:hover {
    background-color: #f8f9fa;
}

.faq-question h3 {
    font-size: 18px;
    font-weight: 500;
    color: #333;
    margin: 0;
}

.faq-icon {
    position: relative;
    width: 20px;
    height: 20px;
}

.faq-icon:before,
.faq-icon:after {
    content: '';
    position: absolute;
    background-color: #2b63ff;
    transition: all 0.3s ease;
}

.faq-icon:before {
    top: 9px;
    left: 0;
    width: 100%;
    height: 2px;
}

.faq-icon:after {
    top: 0;
    left: 9px;
    width: 2px;
    height: 100%;
}

.faq-item.active .faq-icon:after {
    transform: rotate(90deg);
    opacity: 0;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease;
    padding: 0 20px;
}

.faq-item.active .faq-answer {
    max-height: 200px;
    padding: 0 20px 20px;
}

.faq-answer p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .page-header h2 {
        font-size: 60px;
    }
    
    .page-header .subtext {
        font-size: 22px;
    }
    
    .small-header {
        font-size: 28px;
    }
    
    .section-title {
        font-size: 36px;
    }
    
    .feedback-title {
        font-size: 36px;
    }
}

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 40px;
    }
    
    .page-header .subtext {
        font-size: 18px;
    }
    
    .small-header {
        font-size: 24px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .feedback-card {
        padding: 30px;
    }
    
    .feedback-title {
        font-size: 32px;
    }
    
    .submit-button {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .page-header h2 {
        font-size: 32px;
    }
    
    .page-header .subtext {
        font-size: 16px;
    }
    
    .small-header {
        font-size: 20px;
    }
    
    .section-title {
        font-size: 28px;
    }
    
    .feedback-card {
        padding: 20px;
    }
    
    .feedback-title {
        font-size: 28px;
    }
    
    .form-group input,
    .form-group textarea {
        padding: 12px;
    }
    
    .submit-button {
        padding: 14px 30px;
        font-size: 16px;
    }
}
</style>
<body>
    <div class="container">
        <!-- Page Header Section -->
        <section class="page-header">
            <h2>Drive Together, Thrive Together</h2>
            <p class="subtext">Share the Journey, Shape the Future.</p>
        </section>

        <!-- Page Description Section -->
        <section class="page-description">
            <p class="description-item">
                <strong class="small-header">Welcome to the APU Carpool Support Page</strong>
                We're here to assist you with any questions or issues while using our carpooling platform. 
                Our support team is ready to help with booking rides, managing profiles, and ensuring your safety during carpooling.
            </p>
            <p class="description-item">
                <strong class="small-header">We Value Your Feedback</strong>
                We value your feedback as it helps us enhance the platform for the Asia Pacific University community. 
                Whether you have suggestions for new features, need help with an issue, or want to share your thoughts, 
                this is the place to do it!
            </p>
            <p class="description-item">
                <strong class="small-header">Explore Our FAQ</strong>
                Check our FAQ for quick answers or use the feedback form to contact us. We're committed to making your carpooling 
                experience smooth, safe, and convenient for everyone in the APU community.
            </p>
            <p class="description-item">
                <strong class="small-header">Thank You for Choosing APU Carpool</strong>
                Together, we can make campus transportation more convenient, sustainable, and community-focused!
            </p>
        </section>

        <!-- Improved Feedback Section -->
        <section class="feedback-section">
            <div class="section-header">
                <h2 class="section-title">We Value Your Feedback</h2>
                <p class="section-subtitle">Help us improve our carpooling platform by sharing your thoughts, suggestions, or reporting any issues.</p>
            </div>

            <div class="feedback-container">
                <!-- Feedback Form -->
                <div class="feedback-form-container">
                    <div class="feedback-card">
                        <h2 class="feedback-title">Feedback</h2>
                        
                        <form id="feedbackForm" action="support.php" method="POST" class="feedback-form">
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

                            <div class="form-group">
                                <label for="feedback">Feedback:</label>
                                <textarea 
                                    id="feedback" 
                                    name="feedback" 
                                    placeholder="Write your feedback here..." 
                                    required
                                ></textarea>
                            </div>

                            <div class="button-container">
                                <button type="submit" class="submit-button">Submit Feedback</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Image Container -->
                <div class="image-container">
                    <div class="image-wrapper">
                        <img src="image/homepage/feedback.png" alt="Feedback Image">
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="section-header">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Find quick answers to common questions about our carpooling platform.</p>
            </div>

            <div class="faq-container">
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What is the APU Carpool System?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>The APU Carpool System connects students, faculty, and staff to share rides to and from campus, reducing travel costs and environmental impact.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How does APU Carpool work?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>Users register with their APU credentials, indicate whether they can offer a ride or need one, and then match based on routes and schedules.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Who can join the APU Carpool System?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>All current APU students, faculty, and staff with valid APU ID are eligible to use the carpool system.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Is there a fee to use the system?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>The platform is free to use. Any cost-sharing for fuel or parking is arranged directly between drivers and riders.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I become a driver?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>Select the "Driver" option during registration, provide your vehicle details, and post your available seats along with your travel schedule.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How is safety ensured in the carpool?</h3>
                        <span class="faq-icon"></span>
                    </div>
                    <div class="faq-answer">
                        <p>All users are verified with APU credentials, and feedback/rating systems help monitor user reliability. Follow campus safety guidelines at all times.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Toggle FAQ answers
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });

        // Form submission feedback
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            // The form will still submit normally to your PHP script
            // This just adds a visual feedback for the user
            const button = this.querySelector('.submit-button');
            button.textContent = 'Submitting...';
            button.classList.add('submitting');
            
            // You can remove this setTimeout if you want the form to submit immediately
            // This is just for demo purposes to show the button state change
            setTimeout(() => {
                // The form will submit normally after this timeout
            }, 500);
        });
    </script>
</body>
</html>