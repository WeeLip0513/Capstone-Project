document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.featureBtn'); // Updated selector
    const contents = document.querySelectorAll('.contents > div');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.getAttribute('data-content');

            contents.forEach(content => {
                content.style.display = 'none'; // Hide all contents
            });

            // Show the selected content
            const selectedContent = document.querySelector('.' + contentId);
            if (selectedContent) {
                selectedContent.style.display = 'flex'; // Ensure it uses flex display
            }

            // Remove 'active' class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
            this.classList.add('active');
        });
    });

    // Show the first content by default
    if (buttons.length > 0 && contents.length > 0) {
        buttons[0].classList.add('active');
        contents[0].style.display = 'flex'; // Ensure the default content is visible
    }
});
