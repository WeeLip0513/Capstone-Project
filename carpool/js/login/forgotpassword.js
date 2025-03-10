document.querySelector('.forgot').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('passwordResetModal').style.display = 'block';
});

// Close Modal
document.querySelector('.close-modal').addEventListener('click', function () {
    document.getElementById('passwordResetModal').style.display = 'none';
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showFeedback(element, message, color) {
    element.textContent = message;
    element.style.color = color;
    element.style.display = 'block';
}

document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const emailInput = this.querySelector('input');
    const email = emailInput.value.trim();
    const feedback = document.getElementById('resetFeedback');

    // reset current message
    feedback.style.display = 'none';

    // call email check
    if (!email || !validateEmail(email)) {
        showFeedback(feedback, 'Please insert a valid email address', 'red');
        emailInput.focus();
        return;
    }
    showFeedback(feedback, 'Checking email...', 'var(--grad-clr1)');

    fetch('http://localhost/Capstone-Project/carpool/php/login/token-sent.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'email=' + encodeURIComponent(email)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFeedback(feedback, 'Reset link sent to your email!', 'green');
                setTimeout(() => {
                    document.getElementById('passwordResetModal').style.display = 'none';
                    this.reset();
                }, 3000);
            } else {
                showFeedback(feedback, data.message || 'Email not found in our system', 'red');
            }
        })
        .catch(() => {
            showFeedback(feedback, 'Connection error. Please try again.', 'red');
        });
});
