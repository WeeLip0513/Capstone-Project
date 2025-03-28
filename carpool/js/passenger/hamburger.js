document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const navigationUser = document.getElementById('navigation-user');
    const radios = document.querySelectorAll('input[name="tabs"]');
    const labels = document.querySelectorAll('.tabs label');

    function setInitialActiveState() {
        labels.forEach(label => {
            label.classList.remove('active');
        });

        const checkedRadio = document.querySelector('input[name="tabs"]:checked');
        if (checkedRadio) {
            const activeLabel = document.querySelector(`label[for="${checkedRadio.id}"]`);
            if (activeLabel) {
                activeLabel.classList.add('active');
            }
        }
    }

    setInitialActiveState();

    hamburger.addEventListener('click', () => {
        navigationUser.classList.toggle('show');
        hamburger.classList.toggle('open');

        if (navigationUser.classList.contains('show')) {
            document.body.classList.add('no-scroll');
        } else {
            document.body.classList.remove('no-scroll');
        }
    });

    // Add active state to the selected tab's label
    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            labels.forEach(label => {
                label.classList.remove('active');
            });

            const activeLabel = document.querySelector(`label[for="${radio.id}"]`);
            if (activeLabel) {
                activeLabel.classList.add('active');
            }

            navigationUser.classList.remove('show');
            hamburger.classList.remove('open');
            document.body.classList.remove('no-scroll');
        });
    });

    document.addEventListener('click', (event) => {
        if (navigationUser.classList.contains('show') && 
            !navigationUser.contains(event.target) && 
            !hamburger.contains(event.target)) {
            navigationUser.classList.remove('show');
            hamburger.classList.remove('open');
            document.body.classList.remove('no-scroll');
        }
    });
});