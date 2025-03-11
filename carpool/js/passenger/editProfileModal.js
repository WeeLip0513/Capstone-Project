document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editProfileModal');
    const closeBtn = document.querySelector('.close');
    const editProfileForm = document.getElementById('editProfileForm');
    const editFieldValue = document.getElementById('editFieldValue');
    const editFieldName = document.getElementById('editFieldName');
    const editLabel = document.getElementById('editLabel');
    const errorMessage = document.getElementById('errorMessage'); // Get the error message element

    // Mapping field names to readable labels
    const editLabels = {
        firstname: "Edit First Name",
        lastname: "Edit Last Name",
        phone_no: "Edit Phone Number",
        email: "Edit Email"
    };

    // Function to open the modal
    window.openEditProfileModal = function(fieldName, currentValue) {
        const modal = document.getElementById('editProfileModal');
        const editFieldName = document.getElementById('editFieldName');
        const editFieldValue = document.getElementById('editFieldValue');
        const editLabel = document.getElementById('editLabel');

        editFieldName.value = fieldName;
        editFieldValue.value = currentValue;
        editLabel.textContent = editLabels[fieldName] || "Edit Profile"; // Default text if not found

        modal.classList.add('show'); // Show the modal
    };

    // Function to close the modal
    function closeModal() {
        const modal = document.getElementById('editProfileModal');
        modal.classList.remove('show'); // Hide the modal
    }

    // Close the modal when the close button is clicked
    document.querySelector('.close').onclick = closeModal;

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('editProfileModal');
        if (event.target === modal) {
            closeModal();
        }
    };

    // Handle form submission
    editProfileForm.onsubmit = function(event) {
        event.preventDefault();
        const fieldName = editFieldName.value;
        const fieldValue = editFieldValue.value;
        const validationResult = validateField(fieldName, fieldValue);
        if (!validationResult.isValid) {
            alert(validationResult.message);
            return;
        }

        // Send AJAX request to update the profile
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/passenger/updateProfile.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log(xhr.responseText); // Log the response to the console
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update the displayed value on the page
                        document.getElementById(fieldName).textContent = fieldValue;
                        modal.style.display = 'none';
                        alert('Profile Updated Successfully');
                        window.location.reload();
                    } else {
                        alert('Failed to update profile: ' + response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response was:', xhr.responseText);
                    alert('Invalid response from the server. Please check the console for details.');
                }
            } else {
                alert('Request failed. Returned status of ' + xhr.status);
            }
        };
        xhr.send(`fieldName=${fieldName}&fieldValue=${fieldValue}`);
    };
});

function validateField(field, value) {
    value = value.trim();

    const validationRules = {
        firstname: {
            pattern: /^[a-zA-Z\s-]{5,20}$/, //allows letters, spaces between 2-20 characters
            message: "First name must contain letters, spaces, and hyphens."
        },
        lastname: {
            pattern: /^[a-zA-Z\s-]{5,20}$/, //allows letters, spaces between 2-20 characters
            message: "Last name must contain letters, spaces, and hyphens."
        },
        email: {
            pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, //valid email pattern
            message: "Please enter a valid email address."
        },
        phone_no: {
            pattern: /^\+?[\d\s-(){}.]{13,}$/, //allows minimum 10 digits
            message: "Please enter a valid phone number (minimum 10 digits)."
        }
    };
    if (validationRules[field]) {
        if (!validationRules[field].pattern.test(value)) {
            return {
                isValid: false,
                message: validationRules[field].message
            };
        }
        return {
            isValid: true,
            message: "Valid input"
        }
    };
}

document.getElementById('editFieldValue').addEventListener('input', function() {
    const fieldName = document.getElementById('editFieldName').value;
    const value = this.value;
    const validationResult = validateField(fieldName, value);
    const errorMessage = document.getElementById('errorMessage'); // Get the error message element

    if (validationResult.isValid) {
        this.style.borderColor = '#4CAF50';
        errorMessage.classList.remove('show'); // Hide the error message
        errorMessage.textContent = ''; // Clear the error message
    } else {
        this.style.borderColor = '#f44336';
        errorMessage.textContent = validationResult.message; // Set the error message
        errorMessage.classList.add('show'); // Show the error message
    }
});