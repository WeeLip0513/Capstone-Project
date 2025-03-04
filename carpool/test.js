fetch("php/register/checkVehicle.php", {
  method: "POST",
  headers: { "Content-Type": "application/x-www-form-urlencoded" },
  body: `plateNo=${encodeURIComponent(plateNo.value)}`
})
  .then(response => response.json())
  .then(data => {
    console.log("Server Response:", data); // Debugging
    if (data.exists) {
      document.getElementById("plateNoError").textContent = "Plate number already exists!";
      callback(false); // Prevent submission
    } else {
      document.getElementById("plateNoError").textContent = "";
      callback(true); // Allow submission
    }
  })
  .catch(error => {
    console.error("Error checking plate number:", error);
    callback(false); // Prevent submission on error
  });
