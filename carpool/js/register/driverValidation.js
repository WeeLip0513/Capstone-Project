document.addEventListener("DOMContentLoaded", function () {
    const driverForm = document.getElementById("driverSection");
    const vehicleForm = document.getElementById("vehicleSection");
    const nextButton = document.getElementById("nextButton");
    const backButton = document.getElementById("backButton");
    const registrationForm = document.getElementById("registrationForm");

    function validateInput(input, pattern, errorMessage) {
        const errorSpan = document.getElementById(input.id + "Error");
        if (!pattern.test(input.value.trim())) {
            errorSpan.textContent = errorMessage;
            return false;
        } else {
            errorSpan.textContent = "";
            return true;
        }
    }

    const validationRules = [
        { id: "txtTP", pattern: /^TP\d{6}$/, message: "Please enter a valid TP Number. Example: TP012345" },
        { id: "txtFname", pattern: /^[A-Za-z]+$/, message: "Invalid first name (only letters allowed)" },
        { id: "txtLname", pattern: /^[A-Za-z]+$/, message: "Invalid last name (only letters allowed)" },
        { id: "txtPass", pattern: /^(?=.*[|~`+=_-!@#$%^&*:"<>?,./;'[\]{}\\|])(?=.*[A-Z])(?=.*\d).{8,}$/, message: "Password must have at least 8 characters, ONE special character, ONE uppercase letter, and ONE number" },
        { id: "txtEmail", pattern: /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/, message: "Invalid email format" },
        { id: "txtPhone", pattern: /^01\d{8,9}$/, message: "Please enter a valid phone number. Example: 0123456789" },
        { id: "txtLicense", pattern: /^\d{7}[A-Za-z0-9]{7}$/, message: "Please enter a valid license number. Example: 0123456 U3OsjdU" },
        { id: "txtExpDate", pattern: /^\d{4}-\d{2}-\d{2}$/, message: "Please select your license expiry date." },
        { id: "license_photo", pattern: /^.+$/, message: "Upload a photo of your license (front side)" },
        { id: "license_photo_back", pattern: /^.+$/, message: "Upload a photo of your license (back side)" }
    ];

    validationRules.forEach(field => {
        const input = document.getElementById(field.id);
        if (input) {
            input.addEventListener("input", function () {
                validateInput(this, field.pattern, field.message);
            });
        }
    });

    function checkDatabase(tpNumber, licenseNumber, callback) {
        fetch("../php/register/checkUser.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `tpnumber=${tpNumber}&license=${licenseNumber}`
        })
        .then(response => response.json())
        .then(data => callback(data))
        .catch(error => console.error("Error:", error));
    }

    nextButton.addEventListener("click", function () {
        let isValid = true;

        validationRules.forEach(field => {
            const input = document.getElementById(field.id);
            if (!validateInput(input, field.pattern, field.message)) {
                isValid = false;
            }
        });

        if (isValid) {
            const tpNumber = document.getElementById("txtTP").value.trim();
            const licenseNumber = document.getElementById("txtLicense").value.trim();
            const tpErrorSpan = document.getElementById("txtTPError");
            const licenseErrorSpan = document.getElementById("txtLicenseError");

            checkDatabase(tpNumber, licenseNumber, function (result) {
                tpErrorSpan.textContent = "";
                licenseErrorSpan.textContent = "";

                if (result.tpDoesNotExist) {
                    tpErrorSpan.textContent = "TP Number does not exist in the APU table!";
                    return;  // 🚫 STOP HERE if TP does not exist
                } 

                if (result.tpAlreadyRegistered) {
                    tpErrorSpan.textContent = "TP Number is already registered!";
                    return;
                }

                if (result.licenseAlreadyRegistered) {
                    licenseErrorSpan.textContent = "License Number is already registered!";
                    return;
                }

                // ✅ Proceed to vehicle form only if no issues
                driverForm.style.display = "none";
                vehicleForm.style.display = "block";
            });
        }
    });

    backButton.addEventListener("click", function () {
        vehicleForm.style.display = "none";
        driverForm.style.display = "block";
    });

    function validateVehicleForm() {
        let isValid = true;
        const vehicleRules = [
            { id: "vehicleType", message: "Please select a vehicle type" },
            { id: "vehicleYear", message: "Please enter a valid year (1900-2099)", min: 1900, max: 2099 },
            { id: "vehicleBrand", message: "Please select a vehicle brand" },
            { id: "vehicleModel", message: "Please select a vehicle model" },
            { id: "vehicleColor", message: "Please enter a vehicle color" },
            { id: "plateNo", pattern: /^[A-Za-z0-9]+$/, message: "Plate number must be alphanumeric" },
            { id: "seatNo", message: "Seat number is required" },
        ];

        vehicleRules.forEach(field => {
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

    registrationForm.addEventListener("submit", function (event) {
        if (!validateVehicleForm()) {
            event.preventDefault();
        }
    });
});
