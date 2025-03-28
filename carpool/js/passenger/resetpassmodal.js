document.addEventListener('DOMContentLoaded', function () {
    const resetButton = document.getElementById('resetProfilePassword');
    const modal = document.getElementById('passwordResetModal');
    const modalMessage = document.getElementById('modal-message');

    // When the reset password button is clicked, show the modal and process the request.
    resetButton.addEventListener('click', function (e) {
        e.preventDefault();
        modal.style.display = 'flex';
        modalMessage.innerHTML = 'Processing<span class="dots">' +
            '<span class="dot">.</span>' +
            '<span class="dot">.</span>' +
            '<span class="dot">.</span>' +
            '</span>';

        // Send AJAX request to token-sent-profile.php
        fetch('../php/login/token-sent.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modalMessage.textContent = 'Reset link sent to your email!';
                setTimeout(() => {
                    modal.style.setProperty('display', 'none', 'important');
                }, 3000);
            } else {
                modalMessage.textContent = data.message || 'Error occurred';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalMessage.textContent = 'Connection error. Please try again.';
        });
    });

    // Close modal when close icon is clicked
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });
});
