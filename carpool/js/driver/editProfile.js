document.addEventListener('DOMContentLoaded', function () {
  const profileModal = document.getElementById('editProfileModal');
  const licenseModal = document.getElementById('editLicenseModal');
  const licenseExpInput = document.getElementById("newLicenseExp");

  // Calculate the date six months from today
  const today = new Date();
  today.setMonth(today.getMonth() + 6);
  const minDate = today.toISOString().split("T")[0]; // Format as YYYY-MM-DD
  licenseExpInput.setAttribute("min", minDate);

  const editLabels = {
    firstname: "Edit First Name",
    lastname: "Edit Last Name",
    phone_no: "Edit Phone Number",
    email: "Edit Email"
  };

  const validationRules = {
    firstname: /^[a-zA-Z\s-]{2,20}$/,
    lastname: /^[a-zA-Z\s-]{2,20}$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    phone_no: /^\+?[\d\s-(){}.]{10,}$/
  };

  function validateField(field, value) {
    return validationRules[field] ? validationRules[field].test(value.trim()) : true;
  }

  function validateLicenseForm() {
    const licenseNo = document.getElementById('newLicenseNo').value.trim();
    const licenseExp = document.getElementById('newLicenseExp').value;
    const frontPhoto = document.getElementById('newLicensePhotoFront').files[0];
    const backPhoto = document.getElementById('newLicensePhotoBack').files[0];

    document.getElementById("licenseErrorMessage").textContent = "";
    document.getElementById("expDateErrorMessage").textContent = "";
    document.getElementById("photoErrorMessage").textContent = "";

    if (!/^\d{7}[A-Za-z0-9]{7}$/.test(licenseNo)) {
      document.getElementById("licenseErrorMessage").textContent = "License Number must be exactly 7 digits followed by 7 alphanumeric characters.";
      return false;
    }

    const expiryDate = new Date(licenseExp);
    if (expiryDate <= new Date()) {
      document.getElementById("expDateErrorMessage").textContent = "Expiry date must be in the future.";
      return false;
    }

    const sixMonthsLater = new Date();
    sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);
    if (expiryDate < sixMonthsLater) {
      document.getElementById("expDateErrorMessage").textContent = "Expiry date must be at least six months from today.";
      return false;
    }

    if (!frontPhoto || !backPhoto) {
      document.getElementById("photoErrorMessage").textContent = "Both front and back license photos are required.";
      return false;
    }

    if (!["image/jpeg", "image/png", "image/jpg"].includes(frontPhoto.type) ||
        !["image/jpeg", "image/png", "image/jpg"].includes(backPhoto.type)) {
      document.getElementById("photoErrorMessage").textContent = "Only JPG, JPEG, and PNG files are allowed.";
      return false;
    }

    return true;
  }

  document.addEventListener('input', function (event) {
    if (event.target.matches('#editFieldValue')) {
      const fieldName = document.getElementById('editFieldName').value;
      document.getElementById('errorMessage').textContent = validateField(fieldName, event.target.value) ? "" : "Invalid input";
    }
    if (event.target.matches('#newLicenseNo, #newLicenseExp, #newLicensePhotoFront, #newLicensePhotoBack')) {
      validateLicenseForm();
    }
  });

  window.openEditProfileModal = function (fieldName, currentValue) {
    document.getElementById('editFieldName').value = fieldName;
    document.getElementById('editFieldValue').value = currentValue;
    document.getElementById('editLabel').textContent = editLabels[fieldName] || "Edit Profile";
    profileModal.classList.add('show');
  };

  window.openEditLicenseModal = function () {
    licenseModal.classList.add('show');
  };

  function closeModal(modal) {
    modal.classList.remove('show');
  }

  document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.onclick = function () {
      closeModal(profileModal);
      closeModal(licenseModal);
    };
  });

  document.getElementById('editProfileForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const fieldName = document.getElementById('editFieldName').value;
    const fieldValue = document.getElementById('editFieldValue').value.trim();

    if (!validateField(fieldName, fieldValue)) {
      document.getElementById('errorMessage').textContent = "Invalid input";
      return;
    }

    const formData = new FormData();
    formData.append('fieldName', fieldName);
    formData.append('fieldValue', fieldValue);

    fetch('../php/driver/updateProfile.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Profile updated successfully');
          window.location.reload();
        } else {
          alert('Update failed: ' + data.message);
        }
      })
      .catch(error => {
        alert('Request failed: ' + error);
      });
  });

  document.getElementById('editLicenseForm').addEventListener('submit', function (event) {
    event.preventDefault();

    if (!validateLicenseForm()) {
      return;
    }

    const formData = new FormData();
    formData.append('license_no', document.getElementById('newLicenseNo').value.trim());
    formData.append('license_exp', document.getElementById('newLicenseExp').value);
    formData.append('license_photo_front', document.getElementById('newLicensePhotoFront').files[0]);
    formData.append('license_photo_back', document.getElementById('newLicensePhotoBack').files[0]);

    fetch('../php/driver/updateLicense.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('License updated successfully');
        window.location.reload();
      } else {
        alert('Update failed: ' + data.message);
      }
    })
    .catch(error => {
      alert('Request failed: ' + error);
    });
  });

  // Close modal when clicking outside
  window.onclick = function (event) {
    if (event.target === profileModal) closeModal(profileModal);
    if (event.target === licenseModal) closeModal(licenseModal);
  };
});

document.getElementById("deleteDriver").addEventListener("click", function () {
  if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
      fetch("../php/driver/deleteDriver.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "action=delete"
      })
      .then(response => response.text())
      .then(data => {
          console.log("Server Response:", data);
          if (data.trim() === "success") {
              alert("Your account has been deleted successfully.");
              window.location.href = "../homepage.php"; // Redirect after deletion
          } else {
              alert("Error: " + data); // Show exact error message
          }
      })
      .catch(error => {
          console.error("Fetch Error:", error);
          alert("Error deleting account. Please try again.");
      });
  }
});
