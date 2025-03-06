document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.featureBtn'); // Updated selector
    const contents = document.querySelectorAll('.contents > div');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const contentId = this.getAttribute('data-content');

            contents.forEach(content => content.style.display = 'none'); // Hide all contents

            // Show the selected content
            const selectedContent = document.querySelector('.' + contentId);
            if (selectedContent) selectedContent.style.display = 'flex';

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

    // Get form elements
    const txtDate = document.getElementById("txtDate");
    const txtDateError = document.getElementById("txtDateError");

    const hour = document.getElementById("hour");
    const minute = document.getElementById("minute");
    const timeError = document.getElementById("timeError");

    const pickup = document.getElementById("pickup");
    const pickupError = document.getElementById("pickupError");

    const dropoff = document.getElementById("dropoff");
    const dropoffError = document.getElementById("dropoffError");

    const vehicle = document.getElementById("vehicle");
    const vehicleError = document.getElementById("vehicleError");

    // Set the min date to tomorrow
    const today = new Date();
    today.setDate(today.getDate() + 1); // Move to tomorrow
    const minDate = today.toISOString().split("T")[0];
    txtDate.setAttribute("min", minDate); // Set min date to tomorrow

    // Validation function
    function validateField(input, errorElement, errorMessage) {
        if (!input.value.trim()) {
            errorElement.textContent = errorMessage;
            errorElement.style.color = "red";
            input.style.border = "3px solid red";
        } else {
            errorElement.textContent = "";
            input.style.border = "3px solid #009432";
            input.style.color = "#2c2c2c";
            input.style.fontWeight = "bold";
        }
    }

    function validateLocations() {
        const pickup = document.getElementById("pickup");
        const dropoff = document.getElementById("dropoff");
        const pickupError = document.getElementById("pickupError");
        const dropoffError = document.getElementById("dropoffError");

        let isValid = true;

        // Check if pickup is selected
        if (!pickup.value) {
            pickupError.textContent = "Please select a pick-up point.";
            pickupError.style.color = "red";
            pickup.style.border = "3px solid red";
            isValid = false;
        } else {
            pickupError.textContent = "";
            pickup.style.border = "3px solid #009432";
            pickup.style.color = "#2c2c2c";
            pickup.style.fontWeight = "bold";
        }

        // Check if drop-off is selected
        if (!dropoff.value) {
            dropoffError.textContent = "Please select a drop-off point.";
            dropoffError.style.color = "red";
            dropoff.style.border = "3px solid red";
            dropoff.style.fontWeight = "bold";
            isValid = false;
        } else {
            dropoffError.textContent = "";
            dropoff.style.border = "3px solid #009432";
            dropoff.style.color = "#2c2c2c";
            dropoff.style.fontWeight = "bold";
        }

        // Check if both are selected and not the same
        if (pickup.value && dropoff.value && pickup.value === dropoff.value) {
            dropoffError.textContent = "Pickup and Drop-off cannot be the same.";
            dropoffError.style.color = "red";
            pickup.style.border = "3px solid red";
            dropoff.style.border = "3px solid red";
            isValid = false;
        }

        return isValid;
    }


    // Date Validation (Ensures a date is selected)
    function validateDate() {
        if (!txtDate.value.trim()) {
            txtDateError.textContent = "Please select a date.";
            txtDateError.style.color = "red";
            txtDate.style.border = "3px solid red";
        } else {
            txtDateError.textContent = "";
            txtDate.style.border = "3px solid #009432";
            txtDate.style.color = "#2c2c2c";
            txtDate.style.fontWeight = "bold";
        }
    }

    // Attach real-time validation to fields
    txtDate.addEventListener("input", validateDate);
    hour.addEventListener("change", () => validateField(hour, timeError, "Please select a valid time."));
    minute.addEventListener("change", () => validateField(minute, timeError, "Please select a valid time."));
    pickup.addEventListener("change", validateLocations);
    dropoff.addEventListener("change", validateLocations);
    vehicle.addEventListener("change", () => validateField(vehicle, vehicleError, "Please select a vehicle."));

    // Main validation function when form is submitted
    window.validateRideForm = function () {
        let isValid = true;

        validateDate();
        validateField(hour, timeError, "");
        validateField(minute, timeError, "Please select a valid time.");
        validateField(pickup, pickupError, "Please select a pick-up point.");
        validateField(dropoff, dropoffError, "Please select a drop-off point.");
        validateField(vehicle, vehicleError, "Please select a vehicle.");
        validateLocations();

        // Check if there are any error messages still present
        document.querySelectorAll(".error").forEach((error) => {
            if (error.textContent !== "") {
                isValid = false;
            }
        });

        return isValid;
    };

    const rowsPerPage = 7; // Show 7 rows per page
    const tableBody = document.getElementById("tableBody");
    let rows = Array.from(tableBody.querySelectorAll("tr:not(.divider-row):not(.pageControl):not(.create-btn-row)")); // Exclude dividers & pagination row
    const bottomDividerRow = tableBody.querySelectorAll(".divider-row")[1]; // Locate the last divider-row
    const createButtonRow = document.querySelector(".create-btn-row"); // The row containing the button
    const checkboxes = document.querySelectorAll(".rideCheckbox"); // Get all checkboxes

    let currentPage = 1;
    let totalPages = Math.ceil(rows.length / rowsPerPage);

    function showPage(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;

        // Hide all rows first
        rows.forEach(row => (row.style.display = "none"));

        // Get actual rows for the page
        let visibleRows = rows.slice(start, end);
        visibleRows.forEach(row => (row.style.display = "table-row"));

        // Remove previously added empty rows
        document.querySelectorAll(".empty-row").forEach(row => row.remove());

        // Fill with empty rows if needed
        let missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            let emptyRow = document.createElement("tr");
            emptyRow.classList.add("empty-row"); // Optional class for styling
            let columnCount = 6; // Match your table column count

            for (let j = 0; j < columnCount; j++) {
                let emptyCell = document.createElement("td");
                emptyCell.textContent = ""; // No content
                emptyRow.appendChild(emptyCell);
            }

            // Insert empty row before the bottom divider-row
            tableBody.insertBefore(emptyRow, bottomDividerRow);
        }

        updatePagination();
        updateButtonVisibility();
    }

    function changePage(page) {
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            showPage(currentPage);
        }
    }

    function updatePagination() {
        const paginationRow = document.querySelector(".pageControl");
        paginationRow.innerHTML = ""; // Clear previous pagination

        const paginationContainer = document.createElement("td");
        paginationContainer.setAttribute("colspan", "6");
        paginationContainer.style.textAlign = "center";

        for (let i = 1; i <= totalPages; i++) {
            const dot = document.createElement("span");
            dot.classList.add("pagination-dot");
            if (i === currentPage) dot.classList.add("active");

            dot.textContent = "•"; // Dot character
            dot.style.cursor = "pointer";
            dot.style.fontSize = "24px";
            dot.style.margin = "0 5px";
            dot.style.color = i === currentPage ? "#007bff" : "#ccc";

            dot.addEventListener("click", () => changePage(i));

            paginationContainer.appendChild(dot);
        }

        paginationRow.appendChild(paginationContainer);
    }

    function updateButtonVisibility() {
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        createButtonRow.style.display = anyChecked ? "table-row" : "none";
    }

    // Attach event listeners to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateButtonVisibility);
    });

    showPage(currentPage);

});


