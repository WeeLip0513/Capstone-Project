function showConfirmation() {
  if (!validateRideForm()) {
    return;
  }

  const date = document.getElementById('txtDate').value;
  const hour = document.getElementById('hour').value;
  const minute = document.getElementById('minute').value;
  const pickup = document.getElementById('pickup').selectedOptions[0].text;  // Get text instead of value
  const dropoff = document.getElementById('dropoff').selectedOptions[0].text; // Get text instead of value
  const vehicle = document.getElementById('vehicle').selectedOptions[0].text;
  const seatNo = document.getElementById('seatNo').value;

  document.getElementById('rideDetails').innerHTML = `
    Date: ${date}<br>
    Time: ${hour}:${minute}<br>
    Pick-Up: ${pickup}<br>
    Drop-Off: ${dropoff}<br>
    Vehicle: ${vehicle}<br>
    Slots: ${seatNo}
  `;
  document.getElementById('confirmation').style.display = 'block';
  document.getElementById('addRideContainer').style.display = 'none';
  document.getElementById('historyContainer').style.display = 'none';
}

function hideConfirmation() {
document.getElementById('confirmation').style.display = 'none';
document.getElementById('addRideContainer').style.display = 'block';
  document.getElementById('historyContainer').style.display = 'block';
}

function submitForm() {
document.getElementById('addRideForm').setAttribute('action', 'php/driver/addRideProcess.php');
document.getElementById('addRideForm').submit();
}