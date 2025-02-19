document.querySelectorAll("#driverSection input, #vehicleSection input").forEach(input => {
    let errorId = input.id + "Error";
    if (!document.getElementById(errorId)) {
        console.warn(`Missing error span for ${input.id}`);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const driverInputs = document.querySelectorAll("#driverSection input");
    const vehicleInputs = document.querySelectorAll("#vehicleSection input");

    // Add event listeners for real-time validation
    driverInputs.forEach(input => {
        input.addEventListener("input", () => validateField(input));
    });

    vehicleInputs.forEach(input => {
        input.addEventListener("input", () => validateField(input));
    });

    document.getElementById("nextButton").addEventListener("click", function () {
        if (true) {
            document.getElementById("driverSection").style.display = "none";
            document.getElementById("vehicleSection").style.display = "block";
        }
    });

    document.getElementById("backButton").addEventListener("click", function () {
        document.getElementById("vehicleSection").style.display = "none";
        document.getElementById("driverSection").style.display = "block";
    });

    document.getElementById("registrationForm").addEventListener("submit", function (event) {
        if (!validateVehicleForm()) {
            event.preventDefault(); // Prevent submission if validation fails
        }
    });
});

function validateField(input) {
    let errorSpan = document.getElementById(input.id + "Error");
    if (!errorSpan) {
        console.warn(`Missing error span for ${input.id}`); // Debugging
        return;
    }

    let value = input.value.trim();
    let isValid = true;
    let errorMessage = "";

    switch (input.id) {
        case "txtTP":
        case "txtLicense":
        case "plateNo":
            isValid = /^[A-Za-z0-9]+$/.test(value);
            errorMessage = "Only letters and numbers allowed.";
            break;

        case "txtFname":
        case "txtLname":
        case "vehicleBrand":
        case "vehicleColor":
        case "vehicleType":
            isValid = /^[A-Za-z]+$/.test(value);
            errorMessage = "Only letters allowed.";
            break;

        case "txtPass":
            isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}$/.test(value);
            errorMessage = "Must be 8+ chars, with a number, uppercase, and special char.";
            break;

        case "txtEmail":
            isValid = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/.test(value);
            errorMessage = "Enter a valid email address.";
            break;

        case "txtPhone":
            isValid = /^[0-9]+$/.test(value) && value.length >= 10;
            errorMessage = "Enter a valid phone number (10+ digits).";
            break;

        case "txtExpDate":
            isValid = value !== "";
            errorMessage = "Expiration date is required.";
            break;

        case "license_photo":
        case "license_photo_back":
            isValid = input.files && input.files.length > 0;
            errorMessage = "Upload required.";
            break;

        case "vehicleYear":
            let year = parseInt(value);
            isValid = year >= 1900 && year <= new Date().getFullYear();
            errorMessage = "Enter a valid vehicle year.";
            break;

        case "seatNo":
            let seatNum = parseInt(value);
            isValid = seatNum >= 1;
            errorMessage = "Enter at least 1 seat.";
            break;

        default:
            console.warn(`Validation rule missing for ${input.id}`);
    }

    errorSpan.innerText = isValid ? "" : errorMessage;
    return isValid;
}

// Validate the entire driver form
function validateDriverForm() {
    let isValid = true;

    document.querySelectorAll("#driverSection input").forEach(input => {
        let fieldValid = validateField(input);
        console.log(`${input.id} valid: ${fieldValid}`); // Debugging
        if (!fieldValid) {
            isValid = false;
        }
    });

    // ✅ Ensure both license front and back photos are uploaded
    const licenseFront = document.getElementById("license_photo");
    const licenseBack = document.getElementById("license_photo_back");

    if (!licenseFront || !licenseBack) {
        console.error("License photo inputs missing in HTML!");
        return false;
    }

    if (licenseFront.files.length === 0 || licenseBack.files.length === 0) {
        document.getElementById("license_photoError").innerText = "Upload both front and back license images.";
        console.warn("License images missing");
        isValid = false;
    } else {
        document.getElementById("license_photoError").innerText = "";
    }

    console.log("Driver form valid:", isValid);
    return isValid;
}

// Validate the entire vehicle form
function validateVehicleForm() {
    let isValid = true;
    document.querySelectorAll("#vehicleSection input").forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    return isValid;
}
