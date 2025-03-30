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

    // Slider state
    let currentIndex = 0;
    const cardCount = cards.length;
    // Track which card is shown in the modal
    let currentModalIndex = null;

    // Calculate visible cards
    function getVisibleCardCount() {
        const wrapperWidth = cardsWrapper.offsetWidth;
        const cardWidth = 280 + 20;
        return Math.max(1, Math.floor(wrapperWidth / cardWidth));
    }

    // Update slider position (ensure CSS transition is applied on cardsContainer)
    function updateSlider() {
        const visibleCount = getVisibleCardCount();
        const cardWidth = cards[0].offsetWidth + 30;
        const maxIndex = cardCount - visibleCount;
        currentIndex=Math.max(0, Math.min(currentIndex, maxIndex));
        // if (currentIndex < 0) currentIndex = 0;
        // if (currentIndex > maxIndex) currentIndex = maxIndex;
        const offset = currentIndex * cardWidth;
        cardsContainer.style.transform = `translateX(-${offset}px)`;
    }

    // Navigation functions for the slider
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

    // Modal open/close using no-scroll class
    function openModal(title, description, subtitle = 'Carpool Benefits') {
        modalTitle.textContent = title;
        modalDescription.textContent = description;
        modalSubtitle.textContent = subtitle;
        modalOverlay.style.display = 'flex';
        document.body.classList.add('no-scroll');
        void modalOverlay.offsetWidth;
        modalOverlay.classList.add('active');
    }

    function closeModal() {
        modalOverlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
        setTimeout(() => {
            modalOverlay.style.display = 'none';
        }, 300);
    }

    // Update modal content for currentModalIndex
    function updateModalContent() {
        const card = cards[currentModalIndex];
        const title = card.getAttribute('data-title') || (card.querySelector('h2')?.textContent || 'No Title');
        const description = card.getAttribute('data-description') || (card.querySelector('p')?.textContent || 'No Description');
        const subtitle = card.getAttribute('data-subtitle') || 'Carpool Benefits';
        // Update slider index so that the card is visible
        currentIndex = currentModalIndex;
        updateSlider();
        modalTitle.textContent = title;
        modalDescription.textContent = description;
        modalSubtitle.textContent = subtitle;
    }

    // Show next modal card (wraps to first)
    function showNextModalCard() {
        if (currentModalIndex === null) return;
        currentModalIndex = (currentModalIndex + 1) % cardCount;
        updateModalContent();
    }

    // Animate the card slider when modal opens to show the next card
    function animateCardSlide() {
        // Animate slider to next card
        slideNext();
        // After slider animation (300ms), update modal content to the next card
        // setTimeout(() => {
        //     currentModalIndex = (currentModalIndex + 1) % cardCount;
        //     updateModalContent();
        // }, 300);
    }

    // Card click events
    cards.forEach((card, index) => {
        card.addEventListener('click', (event) => {
            if (modalOverlay.classList.contains('active')) {
                // If modal is already open, simply advance to next modal card
                showNextModalCard();
            } else {
                // Set current modal index to the clicked card index
                currentModalIndex = index;
                const title = card.getAttribute('data-title') || (card.querySelector('h2')?.textContent || 'No Title');
                const description = card.getAttribute('data-description') || (card.querySelector('p')?.textContent || 'No Description');
                const subtitle = card.getAttribute('data-subtitle') || 'Carpool Benefits';
                openModal(title, description, subtitle);
                // Immediately animate slider to next card and update modal content
                animateCardSlide();
            }
        });

        const expandButton = card.querySelector('.expand-button');
        if (expandButton) {
            expandButton.addEventListener('click', function (e) {
                e.stopPropagation();
                if (modalOverlay.classList.contains('active')) {
                    showNextModalCard();
                } else {
                    currentModalIndex = index;
                    const title = card.getAttribute('data-title') || (card.querySelector('h2')?.textContent || 'No Title');
                    const description = card.getAttribute('data-description') || (card.querySelector('p')?.textContent || 'No Description');
                    const subtitle = card.getAttribute('data-subtitle') || 'Carpool Benefits';
                    openModal(title, description, subtitle);
                    animateCardSlide();
                }
            });
        }
    });

    // Close modal events
    modalCloseBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
            closeModal();
        }
    });

    // Touch swipe for slider
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

    updateSlider();
});
