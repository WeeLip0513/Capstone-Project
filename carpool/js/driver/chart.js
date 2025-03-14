document.addEventListener("DOMContentLoaded", function () {
  const monthSelect = document.getElementById("month");
  const dateRangeDisplay = document.getElementById("dateRangeDisplay");
  const totalEarnings = document.getElementById("totalEarnings");
  const withdrawBtn = document.getElementById("withdrawBtn");
  const availableBalance = document.createElement("h1"); // Balance display
  const chartContainer = document.getElementById("chartContainer");
  const ctx = document.getElementById("earningsChart").getContext("2d");

  let earningsChart; // Store the chart instance
  let selectedMonth = ""; // Variable to store selected month
  let latestBalance = 0; // Store latest earnings balance

  // Function to get start and end dates based on selected month
  function getMonthRange(month) {
      const year = new Date().getFullYear();
      const months = {
          jan: { start: `${year}-01-01`, end: `${year}-01-31` },
          feb: { start: `${year}-02-01`, end: `${year}-02-28` },
          mar: { start: `${year}-03-01`, end: `${year}-03-31` },
          apr: { start: `${year}-04-01`, end: `${year}-04-30` },
          may: { start: `${year}-05-01`, end: `${year}-05-31` },
          jun: { start: `${year}-06-01`, end: `${year}-06-30` },
          jul: { start: `${year}-07-01`, end: `${year}-07-31` },
          aug: { start: `${year}-08-01`, end: `${year}-08-31` },
          sep: { start: `${year}-09-01`, end: `${year}-09-30` },
          oct: { start: `${year}-10-01`, end: `${year}-10-31` },
          nov: { start: `${year}-11-01`, end: `${year}-11-30` },
          dec: { start: `${year}-12-01`, end: `${year}-12-31` }
      };
      return months[month] || {};
  }

  // Function to fetch earnings and update chart
  function fetchEarnings(month) {
      const { start, end } = getMonthRange(month);

      if (start && end) {
          dateRangeDisplay.innerHTML = `From<br><b>${start}</b> <br>To<br> <b>${end}</b>`;

          fetch("../php/driverPage/process_earnings.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
              },
              body: `month=${encodeURIComponent(month)}`,
          })
          .then(response => response.json())
          .then(data => {
              if (!data.total_earnings || parseFloat(data.total_earnings) === 0) {
                  totalEarnings.textContent = "No Completed Rides Available";
                  availableBalance.textContent = "";
                  chartContainer.style.display = "none";
                  withdrawBtn.style.display = "none";
              } else {
                  totalEarnings.textContent = `Total: RM${data.total_earnings}`;
                  availableBalance.textContent = `Balance: RM${data.available_balance || "0"}`;
                  withdrawBtn.style.display = "block";
                  withdrawBtn.style.textAlign = "center";
                  updateChart(data.dates, data.revenues);
              }
          })
          .catch(error => {
              console.error("Error fetching earnings:", error);
          });
      }
  }

  // Event listener for month selection
  monthSelect.addEventListener("change", function () {
      const selectedMonth = monthSelect.value;
      fetchEarnings(selectedMonth);
  });

  // Event listener for withdraw button
  withdrawBtn.addEventListener("click", function () {
      const selectedMonth = monthSelect.value;
      const balance = availableBalance.textContent.replace("Balance: RM", "").trim();
      const url = `withdrawPage.php?balance=${encodeURIComponent(balance)}&month=${encodeURIComponent(selectedMonth)}`;
      window.location.href = url;
  });

  // Initialize with the default selected month
  monthSelect.dispatchEvent(new Event("change"));

  function updateChart(dates, revenues) {
      if (earningsChart) {
          earningsChart.destroy(); // Destroy previous chart
      }

      earningsChart = new Chart(ctx, {
          type: "line",
          data: {
              labels: dates,
              datasets: [{
                  label: "Daily Earnings (RM)",
                  data: revenues,
                  borderColor: "#2b83ff",
                  backgroundColor: "rgba(75, 192, 192, 0.2)",
                  borderWidth: 2,
                  fill: true,
                  tension: 0.3
              }]
          },
          options: {
              responsive: true,
              scales: {
                  x: {
                      title: { display: true, text: "Date" },
                      ticks: { autoSkip: true, maxTicksLimit: 10 }
                  },
                  y: {
                      title: { display: true, text: "Earnings (RM)" }
                  }
              },
              plugins: {
                  legend: { display: true, position: "top" }
              }
          }
      });
  }

  // Fetch earnings for the initially selected month
  monthSelect.dispatchEvent(new Event("change"));
});

