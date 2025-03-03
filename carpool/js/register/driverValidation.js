document.addEventListener("DOMContentLoaded", function () {
    const driverForm = document.getElementById("driverSection");
    const vehicleForm = document.getElementById("vehicleSection");
    const nextButton = document.getElementById("nextButton");
    const backButton = document.getElementById("backButton");
    const registrationForm = document.getElementById("registrationForm");

    // 🚀 Function to validate the driver form before proceeding
    function validateDriverForm() {
        let isValid = true;

        const fields = [
            { id: "txtTP", pattern: /^TP\d{6}$/, message: "Please enter a valid TP Number. Example: TP012345" },
            { id: "txtFname", pattern: /^[A-Za-z]+$/, message: "Invalid name" },
            { id: "txtLname", pattern: /^[A-Za-z]+$/, message: "Invalid name" },
            { id: "txtPass", pattern: /^(?=.*[!@#$%^&*:"<>?,./;'[\]{}\\|])(?=.*[A-Z])(?=.*\d).{8,}$/, message: "Password must have at least 8 characters, one special character, one uppercase letter, and one number" },
            { id: "txtEmail", pattern: /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/, message: "Invalid email format" },
            { id: "txtPhone", pattern: /^01\d{8,9}$/, message: "Please enter a valid phone number. Example: 0123456789" },
            { id: "txtLicense", pattern: /^\d{7}[A-Za-z0-9]{7}$/, message: "Please enter a valid license number. Example: 0123456 U3OsjdU" },
            { id: "txtExpDate", pattern: /^\d{4}-\d{2}-\d{2}$/, message: "Please select your license expiry date." },
            { id: "license_photo", pattern: /^.+$/, message: "Upload a photo of you license (front side)" },
            { id: "license_photo_back", pattern: /^.+$/, message: "Upload a photo of you license (back side)" },
        ];
        
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const errorSpan = document.getElementById(field.id + "Error");

            if (!field.pattern.test(input.value.trim())) {
                errorSpan.textContent = field.message;
                isValid = false;
            } else {
                errorSpan.textContent = "";
            }
        });

        return isValid;
    }

    // 🚀 Function to validate the vehicle form before submission
    function validateVehicleForm() {
        let isValid = true;

        // List of required inputs in vehicle form
        const fields = [
            { id: "vehicleType", message: "Please select a vehicle type" },
            { id: "vehicleYear", message: "Please enter a valid year (1900-2099)", min: 1900, max: 2099 },
            { id: "vehicleBrand", message: "Please select a vehicle brand" },
            { id: "vehicleModel", message: "Please select a vehicle model" },
            { id: "vehicleColor", message: "Please enter a vehicle color" },
            { id: "plateNo", pattern: /^[A-Za-z0-9]+$/, message: "Plate number must be alphanumeric" },
            { id: "seatNo", message: "Seat number is required" },
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const errorSpan = document.getElementById(field.id + "Error");

            if (field.pattern) {
                if (!field.pattern.test(input.value.trim())) {
                    errorSpan.textContent = field.message;
                    isValid = false;
                } else {
                    errorSpan.textContent = "";
                }
            } else if (field.min && field.max) {
                let value = parseInt(input.value);
                if (isNaN(value) || value < field.min || value > field.max) {
                    errorSpan.textContent = field.message;
                    isValid = false;
                } else {
                    errorSpan.textContent = "";
                }
            } else {
                if (input.value.trim() === "") {
                    errorSpan.textContent = field.message;
                    isValid = false;
                } else {
                    errorSpan.textContent = "";
                }
            }
        });

        return isValid;
    }

    // 🚀 When the "Next" button is clicked, validate driver form before proceeding
    nextButton.addEventListener("click", function () {
        if (validateDriverForm()) {
            driverForm.style.display = "none";
            vehicleForm.style.display = "block";
        }
    });

    // 🚀 When the "Back" button is clicked, go back to driver form
    backButton.addEventListener("click", function () {
        vehicleForm.style.display = "none";
        driverForm.style.display = "block";
    });

    // 🚀 Validate vehicle form before final submission
    registrationForm.addEventListener("submit", function (event) {
        if (!validateVehicleForm()) {
            event.preventDefault(); // Stop form submission if validation fails
        }
    });
});
