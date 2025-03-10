document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll(".featureBtn");
    const contents = document.querySelectorAll(".contents > div");
    const hamburger = document.getElementById("hamburger");
    const featuresMenu = document.getElementById("featuresMenu");

    // Function to show selected content
    function showContent(button) {
        const contentId = button.getAttribute("data-content");

        // Hide all contents
        contents.forEach(content => content.style.display = "none");

        // Show the selected content
        const selectedContent = document.querySelector("." + contentId);
        if (selectedContent) selectedContent.style.display = "flex";

        // Remove 'active' from all buttons
        buttons.forEach(btn => btn.classList.remove("active"));

        // Add 'active' class to the clicked button
        button.classList.add("active");

        // Hide menu on mobile after clicking a button
        if (window.innerWidth <= 1200) {
            featuresMenu.classList.remove("show-menu");
            hamburger.classList.remove("open"); // Close hamburger animation
        }
    }

    // Attach click events to buttons
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            showContent(this);
        });
    });

    // Show first content by default
    if (buttons.length > 0 && contents.length > 0) {
        showContent(buttons[0]); // Ensures first button is selected initially
    }

    // Toggle Menu for Mobile
    hamburger.addEventListener("click", function () {
        featuresMenu.classList.toggle("show-menu");
        this.classList.toggle("open"); // Animate hamburger icon
    });

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
            isValid = false;
        } else {
            dropoffError.textContent = "";
            dropoff.style.border = "3px solid #009432";
            dropoff.style.color = "#2c2c2c";
            dropoff.style.fontWeight = "bold";
        }

        // Check if both are selected and not the same
        if (pickup.value && dropoff.value && pickup.value === dropoff.value) {
            dropoffError.textContent = "Invalid Location";
            dropoffError.style.color = "red";
            pickup.style.border = "3px solid red";
            dropoff.style.border = "3px solid red";
            isValid = false;
        }

        return isValid;
    }

    // Date Validation (Ensures a date is selected)
    function validateDate() {
        validateField(txtDate, txtDateError, "Please select a date.");
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
        validateField(hour, timeError, "Please select a valid time.");
        validateField(minute, timeError, "Please select a valid time.");
        validateField(pickup, pickupError, "Please select a pick-up point.");
        validateField(dropoff, dropoffError, "Please select a drop-off point.");
        validateField(vehicle, vehicleError, "Please select a vehicle.");
        validateLocations();

        document.querySelectorAll(".error").forEach((error) => {
            if (error.textContent !== "") {
                isValid = false;
            }
        });

        return isValid;
    };

    // Pagination Logic
    const rowsPerPage = 7;
    const tableBody = document.getElementById("tableBody");
    let rows = Array.from(tableBody.querySelectorAll("tr:not(.divider-row):not(.pageControl):not(.create-btn-row)"));
    const bottomDividerRow = tableBody.querySelectorAll(".divider-row")[1];
    const createButtonRow = document.querySelector(".create-btn-row");
    const checkboxes = document.querySelectorAll(".rideCheckbox");

    let currentPage = 1;
    let totalPages = Math.ceil(rows.length / rowsPerPage);

    function showPage(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;

        rows.forEach(row => (row.style.display = "none"));

        let visibleRows = rows.slice(start, end);
        visibleRows.forEach(row => (row.style.display = "table-row"));

        document.querySelectorAll(".empty-row").forEach(row => row.remove());

        let missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            let emptyRow = document.createElement("tr");
            emptyRow.classList.add("empty-row");
            let columnCount = 6;

            for (let j = 0; j < columnCount; j++) {
                let emptyCell = document.createElement("td");
                emptyCell.textContent = "";
                emptyRow.appendChild(emptyCell);
            }

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
        paginationRow.innerHTML = "";
    
        if (totalPages > 1) { // Only show dots if more than one page
            for (let i = 1; i <= totalPages; i++) {
                const dot = document.createElement("span");
                dot.classList.add("pagination-dot");
                if (i === currentPage) dot.classList.add("active");
    
                dot.textContent = "•";
                dot.style.cursor = "pointer";
                dot.style.color = i === currentPage ? "#007bff" : "#ccc";
    
                dot.addEventListener("click", () => changePage(i));
                paginationRow.appendChild(dot);
            }
        }
    }
    

    function updateButtonVisibility() {
        createButtonRow.style.display = Array.from(checkboxes).some(checkbox => checkbox.checked) ? "table-row" : "none";
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateButtonVisibility);
    });

    showPage(currentPage);
});
