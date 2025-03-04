document.addEventListener("DOMContentLoaded", function () {
  const vehicleType = document.getElementById("vehicleType");
  const vehicleYear = document.getElementById("vehicleYear");
  const vehicleBrand = document.getElementById("vehicleBrand");
  const vehicleModel = document.getElementById("vehicleModel");
  const vehicleColor = document.getElementById("vehicleColor");
  const plateNo = document.getElementById("plateNo");
  const seatNo = document.getElementById("seatNo");
  const vehicleForm = document.getElementById("vehicleSection");

  // Get the current year and set the min & max values
  const currentYear = new Date().getFullYear();
  const minYear = currentYear - 20;

  vehicleYear.setAttribute("min", minYear);
  vehicleYear.setAttribute("max", currentYear);

  // Error Messages
  const errorMessages = {
      vehicleType: "Please select a vehicle type",
      vehicleYear: `Year must be between ${minYear}-${currentYear}`,
      vehicleBrand: "Please select a vehicle brand",
      vehicleModel: "Please select a vehicle model",
      vehicleColor: "Please enter a valid vehicle color",
      plateNo: "Plate number must be alphanumeric",
      seatNo: "Seat number is required",
  };

  // Vehicle Type → Seat Mapping
  const seatMapping = {
      sedan: 5,
      hatchback: 5,
      suv: 7,
      mpv: 7,
      pickup: 2,
      van: 12,
      jeep: 4,
  };

  // Vehicle Type → Brand → Model Mapping
  const vehicleData = {
    sedan: {
        brands: ["Toyota", "Honda", "Nissan", "Proton", "Perodua"],
        models: {
            Toyota: ["Vios", "Camry", "Corolla Altis"],
            Honda: ["City", "Civic", "Accord"],
            Nissan: ["Almera", "Teana"],
            Proton: ["Saga", "Persona", "Inspira", "Preve"],
            Perodua: ["Bezza"],
        }
    },
    hatchback: {
        brands: ["Perodua", "Honda", "Toyota", "Mazda", "Proton"],
        models: {
            Perodua: ["Myvi", "Axia", "Kelisa", "Viva"],
            Honda: ["Jazz"],
            Toyota: ["Yaris"],
            Mazda: ["Mazda2"],
            Proton: ["Iriz", "Satria Neo"],
        }
    },
    suv: {
        brands: ["Honda", "Mazda", "Toyota", "Proton", "Perodua", "Nissan"],
        models: {
            Honda: ["CR-V", "HR-V"],
            Mazda: ["CX-5", "CX-8"],
            Toyota: ["Fortuner", "Harrier"],
            Proton: ["X50", "X70"],
            Perodua: ["Ativa"],
            Nissan: ["X-Trail"],
        }
    },
    mpv: {
        brands: ["Toyota", "Perodua", "Honda", "Nissan", "Proton"],
        models: {
            Toyota: ["Avanza", "Innova", "Vellfire", "Alphard"],
            Perodua: ["Alza"],
            Honda: ["BR-V", "Odyssey"],
            Nissan: ["Serena"],
            Proton: ["Exora"],
        }
    },
    pickup: {
        brands: ["Toyota", "Nissan", "Ford", "Isuzu", "Mitsubishi"],
        models: {
            Toyota: ["Hilux"],
            Nissan: ["Navara"],
            Ford: ["Ranger"],
            Isuzu: ["D-Max"],
            Mitsubishi: ["Triton"],
        }
    },
    van: {
        brands: ["Toyota", "Nissan", "Hyundai"],
        models: {
            Toyota: ["HiAce"],
            Nissan: ["Urvan", "Caravan"],
            Hyundai: ["Staria"],
        }
    },
    jeep: {
        brands: ["Jeep", "Land Rover"],
        models: {
            Jeep: ["Wrangler", "Cherokee", "Grand Cherokee"],
            "Land Rover": ["Defender", "Range Rover", "Discovery"],
        }
    }
};

  // Validate Fields
  function validateField(input, errorId, validationFn) {
      const errorSpan = document.getElementById(errorId);
      const value = input.value.trim();

      if (validationFn(value)) {
          errorSpan.textContent = "";
          return true;
      } else {
          errorSpan.textContent = errorMessages[input.id] || "Invalid input";
          return false;
      }
  }

  // Validate Entire Form Before Submission
  function validateVehicleForm() {
      let isValid = true;

      isValid = validateField(vehicleType, "vehicleTypeError", value => value !== "") && isValid;
      isValid = validateField(vehicleYear, "vehicleYearError", value => {
          const year = parseInt(value, 10);
          return !isNaN(year) && year >= minYear && year <= currentYear;
      }) && isValid;
      isValid = validateField(vehicleBrand, "vehicleBrandError", value => value !== "") && isValid;
      isValid = validateField(vehicleModel, "vehicleModelError", value => value !== "") && isValid;
      isValid = validateField(vehicleColor, "vehicleColorError", value => /^[A-Za-z\s]+$/.test(value)) && isValid;
      isValid = validateField(plateNo, "plateNoError", value => /^[A-Za-z0-9]+$/.test(value)) && isValid;
      isValid = validateField(seatNo, "seatNoError", value => value !== "") && isValid;

      return isValid;
  }

  // Update Seat Number Based on Vehicle Type
  function updateSeatNumber() {
      seatNo.value = seatMapping[vehicleType.value] || "";
  }

  // Update Available Brands Based on Vehicle Type Selection
  function updateBrands() {
      vehicleBrand.innerHTML = '<option value="">Select Brand</option>';
      vehicleModel.innerHTML = '<option value="">Select Model</option>';
      vehicleBrand.disabled = true;
      vehicleModel.disabled = true;

      const selectedType = vehicleType.value;
      if (vehicleData[selectedType]) {
          vehicleBrand.disabled = false;
          vehicleData[selectedType].brands.forEach(brand => {
              let option = document.createElement("option");
              option.value = brand;
              option.textContent = brand;
              vehicleBrand.appendChild(option);
          });
      }
  }

  // Update Available Models Based on Brand Selection
  function updateModels() {
      vehicleModel.innerHTML = '<option value="">Select Model</option>';
      vehicleModel.disabled = true;

      const selectedType = vehicleType.value;
      const selectedBrand = vehicleBrand.value;
      if (vehicleData[selectedType] && vehicleData[selectedType].models[selectedBrand]) {
          vehicleModel.disabled = false;
          vehicleData[selectedType].models[selectedBrand].forEach(model => {
              let option = document.createElement("option");
              option.value = model;
              option.textContent = model;
              vehicleModel.appendChild(option);
          });
      }
  }

  // Check if Plate Number Already Exists (AJAX Request)
  function checkPlateNumberExists() {
      fetch("../php/register/checkVehicle.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `plateNo=${encodeURIComponent(plateNo.value)}`
      })
      .then(response => response.json())
      .then(data => {
          if (data.exists) {
              document.getElementById("plateNoError").textContent = "Plate number already exists!";
          } else {
              document.getElementById("plateNoError").textContent = "";
          }
      })
      .catch(error => console.error("Error checking plate number:", error));
  }

  // Event Listeners for Real-Time Updates
  vehicleType.addEventListener("change", updateBrands);
  vehicleBrand.addEventListener("change", updateModels);
  vehicleType.addEventListener("change", updateSeatNumber);
  plateNo.addEventListener("input", checkPlateNumberExists);

  // Form Submission Validation
  vehicleForm.addEventListener("submit", function (event) {
      if (!validateVehicleForm()) {
          event.preventDefault();
      }
  });
});
