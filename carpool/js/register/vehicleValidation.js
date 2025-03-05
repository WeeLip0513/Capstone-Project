document.addEventListener("DOMContentLoaded", function () {
  const vehicleType = document.getElementById("vehicleType");
  const vehicleYear = document.getElementById("vehicleYear");
  const vehicleBrand = document.getElementById("vehicleBrand");
  const vehicleModel = document.getElementById("vehicleModel");
  const vehicleColor = document.getElementById("vehicleColor");
  const plateNo = document.getElementById("plateNo");
  const seatNo = document.getElementById("seatNo");
  const vehicleForm = document.getElementById("vehicleSection");
  const plateNoError = document.getElementById("plateNoError");
  const registerButton = document.getElementById("registerButton");

  // Disable brand and model initially
  vehicleBrand.disabled = true;
  vehicleModel.disabled = true;

  // Get the current year and set min/max values
  const currentYear = new Date().getFullYear();
  const minYear = currentYear - 20;
  vehicleYear.setAttribute("min", minYear);
  vehicleYear.setAttribute("max", currentYear);

  // Vehicle Type → Seat Mapping
  const seatMapping = {
    sedan: 5, hatchback: 5, suv: 7, mpv: 7, pickup: 2, van: 12, jeep: 4,
  };

  // Vehicle Data (Brands & Models)
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

  function updateSeatNumber() {
    seatNo.value = seatMapping[vehicleType.value] || "";
  }

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

  vehicleType.addEventListener("change", function () {
    updateBrands();
    updateSeatNumber();
  });

  vehicleBrand.addEventListener("change", updateModels);

  // Check if Plate Number Exists (AJAX Request)
  function checkPlateNumberExists(callback) {
    console.log("Checking plate number...");
    fetch("php/register/checkVehicle.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `plateNo=${encodeURIComponent(plateNo.value)}`
    })
      .then(response => response.json())
      .then(data => {
        console.log("Server Response:", data);
        if (data.exists) {
          plateNoError.textContent = "Plate number already exists!";
          callback(false); // Prevent submission
        } else {
          plateNoError.textContent = "";
          callback(true); // Allow submission
        }
      })
      .catch(error => {
        console.error("Error checking plate number:", error);
        plateNoError.textContent = "Error checking plate number.";
        callback(false); // Prevent submission on error
      });
  }

  // Handle form submission only when "Register" button is clicked
  registerButton.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    if (!vehicleType.value) {
      alert("Please select a vehicle type first.");
      return;
    }

    checkPlateNumberExists(function (isValid) {
      if (isValid) {
        console.log("Form submitted!");
        registrationForm.submit();
      }
    });
  });
});
