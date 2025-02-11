document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.feature');
    const contents = document.querySelectorAll('.contents > div');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.getAttribute('data-content');

            contents.forEach(content => {
                // Remove 'active' class from all contents
                content.style.display = 'none';
            });

            // Add 'active' class to the selected content
            document.querySelector('.' + contentId).style.display = 'block';

            // Remove 'active' class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
            this.classList.add('active');
        });
    });

    // By default, show the first content and mark the first button as active
    if (buttons.length > 0 && contents.length > 0) {
        buttons[0].classList.add('active');
        contents[0].style.display = 'block';
    }
});
