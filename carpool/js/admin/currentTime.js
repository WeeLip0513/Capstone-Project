document.addEventListener("DOMContentLoaded", function () {
    function updateDateTime() {
        let now = new Date();

        // Get the current day
        let optionsDay = { weekday: 'long' };
        let formattedDay = now.toLocaleDateString('en-US', optionsDay);

        // Get the current date
        let optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
        let formattedDate = now.toLocaleDateString('en-US', optionsDate);

        // Get the current time
        let formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });

        // Update the elements in the DOM
        document.getElementById("current-day").textContent = formattedDay;
        document.getElementById("current-date").textContent = formattedDate;
        document.getElementById("current-time").textContent = formattedTime;
    }

    // Update time every second
    setInterval(updateDateTime, 1000);

    // Run once immediately
    updateDateTime();
});
