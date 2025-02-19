document.querySelectorAll("#driverSection input, #vehicleSection input").forEach(input => {
  let errorId = input.id + "Error";
  if (!document.getElementById(errorId)) {
      console.warn(`Missing error span for ${input.id}`);
  }
});
