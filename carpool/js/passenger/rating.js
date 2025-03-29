document.addEventListener("DOMContentLoaded", function () {
    const starContainer = document.getElementById("starContainer");
    const stars = document.querySelectorAll(".star");
    let selectedRating = 0;

    // Function to show a notification
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Reset all star states
    function resetStars() {
        stars.forEach(star => {
            star.classList.remove("selected", "hover");
        });
    }

    // Highlight stars up to a certain point with a given class
    function highlightStars(upTo, className) {
        resetStars();
        for (let i = 0; i < upTo; i++) {
            stars[i].classList.add(className);
        }
    }

    // Hover effect: when hovering over a star, show hover highlight
    starContainer.addEventListener("mouseover", function (e) {
        if (e.target.classList.contains("star")) {
            const hoverRating = parseInt(e.target.dataset.rating);
            highlightStars(hoverRating, "hover");
        }
    });

    // Mouse leave: revert back to selected rating (if any) or clear
    starContainer.addEventListener("mouseleave", function () {
        if (selectedRating > 0) {
            highlightStars(selectedRating, "selected");
        } else {
            resetStars();
        }
    });

    // Click on a star: set the rating and automatically submit it
    starContainer.addEventListener("click", function (e) {
        if (e.target.classList.contains("star")) {
            selectedRating = parseInt(e.target.dataset.rating);
            highlightStars(selectedRating, "selected");
            submitRating(selectedRating);
        }
    });

    // Automatically submit the rating via fetch
    function submitRating(selectedRating) {
        // Get values from URL or previous page context
        const urlParams = new URLSearchParams(window.location.search);
        const rideId = urlParams.get('ride_id') || window.rideId;
        const passengerId = urlParams.get('passenger_id') || window.passengerId;

        if (!passengerId) {
            alert("Session timeout. Please login again.");
            window.location.href = "../loginpage.php";
            return;
        }

        console.log("passenger ID:", passengerId);
        console.log("Ride ID:", rideId);
        console.log("Ride Rating:", selectedRating);
        fetch("../php/passenger/submitRating.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                passenger_id: passengerId,
                ride_id: rideId,
                ride_rating: selectedRating
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Thank you for your rating!
                                    Ride Avg: ${data.rideAvgRating ? data.rideAvgRating.toFixed(1) : 'N/A'} | 
                                    Driver Overall: ${data.overallDriverRating ? data.overallDriverRating.toFixed(1) : 'N/A'}`);
                    document.getElementById("ratingModal").style.display = "none";
                    setTimeout(()=>{
                        window.location.href = "../passenger/passengerPage.php";
                    }, 2500);
                } else {
                    alert("Failed to submit rating.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while submitting your rating.");
            });
    }

    // Automatically show the modal if needed (this could be set via a global variable from PHP)
    if (typeof showRatingModal !== 'undefined' && showRatingModal === "true") {
        document.getElementById("ratingModal").style.display = "flex";
    }

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
