
const pickupSelect = document.getElementById('pickup');
const dropoffSelect = document.getElementById('dropoff');
const dateInput = document.querySelector('input[type="date"]');
const timeInput = document.querySelector('input[type="time"]');
const searchButton = document.querySelector('.btn-login');

// get error message elements
const pickupError = document.getElementById('pickup-error');
const dropoffError = document.getElementById('dropoff-error');
const dateError = document.getElementById('date-error');
const timeError = document.getElementById('time-error');

// ID attributes date and tim
dateInput.id = 'ride-date';
timeInput.id = 'ride-time';

// set minimum date to today
const today = new Date();
const year = today.getFullYear();
const month = String(today.getMonth() + 1).padStart(2, '0');
const day = String(today.getDate()).padStart(2, '0');
const formattedToday = `${year}-${month}-${day}`;
dateInput.setAttribute('min', formattedToday);

// real-time validation
pickupSelect.addEventListener('change', validateForm);
dropoffSelect.addEventListener('change', validateForm);
dateInput.addEventListener('change', validateForm);
timeInput.addEventListener('change', validateForm);

// check is it empty of the date and time input
document.querySelectorAll('input[type="date"].card-holder, input[type="time"].card-holder')
    .forEach(function (input) {
        // Check on input events
        input.addEventListener('input', function () {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });

        // check on page load in case a value is fill
        if (input.value) {
            input.classList.add('has-value');
        }
    });

// main function
function validateForm() {
    const isValid = {
        pickup: validatePickup(),
        dropoff: validateDropoff(),
        sameLocations: validateLocations(),
        date: validateDate(),
        time: validateTime()
    };

    return isValid.pickup && isValid.dropoff && isValid.sameLocations && isValid.date && isValid.time;
}

function validatePickup() {
    if (!pickupSelect.value) {
        pickupSelect.classList.add('error');
        pickupError.textContent = "Please select a pickup point!";
        pickupError.style.display = 'inline';
        return false;
    } else {
        pickupSelect.classList.remove('error');
        pickupError.style.display = 'none';
        return true;
    }
}

function validateDropoff() {
    if (!dropoffSelect.value) {
        dropoffSelect.classList.add('error');
        dropoffError.textContent = "Please select a drop-off point!";
        dropoffError.style.display = 'inline';
        return false;
    } else {
        dropoffSelect.classList.remove('error');
        return true;
    }
}

function validateLocations() {
    if (pickupSelect.value && dropoffSelect.value && pickupSelect.value === dropoffSelect.value) {
        pickupError.textContent = "Pickup and drop-off points cannot be the same!";
        dropoffError.textContent = "Pickup and drop-off points cannot be the same!";
        pickupError.style.display = 'inline';
        dropoffError.style.display = 'inline';
        pickupSelect.classList.add('error');
        dropoffSelect.classList.add('error');
        return false;
    } else {
        if (pickupSelect.value && dropoffSelect.value) {
            pickupError.style.display = 'none';
            dropoffError.style.display = 'none';
            pickupSelect.classList.remove('error');
            dropoffSelect.classList.remove('error');
        }
        return true;
    }
}

function validateDate() {
    if (!dateInput.value) {
        dateInput.classList.add('error');
        dateError.textContent = "Please select a date!";
        dateError.style.display = 'inline';
        return false;
    } else {
        const selectedDate = new Date(dateInput.value);
        selectedDate.setHours(0, 0, 0, 0);

        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);

        if (selectedDate < currentDate) {
            dateInput.classList.add('error');
            dateError.textContent = "Date cannot be in the past!";
            dateError.style.display = 'inline';
            return false;
        } else {
            dateInput.classList.remove('error');
            dateError.style.display = 'none';
            return true;
        }
    }
}

function validateTime() {
    if (!timeInput.value) {
        timeInput.classList.add('error');
        timeError.textContent = "Please select a time!";
        timeError.style.display = 'inline';
        return false;
    } else {
        timeInput.classList.remove('error');
        timeError.style.display = 'none';
        return true;
    }
}

//search button validation
searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    const pickupValid = validatePickup();
    const dropoffValid = validateDropoff();
    const locationsValid = validateLocations();
    const dateValid = validateDate();
    const timeValid = validateTime();

    const isFormValid = pickupValid && dropoffValid && locationsValid && dateValid && timeValid;

    if (isFormValid) {
        var modal = document.getElementById('modal');
        modal.style.display = 'flex';
        var modalMessage = document.getElementById('modal-message');

        modalMessage.innerHTML = 'Searching<span class="dots">' +
            '<span class="dot">.</span>' +
            '<span class="dot">.</span>' +
            '<span class="dot">.</span>' +
            '</span>';

        setTimeout(function () {
            modalMessage.textContent = "Please proceed to login 🥹";
            setTimeout(function () {
                window.location.href = "loginpage.php";
            }, 2000);
        }, 3000);
    }
});

