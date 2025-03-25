document.addEventListener("DOMContentLoaded", function () {
  const monthSelect = document.getElementById("month");
  const totalEarnings = document.getElementById("totalEarnings");
  const dateRange = document.getElementById("dateRange");
  const earningsChartCanvas = document.getElementById("earningsChart");
  const withdrawBtn = document.getElementById("withdrawBtn"); // Get the withdraw button
  const balance = document.getElementById("availableBalance");
  let earningsChart;

  // Define month mapping
  const monthNames = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];

  // Get current month index and map it to "jan", "feb", etc.
  const currentMonth = monthNames[new Date().getMonth()];

  // Set the default selected month
  for (let option of monthSelect.options) {
    if (option.value.toLowerCase() === currentMonth) {
      option.selected = true;
      break;
    }
  }

  function fetchEarnings(month) {
    fetch(`../php/driver/earnings.php?month=${month}`)
      .then(response => response.json())
      .then(data => {
        if (data && data.earnings.length > 0) {
          updateEarningsDisplay(data.total, data.range);
          updateChart(data.earnings);

          // Show available balance only if it's greater than 0
          if (data.balance > 0) {
            balance.textContent = `Balance: RM${data.balance.toFixed(2)}`;
            withdrawBtn.style.display = "block"; // Show withdraw button
          } else {
            balance.textContent = ""; // Hide balance display
            withdrawBtn.style.display = "none"; // Hide withdraw button
          }
        } else {
          dateRange.textContent = "You Have No Earnings";
          totalEarnings.textContent = "";
          balance.textContent = ""; // Hide balance
          updateChart([]);
          withdrawBtn.style.display = "none"; // Hide withdraw button
        }
      })
      .catch(error => {
        console.error("Error fetching earnings:", error);
      });
  }

  function updateEarningsDisplay(total, range) {
    totalEarnings.textContent = `Total: RM${total.toFixed(2)}`;
    dateRange.innerHTML = range.replace(" - ", "<br>"); // Replace " - " with a line break
  }


  function updateChart(earningsData) {
    const labels = earningsData.map(entry => {
      const date = new Date(entry.date);
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }); // Format as "Mar 1"
    });

    const earnings = earningsData.map(entry => entry.amount);

    if (earningsChart) {
      earningsChart.destroy();
    }

    earningsChart = new Chart(earningsChartCanvas, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Earnings (RM)',
          data: earnings,
          borderColor: 'rgba(54,162,235,1)',
          backgroundColor: 'rgba(54,162,235,0.2)',
          borderWidth: 3, // Increase line thickness for visibility
          borderJoinStyle: 'round', // Makes the line joints rounded
          borderCapStyle: 'round', // Rounds the line ends
          tension: 0.4 // Adds smooth curves to the line
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            title: {
              display: true,
              // text: 'Date (Month & Day)' // Label for clarity
            }
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }



  monthSelect.addEventListener("change", function () {
    fetchEarnings(this.value);
  });

  fetchEarnings(monthSelect.value);

  withdrawBtn.addEventListener("click", function () {
    const selectedMonth = monthSelect.value; // Get selected month
    const availableBalance = balance.textContent.replace("Balance: RM", "").trim(); // Extract balance value

    // Navigate to withdraw_page.php with parameters
    window.location.href = `withdrawPage.php?month=${selectedMonth}&balance=${availableBalance}`;
  });

});
