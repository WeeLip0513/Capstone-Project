document.addEventListener("DOMContentLoaded", function () {
  fetch('../php/driver/earnings.php')
    .then(response => response.json())
    .then(data => {
      const earningsContent = document.getElementById("earningsContent");
      const earningsChartContainer = document.getElementById("chartContainer");
      const summaryContainer = document.getElementById("earningDetails");

      if (data.error) {
        earningsContent.innerHTML = `<div class="no-rides"><h2 style="text-align: center; color: red;">${data.error}</h2></div>`;
        earningsChartContainer.style.display = "none";
        summaryContainer.style.display = "none";
        return;
      }

      if (data.error || !data.dates || data.dates.length === 0) {
        earningsChartContainer.style.display = "none";
        summaryContainer.style.display = "none";
        const messageDiv = document.createElement("div");
        messageDiv.id = "noRidesMessage";
        messageDiv.innerHTML = `<h2 style="text-align: center; color: red;">${data.error || "No Completed Rides Found"}</h2>`;
        earningsContent.appendChild(messageDiv);
        return;
      }

      // Show the chart and summary if there is data
      earningsChartContainer.style.display = "block";
      summaryContainer.style.display = "block";

      let totalEarnings = data.revenues.reduce((sum, value) => sum + value, 0);

      document.getElementById("dateRange").innerHTML = `From <br><b>${data.earliest_date}</b> <br>to <br><b>${data.latest_date}</b>`;
      document.getElementById("totalEarnings").innerText = `RM${totalEarnings.toFixed(2)}`;

      var ctx = document.getElementById('earningsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.dates,
          datasets: [{
            label: 'Total Earnings (RM)',
            data: data.revenues,
            backgroundColor: '#2b83ff',
            borderColor: 'white',
            borderRadius: 10,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true },
            x: {
              title: {
                display: true,
                text: `Earnings from ${data.earliest_date} to ${data.latest_date}`
              }
            }
          }
        }
      });

      document.getElementById("withdrawBtn").addEventListener("click", function () {
        alert(`Withdraw Request: RM${totalEarnings.toFixed(2)}`);
      });
    })
    .catch(error => {
      console.error("Error loading data:", error);
      document.getElementById("earningsContent").innerHTML =
        `<div class="no-rides"><h2 style="text-align: center; color: red;">Failed to load data</h2></div>`;
      document.getElementById("earningsChart").parentNode.style.display = "none";
      document.getElementById("earningsSummary").style.display = "none";
    });
});
