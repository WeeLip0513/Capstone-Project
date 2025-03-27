document.addEventListener('DOMContentLoaded', function () {
    const ratingModal = document.getElementById('ratingModal');
    const closeRating = document.querySelector('.close-rating');
    const stars = document.querySelectorAll('.star-rating .star');
    const submitRatingBtn = document.getElementById('submitRating');

    let selectedRating = 0; 

    // show the rating modal
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('payment') === 'success') {
        ratingModal.style.display = 'flex';
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // select rating and update star colors
    stars.forEach(star => {
        star.addEventListener('click', function () {
            selectedRating = parseInt(this.getAttribute('data-value'));
            updateStarDisplay(selectedRating);
        });
        // hover effects
        star.addEventListener('mouseover', function () {
            updateStarDisplay(parseInt(this.getAttribute('data-value')));
        });
        star.addEventListener('mouseout', function () {
            updateStarDisplay(selectedRating);
        });
    });

    function updateStarDisplay(rating) {
        stars.forEach(star => {
            if (parseInt(star.getAttribute('data-value')) <= rating) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }

    // Submit rating button
    submitRatingBtn.addEventListener('click', function () {
        if (selectedRating < 1 || selectedRating > 5) {
            showNotification('Please select a rating between 1 and 5');
            return;
        }
        // Send rating to server
        fetch('http://localhost/Capstone-Project/carpool/php/passenger/updateDriverRating.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            credentials: 'include',
            body: 'driver_id=' + encodeURIComponent(driverId) + '&rating=' + encodeURIComponent(selectedRating)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message||'Thank you for your feedback!');
                ratingModal.style.display = 'none';
            } else {
                showNotification(data.message || 'Failed to update rating');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Connection error. Please try again.');
        });
    });

    // Close modal if close icon is clicked
    closeRating.addEventListener('click', function () {
        ratingModal.style.display = 'none';
    });
});
