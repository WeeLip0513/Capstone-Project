document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.feature');
    const contents = document.querySelectorAll('.contents > div');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.getAttribute('data-content');

            contents.forEach(content => {
                if (content.classList.contains(contentId)) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });

            // Remove 'active' class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
            this.classList.add('active');
        });
    });
});
