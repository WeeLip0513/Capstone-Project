document.addEventListener('DOMContentLoaded', function () {
    const cardsWrapper = document.querySelector('.benefits-cards-wrapper');
    const cardsContainer = document.querySelector('.benefits-cards');
    const cards = document.querySelectorAll('.benefit-card');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');

    // Modal elements
    const modalOverlay = document.getElementById('modalOverlay');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const modalImage = document.getElementById('modalImage');

    // Slider state
    let currentIndex = 0;
    const cardCount = cards.length;

    // Calculate how many cards fit in the visible area
    function getVisibleCardCount() {
        const wrapperWidth = cardsWrapper.offsetWidth;
        const cardWidth = 280 + 20; // card width + gap
        return Math.max(1, Math.floor(wrapperWidth / cardWidth));
    }

    // Move the slider to show the correct cards
    function updateSlider() {
        const visibleCount = getVisibleCardCount();
        const cardWidth = 280 + 20;
        const maxIndex = cardCount - visibleCount;

        // Clamp index to avoid sliding beyond ends
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const offset = currentIndex * cardWidth;
        cardsContainer.style.transform = `translateX(-${offset}px)`;
    }

    // Navigation
    function slideNext() {
        currentIndex++;
        updateSlider();
    }
    function slidePrev() {
        currentIndex--;
        updateSlider();
    }

    nextButton.addEventListener('click', slideNext);
    prevButton.addEventListener('click', slidePrev);

    // Handle card clicks => open modal
    cards.forEach(card => {
        card.addEventListener('click', (event) => {
            // If user specifically clicked the plus icon or anywhere on the card:
            // 1) Stop event if we only want the plus icon to open. 
            //    For now, we let the entire card open the modal.
            // 2) Grab data from the card's attributes
            const title = card.getAttribute('data-title') || 'No Title';
            const description = card.getAttribute('data-description') || 'No Description';
            openModal(title, description);
        });
    });

    // Modal open/close
    function openModal(title, description, subtitle = 'Carpool Benefits', imageUrl = '/api/placeholder/400/400') {
        // Set content
        modalTitle.textContent = title;
        modalDescription.textContent = description;
        modalSubtitle.textContent = subtitle;
        modalImage.style.backgroundImage = `url('${imageUrl}')`;

        // Display the overlay (still invisible due to opacity 0)
        modalOverlay.style.display = 'flex';

        // Trigger reflow to ensure transition works
        void modalOverlay.offsetWidth;

        // Add active class to start animations
        modalOverlay.classList.add('active');
    }

    // Function to close modal with smooth animation
    function closeModal() {
        // Remove active class first (starts fade out)
        modalOverlay.classList.remove('active');

        // Wait for transition to complete before hiding
        setTimeout(() => {
            modalOverlay.style.display = 'none';
        }, 300); // Match the duration of opacity transition
    }

    // Example to trigger modal (you would connect this to your cards)
    document.querySelectorAll('.benefit-card').forEach((card, index) => {
        card.querySelector('.expand-button').addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent card click from triggering too

            // Get content from the card
            const title = card.querySelector('h2').textContent + " " +
                card.querySelector('h3').textContent;
            const description = card.querySelector('p').textContent;

            // Use different image for each card (you would replace these with real images)
            const images = [
                '/api/placeholder/400/400',
                '/api/placeholder/400/400',
                '/api/placeholder/400/400',
                '/api/placeholder/400/400',
                '/api/placeholder/400/400',
                '/api/placeholder/400/400'
            ];

            openModal(title, description, 'Carpool Benefits', images[index]);
        });
    });

    // Close modal when clicking close button
    modalCloseBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });

    // Optional: close with ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
            closeModal();
        }
    });
    // Handle window resizing
    window.addEventListener('resize', updateSlider);

    // Touch swipe for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    cardsWrapper.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    cardsWrapper.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    function handleSwipe() {
        if (touchEndX < touchStartX) {
            slideNext();
        } else if (touchEndX > touchStartX) {
            slidePrev();
        }
    }

    // Initialize slider on page load
    updateSlider();
});