document.addEventListener("DOMContentLoaded", function () {
  const monthSelect = document.getElementById("month");
  const dateRangeDisplay = document.getElementById("dateRange");
  const totalEarnings = document.getElementById("totalEarnings");
  const availableBalance = document.createElement("h1"); // Element for available balance
  totalEarnings.insertAdjacentElement("afterend", availableBalance); // Insert below total earnings
  const chartContainer = document.getElementById("chartContainer");
  const ctx = document.getElementById("earningsChart").getContext("2d");

  let earningsChart; // Store the chart instance

  // Function to get start and end dates based on month
  function getStartEndDate(month) {
      const year = new Date().getFullYear();
      const months = {
          jan: { start: `${year}-01-01`, end: `${year}-01-31` },
          feb: { start: `${year}-02-01`, end: `${year}-02-${isLeapYear(year) ? "29" : "28"}` },
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

  // Function to check leap year
  function isLeapYear(year) {
      return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
  }

  // Function to fetch earnings and update chart
  function fetchEarnings(startDate, endDate) {
      fetch("../php/driver/earnings.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `start_date=${startDate}&end_date=${endDate}`,
      })
      .then(response => response.json())
      .then(data => {
          if (!data.total_earnings || parseFloat(data.total_earnings) === 0) {
              totalEarnings.textContent = "No Completed Rides Available";
              availableBalance.textContent = "";
              chartContainer.style.display = "none"; // Hide the chart
              document.getElementById("withdrawBtn").style.display = "none";
          } else {
              totalEarnings.textContent = `Total: RM${data.total_earnings}`;
              availableBalance.textContent = `Balance: RM${data.available_balance || "0.00"}`;
              chartContainer.style.display = "block"; // Show the chart
              document.getElementById("withdrawBtn").style.display = "block";
              document.getElementById("withdrawBtn").style.textAlign = "center";
              updateChart(data.dates, data.revenues);
          }
      })
      .catch(error => console.error("Error fetching earnings:", error));
  }

  // Function to create or update chart
  function updateChart(dates, revenues) {
      if (earningsChart) {
          earningsChart.destroy(); // Destroy existing chart before updating
      }

      earningsChart = new Chart(ctx, {
          type: "line",
          data: {
              labels: dates,
              datasets: [{
                  label: "Daily Earnings ($)",
                  data: revenues,
                  borderColor: "#2b83ff",
                  // backgroundColor: "rgba(75, 192, 192, 0.2)",
                  borderWidth: 2,
                  pointRadius: 5,
                  pointHoverRadius: 7,
                  fill: true,
                  tension: 0.3 // Smooth the line
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  x: {
                      title: {
                          display: true,
                          text: "Date",
                      },
                      ticks: {
                          autoSkip: true,
                          maxTicksLimit: 10
                      }
                  },
                  y: {
                      title: {
                          display: true,
                          text: "Earnings ($)",
                      },
                      beginAtZero: true
                  }
              },
              plugins: {
                  legend: {
                      display: true,
                      position: "top"
                  }
              }
          }
      });
  }

  // Event listener for month selection
  monthSelect.addEventListener("change", function () {
      const selectedMonth = this.value;
      const { start, end } = getStartEndDate(selectedMonth);

      if (start && end) {
          dateRangeDisplay.innerHTML = `From<br><b>${start}</b> <br>To<br> <b>${end}</b>`;
          fetchEarnings(start, end);
      }
  });

  // Trigger change event on page load to fetch initial data
  monthSelect.dispatchEvent(new Event("change"));
});
