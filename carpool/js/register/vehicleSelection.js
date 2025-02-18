document.addEventListener("DOMContentLoaded", function () {
  const carModels = {
    Perodua: ["Myvi", "Axia", "Bezza", "Alza", "Ativa"],
    Proton: ["Saga", "Persona", "Iriz", "X50", "X70"],
    Toyota: ["Vios", "Corolla", "Camry", "Hilux", "Yaris"],
    Honda: ["City", "Civic", "Accord", "HR-V", "CR-V"],
    Nissan: ["Almera", "X-Trail", "Serena", "Navara", "Teana"],
    Mazda: ["Mazda2", "Mazda3", "Mazda6", "CX-5", "CX-8"],
    BMW: ["X1", "X3", "X5", "3 Series", "5 Series"],
    "Mercedes-Benz": ["A-Class", "C-Class", "E-Class", "GLC", "GLE"],
    Hyundai: ["Elantra", "Tucson", "Santa Fe", "Kona", "Ioniq"],
    Kia: ["Picanto", "Rio", "Cerato", "Sportage", "Sorento"]
  };

  // Function to update models based on selected brand
  function updateModels() {
    const brandSelect = document.getElementById("vehicleBrand");
    const modelSelect = document.getElementById("vehicleModel");

    if (!brandSelect || !modelSelect) return; // Prevent errors if elements are missing

    const selectedBrand = brandSelect.value;
    modelSelect.innerHTML = '<option value="">Select Model</option>'; // Reset options

    if (selectedBrand && carModels[selectedBrand]) {
      carModels[selectedBrand].forEach(model => {
        let option = document.createElement("option");
        option.value = model;
        option.textContent = model;
        modelSelect.appendChild(option);
      });
    }
  }

  // Attach event listener to the vehicle brand dropdown
  const brandDropdown = document.getElementById("vehicleBrand");
  if (brandDropdown) {
    brandDropdown.addEventListener("change", updateModels);
  }

  // Auto-set seat number based on vehicle type
  document.getElementById("vehicleType").addEventListener("change", function () {
    const seatNo = document.getElementById("seatNo");
    const vehicleType = this.value;

    const seatNumbers = {
      motorcar: 5,
      pickup: 2,
      jeep: 4,
      van: 12,
      mpg: 6,
      suv: 7,
    };

    if (seatNo) {
      seatNo.value = seatNumbers[vehicleType] || "";
    }
  });
});
