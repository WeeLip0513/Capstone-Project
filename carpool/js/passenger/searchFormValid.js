function fetchAvailableRides() {
    const pickup = document.getElementById('pickup').value;
    const dropoff = document.getElementById('dropoff').value;
    const date = document.getElementById('date').value;
    const hour = document.getElementById('hour').value;
    const minute = document.getElementById('minute').value;
    const time = (hour && minute) ? `${hour}:${minute}` : "";

    const formData = new FormData();
    if (pickup) {
        formData.append('pickup', pickup);
    }
    if (dropoff) {
        formData.append('dropoff', dropoff);
    }
    if (date) {
        formData.append('date', date);
    }
    if (time) {
        formData.append('time', time);
    }

    // debug
    // console.log("Form data sent:", {
    //     pickup,
    //     dropoff,
    //     date,
    //     time
    // }); 

    fetch('../php/passenger/displayrides.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('rideResults').innerHTML = html;
        })
        .catch(error => {
            console.error('Error fetching rides:', error);
            document.getElementById('rideResults').innerHTML = '<p>Error loading rides.</p>';
        });
}

document.addEventListener('DOMContentLoaded', function () {
    // ** REMEMBER UNCOMMENT IN PRESENTATION**
    // const today = new Date().toISOString().split("T")[0];
    // document.getElementById("date").min = today;
    document.getElementById('pickup').addEventListener('change', fetchAvailableRides);
    document.getElementById('dropoff').addEventListener('change', fetchAvailableRides);
    document.getElementById('date').addEventListener('change', fetchAvailableRides);
    document.getElementById('hour').addEventListener('change', fetchAvailableRides);
    document.getElementById('minute').addEventListener('change', fetchAvailableRides);
});